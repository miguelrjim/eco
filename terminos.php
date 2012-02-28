<?php
session_start();
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
<li><a href="index.php">Home</a></li><li><a href="comunidadesv.php">Comunidades</a></li><li><a href="comunidadd.php">Comunidad</a></li><?php if(isset($_SESSION['id'])) { ?><li><a href="agregar.php">Subir Noticia</a></li><?php } ?>
</ul>
<div class="contenido">
<h2>Términos y condiciones del sitio</h2>
<p>Toda persona (Usuario) que tenga acceso a la pagina web de ECO a través de la página de Internet http://ambientes.sititec.com/, reconoce y voluntariamente se sujeta a lo siguiente:</p>
<p>Toda persona (Usuario) que tenga acceso al sitio de Internet conocido comercialmente como ECO a través de la página de Internet http://ambientes.sititec.com/ por el simple hecho de ingresar o navegar por el referido sitio, reconoce y voluntariamente se sujeta a los siguientes términos y condiciones de uso:</p>
<h2>Marcas Y Copyright</h2>
<p>Las marcas ECO, derechos de autor y de propiedad industrial, así como los nombres de dominio, diseños y programas de computo de ECO, con sus logos, elementos literales, auditivos, de multimedia y sus características, y/o otros productos y servicios son marcas registradas propiedad de ITESM o son derechos utilizados bajo licencia de su titular.</p>
<p>El Usuario reconoce y acepta que se prohíbe la reproducción en cualquier medio que la tecnología proporcione respecto de cualquier contenido imagen, video, fotografía que son propiedad de ITESM. o que son utilizados bajo licencia de su titular, estando únicamente permitido el uso y almacenamiento de imágenes, diseños, textos, material multimedia, entre otros, siempre que dicha utilización se encuentre expresamente permitida por ITESM; que dicha utilización se realice siguiendo los propósitos para los que ITESM ha creado o destinado dicho servicio o material y que dicho uso se realice en beneficio exclusivamente personal del Usuario sin que involucre ningún tipo de beneficio económico ni a favor del Usuario ni de ningún tercero.</p>
<p>Sin perjuicio de lo anterior el Usuario reconoce que la página de Internet http://ambientes.sititec.com/ despliega contenidos, imágenes e información que son libremente divulgadas y que son tomadas o enlazadas desde sitios públicos donde sus titulares la han colocado para su libre difusión. ITESM., no se hace responsable sobre a veracidad de los contenidos y/o de la información desplegada así como de la disponibilidad de cualquier tipo de material que sea enlazado desde cualquier otro portal de Internet.</p>
<p>Todos los derechos no concedidos expresamente a favor del Usuario o de terceros en el presente Aviso Legal de Términos y Condiciones de Uso, están reservados a favor exclusivamente de ITESM, sus filiales, subsidiarias o licenciatarios autorizados.</p>
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