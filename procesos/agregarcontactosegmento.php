<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: ../index.php');
}
else {
	require_once "../clases/conexion.php";
	require_once "../clases/crud.php";
	$obj= new crud();

	$ListaContactos=$_POST['dataArray'];
	$idsegment = $_POST['idsegment'];

	//error_log("recibi el post! ", 3, "my-errors.log");

	echo $obj->agregarcontactosegmento($ListaContactos,$idsegment);
	

}
 ?>