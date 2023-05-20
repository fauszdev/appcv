<?php
//incluimos la conexion a la BD
include("../../bd.php");

//Al recibir la ID via get del enlace anterior accedemos a este metodo para obtener los datos del elemento con esa ID y poder mostrarlos en el nuevo formulario
if(isset($_GET['txtID'])){
    //Si existe este dato lo asignamos, sino lo asignamos como vacio
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    //Preparamos sentencia para obtener un valor
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos` WHERE id=:id");
    $sentencia -> bindparam(":id",$txtID);
    $sentencia -> execute();
    //Para que solo guarde un solo registro con sus campos
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    //En esta variable asignamos lo que vale el campo concreto
    $nombre_puesto = $registro["nombre_puesto"];
}

//Si le llega el POST del boton editar entonces obtiene los datos del form y los actualiza en la BD
if($_POST){
    print_r($_POST);
    $txtID=(isset($_POST['id']))?$_POST['id']:"";
    //asignamos a esta variable elcontenido del input de nombre del puesto si le llega via post, si no le llega asignamos como que no hay valor
    $nombre_puesto = (isset($_POST['nombre_puesto'])?$_POST['nombre_puesto']:"");

    //Preparamos la insercion de los datos
    $sentencia = $conexion->prepare("UPDATE  tbl_puestos SET nombre_puesto=:nombre_puesto WHERE id=:id");

    //Asigno los valores que vienen del metodo POST (datos del form), esta linea hara una asignacion de datos para poder enviarlos al SQL
    $sentencia->bindParam(":nombre_puesto",$nombre_puesto);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    //Guardamos el mensaje para mostrarlo en el paso mas adelante
    $mensaje="Registro actualizado";

    //Redigirá a la misma pagina pero con la variable mensaje para mostrarla
    header("Location:index.php?mensaje=".$mensaje);

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
              <label for="id" class="form-label">ID</label>
              <!--La propiedad readonly aplica a que el input sea solo de lectura-->
              <input type="text" class="form-control" readonly name="id" id="id" aria-describedby="helpId" placeholder="ID" value="<?php echo $txtID;?>">
            </div>
            <div class="mb-3">
              <label for="nombre_puesto" class="form-label">Nombre del puesto:</label>
              <input type="text" class="form-control" name="nombre_puesto" id="nombre_puesto" aria-describedby="helpId" placeholder="Nombre del puesto" value="<?php echo $nombre_puesto;?>">
            </div>

            <button type="submit" class="btn btn-success">Editar</button>
            <a name="btn_cancelar_crear_puesto" id="btn_cancelar_crear_puesto" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
        
    </div>
</div>


<?php include("../../templates/footer.php");?>