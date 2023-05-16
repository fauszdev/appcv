<?php
//incluimos la conexion a la BD
include("../../bd.php");

//Si llega el get txtID del boton con la ID...
if(isset($_GET['txtID'])){
    //Si existe este dato lo asignamos, sino lo asignamos como vacio
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    //Buscar el archivo (foto y pdf) relacionado con el empleado cuando el id sea encontrado
    $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia -> execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
    
    //Buscamos el registro con la foto
    if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!=""){
        //Si existe este archivo
        if(file_exists("./".$registro_recuperado["foto"])){
            //Borramos el archivo
            unlink("./".$registro_recuperado["foto"]);
        }
    }

    //Buscamos el registro con el pdf
    if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!=""){
        //Si existe este archivo
        if(file_exists("./".$registro_recuperado["cv"])){
            //Borramos el archivo
            unlink("./".$registro_recuperado["cv"]);
        }
    }
    
    $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php");
}
/*se prepara la sentencia, en este caso a parte de seleccionar todos los datos de empleados, tambien aplicamos una subconsulta con el nombre del puesto de la tabla puesto
cuya id se corresponda con la id del puesto del empleado, tambien aplicamos limit 1 para que solo nos lo aplique a un solo registro y la referencia al dato será puesto
*/
$sentencia = $conexion->prepare("SELECT *,(SELECT nombre_puesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.id_puesto limit 1) as puesto FROM `tbl_empleados`");

//se ejecuta la sentencia
$sentencia -> execute();


//creamos una lista(array) con todos los registros de la tabla via asociativo (nombre celdas y valor)
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../../templates/header.php");?>
<br>
<!-- bs5-card-head-foot // crea tabla con titulo, cuerpo y footer-->

<div class="card">
    
    <div class="card-header">
        
        <!--bs5-button-a -->
        <!-- boton que al pulsar nos redireccionara a la pagina crear.php (empleados)-->
        <a name="btn_ir_a_crear_empleado" id="btn_ir_a_crear_empleado" class="btn btn-primary" href="crear.php" role="button">Agregar Registro</a>
    </div>

    <!--bs5-table-default-->
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_tbl_empleados as $registro){?>
                
                    <tr class="">
                        <td><?php echo $registro['id'];?></td>
                        <td scope="row"><?php echo $registro['primer_nombre']." ".$registro['segundo_nombre']." ".$registro['primer_apellido']." ".$registro['segundo_apellido'];?></td>
                        <td>
                        <img width="50" src="<?php echo $registro['foto'];?>" class="img-fluid rounded" alt="" /></td>
                        <td>
                            <?php echo $registro['cv'];?>
                        </td>
                        <td><?php echo $registro['puesto'];?></td>
                        <td><?php echo $registro['fecha_ingreso'];?></td>
                        <td>
                            <a name="btn_crear_carta_empleado" id="btn_crear_carta_empleado" class="btn btn-primary" href="crear.php?txtID=<?php echo $registro['id'];?>" role="button">Carta</a> |
                            <a name="btn_editar_empleado" id="btn_editar_empleado" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id'];?>" role="button">Editar</a> |
                            <a name="btn_eliminar_empleado" id="btn_eliminar_empleado" class="btn btn-danger" href="index.php?txtID=<?php echo $registro['id'];?>" role="button">Eliminar</a>
                        </td> 
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        
    </div>
    
</div>
<?php include("../../templates/footer.php");?>