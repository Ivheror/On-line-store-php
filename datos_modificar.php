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
                header("Refresh:1; url=logout.php", true, 303); 
                exit();
            }
        }
//datos a modificar
$dni=$_POST['dni'];
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$usuario=$_POST['usuario'];
$password=$_POST['password'];
$passEncrypt=crypt($password,'');
/*
echo $_SESSION['usuario']."<br>";
echo $dni."<br>";
echo $nombre."<br>";
echo $direccion."<br>";
echo $usuario."<br>";
echo $password."<br>";
echo $passEncrypt."<br>";
*/
$conexion=mysqli_connect("localhost","root","","tienda") or die ("Imposible realizar conexion");
$consulta="UPDATE CLIENTES SET dni=$dni, nombre='$nombre', direccion='$direccion', usuario='$usuario', password='$passEncrypt' 
          where usuario='".$_SESSION['usuario']."'";
$resultado=mysqli_query($conexion,$consulta) or die ("No se realizo el update, puede que ya este en la base de datos , o tenga pedidos ya");
if ($resultado=mysqli_query($conexion,$consulta)==true)
{
	echo '<script language="javascript">alert("Usuario MODIFICADO");</script>';
	header("Refresh:1; url=index.php", true, 303); //sirve para refrescar la pagina porque al usar location se hace tan rapido que el alert no llega a aparecer.
}
mysqli_close($conexion);
?>