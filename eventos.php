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
		<a href="index.php"><img src="img/inicio1.gif" alt="carro" height="90" width="80" style="margin-left: 9%;"></a>
		<div id="contenido">
		<p><b><center>Por favor , regístrese o identifícate para comprar</b></p>
		<form action="empezar.php" method="post" accept-charset="utf-8">
			<table>
			 <tr><td>Usuario</td><td><input type="text" name="user"></td></tr>
			 <tr><td>Contraseña</td><td><input type="password" name="pass"></td></tr>
			</table>
			<center><input type="submit" name="envio" value="Entrar">
			<input type="reset" name="Cancelar"></center>
			No tienes una cuenta? <a href="registro.php">créala aquí</a>
		</form>
		</div>
		<br>
	</div>
	<?php
		$conexion=mysqli_connect("localhost","root","","tienda") or die ("Imposible conectarse con la base de datos");
		mysqli_set_charset($conexion,"utf8");
		echo "<div align='center'>Échale un vistazo a nuestros productos !</div>";
		echo "<br>";
		if (!isset($_POST['envio'])) 
		{
			if (!isset($_POST['tipo'])) 
			{
				echo "<center>Selecciona algun tipo de producto</center>";
				header("Refresh:1; url=logout.php", true, 303); //salgo y cierro sesion para que no se cree una sesion con un usuario que no existe y tengas que cerrar el navegador
                exit();
			}
			echo "<div align='center'>";
			echo '<form action="eventos.php" method="post" accept-charset="utf-8">';
			echo "<table>";
			echo '<tr><td>Tipo:</td><td><select name="tipo">';
			$consulta_tipo="SELECT distinct familia from producto";
			$result1=mysqli_query($conexion,$consulta_tipo)or die ("Imposible hacer la query");
			echo "<option value='todo'>Todo</option>";
			while ($fila_consulta_tipo=mysqli_fetch_array($result1,MYSQLI_NUM)) 
			{
				echo '<option value="'.$fila_consulta_tipo[0].'">'.$fila_consulta_tipo[0].'</option>';
			}
			echo '</select>';	
			echo "<tr><td>Buscar:</td><td><input type='text' name='busqueda'></td></tr>";
			echo '</td><td><input type="submit" name="buscar" value="Aplicar filtro"></td></tr>';
			echo "</table>";
			echo '</form>';
			echo "</div>";	
			echo "<br>";
		}
		$buscar=$_POST['busqueda'];
		if (!empty($_POST['busqueda'])) //doy prioridad a la busqueda
		{
			echo "<h3><center>RESULTADO DE LA BUSQUEDA</center></h3>";
			
			$consultaB="SELECT * from producto where nombre like '%".$buscar."%'";
			$resultadoB=mysqli_query($conexion,$consultaB)or die("Algo va mal en la consulta");
			if (mysqli_num_rows($resultadoB)>0) 
			{
				echo "<table border='1' align='center'>";
				echo "<tr><th>Cod</th><th>Nombre</th><th>Descripcion</th><th>Pvp</th><th>Familia</th><th>Stock</th></tr>";
				while ($filaB=mysqli_fetch_array($resultadoB,MYSQLI_NUM)) 
				{
					echo "<tr><td>".$filaB[0]."</td><td>".$filaB[1]."</td><td>".$filaB[2]."</td><td>".$filaB[3]."</td><td>"
					.$filaB[4]."</td><td>".$filaB[5]."</td></tr>";
				}
				echo "</table>";
				exit(); //cierro para que no se me duplique las cajas ya que sino saldria tanto la busqueda como el filtrado por tipos
			}
			else
			{
				echo "<center>No se encontraron registros para esa busqueda</center>";
				exit(); //cierro para que no se me duplique las cajas ya que sino saldria tanto la busqueda como el filtrado por tipos
			}		
		}
		$tipo=$_POST['tipo'];
		if ($tipo=="todo")
		{
			$consulta1="SELECT * from producto";
			$resultado1=mysqli_query($conexion,$consulta1)or die("Algo va mal en la consulta");
			echo "<table border='1' align='center'>";
			echo "<tr><th>Cod</th><th>Nombre</th><th>Descripcion</th><th>Pvp</th><th>Familia</th><th>Stock</th></tr>";
			while ($fila2=mysqli_fetch_array($resultado1,MYSQLI_NUM)) 
			{
				echo "<tr><td>".$fila2[0]."</td><td>".$fila2[1]."</td><td>".$fila2[2]."</td><td>".$fila2[3]."</td><td>"
				.$fila2[4]."</td><td>".$fila2[5]."</td></tr>";
			}
			echo "</table>";
		}
		else
		{
			$consulta1="SELECT * from producto where familia like '$tipo'";
			$resultado1=mysqli_query($conexion,$consulta1)or die("Algo va mal en la consulta");
			echo "<table border='1' align='center'>";
			echo "<tr><th>Cod</th><th>Nombre</th><th>Descripcion</th><th>Pvp</th><th>Familia</th><th>Stock</th></tr>";
			while ($fila2=mysqli_fetch_array($resultado1,MYSQLI_NUM)) 
			{
				echo "<tr><td>".$fila2[0]."</td><td>".$fila2[1]."</td><td>".$fila2[2]."</td><td>".$fila2[3]."</td><td>"
				.$fila2[4]."</td><td>".$fila2[5]."</td></tr>";
			}
			echo "</table>";
		}	
		mysqli_close($conexion);
	?>
</body>
</html>