<?php
include("../../bd.php");

//Obtenemos los datos del empleado mediante su ID
if(isset($_GET['txtID'])){
    //Si existe este dato lo asignamos, sino lo asignamos como vacio
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    //Buscar el archivo (foto y pdf) relacionado con el empleado cuando el id sea encontrado
    $sentencia = $conexion->prepare("SELECT * ,(SELECT nombre_puesto FROM tbl_puestos WHERE tbl_puestos.id = tbl_empleados.id_puesto LIMIT 1) as puesto FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia -> execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    //print_r($registro);

    //En esta variable asignamos lo que vale el campo concreto
    $primer_nombre = $registro["primer_nombre"];
    $segundo_nombre = $registro["segundo_nombre"];
    $primer_apellido = $registro["primer_apellido"];
    $segundo_apellido = $registro["segundo_apellido"];
    $foto = $registro["foto"];
    $cv = $registro["cv"]; 
    $id_puesto = $registro["id_puesto"];
    $fecha_ingreso = $registro["fecha_ingreso"];
    $puesto = $registro["puesto"];

    $nombreCompleto = $primer_nombre." ".$segundo_nombre." ".$primer_apellido." ".$segundo_apellido;

    //Obtenemos fecha actual formato europeo
    $fecha = date("d-m-Y");

    //Para calcular el tiempo entre el inicio de una fecha y la actual 
    //Obtenemos la fecha de inicio
    $fechaInicio = new DateTime($fecha_ingreso);
    //Obtenemos la fecha actual
    $fechaFin = new DateTime(date('Y-m-d'));
    //Se calcula la diferencia entre ambas
    $diferencia = date_diff($fechaInicio,$fechaFin);
    //Para mostrarlo tendremos que indicar que queremos la diferencia en el tiempo que decidamos, en este caso en años, para ello obtendremos el atributo -> y
}
//Todos los html que pongamos a partir de aqui se va a guardar en esta variable
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendación</title>
</head>
<body>
    <h1>Carta de Recomendación Laboral</h1>
    <br><br>
    Albatera Alicante, España a <strong><?php echo $fecha;?></strong>
    <br><br>
    A quien pueda interesar.
    <br><br>
    Reciba un cordial saludo.
    <br><br>

    A través de estas líneas deseo hacer de su conocimiento que Sr(a) <strong><?php echo $nombreCompleto; ?></strong>
    quien trabajó en mi organizacion durante <strong><?php echo $diferencia->y;?> año(s)</strong>
    es un ciudadano con una conducta intachable. Ha demostrado ser un gran trabajador, comprometido, responsable y fiel cumplidor de sus tareas.
    Siempre ha manifestado preocupacion por mejorar, capacitarse y actualizar sus conocimientos.
    <br><br>
    Durante estos años se ha desempeñado como: <strong><?php echo $puesto; ?> </strong>
    Es por ello le sugiero esta recomendación, con la confianza de que estará siempre a la altura de sus compromisos y responsabilidades.
    <br><br>
    Sin más nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi número de contacto para cualquier información de interés.
    <br><br><br><br><br><br>
    ________________________
    <br>
    Atentamente,
    <br>
    Ing. Marco Licinio Craso.
</body>
</html>

<?php
//Creamos variable que obtendra todo el html presentado en el formato, pero para poder usar esta propiedad hay que crear antes ob_start

$HTML = ob_get_clean();

//Desde la página https://github.com/dompdf/dompdf/releases descargamos el repositorio dompdf_2-0-3.zip, el contenido lo extraemos dentro de nuestra carpeta libs
require_once("../../libs/autoload.inc.php");

//Usaremos esta clase
use Dompdf\Dompdf;

//Creamos nuestro objeto Dompdf
$dompdf = new Dompdf();

//Guardamos las activaciones a las obtenciones de las opciones para poder asignarlas a parametros.
$opciones = $dompdf->getOptions();

//Para poder ver todos los archivos
$opciones->set(array("isRemoteEnabled" =>true));

//Activamos las opciones
$dompdf->setOptions(($opciones));

//Le pasamos un documento HTML
$dompdf->load_html($HTML);

//Tipo de papel a utilizar
$dompdf->setPaper('letter');

//Para renderizar
$dompdf->render();

//Mostrar el archivo enviandole archivos para hacer un atach y poder descargar este archivo
$dompdf->stream("archivo.pdf",array("Atacchment"=>false));
?>