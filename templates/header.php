<?php
session_start();
//Url base para que no haya problema a la hora de redireccionar con las paginas del Nav
$url_base="http://localhost/AppCV/";

//Para bloquear el acceso a las paginas sin sesion desde fuera por el navegador o redireccionar directamente al login
if(!isset($_SESSION['usuario'])){
  header("Location:".$url_base."login.php");
}

?>

<!--bs5 + tab para crear estructura HTML con bootstrap-->
<!doctype html>
<html lang="es">

<head>
  <title>AppCV</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

      <!-- Estilos del DataTable-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
      <!-- Funcionalidades de datatable-->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <!--Mensajes de alerta personalizados-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <!--bs5-nav-(elegir tipo de menu, en este caso minimal-ul)-->
  <nav class="navbar navbar-expand navbar-light bg-light">
      <div class="nav navbar-nav">
          <a class="nav-item nav-link active" href="<?php echo $url_base;?>" aria-current="page">Sistema <span class="visually-hidden">(current)</span></a>
          <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/empleados">Empleados</a>
          <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/puestos">Puestos</a>
          <a class="nav-item nav-link" href="<?php echo $url_base;?>secciones/usuarios">Usuarios</a>
          <a class="nav-item nav-link" href="<?php echo $url_base;?>cerrar.php">Cerrar Sesion</a>
          <p class="nav-item nav-link">Usuario: <?php echo $_SESSION['usuario'];?></p>
      </div>
  </nav>
  <main class="container">
    
  <?php
//Evalua si hay un mensaje en el navegador
 if(isset($_GET['mensaje'])){?>
<script>
    //Si lo hay mostrará el icono de realizado con el mensaje
    Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje'];?>"});
    
</script>
<?php }?>