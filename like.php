<?php
session_start();
if(!isset($_SESSION['id'],$_GET['id'])) die('');
include 'condb.php';
$nid = $db->real_escape_string($_GET['id']);
$db->real_query("INSERT INTO likes (id_noticia,id_usuario) VALUES ($nid,{$_SESSION['id']})");
header("Location: noticiac.php?id=$nid");
?>