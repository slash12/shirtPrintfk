<?php require('../includes/admin_navbar.php'); ?>

<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
require("../includes/dbconnect.php");

if(!$_GET['out'])
{
  $pageid ='1';
}
else
{
  $pageid = preg_replace("[^0-9]", "", $_GET['out']);
}

$sqlCommand = "SELECT user_id, username FROM tbl_user WHERE username ='".$_SESSION['admin']."'";
$query = mysqli_query($dbc ,$sqlCommand);

while ($row = mysqli_fetch_array($query)) {
  # code...
  $pid =$row['user_id'];
  $username = $row['username'];
}
mysqli_free_result($query);


$sqlCommand = "SELECT id, userid , to_userid, to_username, title, content, senddate FROM pm_outbox WHERE id='$pageid' AND userid='$pid'";
$query = mysqli_query($dbc ,$sqlCommand);

while ($row = mysqli_fetch_array($query)) {
  # code...
  $Hid =$row['id'];
  $Huserid = $row['userid'];
  $Hfrom_id = $row['to_userid'];
  $Hfrom_username = $row['to_username'];
  $Htitle = $row['title'];
  $Hcontent = $row['content'];
  $Hreceivedate = $row['senddate'];
}
mysqli_free_result($query);
?>

<?php include("pm_check.php"); ?>

<div class="container">
  <div class="row">
    <div class="col-sm">
      <table class="table table-sm" id="view_out">
        <thead>
          <tr>
            <th scope="col">Message To</th>
            <th scope="col">Message Subject:</th>
            <th scope="col">Message Content</th>
            <th scope="col">Date sent:</th>

          </tr>
        </thead>
        <tbody>
          <tr>
            <td ><?php print $Hfrom_username; ?></td>
            <td ><?php print $Htitle; ?></td>
            <td ><?php print $Hcontent; ?></td>
            <td><?php print $Hreceivedate; ?></td>
          </tr>

        </tbody>
      </table>    </div>

  </div>
</div>

<?php require('../includes/admin_footer.php'); ?>
