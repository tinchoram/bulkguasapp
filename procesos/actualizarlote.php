<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: ../index.php');
}
else {
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();

	$datos=array(
		$_POST['idlote'],
		$_POST['nameU'],
		$_POST['descriptionU'],
		$_POST['idmessageU'],
		$_POST['idsegmentU']
				);
	
	/*error_log("¡array! ", 3, "my-errors.log");*/			
	echo $obj->actualizarlote($datos);
	
}
 ?>