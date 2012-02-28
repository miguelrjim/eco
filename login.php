<?php
session_start();
$res = array();
if(isset($_SESSION["id"]))
{
	$res["success"] = true;
	$res["email"] = $_SESSION["email"];
	$res["nombre"] = $_SESSION["nombre"];
}
else
{
	include "condb.php";
	if(!$db->real_query("SELECT * FROM usuarios WHERE email = '" . $db->real_escape_string($_GET["email"]) . "' AND password = '" . $db->real_escape_string($_GET["password"]) . "' LIMIT 1"))
	{
		$res["success"] = false;
		$res["error"] = $db->errno . ": " . $db->error;
	}
	else
	{
		$result = $db->store_result();
		if($result->num_rows > 0)
		{
			$fila = $result->fetch_assoc();
			$_SESSION["id"] = $fila["id"];
			$_SESSION["email"] = $fila["email"];
			$_SESSION["nombre"] = $fila["nombre"] . " " . $fila["apellido"];
			$res["success"] = true;
			$res["email"] = $fila["email"];
			$res["nombre"] = $fila["nombre"] . " " . $fila["apellido"];
			$res["titulo"] =  "Bienvenido, " . $res["nombre"];
			$res["mensaje"] = "Te has logueado correctamente";
		}
		else
		{
			$res["success"] = false;
			$res["titulo"] = "Error";
			$res["mensaje"] = "Usuario y/o password no coinciden/encontrado";
		}
	}
	include "cerdb.php";
}
echo json_encode($res);
?>