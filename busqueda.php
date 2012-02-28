<?php
session_start();
if(!isset($_GET['q']))
{
	header('Location: index.php');
	die('');
}
include 'condb.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="prueba.css" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".noticia:not(:first)").hide();
	$(".preview").click(function(e) {
        $(".noticia").hide();
		$(".noticia:eq(" + $(this).index() + ")").show();
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
<h1 style="text-align:center;">Resultados de la busqueda</h1>
<div class="noticias">
<?php
$todos = array();
$result = $db->query("SELECT a.*,LENGTH(a.abstracto) AS tamano,SUBSTRING(a.abstracto,1,140) AS abstracto,b.nombre,b.apellido,b.id,c.nombre AS autor FROM noticias AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id INNER JOIN comunidades AS c ON c.id=a.id_comunidad WHERE a.id_comunidad IS NOT NULL AND c.nombre RLIKE '{$_GET['q']}' ORDER BY a.id DESC");
$ids = array();
while($fila=$result->fetch_assoc())
{
	$todos[] = $fila;
	$ids[] = $fila['id'];
}
$result = $db->query("SELECT a.*,LENGTH(a.abstracto) AS tamano,SUBSTRING(a.abstracto,1,140) AS abstracto,b.nombre,b.apellido,b.id,c.nombre AS autor FROM noticias AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id INNER JOIN comunidades AS c ON c.id=a.id_comunidad WHERE a.id_comunidad IS NOT NULL AND a.id NOT IN(" . implode(',',$ids) . ") AND (b.nombre RLIKE '{$_GET['q']}' OR b.apellido RLIKE '{$_GET['q']}') ORDER BY a.id DESC");
while($fila=$result->fetch_assoc())
{
	$todos[] = $fila;
	$ids[] = $fila['id'];
}
$result = $db->query("SELECT a.*,LENGTH(a.abstracto) AS tamano,SUBSTRING(a.abstracto,1,140) AS abstracto,b.nombre,b.apellido,b.id,c.nombre AS autor FROM noticias AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id INNER JOIN comunidades AS c ON c.id=a.id_comunidad WHERE a.id_comunidad IS NOT NULL AND a.id NOT IN(" . implode(',',$ids) . ") AND (a.titulo RLIKE '{$_GET['q']}' OR a.abstracto RLIKE '{$_GET['q']}' OR a.descripcion RLIKE '{$_GET['q']}') ORDER BY a.id DESC");
while($fila=$result->fetch_assoc())
	$todos[] = $fila;
?>
<div class="previews">
<?php
foreach($todos as $fila)
{
?>
<div class="preview"">
<img src="<?=file_exists("noticias/{$fila['id']}") ? "noticias/{$fila['id']}" : "comunidades/{$fila['id_comunidad']}"?>" />
<div class="titulo"><?=$fila['titulo']?></div>
</div>
<?php
}
?>
</div>
<div class="noticias-cont">
<?php
foreach($todos as $fila)
{
?>
<div class="noticia" id="not<?=$fila['id']?>" style="background-size:100% 100%; background-image:url(<?=file_exists("noticias/{$fila['id']}") ? "noticias/{$fila['id']}" : "comunidades/{$fila['id_comunidad']}"?>)">
<div style="position:absolute; bottom:0;">
<div class="abstracto"><?=$fila['abstracto']?></div>
<div class="autor">By <img src="usuarios/<?=$fila['autor']?>" /><?=$fila['nombre'] . ' ' . $fila['apellido']?></div>
<div class="completo"><a href="noticiac.php?id=<?=$fila['id']?>">Ver mas</a></div>
</div>
</div>
<?php
}
?>
</div>
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
</body>
</html>
<?php
include 'cerdb.php';
?>