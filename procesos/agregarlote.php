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
		$_POST['name'],
		$_POST['description'],
		$_POST['idmessage'],
		$_POST['idsegment'],
		$_SESSION['user_id']
				);

	//error_log("recibi el post: ".$_SESSION['user_id']." ".$_POST['name']." ".$_POST['description'], 3, "my-errors.log");
	echo $obj->agregarLote($datos);
	
}
 ?>