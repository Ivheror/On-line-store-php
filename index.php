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
		echo "<div align='center'>Échale un vistazo a nuestros productos !</div>";
		echo "<br>";
		$conexion=mysqli_connect("localhost","root","","tienda") or die ("Imposible conectarse con la base de datos");
		mysqli_set_charset($conexion,"utf8");
		if (!isset($_POST['envio'])) 
		{
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
		echo "<center>Selecciona alguna gama de producto aplicando uno de los filtros</center>";
		mysqli_close($conexion);
	?>
</body>
</html>