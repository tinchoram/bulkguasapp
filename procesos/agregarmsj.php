<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: ../index.php');
}
else { 
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();


	//error_log("ACA: ".$_FILES['mediapath']["name"], 3, "my-errors.log");

	$datos=array(
		$_POST['name'],
		$_POST['message'],
		$_POST['mediapath'],
		$_SESSION['user_id']
				);

	echo $obj->agregarmsj($datos);
	

}
 ?>