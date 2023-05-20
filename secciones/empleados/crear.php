<?php include("../../bd.php");?>
<?php
if($_POST){
  /*print_r($_POST);
  print_r($_FILES);*/
  $primer_nombre = (isset($_POST['nombre1_empleado'])?$_POST['nombre1_empleado']:"");
  $segundo_nombre = (isset($_POST['nombre2_empleado'])?$_POST['nombre2_empleado']:"");
  $primer_apellido = (isset($_POST['apellido1_empleado'])?$_POST['apellido1_empleado']:"");
  $segundo_apellido = (isset($_POST['apellido2_empleado'])?$_POST['apellido2_empleado']:"");
  $foto_empleado = (isset($_FILES['foto_empleado']['name'])?$_FILES['foto_empleado']['name']:"");
  $cv_empleado = (isset($_FILES['cv_empleado']['name'])?$_FILES['cv_empleado']['name']:"");
  $id_puesto_empleado = (isset($_POST['id_puesto_empleado'])?$_POST['id_puesto_empleado']:"");
  $fecha_ingreso_empleado = (isset($_POST['fecha_ingreso_empleado'])?$_POST['fecha_ingreso_empleado']:"");
  //Preparamos la insercion de los datos
  $sentencia = $conexion->prepare("INSERT INTO `tbl_empleados` (id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,foto,cv,id_puesto,fecha_ingreso) VALUES (NULL,:primer_nombre,:segundo_nombre,:primer_apellido,:segundo_apellido,:foto_empleado,:cv_empleado,:id_puesto_empleado,:fecha_ingreso_empleado);");

  //Asigno los valores que vienen del metodo POST (datos del form), esta linea hara una asignacion de datos para poder enviarlos al SQL
  $sentencia->bindParam(":primer_nombre",$primer_nombre);
  $sentencia->bindParam(":segundo_nombre",$segundo_nombre);
  $sentencia->bindParam(":primer_apellido",$primer_apellido);
  $sentencia->bindParam(":segundo_apellido",$segundo_apellido);

  //Para darle el nombre a la foto obtenemos el momento actual para que no se sobrescriba la foto
  $fecha = new DateTime();

  //Si el valor de la foto tiene nombre (hay una imagen seleccionada) adjuntamos al nombre primero la fecha y despues el nombre que tenia, si no tiene se da valor vacio
  $nombre_archivo_foto = ($foto_empleado!='')?$fecha->getTimestamp()."_".$_FILES['foto_empleado']['name']:"";

  //Variable temporal con el nombre temporal de la foto para usarlo a la hora de mover la foto al nuevo destino
  $tmp_foto = $_FILES['foto_empleado']['tmp_name'];

  //Si la foto temporal no esta vacia (si hay una foto)
  if($tmp_foto!=""){
    //Indicamos a donde va a ir el archivo con el nuevo nombre
    move_uploaded_file($tmp_foto,"./".$nombre_archivo_foto);
  }

  //Hay que adjuntar la foto
  $sentencia->bindParam(":foto_empleado",$nombre_archivo_foto);

  //Si el valor del pdf tiene nombre (hay un pdf seleccionado) adjuntamos al nombre primero la fecha y despues el nombre que tenia, si no tiene se da valor vacio
  $nombre_archivo_pdf = ($cv_empleado!='')?$fecha->getTimestamp()."_".$_FILES['cv_empleado']['name']:"";

  //Variable temporal con el nombre temporal del pdf para usarlo a la hora de mover el pdf al nuevo destino
  $tmp_pdf = $_FILES['cv_empleado']['tmp_name'];

  //Si la foto temporal no esta vacia (si hay una foto)
  if($tmp_pdf!=""){
    //Indicamos a donde va a ir el archivo con el nuevo nombre
    move_uploaded_file($tmp_pdf,"./".$nombre_archivo_pdf);
  }
  $sentencia->bindParam(":cv_empleado",$nombre_archivo_pdf);


  $sentencia->bindParam(":id_puesto_empleado",$id_puesto_empleado);
  $sentencia->bindParam(":fecha_ingreso_empleado",$fecha_ingreso_empleado);
  
  $sentencia->execute();

  //Guardamos el mensaje para mostrarlo en el paso mas adelante
  $mensaje="Registro agregado";

  //Redigirá a la misma pagina pero con la variable mensaje para mostrarla
  header("Location:index.php?mensaje=".$mensaje);
}
?>
<?php include("../../templates/header.php");?>
<?php
  $sentencia=$conexion->prepare("SELECT * FROM tbl_puestos");
  $sentencia->execute();
  $lista_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
  
