<?php
//incluimos la conexion a la BD
include("../../bd.php");

//Si llega el get txtID del boton con la ID...
if(isset($_GET['txtID'])){
    //Si existe este dato lo asignamos, sino lo asignamos como vacio
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia = $conexion->prepare("DELETE FROM tbl_usuarios WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php");
}
//se prepara la sentencia
$sentencia = $conexion->prepare("SELECT * FROM `tbl_usuarios`");

//se ejecuta la sentencia
$sentencia -> execute();


//creamos una lista(array) con todos los registros de la tabla via asociativo (nombre celdas y valor)
$lista_tbl_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php");?>


<br>

<div class="card">
    <div class="card-header">
        <a name="btn_ir_a_crear_usuario" id="btn_ir_a_crear_usuario" class="btn btn-primary" href="crear.php" role="button">Agregar Usuario</a>
    </div>
    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_tbl_usuarios as $registro){?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id'];?></td>
                        <td><?php echo $registro['usuario'];?></td>
                        <td><?php echo $registro['passwrd'];?></td>
                        <td><?php echo $registro['correo'];?></td>
                        <td>
                            <a name="btn_editar_usuario" id="btn_editar_usuario" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id'];?>" role="button">Editar</a> | 
                            <a name="btn_eliminar_usuario" id="btn_eliminar_usuario" class="btn btn-danger" href="index.php?txtID=<?php echo $registro['id'];?>" role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>



<?php include("../../templates/footer.php");?>