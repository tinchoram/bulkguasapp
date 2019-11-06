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
		$_POST['nameU'],
        $_POST['apellidoU'],
        $_POST['apodomsjU'],
        $_POST['telefonoU'],
        $_POST['dniU'],
        $_POST['direccionU'],
        $_POST['localidadU']
				);
	
	/*error_log("¡array! ", 3, "my-errors.log");*/			
	echo $obj->actualizarcontacto($datos);
	

}
 ?>