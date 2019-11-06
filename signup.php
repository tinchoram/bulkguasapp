<?php

  //require 'Connections/database.php';

require_once "clases/conexion.php";

  $message = '';

  try {

   if (!empty($_POST['user']) && !empty($_POST['password']) && !empty($_POST['email']) ) {
    $user = $_POST['user']; 
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];  
    $obj= new conectar();
    $conexion=$obj->conexion();
    $sql = "INSERT INTO user (user, email, password) VALUES ('$user','$email','$pass')";

    if ($result=mysqli_query($conexion,$sql)) {
      $message = 'Usuario Creado Correctamente, pronto recibira un correo con la activacion!';
    } else {
      $message = 'Sorry there must have been an issue creating your account';
    }
  }

} catch (Exception $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SignUp</title>
    <link rel="shortcut icon" href="static/img/bulkguasapp-logo.ico" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="librerias/tinchoram/css/login.css">
  </head>
  <body>

    <?php require 'partials/initheader.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>SignUp</h1>
    <span>or <a href="index.php">Login</a></span>

    <form action="signup.php" method="POST">
      <input name="user" type="text" placeholder="Enter your user"> 
      <input name="email" type="text" placeholder="Enter your email">
      <input name="password" type="password" placeholder="Enter your Password">
      <input name="confirm_password" type="password" placeholder="Confirm Password">
      <input type="submit" value="Submit">
    </form>

  </body>
</html>
