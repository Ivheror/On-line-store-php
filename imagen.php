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
$base="tienda";
$tabla="fotos";
if (!isset($_GET['n'])) 
{
	header("Refresh:1; url=logout.php", true, 303); //salgo y cierro sesion para que no se cree una sesion con un usuario que no existe y tengas que cerrar el navegador
	exit();

}
$numero=$_GET['n'];
$conexion=mysqli_connect ("localhost","root","",$base);
$sacar = "SELECT * FROM ".$tabla." WHERE (num_ident=$numero)" ;
$resultado = mysqli_query($conexion,$sacar);
if ($registro = mysqli_fetch_array($resultado))
{  
	  $tipo_foto=$registro['formato'];
	  header("Content-type: $tipo_foto");	  
	  echo $registro['imagen'];
}
mysqli_close($conexion);
?>