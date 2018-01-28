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
 	echo "<div align='center'></div>";
 	echo "<br>";
if (!isset($_GET['cliente']) || $_GET['cliente']=="admin") 
{
	echo "<center>El admin no puede comprar</center>";
	header("Refresh:1; url=logout.php", true, 303); //salgo y cierro sesion 
    exit();
}
if (!isset($_GET["borrar"]))
{
if (isset($_GET["precio"]) && isset($_GET["producto"]))
{
if (isset($_SESSION["producto"]))
// si tengo productos en la cesta
{
	$dimension=COUNT($_SESSION["producto"]);
	if (!in_array($_GET["producto"],$_SESSION["producto"]))
	{
		$_SESSION["contador"]=$_SESSION["contador"]+1;
		$_SESSION["producto"][]=$_GET["producto"];
		$_SESSION["precio"][]=$_GET["precio"];
		$_SESSION["unidades"][]=1;
		$_SESSION["total"]=$_SESSION["total"]+$_GET["precio"];
	}
	else
	{
		$indice=array_search($_GET["producto"],$_SESSION["producto"]);
		$_SESSION["unidades"][$indice]=$_SESSION["unidades"][$indice]+1;
		$_SESSION["total"]=$_SESSION["total"]+$_GET["precio"];
	}
}
else
//si cesta vacia inicializo variables de sesion
{$_SESSION["contador"]=1;
$_SESSION["producto"][0]=$_GET["producto"];
$_SESSION["precio"][0]=$_GET["precio"];
$_SESSION["unidades"][0]=1;
$_SESSION["total"]=$_GET["precio"];}
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
}
echo "</div>";


}
else
{
	$borrarindice=$_GET["valor"];
	$_SESSION["total"]=$_SESSION["total"]-$_SESSION["precio"][$borrarindice]*$_SESSION["unidades"][$borrarindice];
	$_SESSION["contador"]=$_SESSION["contador"]-1;
	if ($_SESSION["contador"]==0)
	{
	unset($_SESSION);
	session_destroy();
	}
	else
	{unset($_SESSION["precio"][$borrarindice]);
	unset($_SESSION["producto"][$borrarindice]);
	unset($_SESSION["unidades"][$borrarindice]);
	}
	

}
mostrar();
/*echo "<pre>";
print_r($_SESSION); //esto para saber lo que me llega de la sesion de la cesta;
echo "</pre>";*/
function mostrar()
{
$cabecera='<table border="1 ridge" align="center" width="40%"><caption>Productos actuales de su cesta</caption>';
$cabecera.= '<tr><th>Productos</th><th>Unidades</th><th>Precio</th><th>Subtotal</th><th>Borrar?</td></tr>';
if (isset($_SESSION["producto"]))
{$productos=$_SESSION["producto"];
$precios=$_SESSION["precio"];
$unidades=$_SESSION["unidades"];
$dimension=COUNT($productos);
echo $cabecera;
foreach ($productos as $indice=>$valor)
	{$mostrar1="<tr><td>".$valor."</td><td>".$unidades[$indice];
	 $mostrar1.="</td><td>".$precios[$indice]."</td>"."<td>".$unidades[$indice]*$precios[$indice];
	 $mostrar1.="<td width=20><a href=cesta.php?borrar=S&valor=$indice&cliente=".$_GET['cliente'].">"."<img title='Eliminar' src='img/eliminar.png' width=\"100%\" heigth=\"20%\"
			 ></a></td></tr>";
	 echo $mostrar1;
	 }		
	
			  
    

echo"<tfoot>
    <tr>
      <td colspan=3 align='center'>Suma</td>
      <th colspan=2>Total: ".$_SESSION['total']." €"."</th>
    </tr>
  </tfoot>
</table>";
echo "<table id='enlaces'align='center'><tr><td>";
echo "<a href='empezar.php'>Seguir Comprando</a>";
echo "</td><td>";
echo "<a href='Anular.php'>Anular Compra</a>";
echo "</td><td>";
echo "<a href='confirmar.php?cliente=".$_GET['cliente']."&total=".$_SESSION['contador']."'>Confirmar Pedido</a>";//mando por get el nombre del que tiene iniciada la sesion para poder introducirlo en la base de datos en la tabla de pedidos con un dni que sacare con una consulta en confirmar.php
echo "</td></tr></table>";
}
else
	{echo "<div align='center'></div>";
 	echo "<br>";
		echo "<h2><center>Cesta vacia</center></h2>";
		echo '<center><a href="empezar.php"> Volver </a></center>';
	}
}
?>
