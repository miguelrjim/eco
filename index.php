<?php
session_start();
$_SESSION['comunidad'] = 1;
$_SESSION['comunidadn'] = 'Global';
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
<div class="esq-sup-der"><?php if(isset($_SESSION['id'])) {?>><a href="logout.php">Logout</a><br /><img class="foto" src="usuarios/<?=$_SESSION['id']?>" /><br /><?=$_SESSION['nombre']?><?php } else { ?><a href="registro.php">Registrarte</a> | <a href="login.php">Iniciar sesion</a><?php } ?></div>
<div class="esq-inf-der"><form action="busqueda.php" method="get"><input type="text" id="buscar" name="q" placeholder="Buscar..." /><span class="lupa"></span></form></div>
</div>
<ul class="navegacion">
<li><a href="index.php">Home</a></li><li><a href="comunidadesv.php">Comunidades</a></li><li><a href="comunidadd.php">Comunidad</a></li><?php if(isset($_SESSION['id'])) { ?><li>Mi Perfil</li><li><a href="agregar.php">Subir Noticia</a></li><?php } ?>
</ul>
<div class="contenido">
<ul class="pestanas">
<li class="selected">Noticias destacadas</li>
</ul>
<div class="noticias">
<?php
include 'condb.php';
include 'ranking.php';
$principales = RankeaNoticiasPerra();
$stmt = $db->prepare('SELECT a.*,LENGTH(a.abstracto) AS tamano,SUBSTRING(a.abstracto,1,140) AS abstracto,DATE_FORMAT(a.fecha,"%e/%m/%Y") AS fechac,b.nombre,b.apellido,b.id AS autor FROM noticias AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id  WHERE a.id=? AND a.id_comunidad IS NOT NULL ORDER BY a.id DESC');
$stmt->bind_param('i', $noticia);
$todos = array();
foreach($principales as $noticia=>$valor)
{
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows == 0)
	{
		$result->free;
		continue;
	}
	$fila=$result->fetch_assoc();
	$todos[] = $fila;
	$result->free();
}
$stmt->close();
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
<div class="autor">By <img src="usuarios/<?=$fila['autor']?>" /><?=$fila['nombre'] . ' ' . $fila['apellido']?> <?=$fila['fechac']?></div>
<div class="completo"><a href="noticiac.php?id=<?=$fila['id']?>">Ver mas</a></div>
</div>
</div>
<?php
}
?>
</div>
</div>
</div>
<div class="comunidades">
<p style="text-align:center;">Todas las comunidades</p>
<?php
$result=$db->query("SELECT * FROM comunidades");
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