?>
<!--bs5-card-head-foot-->
<br>
<div class="card">
    <div class="card-header">
        Datos del Empleado
    </div>
    <div class="card-body">
        <!-- Formulario para el registro del empleado, añadimos el enctype para poder adjuntar archivos al form-->
        <form action="" method="post" enctype="multipart/form-data">
            <!--bs5-form-input-->
            

        <div class="mb-3">
          <label for="nombre1_empleado" class="form-label">Primer Nombre</label>
          <input type="text" class="form-control" name="nombre1_empleado" id="nombre1_empleado" aria-describedby="helpId" placeholder="Primer Nombre">
        </div>

        <div class="mb-3">
          <label for="nombre2_empleado" class="form-label">Segundo Nombre</label>
          <input type="text" class="form-control" name="nombre2_empleado" id="nombre2_empleado" aria-describedby="helpId" placeholder="Segundo Nombre">
        </div>

        <div class="mb-3">
          <label for="apellido1_empleado" class="form-label">Primer Apellido</label>
          <input type="text" class="form-control" name="apellido1_empleado" id="apellido1_empleado" aria-describedby="helpId" placeholder="Primer Apellido">
        </div>

        <div class="mb-3">
          <label for="apellido2_empleado" class="form-label">Segundo Apellido</label>
          <input type="text" class="form-control" name="apellido2_empleado" id="apellido2_empleado" aria-describedby="helpId" placeholder="Segundo Apellido">
        </div>

        <div class="mb-3">
          <label for="foto_empleado" class="form-label">Foto:</label>
          <input type="file" class="form-control" name="foto_empleado" id="foto_empleado" aria-describedby="helpId" placeholder="Foto">
        </div>

        <div class="mb-3">
          <label for="cv_empleado" class="form-label">CV(PDF):</label>
          <input type="file" class="form-control" name="cv_empleado" id="cv_empleado" aria-describedby="helpId" placeholder="CV(PDF)">
        </div>

        <!-- bs5-select-custom-->
        <div class="mb-3">
            <label for="id_puesto_empleado" class="form-label">Puesto:</label>
            <select class="form-select form-select-sm" name="id_puesto_empleado" id="id_puesto_empleado">
                <?php foreach($lista_puestos as $registro){?>
                  <option value="<?php echo $registro['id'];?>"><?php echo $registro['nombre_puesto'];?></option>
                <?php }?>
                
            </select>
        </div>

        <!-- Ponemos el tipo correo pero lo cambiamos por fecha pues fecha no está directamente-->
        <div class="mb-3">
          <label for="fecha_ingreso_empleado" class="form-label">Fecha de ingreso:</label>
          <input type="date" class="form-control" name="fecha_ingreso_empleado" id="fecha_ingreso_empleado" aria-describedby="emailHelpId" placeholder="Fecha de ingreso">
          
        </div>

        <!-- bs5-button-default-->
        <button type="submit" class="btn btn-success">Agregar Registro</button>

        <!-- bs5-button-a-->
        <!--boton de cancelar que llevará al index de empleados-->
        <a name="btn_cancelar_crear_empleado" id="btn_cancelar_crear_empleado" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


        </form>
    </div>
    <div class="card-footer text-muted"></div>
    
</div>
<?php include("../../templates/footer.php");?>