<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location: login.php');
}
else {	
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>BulkGuasapp</title>
    <link rel="shortcut icon" href="static/img/bulkguasapp-logo.ico" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <?php require_once "scripts.php";  ?>
  </head>
  <body class="home">
    <?php require 'partials/header.php' ?>

    <h1><img src="static/img/small_bulklogo.png" th:src="@{static/img/small_bulklogo.png}"/>BulkGuasapp</h1>
    
    <iframe width="560" height="315" src="https://www.youtube.com/embed/AVUahD9cfGI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

    <h2><a href="download/BulkGuasapp_v1.0.rar"><span class="fa fa-download"></span>Descargar</a></h2>

    <div class="card-footer">
            <a class="row justify-content-center" target="_blank" href="http://tinchoram.com.ar/">By Tinchoram</a>
          </div>
  </body>
</html>

<?php }?>
