<?php

  //require 'Connections/database.php';

require_once "clases/conexion.php";

  $message = '';

  try {
         if (!empty($_POST['user']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['confirm_password']) ) {

         if($_POST['confirm_password'] == $_POST['password']  ) {

                $obj= new conectar();
                $conexion=$obj->conexion();
                $user = mysqli_real_escape_string($conexion,$_POST['user']);
                $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $email = mysqli_real_escape_string($conexion,$_POST['email']);
                  if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){
    // Return Error - Invalid Email
                    $message = 'The email you have entered is invalid, please try again.';
                    }else{
    // Return Success - Valid Email
                    $hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.  
                    $sql = "INSERT INTO user (user, email, password, token) VALUES ('$user','$email','$pass','$hash')";

      if ($result=mysqli_query($conexion,$sql)) {

      require 'procesos/sendmail.php';

      } else {
      $message = 'Sorry there must have been an issue creating your account';
      }
    } 

         } else {
          $message = 'Las contraseñas no coinciden';
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
    <title>BulkGuasapp</title>
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
