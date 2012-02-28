<?php
session_start();
if(!isset($_GET['id']))
{
	header('Location: index.php');
	die();
}
include 'condb.php';
$nid = $db->real_escape_string($_GET['id']);
if($db->real_query("SELECT a.*,DATE_FORMAT(a.fecha,'%e/%m/%Y') AS fechac,b.nombre,b.apellido FROM noticias AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id WHERE a.id=$nid LIMIT 1"))
{
	$result = $db->store_result();
	if($result->num_rows == 0)
	{
		header('Location: index.php');
		die();
	}
	$fila = $result->fetch_assoc();
	$result->free();
	$pid = isset($_SESSION['id']) ? $_SESSION['id'] : 'NULL';
	$db->query("INSERT INTO vistas (id_usuario,id_noticia) VALUES ($pid,$nid)");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="prueba.css" />
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
</ul>
<div class="contenido">
<h1 style="text-align:center">Comunidad <?=$_SESSION['comunidadn']?></h1>
<h1><?=$fila['titulo']?> <span style="font-size:8px; color:#777"><?=$fila['nombre'] . ' ' . $fila['apellido']?> <?=$fila['fechac']?></span></h1>
<div><img style="max-width:80%;" src="<?=file_exists("noticias/{$fila['id']}") ? "noticias/{$fila['id']}" : "comunidades/{$fila['id_comunidad']}"?>" /></div>
<p><?=$fila['abstracto']?></p>
<p><?=$fila['descripcion']?></p>
<p><?=$fila['fuentes']?></p>
<div class="comentarios">
<?php
	$db->real_query("SELECT a.*,b.id AS autor,b.nombre,b.apellido FROM comentarios AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id WHERE id_noticia=$nid");
	$result=$db->store_result();
	while($fila=$result->fetch_assoc())
	{
?>
<div class="comentario">
<div class="comentario-texto"><?=$fila['texto']?></div>
<div class="comentario-autor">By <img src="usuarios/<?=$fila['autor']?>" /><?=$fila['nombre'] . ' ' . $fila['apellido']?></div>
</div>
<?php
	}
	$result->free();
	if(isset($_SESSION['id']))
	{
		$db->multi_query("SELECT COUNT(*) AS total FROM likes WHERE id_noticia=$nid;SELECT * FROM likes WHERE id_noticia=$nid AND id_usuario={$_SESSION['id']}");
		$result=$db->store_result();
		$fila=$result->fetch_assoc();
		$likes=$fila['total'];
		$result->free();
		$db->next_result();
		$result = $db->store_result();
		$likeado = $result->num_rows == 1;
		$result->free();
?>
<div class="like"><?=$likes?> like! <? if(!$likeado) {?><a href="like.php?id=<?=$nid?>">Likear</a><? } ?></div>
<form action="comentarios.php" method="post">
<input type="hidden" name="accion" value="subir" />
<input type="hidden" name="id" value="<?=$nid?>" />
<textarea name="texto" style="width:100%; height:80px;"></textarea><br />
<input type="submit" value="Comentar" />
</form>
<?php
	}
?>
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
}
include 'cerdb.php';
?>