<?php

$seccion = '';
$accion = '';

// si me mandaron algo por get seccion lo guardo en la variable $seccion
if (isset($_GET['seccion'])) {
  $seccion = $_GET['seccion'];
}

// si me mandaron algo por get accion lo guardo en la variable $accion
if (isset($_GET['accion'])) {
  $accion = $_GET['accion'];
}

$archivo = $seccion . "_" . $accion . ".php";

if (!file_exists($archivo)) {
  $archivo = "inicio.php";
}

?>

<!doctype html>
<html lang="en">

<head>
  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestion de Ventas</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</head>

<body>

  <?php
  include "menu.php";

  include $archivo;
  // Este es un bloque de código PHP
  ?>


</body>

</html>