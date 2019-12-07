<?php  

require_once "clases/conexion.php";

  $message = '';

  try {
        
        if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
                $obj= new conectar();
                $conexion=$obj->conexion();
                $email = mysqli_real_escape_string($conexion,$_GET['email']);
                $hash = mysqli_real_escape_string($conexion,$_GET['hash']);
                $sql = "SELECT email, token, status FROM user WHERE email='$email' AND token='$hash' AND status=0";

                if ($result=mysqli_query($conexion,$sql)){

                    $row_cnt = mysqli_num_rows($result);

                    if($row_cnt > 0){
                        // We have a match, activate the account
                        $sqlup = "UPDATE user SET status=1 WHERE email='$email' AND token='$hash' AND status=0";
                        if ($result=mysqli_query($conexion,$sqlup)) {
                          $message = 'Su cuenta fue activada correctamente';
                        }


                    }else{
                        // No match -> invalid url or account has already been activated.
                        $message = 'Error al activar la cuenta, contacte con tinchoram.com';
                    }

                }

                

          }else{
    // Invalid approach
            $message = 'Invalid approach, please use the link that has been send to your email.';           

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

    <span><a href="index.php">Login</a></span>

  </body>
</html>