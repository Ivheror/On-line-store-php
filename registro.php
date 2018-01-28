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
	<div id="cabecera">
		<h2>Bienvenid@ a MediaDaw</h2>
		<a href="index.php"><img src="img/inicio1.gif" alt="carro" height="90" width="80" style="margin-left: 9%;"></a>
	</div>
	<?php 
	echo '
	<a href="index.php">Volver a la página principal</a>
	<div id="caja">
	<form class="form-horizontal" action="datos_registro.php" method="post" accept-charset="utf-8">
	<fieldset>
	<center> 
	<legend>Formulario de Registro</legend>
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
	<button type="submit" class="btn btn-primary" style="cursor:pointer;">Dar de alta</button>
	<button type="reset" class="btn btn-danger" style="cursor:pointer;">Cancelar</button>
	<br>
	</center>
</fieldset>
</form></div>';
	?>
</body>
</html>


