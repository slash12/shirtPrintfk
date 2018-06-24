<?php require('../includes/admin_navbar.php'); ?>

<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
require("../includes/dbconnect.php");

if(!$_GET['in'])
{
  $pageid2 ='1';
}
else
{
  $pageid2 = preg_replace("[^0-9]", "", $_GET['in']);
}

$sqlCommand = "SELECT user_id, username FROM tbl_user WHERE username ='".$_SESSION['admin']."'";
$query = mysqli_query($dbc ,$sqlCommand);

while ($row = mysqli_fetch_array($query)) {
  # code...
  $pid =$row['user_id'];
  $username = $row['username'];
}
mysqli_free_result($query);


$sqlCommand = "SELECT id, userid, from_id , from_username, title, content, receive_date FROM pm_inbox WHERE id='$pageid2' AND userid='$pid'";
$query = mysqli_query($dbc ,$sqlCommand);

while ($row = mysqli_fetch_array($query)) {
  # code...
  $Hid =$row['id'];
  $Huserid = $row['userid'];
  $Hfrom_id = $row['from_id'];
  $Hfrom_username = $row['from_username'];
  $Htitle = $row['title'];
  $Hcontent = $row['content'];
  $Hreceivedate = $row['receive_date'];
}
mysqli_free_result($query);

$query = mysqli_query($dbc , "UPDATE pm_inbox SET viewed='1' WHERE id='$pageid2'");

?>
<?php include("pm_check.php"); ?>
<div class="container">
  <div class="row">
    <div class="col-sm">


      <table class="table table-sm" id="view_in">
        <thead>
          <tr>
            <th scope="col">Message Subject:</th>
            <th scope="col">Message Content</th>
            <th scope="col">Message From:</th>
            <th scope="col">Date Received:</th>
            <th scope="col">Reply Message</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td ><?php print $Htitle; ?></td>
            <td ><?php print $Hcontent; ?></td>
            <td><?php print $Hreceivedate; ?></td>
            <td ><?php print $Hfrom_username; ?></td>
            <td ><button class="reply_button"><?php print "<a href='pm_reply.php?from=$Hfrom_username'>Reply</a>"; ?> </button></td>

          </tr>
          
        </tbody>
      </table>


    </div>

  </div>
</div>

<?php require('../includes/admin_footer.php'); ?>
