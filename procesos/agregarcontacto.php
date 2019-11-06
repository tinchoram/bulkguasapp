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
        $_POST['apellido'],
        $_POST['apodomsj'],
        $_POST['telefono'],
        $_POST['dni'],
        $_POST['direccion'],
        $_POST['localidad'],
        $_SESSION['user_id']
				);
	echo $obj->agregarcontacto($datos);
	

}
 ?>