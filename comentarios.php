<?php
session_start();
$res = array();
if(isset($_POST['accion'],$_SESSION['id']))
{
	include 'condb.php';
	switch($_POST['accion'])
	{
		case 'subir':
			if(isset($_POST['texto'],$_POST['id']))
			{
				$texto = $db->real_escape_string($_POST['texto']);
				$idn = $db->real_escape_string($_POST['id']);
				if($db->real_query("INSERT INTO comentarios (id_noticia,id_usuario,texto) VALUES ($idn,{$_SESSION['id']},'$texto')"))
				{
					if($db->affected_rows == 1)
					{
						$res['success'] = true;
						header("Location: noticiac.php?id=$idn");
					}
					else
						echo $db->errno . ':' . $db->error;
				}
				else
					echo $db->errno . ':' . $db->error;
			}
		break;
	}
	include 'cerdb.php';
}
else
{
	
}
?>