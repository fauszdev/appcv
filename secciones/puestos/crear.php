<?php
//incluimos la conexion a la BD
include("../../bd.php");

//si hay algun envio de datos a esta pagina via POST
if($_POST){
    print_r($_POST);

    //asignamos a esta variable elcontenido del input de nombre del puesto si le llega via post, si no le llega asignamos como que no hay valor
    $nombre_puesto = (isset($_POST['nombre_puesto'])?$_POST['nombre_puesto']:"");

    //Preparamos la insercion de los datos
    $sentencia = $conexion->prepare("INSERT INTO tbl_puestos(id,nombre_puesto) VALUES (null, :nombre_puesto)");

    //Asigno los valores que vienen del metodo POST (datos del form), esta linea hara una asignacion de datos para poder enviarlos al SQL
    $sentencia->bindParam(":nombre_puesto",$nombre_puesto);
    $sentencia->execute();

    //Tras la insercion de datos a la BD redireccionamos la página al index.
    header("Location:index.php");

}
?>

<?php include("../../templates/header.php");?>


<br>
<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nombre_puesto" class="form-label">Nombre del puesto:</label>
              <input type="text" class="form-control" name="nombre_puesto" id="nombre_puesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="btn_cancelar_crear_puesto" id="btn_cancelar_crear_puesto" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
        
    </div>
</div>


<?php include("../../templates/footer.php");?>