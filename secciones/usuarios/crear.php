<?php
//incluimos la conexion a la BD
include("../../bd.php");

//si hay algun envio de datos a esta pagina via POST
if($_POST){
  print_r($_POST);


  $nombre_usuario = (isset($_POST['nombre_usuario'])?$_POST['nombre_usuario']:"");
  $contrasenia_user = (isset($_POST['contrasenia_user'])?$_POST['contrasenia_user']:"");
  $correo_usuario = (isset($_POST['correo_usuario'])?$_POST['correo_usuario']:"");
  //Preparamos la insercion de los datos
  $sentencia = $conexion->prepare("INSERT INTO tbl_usuarios(id,usuario,passwrd,correo) VALUES (null, :nombre_usuario,:contrasenia_user,:correo_usuario)");

  //Asigno los valores que vienen del metodo POST (datos del form), esta linea hara una asignacion de datos para poder enviarlos al SQL
  $sentencia->bindParam(":nombre_usuario",$nombre_usuario);
  $sentencia->bindParam(":contrasenia_user",$contrasenia_user);
  $sentencia->bindParam(":correo_usuario",$correo_usuario);
  $sentencia->execute();

  //Tras la insercion de datos a la BD redireccionamos la página al index.
  header("Location:index.php");

}
?>
<?php include("../../templates/header.php");?>
<br>
<div class="card">
    <div class="card-header">
        Datos del Usuario
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nombre_usuario" class="form-label">Nombre del usuario:</label>
              <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" aria-describedby="helpId" placeholder="Nombre del usuario">
            </div>

            <div class="mb-3">
              <label for="contrasenia_user" class="form-label">Password:</label>
              <input type="password"
                class="form-control" name="contrasenia_user" id="contrasenia_user" aria-describedby="helpId" placeholder="Introduce la contraseña">
            </div>

            <div class="mb-3">
              <label for="correo_usuario" class="form-label">Correo:</label>
              <input type="email"
                class="form-control" name="correo_usuario" id="correo_usuario" aria-describedby="helpId" placeholder="Introduce el correo electronico">
            </div>


            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="btn_cancelar_crear_puesto" id="btn_cancelar_crear_puesto" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
        
    </div>
</div>
<?php include("../../templates/footer.php");?>