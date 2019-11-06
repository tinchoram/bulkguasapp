<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /php-login');
  }
  require_once "clases/conexion.php";

   try {

  if (!empty($_POST['user']) && !empty($_POST['password'])) {
    $user = $_POST['user']; 
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);  
    $obj= new conectar();
    $conexion=$obj->conexion();
    $sql = "SELECT id, user, password FROM user WHERE USER = '$user' AND STATUS = 1";

    //error_log("¡query! $sql", 3, "my-errors.log");
    $result=mysqli_query($conexion,$sql); 

    $message = '';
   
      if ($result=mysqli_query($conexion,$sql)) {

        $row=mysqli_fetch_row($result);

        if (password_verify($_POST['password'], $row[2])) {
              $_SESSION['user_id'] = $row[0];
              $_SESSION['user_name'] = $_POST['user'];
              header("Location: index.php");
            } else {
              $message = 'Sorry, no estas autorizado';
            }    
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

    <h1><img src="static/img/small_bulklogo.png" th:src="@{static/img/small_bulklogo.png}"/></h1>
    <!--<span>or <a href="signup.php">SignUp</a></span>-->

    <form action="login.php" method="POST">
      <input name="user" type="text" placeholder="Enter your user">
      <input name="password" type="password" placeholder="Enter your Password">
      <input type="submit" value="Submit">
    </form>
    <span>or <a href="signup.php">SignUp</a></span>
  </body>
</html>
