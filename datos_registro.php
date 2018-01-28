<?php  
$dni=$_POST['dni'];
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$usuario=$_POST['usuario'];
$password=$_POST['password'];
$passEncrypt=crypt($password,'');
//echo $dni."<br>".$nombre."<br>".$direccion."<br>".$usuario."<br>".$passEncrypt;


$conexion=mysqli_connect("localhost","root","","tienda") 
			or die ("Imposible realizar conexion");
$consulta="SELECT COUNT(*) from clientes where usuario='$usuario'";
$resultado=mysqli_query($conexion,$consulta) or die("No se ejecuto la consulta");
$numero_registros=mysqli_fetch_array($resultado,MYSQLI_NUM);
foreach ($numero_registros as $value) 
{
	if ($value==0) 
	{
		$insertar="INSERT INTO CLIENTES 
				  VALUES('$dni','$nombre','$direccion','$usuario','$passEncrypt');";
		$resultado_insert=mysqli_query($conexion,$insertar) or die ("Fallo al insertar");
		echo '<script language="javascript">alert("Usuario dado de alta");</script>';
		header("Refresh:1; url=index.php", true, 303); //sirve para refrescar la pagina porque al usar location se hace tan rapido que el alert no llega a aparecer.
	}
	else
	{
		echo '<script language="javascript">alert("Usuario en uso , eliga otro");</script>';
		header("Refresh:1; url=registro.php", true, 303); //sirve para refrescar la pagina porque al usar location se hace tan rapido que el alert no llega a aparecer.
	}
}
?>