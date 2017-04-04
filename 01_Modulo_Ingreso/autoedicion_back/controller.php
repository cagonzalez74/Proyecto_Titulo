<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"].'/organizacion/autoedicion/lib.php');

if(!isset($_GET[mod])){$mod=1;}else{$mod=$_GET[mod];}

$cFun = new clasFunciones();

switch ($mod){

	case 1:
		$id_usuario	= $_GET['id_usuario'];
		$nombre		= $_GET['nombre'];
		$cFun->actualizaFotoUsuario($id_usuario,$nombre);
		break;
	case 2:
		$pathfoto	= $_GET['pathfoto'];
		$id_usuario	= $_GET['id_usuario'];
		$cFun->eliminaFotoUsuario($pathfoto,$id_usuario);
		break;
	case 3:
		$pass		= $_GET['pass'];
		$id_usuario	= $_SESSION['user']['id'];
		$cFun->actualizaPassword($pass,$id_usuario);
		break;
}