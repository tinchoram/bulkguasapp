<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: ../index.php');
}
else {
	
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();

	//echo json_encode($obj->ActivarLote($_POST['idlote']));
	echo $obj->ActivarLote($_POST['idlote'],$_SESSION['user_id']);
}
 ?>