<?php include("../../bd.php");
//Si llega el get txtID del boton con la ID...
if(isset($_GET['txtID'])){
    //Si existe este dato lo asignamos, sino lo asignamos como vacio
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    //Buscar el archivo (foto y pdf) relacionado con el empleado cuando el id sea encontrado
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia -> execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    //En esta variable asignamos lo que vale el campo concreto
    $primer_nombre = $registro["primer_nombre"];
    $segundo_nombre = $registro["segundo_nombre"];
    $primer_apellido = $registro["primer_apellido"];
    $segundo_apellido = $registro["segundo_apellido"];
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $id_puesto = $registro["id_puesto"];
    $fecha_ingreso = $registro["fecha_ingreso"];

    /*$sentencia->bindParam(":primer_nombre",$primer_nombre);
    $sentencia->bindParam(":segundo_nombre",$segundo_nombre);
    $sentencia->bindParam(":primer_apellido",$primer_apellido);
    $sentencia->bindParam(":segundo_apellido",$segundo_apellido);
    $sentencia->bindParam(":cv_empleado",$nombre_archivo_pdf);
    $sentencia->bindParam(":id_puesto_empleado",$id_puesto_empleado);
    $sentencia->bindParam(":fecha_ingreso_empleado",$fecha_ingreso_empleado);
*/
    $sentencia=$conexion->prepare("SELECT * FROM tbl_puestos");
    $sentencia->execute();
    $lista_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php include("../../templates/header.php");?>
<?php
    
    
    if($_POST){
        //print_r($_POST);
        $txtID=(isset($_POST['id_empleado']))?$_POST['id_empleado']:"";
        //asignamos a esta variable elcontenido del input de nombre del puesto si le llega via post, si no le llega asignamos como que no hay valor
        $primer_nombre = (isset($_POST['nombre1_empleado'])?$_POST['nombre1_empleado']:"");
        $segundo_nombre = (isset($_POST['nombre2_empleado'])?$_POST['nombre2_empleado']:"");
        $primer_apellido = (isset($_POST['apellido1_empleado'])?$_POST['apellido1_empleado']:"");
        $segundo_apellido = (isset($_POST['apellido2_empleado'])?$_POST['apellido2_empleado']:"");
        $id_puesto = (isset($_POST['id_puesto_empleado'])?$_POST['id_puesto_empleado']:"");
        $fecha_ingreso = (isset($_POST['fecha_ingreso_empleado'])?$_POST['fecha_ingreso_empleado']:"");

        //Preparamos la insercion de los datos
        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET primer_nombre=:primer_nombre,segundo_nombre=:segundo_nombre,primer_apellido=:primer_apellido,segundo_apellido=:segundo_apellido,id_puesto=:id_puesto,fecha_ingreso=:fecha_ingreso WHERE id=:id");
    
        //Asigno los valores que vienen del metodo POST (datos del form), esta linea hara una asignacion de datos para poder enviarlos al SQL
        $sentencia->bindParam(":primer_nombre",$primer_nombre);
        $sentencia->bindParam(":segundo_nombre",$segundo_nombre);
        $sentencia->bindParam(":primer_apellido",$primer_apellido);
        $sentencia->bindParam(":segundo_apellido",$segundo_apellido);
        $sentencia->bindParam(":id_puesto",$id_puesto);
        $sentencia->bindParam(":fecha_ingreso",$fecha_ingreso);
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();

        //Primero se actualizan los datos normales, una vez actualizados si tiene que editar la imagen o pdf se hará a continuacion

        //Hay que comprobar la imagen y despues eliminarla para poder subir una nueva
        $foto_empleado = (isset($_FILES['foto_empleado']['name'])?$_FILES['foto_empleado']['name']:"");
        //Para darle el nombre a la foto obtenemos el momento actual para que no se sobrescriba la foto
        $fecha = new DateTime();

        //Si el valor de la foto tiene nombre (hay una imagen seleccionada) adjuntamos al nombre primero la fecha y despues el nombre que tenia, si no tiene se da valor vacio
        $nombre_archivo_foto = ($foto_empleado!='')?$fecha->getTimestamp()."_".$_FILES['foto_empleado']['name']:"";

        //Variable temporal con el nombre temporal de la foto para usarlo a la hora de mover la foto al nuevo destino
        $tmp_foto = $_FILES['foto_empleado']['tmp_name'];

        //Si la foto temporal no esta vacia (si hay una foto)
        if($tmp_foto!=""){
          //Indicamos a donde va a ir el archivo con el nuevo nombre, ahi crea la imagen
          move_uploaded_file($tmp_foto,"./".$nombre_archivo_foto);
          //Buscar el archivo (foto y pdf) relacionado con el empleado cuando el id sea encontrado para poder eliminar el antiguo

          $sentencia = $conexion->prepare("SELECT foto FROM `tbl_empleados` WHERE id=:id");
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


          //Al haber eliminado el antiguo y creado el nuevo se inserta la actualizacion en la BD
          $sentencia = $conexion->prepare("UPDATE tbl_empleados SET foto=:foto_empleado WHERE id=:id");
          //Hay que adjuntar la foto
          $sentencia->bindParam(":foto_empleado",$nombre_archivo_foto);
          $sentencia->bindParam(":id",$txtID);
          $sentencia->execute();



          
        }

        
        
        $cv_empleado = (isset($_FILES['cv_empleado']['name'])?$_FILES['cv_empleado']['name']:"");

        //Si el valor del pdf tiene nombre (hay un pdf seleccionado) adjuntamos al nombre primero la fecha y despues el nombre que tenia, si no tiene se da valor vacio
        $nombre_archivo_pdf = ($cv_empleado!='')?$fecha->getTimestamp()."_".$_FILES['cv_empleado']['name']:"";

        //Variable temporal con el nombre temporal del pdf para usarlo a la hora de mover el pdf al nuevo destino
        $tmp_pdf = $_FILES['cv_empleado']['tmp_name'];

        //Si la foto temporal no esta vacia (si hay una foto)
        if($tmp_pdf!=""){
          //Indicamos a donde va a ir el archivo con el nuevo nombre
          move_uploaded_file($tmp_pdf,"./".$nombre_archivo_pdf);

          $sentencia = $conexion->prepare("SELECT cv FROM `tbl_empleados` WHERE id=:id");
          $sentencia->bindParam(":id",$txtID);
          $sentencia -> execute();
          $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

          //Buscamos el registro con el pdf
          if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!=""){
            //Si existe este archivo
            if(file_exists("./".$registro_recuperado["cv"])){
                //Borramos el archivo
                unlink("./".$registro_recuperado["cv"]);
            }
          }

          $sentencia = $conexion->prepare("UPDATE tbl_empleados SET cv=:cv_empleado WHERE id=:id");
          $sentencia->bindParam(":cv_empleado",$nombre_archivo_pdf);
          $sentencia->bindParam(":id",$txtID);
          $sentencia->execute();
        }

        header("Location:index.php");
    }
