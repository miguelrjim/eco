<?php
session_start();
if(!isset($_SESSION['id']))
{
	include 'index.php';
	die();
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="estilo.css"/>
	</head>
	<body>
		<div id="contenedor">
			<div id="header">
				<div id="espacio">
					Hola <?=$_SESSION['nombre']?>
					<div id="r">
					<ul class="navegacion">
						<li>
							<a href="">Buscar</a>
						</li>
						<li>
							<a href="">Logout</a>
						</li>
					</ul>
				</div>
				</div>
				
				
				
				<div id="nombre">
					
					<div id="r">
					<ul class="navegacion">
						<li>
							<a href="">Mis Comunidades</a>
						</li>
						<li>
							<a href="">Noticias Destacadas</a>
						</li>
						<li>
							<a href="">Mis Favoritas</a>
						</li>
					</ul>
				</div>
				<h1>Proyecto</h1>
				</div>
				
				
			</div>
			<div id="contenido">
            
            	<div id="forma-subir">
                	<form action="noticia.php" method="post">
                    	<input type="hidden" name="accion" value="subir" />
                    	Titulo: <input type="text" name="titulo" /><br>
						Texto:<br>
						<textarea name="texto"></textarea><br>
						<input type="submit" value="Subir noticia" />
                    </form>
                </div>
<?php
include 'condb.php';
$result = $db->query('SELECT a.id,a.titulo,LENGTH(a.texto) AS tamano,SUBSTRING(a.texto,1,140) AS texto,b.nombre,b.apellido FROM noticias AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id ORDER BY a.id DESC');
while($fila=$result->fetch_assoc())
{
?>
				<div class="noticia" id="not<?=$fila['id']?>">
					<div class="titulo"><?=$fila['titulo']?></div>
					<div class="links"><?=$fila['texto'] . ($fila['tamano'] > 140 ? "...<br /><a href=\"noticiac.php?id={$fila['id']}\">Ver mas</a>" : '')?></div>
                    <div class="autor"><?=$fila['nombre'] . ' ' . $fila['apellido']?></div>
				</div>
<?php
}
include 'cerdb.php';
?>
			</div>
		</div>
	</body>
</html>