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
echo "<div align='center'>";

$foto_name= $_FILES['foto']['name'];
$foto_size= $_FILES['foto']['size'];
$foto_type=  $_FILES['foto']['type'];
$foto_temporal= $_FILES['foto']['tmp_name'];
$lim_tamano= $_POST['lim_tamano'];
$foto_titulo= $_POST['titulo'];

if ($foto_type=="image/x-png" OR $foto_type=="image/png"){
 $extension="image/png";
 }
if ($foto_type=="image/jpeg" ){
 $extension="image/jpeg";
 }
if ($foto_type=="image/gif" ){
 $extension="image/gif";
 }

if ($foto_name != "" AND $foto_size != 0
                           AND $foto_titulo !='' AND
                        $foto_size<=$lim_tamano AND $extension !=''){

$f1= fopen($foto_temporal,"rb");
	
$foto_reconvertida = fread($f1, $foto_size);
	
$foto_reconvertida=addslashes($foto_reconvertida);

$base="tienda";
$tabla="fotos";
$n=$_POST["clave"];
$conexion=mysqli_connect ("localhost","root","",$base);
$sacar = "SELECT num_ident FROM ".$tabla." WHERE (num_ident=$n)" ;
$resultado = mysqli_query($conexion,$sacar);
$fila=mysqli_fetch_row($resultado);
$num_registros=mysqli_num_rows($resultado);
if ($num_registros==0)
	{$meter="INSERT INTO ".$tabla;
	 $meter .=" (num_ident, imagen, nombre, tamano, formato) ";
	 $meter .=" VALUES(".$_POST["clave"].",'$foto_reconvertida','$foto_titulo',";
	 $meter .= "$foto_size, '$extension')";
	 $mensaje= "Foto guardada en la tabla";}
else
{
$meter="UPDATE $tabla SET imagen='".$foto_reconvertida."' WHERE num_ident=$n";
$mensaje="<h2>Se ha cambiado la imagen del producto</h2>";

}
    if (mysqli_query($conexion,$meter))
    {
        echo $mensaje;
		header("Refresh:1; url=empezar.php", true, 303);
    }else
    {	
		print "mysqli_error" ;
		echo '<script language="javascript">alert("Ha habido algun error");</script>';
		header("Refresh:1; url=index.php", true, 303);
    }
}else{
    echo "<h2>No ha podido transferirse el fichero</h2>";
 }
echo "</div>";
mysqli_close($conexion);
?>
</body>
</html>
