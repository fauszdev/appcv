<?php
//incluimos la conexion a la BD
include("../../bd.php");

//Si llega el get txtID del boton con la ID...
if(isset($_GET['txtID'])){
    //Si existe este dato lo asignamos, sino lo asignamos como vacio
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia = $conexion->prepare("DELETE FROM tbl_puestos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php");
}

//se prepara la sentencia
$sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");

//se ejecuta la sentencia
$sentencia -> execute();

//creamos una lista(array) con todos los registros de la tabla via asociativo (nombre celdas y valor)
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//print_r($lista_tbl_puestos);
?>
<?php include("../../templates/header.php");?>

<br>

<div class="card">
    <div class="card-header">
        <a name="btn_ir_a_crear_puesto" id="btn_ir_a_crear_puesto" class="btn btn-primary" href="crear.php" role="button">Agregar Puesto</a>
    </div>
    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- hacemos bucle para recorrer todos los registros del array con los resultados obtenidos para poder tener el objeto individual-->
                    <?php foreach($lista_tbl_puestos as $registro){ ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id'];?></td>
                        <td><?php echo $registro['nombre_puesto'];?></td>
                        <td>
                        <a name="btn_editar_puesto_empleado" id="btn_editar_puesto_empleado" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id'];?>" role="button">Editar</a> |
                            
                            <!-- Boton con enlace que al pulsar manda un get al index (pagina actual) con la variable txtID que tiene la ID del elemento actual-->
                            <a name="btn_eliminar_puesto_empleado" id="btn_eliminar_puesto_empleado" class="btn btn-danger" href="index.php?txtID=<?php echo $registro['id'];?>" role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </div>
    
</div>




<?php include("../../templates/footer.php");?>