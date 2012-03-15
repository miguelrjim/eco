<?php
if(!isset($_GET['id']))
{
	header('Location: logged.php');
	die();
}
include 'condb.php';
$id = $db->real_escape_string($_GET['id']);
if($db->real_query("SELECT a.*,b.nombre,b.apellido FROM noticias AS a INNER JOIN usuarios AS b ON a.id_usuario=b.id WHERE a.id=$id LIMIT 1"))
{
	$result = $db->store_result();
	if($result->num_rows == 0)
	{
		header('Location: logged.php');
		die();
	}
	$fila = $result->fetch_assoc();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h1><?=$fila['titulo']?></h1>
<p><?=$fila['texto']?></p>
<h1><?=$fila['nombre'] . ' ' . $fila['apellido']?></h1>
</body>
</html>
<?php
}
include 'cerdb.php';
?>