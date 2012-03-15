<?php
session_start();
$res = array();
if(isset($_POST['accion'],$_SESSION['id']))
{
	include 'condb.php';
	switch($_POST['accion'])
	{
		case 'subir':
			if(isset($_POST['titulo'],$_POST['texto']))
			{
				$titulo = $db->real_escape_string($_POST['titulo']);
				$texto = $db->real_escape_string($_POST['texto']);
				if($db->real_query("INSERT INTO noticias (titulo,texto,id_comunidad,id_usuario) VALUES ('$titulo','$texto',{$_SESSION['comunidad']},{$_SESSION['id']})"))
				{
					if($db->affected_rows == 1)
					{
						$res['success'] = true;
						$res['titulo'] = $_POST['titulo'];
						$res['texto'] = $_POST['texto'];
						header('Location: logged.php');
					}
				}
			}
		break;
	}
	include 'cerdb.php';
}
else
{
	
}
?>