<?php
session_start();
$res = array();
if(isset($_POST['accion'],$_SESSION['id']))
{
	include 'condb.php';
	switch($_POST['accion'])
	{
		case 'subir':
			if(isset($_POST['fuentes'],$_POST['abstracto']))
			{
				$fuentes = $db->real_escape_string($_POST['fuentes']);
				$abstracto = $db->real_escape_string($_POST['abstracto']);
				$descripcion = isset($_POST['descripcion']) ? "'" . $db->real_escape_string($_POST['descripcion']) . "'" : 'NULL';
				$titulo = isset($_POST['titulo']) ? "'" . $db->real_escape_string($_POST['titulo'])  . "'" : 'NULL';
				if($db->multi_query("INSERT INTO noticias (titulo,abstracto,fuentes,descripcion,id_comunidad,id_usuario,fecha) VALUES ($titulo,'$abstracto','$fuentes',$descripcion,{$_SESSION['comunidad']},{$_SESSION['id']},NOW()); SELECT id FROM noticias ORDER BY id DESC LIMIT 1"))
				{
					if($db->affected_rows == 1)
					{
						$db->next_result();
						$result = $db->store_result();
						$fila = $result->fetch_assoc();
						if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0)
							move_uploaded_file($_FILES['imagen']['tmp_name'], "noticias/{$fila['id']}");
						$res['success'] = true;
						header("Location: noticiac.php?id={$fila['id']}");
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