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
		$_POST['message'],
		$_SESSION['user_id']
				);

	echo $obj->agregarmsj($datos);
	

}
 ?>