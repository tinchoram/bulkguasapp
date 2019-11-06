<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: ../index.php');
}
else {

	$user_id = $_SESSION['user_id']; 
	
	require_once "clases/conexion.php";
	require_once "clases/crud.php";

	$obj= new crud();

	$result=$obj->listaSegmentos($user_id);

while($fila=mysqli_fetch_row($result)){
    echo "<option value='".$fila['0']."'>".$fila['0']." - ".$fila['1']."</option>";
}

}
?>






 