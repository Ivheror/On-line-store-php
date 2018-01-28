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
	<?php  
		session_cache_limiter();
		session_name('tienda');
		session_start();	
		if (!isset($_SESSION['usuario']) || $_SESSION['usuario']!="admin") //con esto controlo que un usuario no vea TODOS los pedidos cosa de admin
        {
            if (isset($_POST['user'])) 
            {
                $_SESSION["usuario"]= $_POST["user"];
                $_SESSION["clave"]= $_POST["pass"];
            }
            else
            {
                header("Refresh:1; url=logout.php", true, 303); //salgo y cierro sesion para que no se cree una sesion con un usuario que no existe y tengas que cerrar el navegador
                exit();
            }
        }
	?>
	<div id="cabecera">
		<h2>Bienvenid@ a MediaDaw</h2>
		<a href="logout.php"><img src="img/inicio1.gif" alt="carro" height="90" width="80" style="margin-left: 9%;"></a>
		<div id="contenido">
			<br>
			<br>
			<center>		
			<?php			
					echo "<h3>Bienvenido de nuevo , ".$_SESSION['usuario']."<h3>"; 
					if ($_SESSION['usuario']=="admin") 
					{
						echo "<a href='pedidos.php'><img src='img/pedidos.png' title='Ver pedidos' height='40' width='50'></a>";
					}
					else
					{
						echo "<a href='modificar.php'><img src='img/misdatos.png' title='Mis datos - Modificar' height='40' width='40'></a>";
						echo "<a href='cesta.php?cliente=".$_SESSION['usuario']."'><img src='img/cesta.png' title='Ver cesta' height='40' width='40'></a>";

					}
					echo "<a href='logout.php'><img src='img/logout.png' title='Cerrar sesión' height='40' width='40'></a>";
					
			?>	
			</center>
		</div>
		<br>
		</div>
<?php
echo "<div align='center'>";
echo "Datos devueltos para todos los pedidos";
$conexion=mysqli_connect("localhost","root","","tienda");
$cuantos="SELECT COUNT(*) FROM PEDIDOS";  //compruebo a ver si existen pedidos en la base de datos, si es asi los muestro , sino doy un mensaje de error
$rsetCuantos=mysqli_query($conexion,$cuantos);
$fila_cuantos=mysqli_fetch_array($rsetCuantos,MYSQL_NUM);
if ($fila_cuantos[0]==0) //si es 0 el count no tengo pedidos con lo cual muestro un mensaje y doy la opcion para volver atras
{
	echo "<div align='center' style='margin-top:2%;'>";
	echo "No hay pedidos aún.";
	echo "</div>";
	echo '<a href="empezar.php">Volver</a>';
	echo "</div>"; 	
}
else
{
	$consulta="SELECT * FROM PEDIDOS";
	$resultado=mysqli_query($conexion,$consulta);
	echo "<div align='center' style='margin-top:2%; border-collapse: collapse;'>";
	echo "<table border=1>";
	echo "<tr><th>Numero de pedido</th><th>Dni cliente</th><th>Fecha</th><th>Total</th></tr>";
	while ($fila=mysqli_fetch_array($resultado,MYSQL_NUM)) 
	{
		echo "<tr><td>".$fila[0]."</td><td>".$fila[1]."</td><td>".$fila[2]."</td><td>".$fila[3]."</td></tr>";
	}
	echo "</table>";
	echo "</div>";
	echo '<a href="empezar.php">Volver</a>';
	echo "</div>";
}
?>
	
</body>
</html>