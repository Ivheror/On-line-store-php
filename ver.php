<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style type="text/css" media="screen">
  	.zoom{
        /* Aumentamos la anchura y altura durante 2 segundos */
        transition: width 2s, height 2s, transform 2s;
        -moz-transition: width 2s, height 2s, -moz-transform 2s;
        -webkit-transition: width 2s, height 2s, -webkit-transform 2s;
        -o-transition: width 2s, height 2s,-o-transform 2s;
    }
    .zoom:hover{
        /* tranformamos el elemento al pasar el mouse por encima al doble de
           su tamaño con scale(2). */
        transform : scale(2);
        -moz-transform : scale(2);      /* Firefox */
        -webkit-transform : scale(2);   /* Chrome - Safari */
        -o-transform : scale(2);        /* Opera */
    }
  </style>
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
  echo "<div align='center'>Producto seleccionado</div>";
  echo "<center><h3>NOTA:*PUEDES AMPLIAR LA IMAGEN AL PASAR EL RATON POR ENCIMA*</h3></center>";
  echo "<br>";
  if (!isset($_GET['n'])) 
  {
    echo "<center><h1>Debe seleccionar un producto de la lista</center></h1>";
    header("Refresh:1 url=empezar.php");
    exit();
  }
  $n=$_GET['n'];

  $conexion=mysqli_connect ("localhost","root","","tienda")or die("Imposible conectarse con la base de datos");
  mysqli_set_charset($conexion, "utf8");
  $cadsql="SELECT * FROM producto where producto.cod=$n";

  $resultado0 = mysqli_query($conexion,$cadsql)or die ("Imposible realizar la consulta del producto");
  $fila0= mysqli_fetch_array($resultado0);
  echo "<div align='center'>";
  ?>
  <?php
  $sacar = "SELECT count(*) FROM fotos WHERE (num_ident=$n)" ;
  $resultado = mysqli_query($conexion,$sacar);
  $fila=mysqli_fetch_row($resultado);
  $num_registros=$fila[0];
  if ($num_registros<>0)
  {
  	echo "<div align='center' class='zoom' style='width:20%;'>";
  		    echo "<img src='imagen.php?n=".$n."'>";
  	echo "</div>";
  }
  else
  {
  echo "<img src=img/noimg.png>";
  }
  echo "</td></tr></table>";
  echo "</div>";
  echo "</div>";
  mysqli_close($conexion);
  ?>
	<hr>
	<h3><center>Detalles del producto</h3></center>
  	<?php  
  	echo "<div style='margin-left:20%;'>";
  	echo "<table cellspacing='40'>";
  	echo "<tr><td>Codigo del producto: ".$fila0[0]."<br>"."Nombre: ".$fila0[1]."<br>"."Descripción: ".$fila0[2]."<br>"."</td>
  		 <td>Precio: ".$fila0[3]."<br>"."Familia: " .$fila0[4]."<br>"."Stock del producto: ".$fila0[5]."<br>"."</td></tr>";
  	echo "</table>";
  	echo "</div>";
  	echo '<center><a href="empezar.php"> Volver </a></center>';
  	?>
	