?>
    <br>
<!-- bs5-card-head-foot // crea tabla con titulo, cuerpo y footer-->

<!--bs5-card-head-foot-->
<br>
<div class="card">
    <div class="card-header">
        Datos del Empleado
    </div>
    <div class="card-body">
        <!-- Formulario para el registro del empleado, añadimos el enctype para poder adjuntar archivos al form-->
        <form action="" method="POST" enctype="multipart/form-data">
            <!--bs5-form-input-->
            
        <div class="mb-3">
          <label for="id_empleado" class="form-label">ID</label>
          <input type="text" class="form-control" name="id_empleado" id="id_empleado" aria-describedby="helpId" placeholder="Primer Nombre" value="<?php echo $txtID;?>">
        </div>

        <div class="mb-3">
          <label for="nombre1_empleado" class="form-label">Primer Nombre</label>
          <input type="text" class="form-control" name="nombre1_empleado" id="nombre1_empleado" aria-describedby="helpId" placeholder="Primer Nombre" value="<?php echo $primer_nombre;?>">
        </div>

        <div class="mb-3">
          <label for="nombre2_empleado" class="form-label">Segundo Nombre</label>
          <input type="text" class="form-control" name="nombre2_empleado" id="nombre2_empleado" aria-describedby="helpId" placeholder="Segundo Nombre" value="<?php echo $segundo_nombre;?>">
        </div>

        <div class="mb-3">
          <label for="apellido1_empleado" class="form-label">Primer Apellido</label>
          <input type="text" class="form-control" name="apellido1_empleado" id="apellido1_empleado" aria-describedby="helpId" placeholder="Primer Apellido" value="<?php echo $primer_apellido;?>">
        </div>

        <div class="mb-3">
          <label for="apellido2_empleado" class="form-label">Segundo Apellido</label>
          <input type="text" class="form-control" name="apellido2_empleado" id="apellido2_empleado" aria-describedby="helpId" placeholder="Segundo Apellido" value="<?php echo $segundo_apellido;?>">
        </div>

        <div class="mb-3">
          <label for="foto_empleado" class="form-label">Foto:</label>
          <br/>
          
          <img width="100" src="<?php echo $foto;?>" class="rounded" alt="" />
          <br/><br/>
          <input type="file" class="form-control" name="foto_empleado" id="foto_empleado" aria-describedby="helpId" placeholder="Foto" value="<?php echo $foto;?>">
        </div>

        <div class="mb-3">
          <label for="cv_empleado" class="form-label">CV(PDF):</label>
          <br/>
          <a href="<?php echo $cv;?> "target="_blank"> <?php echo $cv;?></a>
          <input type="file" class="form-control" name="cv_empleado" id="cv_empleado" aria-describedby="helpId" placeholder="CV(PDF)" value="<?php echo $cv;?>">
        </div>

        <!-- bs5-select-custom-->
        <div class="mb-3">
            <label for="id_puesto_empleado" class="form-label">Puesto:</label>
            <select class="form-select form-select-sm" name="id_puesto_empleado" id="id_puesto_empleado">
                <?php foreach($lista_puestos as $registro){?>
                <?php //Si el id del puesto coincide con el del registro imprimirá la propiedad SELECTED, sino no pondra nada?>
                  <option <?php echo ($id_puesto == $registro['id'])?"SELECTED":"";?> value="<?php echo $registro['id'];?>"><?php echo $registro['nombre_puesto'];?></option>
                <?php }?>
                
            </select>
        </div>

        <!-- Ponemos el tipo correo pero lo cambiamos por fecha pues fecha no está directamente-->
        <div class="mb-3">
          <label for="fecha_ingreso_empleado" class="form-label">Fecha de ingreso:</label>
          <input type="date" class="form-control" name="fecha_ingreso_empleado" id="fecha_ingreso_empleado" aria-describedby="emailHelpId" placeholder="Fecha de ingreso" value="<?php echo $fecha_ingreso;?>">
          
        </div>
        <!-- bs5-button-default-->
        <button type="submit" class="btn btn-success">Actualizar Registro</button>

        <!-- bs5-button-a-->
        <!--boton de cancelar que llevará al index de empleados-->
        <a name="btn_cancelar_crear_empleado" id="btn_cancelar_crear_empleado" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


        </form>
    </div>
    <div class="card-footer text-muted"></div>
    
</div>
    
                           

<?php include("../../templates/footer.php");?>