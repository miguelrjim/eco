<?php
function Rankea($Tabla, $porcentajeOptimo)
{

$cantidadDeNoticias = 10;
$bd = new mysqli("localhost", "root", "fantasy", "ambientes");
$tabla = $bd->real_escape_string($Tabla);
$cantidad = $bd->real_escape_string($cantidadDeNoticias);

$myArray = array();

$bd->real_query("SELECT id_noticia,count(*) as num_likes FROM $tabla GROUP BY id_noticia ORDER BY num_likes DESC LIMIT $cantidad");
$mayores = $bd->store_result();
$arreglo = array();
while($row = $mayores->fetch_row()) 
{
	$arreglo[] = $row;
}
$numeroMayor = $arreglo[0][1];

$porcentaje = array();
$count = 0;
foreach ($arreglo as &$fila)
{
	$fila[1] = $fila[1]/$numeroMayor*$porcentajeOptimo;
}

$bd->close();
return $arreglo;

}


//FUNCION PRINCIPAL A LA QUE SE VA A LLAMAR DESDE EL PROGRAMA 

function RankeaNoticiasPerra()
{
	
	$masLikes = Rankea("likes", 40);
	$masComentarios = Rankea("comentarios", 25);
	//mikee no se si sea problema, pero tome en cuenta como que iba a haber una 
	//tabla normalizada de el usuario que vio la noticia para poder tener en cuenta que noticias han visto y asi,
	//a parte hace el algoritmo de rankeo mas facil, pero como tu veas wey, te amooo!!!!
	$masVistas = Rankea ("vistas", 25);
	
	$arregloFinal= array();
	for($i=0; $i<count($masLikes); $i++)
	{
		$arregloFinal[$masLikes[$i][0]] = $masLikes[$i][1];
	}
	for($i=0; $i<count($masComentarios); $i++)
	{
		if(!isset($arregloFinal[$masComentarios[$i][0]])) $arregloFinal[$masComentarios[$i][0]] = 0;
		$arregloFinal[$masComentarios[$i][0]] += $masComentarios[$i][1];
	}
	for($i=0; $i<count($masVistas); $i++)
	{
		if(!isset($arregloFinal[$masVistas[$i][0]])) $arregloFinal[$masVistas[$i][0]] = 0;
		$arregloFinal[$masVistas[$i][0]] += $masVistas[$i][1];
	}
	arsort($arregloFinal);
	return $arregloFinal;
	
	
}


?>