<?php
include("../../bd.php");
//Al recibir la ID via get del enlace anterior accedemos a este metodo para obtener los datos del elemento con esa ID y poder mostrarlos en el nuevo formulario
if(isset($_GET['txtID'])){
    //Si existe este dato lo asignamos, sino lo asignamos como vacio
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    //Preparamos sentencia para obtener un valor
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_usuarios` WHERE id=:id");
    $sentencia -> bindparam(":id",$txtID);
    $sentencia -> execute();
    //Para que solo guarde un solo registro con sus campos
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    //En esta variable asignamos lo que vale el campo concreto
    $nombre_usuario = $registro["usuario"];
    $contrasenia_usuario = $registro["passwrd"];
    $correo_usuario = $registro["correo"];
}

//Si le llega el POST del boton editar entonces obtiene los datos del form y los actualiza en la BD
if($_POST){
    print_r($_POST);
    $txtID=(isset($_POST['id']))?$_POST['id']:"";
    //asignamos a esta variable elcontenido del input de nombre del puesto si le llega via post, si no le llega asignamos como que no hay valor
    $nombre_usuario = (isset($_POST['nombre_usuario'])?$_POST['nombre_usuario']:"");
    $contrasenia_user = (isset($_POST['contrasenia_user'])?$_POST['contrasenia_user']:"");
    $correo_usuario = (isset($_POST['correo_usuario'])?$_POST['correo_usuario']:"");

    //Preparamos la insercion de los datos
    $sentencia = $conexion->prepare("UPDATE  tbl_usuarios SET usuario=:nombre_usuario,passwrd=:contrasenia_user,correo=:correo_usuario WHERE id=:id");

    //Asigno los valores que vienen del metodo POST (datos del form), esta linea hara una asignacion de datos para poder enviarlos al SQL
    $sentencia->bindParam(":nombre_usuario",$nombre_usuario);
    $sentencia->bindParam(":contrasenia_user",$contrasenia_user);
    $sentencia->bindParam(":correo_usuario",$correo_usuario);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php");

}?>
<?php include("../../templates/header.php");?>
<br>
<div class="card">
    <div class="card-header">
        Datos del Usuario
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="id" class="form-label">ID</label>
              <input type="text" readonly class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="ID" value="<?php echo $txtID;?>">
            </div>
            <div class="mb-3">
              <label for="nombre_usuario" class="form-label">Nombre del usuario:</label>
              <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" aria-describedby="helpId" placeholder="Nombre del usuario" value="<?php echo $nombre_usuario;?>">
            </div>

            <div class="mb-3">
              <label for="contrasenia_user" class="form-label">Password:</label>
              <input type="password" class="form-control" name="contrasenia_user" id="contrasenia_user" aria-describedby="helpId" placeholder="Introduce la contraseña" value="<?php echo $contrasenia_usuario;?>">
            </div>

            <div class="mb-3">
              <label for="correo_usuario" class="form-label">Correo:</label>
              <input type="email" class="form-control" name="correo_usuario" id="correo_usuario" aria-describedby="helpId" placeholder="Introduce el correo electronico" value="<?php echo $correo_usuario;?>">
            </div>


            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="btn_cancelar_crear_puesto" id="btn_cancelar_crear_puesto" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
        
    </div>
</div>
<?php include("../../templates/footer.php");?>