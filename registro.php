<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="prueba.css" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#forma").submit(function(e) {
        e.preventDefault();
		var cont=true;
		$("#forma input,#forma textarea").each(function(index, element) {
            if($(this).val().length == 0) cont = false;
        });
		if(!cont)
		{
			alert("Tienes que llenar todos los campos!");
			return false;
		}
		cont = true;
		$("#forma input[name='nombre'],#forma input[name='apellido']").each(function(index, element) {
            if($(this).val().length > 32) cont = false;
        });
		if(!cont)
		{
			alert("Te has pasado de los 32 caracteres en el nombre o apellido, corrigelo!");
			return false;
		}
		if($("#forma input[name='password']").val().length > 20)
		{
			alert("Te has pasado de los 20 caracteres en el password, corrigelo!");
			return false;
		}
		if(!(/\w+@\w+\.\w+/).test($("#forma input[name='email']").val()))
		{
			alert("Escribe un correo real");
			return false;
		}
		var data=new FormData($("#forma")[0]);
		$.ajax({  
			url: "registro2.php",  
			type: "POST",  
			data: data,  
			processData: false,  // tell jQuery not to process the data  
			contentType: false,  // tell jQuery not to set contentType  
			success: function(data) {
				data = JSON.parse(data);
				if(data.success)
				{
					alert("Te has registrado correctamente!");
					window.location.href = "index.php";
				}
				else
					alert("Ya existe un usuario con ese correo registrado");
			}
		});
    });
});
</script>
</head>
<body>
<div class="principal">
<div class="header">
<div class="logo"></div>
<div class="esq-sup-der"><?php if(isset($_SESSION['id'])) {?><a href="logout.php">Logout</a><br /><img class="foto" src="usuarios/<?=$_SESSION['id']?>" /><br /><?=$_SESSION['nombre']?><?php } else { ?><a href="registro.php">Registrarte</a> | <a href="login.php">Iniciar sesion</a><?php } ?></div>
<div class="esq-inf-der"><form action="busqueda.php" method="get"><input type="text" id="buscar" name="q" placeholder="Buscar..." /><span class="lupa"></span></form></div>
</div>
<ul class="navegacion">
<li><a href="index.php">Home</a></li><li><a href="comunidadesv.php">Comunidades</a></li><li><a href="comunidadd.php">Comunidad</a></li><?php if(isset($_SESSION['id'])) { ?><li>Mi Perfil</li><li><a href="agregar.php">Subir Noticia</a></li><?php } ?>
</ul>
<div class="contenido">
<div class="registro">
<p>REGISTRATE</p>
<form id="forma" action="registro2.php" id="forma" method="post" enctype="multipart/form-data">
<input type="text" placeholder="Email:" name="email"><br />
<input type="password" placeholder="Password:" name="password"><br />
<input type="text" placeholder="Nombre:" name="nombre"><br />
<input type="text" placeholder="Apellido:" name="apellido"><br />
<input type="text" placeholder="Escuela:" name="escuela"><br />
<input type="file" placeholder="Foto:" name="foto" /><br />
<div class="registro-footer">
<div class="registro-social">
O registrate con:<br />
<img src="images/facebook.png" /><img src="images/twitter.png" /><img src="images/google.png" />
</div>
<input type="submit" class="aceptar" value="Aceptar" />
</div>
</form>
</div>
</div>
<div class="comunidades"></div>
<div class="footer">
<ul class="lista">
<li><a href="index.php">Inicio</a></li> | <li><a href="quienes.php">Quienes somos</a></li> | <li><a href="mailto:ecopagsoporte@hotmail.com">Contacto</a></li> | <li><a href="terminos.php">Términos y condiciones</a></li>
</ul>
<a href="https://www.facebook.com/eco.ambientes" target="_blank"><img src="images/facebook.png" /></a><a href="https://twitter.com/#!/EcoItesm" target="_blank"><img src="images/twitter.png" /></a><a href="https://plus.google.com/u/0/101277163475432095165" target="_blank"><img src="images/google.png" /></a>
</div>
</div>
</body>
</html>