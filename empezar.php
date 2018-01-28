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
	include('lib/password.php');	
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
            else //controlo que no puedan acceder por la url
            {
                header("Refresh:1; url=logout.php", true, 303); //salgo y cierro sesion para que no se cree una sesion con un usuario que no existe y tengas que cerrar el navegador
                exit();
            }
        }
		
		$conexion=mysqli_connect("localhost","root","","tienda")or die("Imposible realizar la conexion");
		mysqli_set_charset($conexion,"utf8");
		$consulta="SELECT password from clientes where usuario='".$_SESSION["usuario"]."'";
		$resultado_consulta=mysqli_query($conexion,$consulta)or die ("No se ha realizado la consulta");
		$totalFilas=mysqli_num_rows($resultado_consulta);
		if ($totalFilas==0) 
		{
			echo '<script language="javascript">alert("Error: Datos incorrectos, introduzca bien sus datos");</script>';
			header("Refresh:1; url=index.php", true, 303); //sirve para refrescar la pagina porque al usar location se hace tan rapido que el alert no llega a aparecer.
		}
		while ($fila_c=mysqli_fetch_array($resultado_consulta,MYSQLI_NUM)) 
		{
			if(password_verify($_SESSION["clave"],$fila_c[0]))
			{
				echo '<script language="javascript">alert("Correcto: Cargando  . . .");</script>';
			}
			else 
			{
				echo '<script language="javascript">alert("Error: Contraseña o usuarios incorrectos");</script>';	// si no tiene la contraseña bien puesta
				session_unset('tienda');//desmonto la sesion por si entras con un usuario que no esta en la base de datos que no se cree una sesion , sino que se elimine
				header("Refresh:1; url=index.php", true, 303);		  
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
				if ($totalFilas>0) 
				{
					echo "<h3>Bienvenido de nuevo , ".$_SESSION['usuario']."<h3>"; 
					if ($_SESSION['usuario']=="admin") 
					{
						echo "<a href='pedidos.php'><img src='img/pedidos.png' title='Ver pedidos' height='40' width='50'></a>";
					}
					else
					{
						echo "<a href='modificar.php'><img src='img/misdatos.png' title='Mis datos - Modificar' height='40' width='40' style='margin-left:5%;'></a>";
						echo "<a href='cesta.php?cliente=".$_SESSION['usuario']."'><img src='img/cesta.png' title='Ver cesta' height='40' width='40' style='margin-left:5%;'></a>";

					}
					echo "<a href='logout.php'><img src='img/logout.png' title='Cerrar sesión' height='40' width='40' style='margin-left:5%;'></a>";
				}
				else
				{
					session_unset('tienda');//desmonto la sesion por si entras con un usuario que no esta en la base de datos que no se cree una sesion , sino que se elimine
					echo "<h3>Volviendo a la página ...</h3>";
					exit();					

				}
			?>	
			</center>
		</div>
		<br>
		</div>
		<?php 
		if ($_SESSION['usuario']!="admin") 
		{
		echo "<div align='center'>Échale un vistazo a nuestros productos !  ";
		echo "<br>";
		}
		else //con esto controlo que solo el usuario logeado vea o pueda ver la cesta en teoria ni admin ni invitado pueden
		{
			echo "<div align='center'>Échale un vistazo a nuestros productos ! ";
			echo "<br>";
		}
				echo "<div align='center'>";
				echo "<br>";
					$consulta1="SELECT * from producto";
					$resultado1=mysqli_query($conexion,$consulta1)or die("Algo va mal en la consulta");
					echo "<table border='1px' align='center' style='width:80%; border-collapse: collapse;'>";
					echo "<tr><th>Cod</th><th>Nombre</th><th>Descripcion</th><th>Precio</th><th>Familia</th><th>Stock</th><th>Imagen</th>";
					if ($_SESSION['usuario']!="admin") 
					{
						echo "<th>Comprar</th></tr>";//si el usuario es distinto de administrados , que suponemos que siempre va a ser admin saca otra tabla mas para poder comprar el producto
					}
					while ($fila2=mysqli_fetch_array($resultado1,MYSQLI_NUM)) 
					{
						if ($_SESSION['usuario']=="admin") 
						{
							echo "</tr><tr><td>".$fila2[0]."</td><td>".$fila2[1]."</td><td>".$fila2[2]."</td><td>".$fila2[3]."</td><td>"
							.$fila2[4]."</td><td>".$fila2[5]."</td><td><a href='formulario.php?n=$fila2[0]'><img src='img/subir.png' title='Asignar imagen' height='50' width='100'></td></a></tr>"; //si es admin puede poner fotos
						}
						else
						{
							echo "<tr><td>".$fila2[0]."</td><td>".$fila2[1]."</td><td>".$fila2[2]."</td><td>".$fila2[3]."</td><td>"
							.$fila2[4]."</td><td>".$fila2[5]."</td>
							<td><a href='ver.php?n=$fila2[0]'><img src='img/verp.png' title='ver' height='50' width='200'></td></td></a>";
							if ($fila2[5]=="0") 
							{
								echo "<td><center><img src='img/agotado.png' title='Producto agotado' height='50' width='180'></td></center>";
							}
							else
							{
							echo "<td><a href='cesta.php?producto=$fila2[1]&precio=$fila2[3]&cliente=".$_SESSION['usuario']."'><img src='img/agregar.png' title='Añadir a la cesta' height='50' width='200'></td></a></tr>"; //si es user puede ver el producto y comprarlo
							}
						}			
					}
					echo "</table>";
				echo "</div>";
			?>		
		<br>
	
	
</body>
</html>
