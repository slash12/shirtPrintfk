<?php
session_start();
if(isset($_SESSION['uname']))
{
  header('Location: index.php');
}
require('includes/dbconnect.php');

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register Successful - ShirtPrints</title>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php require('includes/navbar.php'); ?>
  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h5 class="display-6">Your Account is activated</h5>
    <p class="lead">  Please login.</p>
  </div>
</div>
  </body>
  <?php require('includes/footer.php'); ?>
</html>
