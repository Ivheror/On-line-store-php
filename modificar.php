<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="theme.css">
	<link rel="icon" type="image/png" href="img/favicon.png" />

	<title>Tienda virtual</title>
</head>
<body>
	<?php     //permito que solo el usuario pueda entrar por url, ya que se sobreentiende que solo el puede tocar los usuarios para modificarlos
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
                header("Refresh:1; url=empezar.php", true, 303); 
                exit();
            }
        }
    
  ?>
	<div id="cabecera">
    <h2>Bienvenid@ a MediaDaw</h2>
    <a href="index.php"><img src="img/inicio1.gif" alt="carro" height="90" width="80" style="margin-left: 9%;"></a>
    <div id="contenido">
      <br>
      <br>
      <center>    
      <?php
          echo "<h3>Bienvenido de nuevo , ".$_SESSION['usuario']."<h3>"; 
         if ($_SESSION['usuario']=="admin") //arreglar, el admin no modifica nada
					{
						echo "<a href='pedidos.php'><img src='img/pedidos.png' title='Ver pedidos' height='40' width='50' style='margin-left:5%;'></a>";
					}
					else
					{
						echo "<a href='modificar.php'><img src='img/misdatos.png' title='Mis datos - Modificar' height='40' width='40' style='margin-left:5%;'></a>";
						echo "<a href='cesta.php?cliente=".$_SESSION['usuario']."'><img src='img/cesta.png' title='Ver cesta' height='40' width='40' style='margin-left:5%;'></a>";

					}
					echo "<a href='logout.php'><img src='img/logout.png' title='Cerrar sesión' height='40' width='40' style='margin-left:5%;'></a>";
      ?>  
      </center>
    </div>
    <br>
    </div>


	<?php
	echo '
	<a href="empezar.php">Volver a los productos</a>
	<div id="caja">
	<form class="form-horizontal" action="datos_modificar.php" method="post" accept-charset="utf-8">
	<fieldset>
	<center> 
	<legend>Introduce los datos para MODIFICARLOS</legend>
	<hr>
	<div class="form-group">
  		<label class="col-md-4 control-label" for="dni">Dni</label> 
  		<div class="col-md-4">
  			<input id="textinput" name="dni" placeholder="" class="form-control input-md" required="" type="text"> 
  		</div>
	</div>
	<div class="form-group">
  		<label class="col-md-4 control-label" for="nombre">Nombre</label>
 		<div class="col-md-4">
  			<input id="textinput" name="nombre" placeholder="" class="form-control input-md" required="" type="text">
  		</div>
	</div>
	<div class="form-group">
  		<label class="col-md-4 control-label" for="direccion">Direccion</label>  
  		<div class="col-md-4">
  			<input id="textinput" name="direccion" placeholder="" class="form-control input-md" required="" type="text">
    	</div>
	</div>
	<div class="form-group">
  		<label class="col-md-4 control-label" for="usuario">Usuario</label>  
  		<center> 
  		<div class="col-md-4">
  			<input id="textinput" name="usuario" placeholder="" class="form-control input-md" required="" type="text">
  	</div>
	</div>
	<div class="form-group">
  		<label class="col-md-4 control-label" for="password">Contraseña</label>
  		<div class="col-md-4">
    		<input id="passwordinput" name="password" placeholder="" class="form-control input-md" required="" type="password"> 
  		</div>
	</div>
	<button type="submit" class="btn btn-primary" style="cursor:pointer;">Modificar Usuario</button>
	<button type="reset" class="btn btn-danger" style="cursor:pointer;">Cancelar</button>
	<br>
	</center>
</fieldset>
</form></div>';
	?>

</body>
</html>


