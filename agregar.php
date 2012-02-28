<?php session_start(); if(!isset($_SESSION['id'])) die(''); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="prueba.css" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#personalizar,#rapido").click(function(e) {
        $("#not-rap,#not-det").toggle();
    });
	$("#cancelar").click(function(e) {
        window.location.href = 'index.php';
    });
	$("#agregar").click(function(e) {
        $("#f-det").submit();
    });
	$("#video").change(function(e) {
        var reg=/https?:\/\//g;
		var t=$(this).val();
    });
	$("#imagen").change(function(e) {
        var r=new FileReader();
		r.onload = function(e) {
			$("#imagenp").attr("src", e.target.result);
		}
		r.readAsDataURL(this.files[0]);
    });
});
</script>
</head>
<body>
<div class="principal">
<div class="header">
<div class="logo"></div>
<div class="esq-sup-der"><?php if(isset($_SESSION['id'])) {?>><a href="logout.php">Logout</a><br /><img class="foto" src="usuarios/<?=$_SESSION['id']?>" /><br /><?=$_SESSION['nombre']?><?php } else { ?><a href="registro.php">Registrarte</a> | <a href="login.php">Iniciar sesion</a><?php } ?></div>
<div class="esq-inf-der"><form action="busqueda.php" method="get"><input type="text" id="buscar" name="q" placeholder="Buscar..." /><span class="lupa"></span></form></div>
</div>
<ul class="navegacion">
<li><a href="index.php">Home</a></li><li><a href="comunidadesv.php">Comunidades</a></li><li><a href="comunidadd.php">Comunidad</a></li><?php if(isset($_SESSION['id'])) { ?><li>Mi Perfil</li><li><a href="agregar.php">Subir Noticia</a></li><?php } ?>
</ul><div class="contenido">
<h1 style="text-align:center">Comunidad <?=$_SESSION['comunidadn']?></h1>
<div class ="anoticias">
<div id="not-rap">
<h1>Agregar Noticia - Modo Rápido -</h1>
<form action="noticia.php" method="post">
<input type="hidden" name="accion" value="subir" />
<input class="n_noticia" type="text" name="fuentes" placeholder="Pegar el link de la noticia"/></br>
<textarea class="c_noticia" name="abstracto" placeholder="Comentarios de la noticia"></textarea>
<div style="float:right; margin-right:106px;">
<input class="b_noticia" type="submit" value="Agregar Noticia"/><br />
<input class="p_noticia" type="button" id="personalizar" value="Personalizar Noticia"/>
</div>
</form>
</div>
<div id="not-det" style="display:none">
<h1>Agregar Noticia </h1>
<form action="noticia.php" method="post" id="f-det" enctype="multipart/form-data">
<input type="hidden" name="accion" value="subir" />
<input class="p_noticiaf1" type="text" name="titulo" placeholder="Titulo de la Noticia"/>
<br />
<textarea class="p_noticiaf1" style="height: 100px" name="abstracto" placeholder="Abstracto de la Noticia"></textarea>
<textarea class="p_noticiaf1" style="height: 150px" name="descripcion" placeholder="Descripción de la Noticia"></textarea>
<textarea class="p_noticiaf1" style="height: 100px" name="fuentes" placeholder="Fuentes de la Noticia"></textarea><br />
<div class="p_noticiaf2">
<div style="width:40%;height:100%">
<input class="p_noticiaf1" style="width:150px" type="file" name="imagen" id="imagen" value="Adjuntar Imágenes"/>
<img id="imagenp" style="width:80%; height:80%; margin-left:16%;" />
</div>
<div style="position:relative; bottom : 300px;left:40%;width:60%;height:100%">
<span class="p_noticiaf3">Adjuntar video</span> <br />
<input style="height:40px;width:350px;margin-left:10px;" type="text" id="video" name="video" placeholder="Pegar el URL del video"/> <br />
<input class="p_noticiaf3" type="button" value="Escojer Layout"/> <br />
<input class="p_noticiaf3" type="text" placeholder="Nombre Layout"/> <br />
</div>

</div>
<ul class="noticias_botones">
<li><a href="#" id="agregar">Agregar Noticia</a></li><li><a href="#" id="rapido">Modo Rápido</a></li><li>Preview</li><li><a href="#" id="cancelar">Cancelar</a></li>
</ul>
</form>
</div>
</div>
<?php if(isset($_SESSION['id'])) { ?>
<div class="comunidades">
<p style="text-align:center;">Comunidades que sigues</p>
<?php
$result=$db->query("SELECT a.* FROM comunidades AS a INNER JOIN usuarios_comunidades AS b ON b.id_comunidad=a.id AND b.id_usuario={$_SESSION['id']}");
while($fila=$result->fetch_assoc())
{
?>
<div class="comunidad">
<a href="comunidades.php?accion=cambiar&id=<?=$fila['id']?>">
<img src="comunidades/<?=$fila['id']?>" />
<p><?=$fila['nombre']?></p>
</a>
</div>
<?php
}
?>
</div>
<?php
}
?>
<div class="footer">
<ul class="lista">
<li><a href="index.php">Inicio</a></li> | <li><a href="quienes.php">Quienes somos</a></li> | <li><a href="mailto:ecopagsoporte@hotmail.com">Contacto</a></li> | <li><a href="terminos.php">Términos y condiciones</a></li>
</ul>
<a href="https://www.facebook.com/eco.ambientes" target="_blank"><img src="images/facebook.png" /></a><a href="https://twitter.com/#!/EcoItesm" target="_blank"><img src="images/twitter.png" /></a><a href="https://plus.google.com/u/0/101277163475432095165" target="_blank"><img src="images/google.png" /></a>
</div>
</div>
</div>
</body>
</html>