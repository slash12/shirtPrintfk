<?php
//include database connection
    require('includes/dbconnect.php');
//include database connection
//Session check and redirect
    session_start();

    if(!isset($_SESSION['user_login']))
    {
    require('includes/session_timer.php');
    }

    if(isset($_SESSION['admin']))
    {
    header('Location:webadmin/crudtshirt.php');
    }
//Session check and redirect
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ShirtPrints | Search</title>
  <!-- Imports -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-magnify.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-magnify.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
  <!-- /Imports -->

  <!-- Temporarily Style -->
  <style>

.wrapper {
height: 420px;
margin-left: 1%;
margin-top: -1%;
width: 98%;
border-radius: 7px 7px 7px 7px;
-webkit-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
-moz-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
}

.product-img {
  float: left;
  height: 420px;
  width: 327px;
}

.product-img img {
  border-radius: 7px 0 0 7px;
}

.product-info {
  float: left;
  height: 420px;
  width: 73.4%;
  border-radius: 0 7px 10px 7px;
  background-color: #ffffff;
}

.product-text {
  height: 300px;
  width: auto;
}

.product-text h1 {
  margin: 0 0 0 38px;
  padding-top: 52px;
  font-size: 34px;
  color: #474747;
}

.product-text h1,
.product-price-btn p {
  font-family: 'Bentham', serif;
}



.product-text p {
  height: 125px;
  margin: 0 0 0 38px;
  font-family: 'Playfair Display', serif;
  color: #8d8d8d;
  line-height: 1.7em;
  font-size: 15px;
  font-weight: lighter;
  overflow: hidden;
}

.product-price-btn {
  height: 103px;
  width: 327px;
  margin-top: 17px;
  position: relative;
}

.product-price-btn p {
  display: inline-block;
  position: absolute;
  top: -13px;
  height: 50px;
  font-family: 'Trocchi', serif;
  margin: 0 0 0 38px;
  font-size: 28px;
  font-weight: lighter;
  color: #474747;
}

span {
  display: inline-block;
  height: 50px;
  font-family: 'Suranna', serif;
  font-size: 34px;
}

.product-price-btn button {
  float: right;
  display: inline-block;
  height: 50px;
  width: 176px;
  margin: 0 40px 0 16px;
  box-sizing: border-box;
  border: transparent;
  border-radius: 60px;
  font-family: 'Raleway', sans-serif;
  font-size: 14px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: #ffffff;
  background-color: #9cebd5;
  cursor: pointer;
  outline: none;
}

.product-price-btn button:hover {
  background-color: #79b0a1;
}</style>
  <!-- /Temporarily Style -->
</head>
<body>
<!-- navbar include -->
  <?php
  require("includes/navbar.php");
  ?>
<!-- /navbar include -->

<!-- content -->
    <div class="container-fluid body-container">
        <div class="wrapper">
            <div class="product-img">
                <img src="http://bit.ly/2tMBBTd" height="420" width="327">
            </div>
        <div class="product-info">
        <div class="product-text">
            <h1>Harvest Vase</h1>
            <table class="table">
                <tr>
                    <th>Model Number</th>
                    <td>M160</td>
                </tr>
            </table>
        </div>
        <div class="product-price-btn">
            <p><span>78</span>$</p>
            <button type="button">buy now</button>
        </div>
        </div>
        </div>
    </div>
<!-- /content -->
   
<!-- footer include -->
    <?php
    require("includes/footer.php");
    ?>
<!-- /footer include -->
  </body>
  </html>
