<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" type="text/css" href="theme.css">
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <title>Tienda virtual</title>
</head>
<body>
  <div id="cabecera">
    <h2>Bienvenid@ a MediaDaw</h2>
    <a href="logout.php"><img src="img/inicio1.gif" alt="carro" height="90" width="80" style="margin-left: 9%;"></a>
<?php
session_cache_limiter();
	session_name('cesta');
	session_start();
session_destroy();
echo "<div align='center' id='contenido'></div>";
echo "<br>";
echo "<h2><center>Compra Anulada</center></h2>";
echo '<center><a href="empezar.php"> Volver </a></center>';

?>
