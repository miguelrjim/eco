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
		if($db->real_query("INSERT INTO usuarios (email,password,nombre,apellido) VALUES ('$email','$password','$nombre','$apellido')"))
		{
			$db->real_query("SELECT id FROM usuarios WHERE email='$email'");
			$result = $db->use_result();
			$fila = $result->fetch_assoc();
			$id = $fila["id"];
			$result->free();
			$token = md5(uniqid("sititecRegistro"));
			$db->real_query($query="INSERT INTO usuarios_activacion (id,usuario_id,fecha) VALUES ('$token',$id,NOW())");
			/*$data = file_get_contents("mail_activacion.html");
			$data = str_replace("//Password//", $_GET["password"], $data);
			$data = str_replace("//Link//", "http://sititec.localhost/carritodecompras/index.php?accion=activar&token=$token&r=" . rand(), $data);
			$nombreArch = uniqid("archivo");
			file_put_contents($nombreArch, $data);*/
			include "MIME.class";
			$correo = new MIME_mail("admin@sititec.com", $_GET["email"], "Activacion de usuario en Sititec");
			$correo->attach("http://sititec.localhost/carritodecompras/index.php?accion=activar&token=$token&r=" . rand(), "", TEXT, BIT7);
			//$correo->fattach($nombreArch, "", HTML, BASE64);
			$correo->send_mail();
			//unlink($nombreArch);
			$res["success"] = true;
			$res["titulo"] = "Gracias por registrarte";
			$res["mensaje"] = "Te hemos enviado un correo de confirmacion a {$_GET['email']}";
		}
		else
		{
			$res["success"] = false;
			$res["titulo"] = "Registro erroneo";
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