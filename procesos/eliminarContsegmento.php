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
		$_POST['idcontacto'],
		$_POST['idsegmento']
				);

	//error_log("recibi el post! para eliminar".$_POST['idcontacto']." ".$_POST['idsegmento'], 3, "my-errors.log");

	echo $obj->eliminarContSegmento($datos);
	//echo $obj->eliminarContSegmento($_POST['idcontacto']);
}
 ?>