<?php
include('../includes/dbconnect.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title></title>
<?php

include('../js/libraries/libraries.php');
?>
<style media="screen">

.bottom-right{
margin-top: 23px;
}
</style>
</head>
<body>
<?php
include('../includes/navbar.php');
?>

<br>
<div class="container">
<div class="row">
<div class="col-md-3" >

<?php

$sql = "SELECT * FROM addcustomizedtshirt  ORDER BY CustomizedTshirt_id DESC LIMIT 1";
$qry = mysqli_query($dbc, $sql);
$row = mysqli_fetch_array($qry);

echo "<center>";

echo "<img src='".$row['img_path']."' style='height:300px;  width: 100%;' class='img-thumbnail'>";

echo "</center>";

?>
</div>



<div class="col-md-5" >



<h2 style="text-align:center;"> Item Descriptions</h2>
<?php

$sql = "SELECT * FROM addcustomizedtshirt  ORDER BY CustomizedTshirt_id DESC LIMIT 1";
$qry = mysqli_query($dbc, $sql);
$row = mysqli_fetch_array($qry);


echo "<div class=table-responsive-sm>
<table class=table>
<tr>
<th> Size </th>
<th> Category </th>
<th> Position </th>

</tr>



<tr>
<td> ". $row['size']." </td>
<td> ". $row['category']." </td>
<td> ". $row['position']." </td>
</tr>

<tr>
<th> Gender </th>
<th> Color Name </th>
<th> Pattern </th>

</tr>

<tr>
<td> ". $row['gender']." </td>
<td> ". $row['color_name']." </td>
<td> ". $row['pattern']." </td>
</tr>

<tr>
<td> <h4> Total </h4></td>
<td> <h4 style=color:red;> MUR Rs ". $row['price']." .00 </h4></td>
</tr>





</table>
</div>";





?>



</div>



<div class="col-md-4">
<div class="row">
<div class="col-sm-12" >

<h2 style="text-align:center;">Customer information</h2>
<table>

<tr>

<td>First Name</td>
</tr>

<tr>

<td>Last  Name</td>
</tr>

<tr>

<td>Contact info</td>
</tr>


<tr>

<td>Shipping address</td>
</tr>

<tr>

<td>Country</td>
<td>Mobile : </td>
<td>Home : </td>
<td>Office : </td>
<td>Email : </td>
</tr>

<tr>
<td>Order number</td>
</tr>

</table>

</div>
</div>
<div class="row bottom-right">
<div class="col-sm-12" >

<center><a href="paypal.php"> <button type="button" class="btn btn-primary btn-lg">Proceed to checkout</button></a></center>
</div>
</div>
</div>
</div>
</div>




</body>
</html>
