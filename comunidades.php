<?php
session_start();
$res = array();
if(isset($_GET['accion']))
{
	include 'condb.php';
	switch($_GET['accion'])
	{
		case 'cambiar':
			if(isset($_GET['id']))
			{
				$comunidad = $db->real_escape_string($_GET['id']);
				if($db->real_query("SELECT * FROM comunidades WHERE id=$comunidad"))
				{
					$result=$db->store_result();
					$fila=$result->fetch_assoc();
					$_SESSION['comunidad'] = $fila['id'];
					$_SESSION['comunidadn'] = $fila['nombre'];
					header('Location: comunidadd.php');
				}
				else
					echo $db->errno . ':' . $db->error;
			}
		break;
		case 'seguir':
			$db->real_query("INSERT INTO usuarios_comunidades (id_usuario,id_comunidad) VALUES({$_SESSION['id']},{$_SESSION['comunidad']})");
			header('Location: comunidadd.php');
		break;
		case 'dejar':
			$db->real_query("DELETE FROM usuarios_comunidades WHERE id_usuario={$_SESSION['id']} AND id_comunidad={$_SESSION['comunidad']} AND tipo=1");
			header('Location: comunidadd.php');
		break;
		case 'eliminar':
			$db->multi_query("DELETE FROM comunidades WHERE id=(SELECT id_comunidad FROM usuarios_comunidades WHERE id_comunidad={$_SESSION['comunidad']} AND id_usuario={$_SESSION['id']} AND tipo=0 AND id_comunidad!=1);DELETE FROM usuarios_comunidades WHERE id_usuario={$_SESSION['id']} AND id_comunidad={$_SESSION['comunidad']} AND tipo=0 AND id_comunidad!=1");
			if($db->affected_rows == 1)
			{
				$_SESSION['comunidad'] = 1;
				$_SESSION['comunidadn'] = 'Global';
			}
			header('Location: comunidadd.php');
		break;
		case 'quitar':
			if(isset($_GET['usuario']))
			{
				$usuario = $db->real_escape_string($_GET['usuario']);
				$db->real_query("DELETE d1 FROM usuarios_comunidades d1 JOIN usuarios_comunidades d2 ON d1.id_usuario=$usuario AND d1.id_comunidad=d2.id_comunidad AND d2.id_usuario={$_SESSION['id']} AND d2.id_comunidad={$_SESSION['comunidad']} AND d2.tipo=0");
			}
			header('Location: comunidadd.php');
		break;
	}
	include 'cerdb.php';
}
else if(isset($_POST['accion']))
{
	include 'condb.php';
	switch($_POST['accion'])
	{
		case 'crear':
			$nombre = $db->real_escape_string($_POST['nombre']);
			$descripcion = $db->real_escape_string($_POST['descripcion']);
			if($db->multi_query("INSERT INTO comunidades (nombre,descripcion) VALUES ('$nombre','$descripcion'); SELECT id FROM comunidades ORDER BY id DESC LIMIT 1"))
			{
				if($db->affected_rows == 1)
				{
					$db->next_result();
					$result = $db->store_result();
					$fila = $result->fetch_assoc();
					$result->free();
					$nid = $fila['id'];
					$db->query("INSERT INTO usuarios_comunidades (id_usuario,id_comunidad,tipo) VALUES ({$_SESSION['id']},$nid,0)");
					$res['success'] = true;
					$res['id'] = $nid;
					if($_FILES['foto']['error'] == 0)
						move_uploaded_file($_FILES['foto']['tmp_name'], "comunidades/$nid");
					$_SESSION['comunidad'] = $nid;
					$_SESSION['comunidadn'] = $nombre;
				}
				else
				{
					$res['success'] = false;
					$res['error'] = $db->errno . ':' . $db->error;
					if($_FILES['foto']['error'] == 0)
						unlink($_FILES['foto']['tmp_name']);
				}
			}
		break;
	}
}
echo json_encode($res);
?>