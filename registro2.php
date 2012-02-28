<?php
	function verificarCampos()
	{
		for ($i = 0;$i < func_num_args();$i++)
			if(strlen(func_get_arg($i)) == 0)
				return false;
		return true;
    }

	$res = array();
	if(isset($_POST["nombre"],$_POST["apellido"],$_POST["email"],$_POST["password"],$_POST['escuela']) && verificarCampos($_POST["nombre"],$_POST["apellido"],$_POST["email"],$_POST["password"],$_POST['escuela']))
	{
		include "condb.php";
		$nombre = $db->real_escape_string($_POST["nombre"]);
		$apellido = $db->real_escape_string($_POST["apellido"]);
		$email = $db->real_escape_string($_POST["email"]);
		$password = $db->real_escape_string($_POST["password"]);
		$escuela = $db->real_escape_string($_POST["escuela"]);
		if($db->multi_query($res['query']="INSERT INTO usuarios (email,password,nombre,apellido,escuela) VALUES ('$email','$password','$nombre','$apellido','$escuela');SELECT * FROM usuarios ORDER BY id DESC LIMIT 1"))
		{
			$db->next_result();
			$result = $db->store_result();
			$fila = $result->fetch_assoc();
			$result->free();
			$db->query("INSERT INTO usuarios_comunidades (id_usuario,id_comunidad) VALUES ({$fila['id']},1)");
			if($_FILES['foto']['error'] == 0)
				move_uploaded_file($_FILES['foto']['tmp_name'], "usuarios/{$fila['id']}");
			$res["success"] = true;
			$res["titulo"] = "Gracias por registrarte";
			$res["mensaje"] = "Disfruta de la pagina";
			session_start();
			$_SESSION['id'] = $fila['id'];
			$_SESSION['nombre'] = $nombre . ' ' . $apellido;
			$_SESSION['email'] = $email;
			$_SESSION['escuela'] = $escuela;
		}
		else
		{
			$res["success"] = false;
			$res["titulo"] = $db->errno . ':' . $db->error;
			$res["mensaje"] = "Ya existe una cuenta con ese correo registrado";
		}
		include "cerdb.php";
	}
	else
	{
		$res["success"] = false;
		$res["titulo"] = "Registro erroneo";
		$res["mensaje"] = "Faltaron de llenar campos";
	}
	echo json_encode($res);
?>