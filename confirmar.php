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
if (!isset($_GET['cliente']) || $_GET['cliente']=="admin") 
{
	echo "<center><h1>No tienes permiso para estar aqui</h1></center>";
	header("Refresh:2; url=logout.php", true, 303); //salgo y cierro sesion para poder comprobar la introduccion de datos con el administrador
	exit();
}
session_cache_limiter();
session_name('cesta');
session_start(); 
echo "<div align='center'></div>";
echo "<br>";
echo "<div align='center'>";

$usuario=$_GET['cliente'];//aqui tengo el nombre , pero necesito su dni para meterlo en la columna de dni cliente
$conexion=mysqli_connect("localhost","root","","tienda")or die ("Imposible conectar");
$buscarDni="SELECT dni from clientes where nombre like '$usuario'";
$resultBuscar=mysqli_query($conexion,$buscarDni)or die("No se realizo la consulta para el dni");
while ($fila=mysqli_fetch_array($resultBuscar,MYSQLI_NUM)) 
{
	$dni=$fila[0];
}
$total=$_GET['total'];//aqui el total de productos que el tio a comprado
$productos=$_SESSION['producto'];
$consultaNum="SELECT count(NUM_PEDIDO)+1 from pedidos";//porque voy a contar los num pedidos , como un ejercicio que usamos max(count)para no hacerlo todo autonumerico 
$resultNum=mysqli_query($conexion,$consultaNum)or die("Imposible hacer NUM PEDIDO");
$contador=1; 
while ($filaNum=mysqli_fetch_array($resultNum,MYSQLI_NUM)) 
{
	$consulta="INSERT INTO pedidos(`NUM_PEDIDO`, `dni_cliente`, `fecha`, `total_pedido`) VALUES ($filaNum[0],'$dni',now(),$total)";//en filaNum[0] tengo el maximo 
	$resultadoInsert=mysqli_query($conexion,$consulta)or die("Imposible hacer la consulta");
	if ($resultadoInsert) 
	{
		echo "<h1>Compra realizada con éxito,saliendo...</h1>"; //si sale bien muestro el mensaje
		echo "<h3>Gracias por su visita!</h3>";
		echo "<br>";   
	}	
	foreach ($productos as $nombreProducto) 
	{
		$consulta_num_producto="SELECT cod from producto where nombre like '".$nombreProducto."' ";
		$resultado_num_producto=mysqli_query($conexion,$consulta_num_producto)or die ("Imposible sacar el cod del producto");
		$fila_num_producto=mysqli_fetch_array($resultado_num_producto,MYSQLI_NUM);
		$fila_num_producto[0];//aqui tengo el codigo del producto a meter en la tabla de lineas
		$consulta_lineas="INSERT INTO lineas(`num_pedido`, `num_linea`, `producto`) VALUES ($filaNum[0],$contador,$fila_num_producto[0])";
		$resultadoInsert_lineas=mysqli_query($conexion,$consulta_lineas)or die("Imposible hacer la consulta 2");
		if ($resultadoInsert_lineas) 
		{
			$contador++;//incremento para el siguiente pedido			
		}

		//quedaria quitar stock de la tabla productos con un update para cada nombre de producto
		$update="UPDATE producto set stock=stock-1 where nombre='$nombreProducto'";
		$resultaUpdate=mysqli_query($conexion,$update)or die("Imposible modificar");
		
	}
	if ($resultaUpdate) 
	{
		echo "Stock modificados correctamente";
	}
	
}	
header("Refresh:2; url=logout.php", true, 303); //salgo y cierro sesion para poder comprobar la introduccion de datos con el administrador
echo "</div>";
?>