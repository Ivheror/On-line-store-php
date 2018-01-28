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
		if (!isset($_SESSION['usuario'])) 
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
						echo "<a href='logout.php'><img src='img/logout.png' title='Cerrar sesión' height='40' width='40' style='margin-left:5%;'></a>";
					}
					else
					{
						echo "<center>No tienes permiso para estar en esta pagina</center>";
						header("Refresh:2; url=logout.php", true, 303); //salgo y cierro sesion 
    					exit();
					}
			?>	
			</center>
		</div>
		<br>
		</div>

<?php
if (isset($_GET['n'])) //controlo que llege algo de get n para que el administrador no entre por url a formulario.php
{
	$clave=$_GET['n'];
	echo "<div style='margin-left:40%;'>Seleccionar imagen para el artículo: ".$clave."</div>";
}
else
{
	echo "<div align='center'>Error , no puedes pasar. ";
	echo "<br>";
	echo"<center><h3>Selecciona un producto haciendo clic en Subir!</h3></center>";
	header("Refresh:2; url=empezar.php", true, 303); //salgo y cierro sesion 
	exit();
}

?>
<FORM ENCTYPE="multipart/form-data" ACTION="grabar_img.php" METHOD="post" align="center">
<INPUT type="hidden" name="lim_tamano" value="65000">
<INPUT type="hidden" name="clave" value=<?php echo $clave; ?>>
<p><b>Selecciona la imagen a transferir: <b><br>
<INPUT type="file" name="foto"><br>
<p><b>Título la imagen: <b><br>
<INPUT TYPE="text" NAME="titulo" value="<?php echo $clave?>" />
<p><INPUT type="submit" name="enviar" value="Aceptar"></p>
<a href="empezar.php">Volver</a>
</FORM>
<?php echo "</div>"; ?>
	
</body>
</html>