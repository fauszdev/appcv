<?php
//Url base para que no haya problema a la hora de redireccionar con las paginas del Nav
$url_base="http://localhost/AppCV/";

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
      </div>
  </nav>
  <main class="container">