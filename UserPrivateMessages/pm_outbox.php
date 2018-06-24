<?php require('../includes/navbar.php') ?>

<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
require("../includes/dbconnect.php");

$sqlCommand = "SELECT user_id, username FROM tbl_user WHERE username ='".$_SESSION['admin']."'";
$query = mysqli_query($dbc ,$sqlCommand);

while ($row = mysqli_fetch_array($query))
{
  # code...
  $pid =$row['user_id'];
  $username = $row['username'];
}
mysqli_free_result($query);

//check for all messages in the inbox
$sqlCommand = "SELECT COUNT(id) AS numbers FROM pm_outbox WHERE userid = '$pid'";
$query = mysqli_query($dbc , $sqlCommand);
$result = mysqli_fetch_assoc($query);

$outboxMessages = $result['numbers'];

?>

<?php include("pm_check.php"); ?>

</br>

<?php

// require("../includes/dbconnect.php");
$sql = "SELECT * FROM pm_outbox WHERE userid = '$pid' ORDER by id DESC";
$result = mysqli_query($dbc, $sql);
$count = mysqli_num_rows($result);
?>
<script type="text/javascript" src="../js/filter.js"></script>

<div class="container">
  <div class="row">
    <div class="col-sm">

      <table class="table"  id="myTable">
        <form name="form1" action="pm_outbox.php" method="post">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Subject:</th>
            <th scope="col">From : <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by name"></th>

          </tr>
        </thead>
        <tbody>
          <?php
          while($rows=mysqli_fetch_array($result))
          {
          ?>

          <tr>
            <td width= "10" height="10"align="left"><input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox" value="<?php echo $rows['id']; ?>" /> </td>
            <td ><a href="pm_view_out.php?out=<?php echo $rows['id'];?>"><?php echo $rows['title']; ?></a></td>
            <td ><?php echo $rows['to_username'];?> </td>
          </tr>
        <?php } ?>

          <tr>
            <td colspan="3" align="center"> <center><?php if($outboxMessages > 0){ ?> <input type="submit" name="delete" id="delete" value="Delete Selected Messages" class="btn btn-primary" /><?php } else { echo "There are no messages in your Outbox"; } ?></center></td>


          </tr>
          <?php require('outbox_delete_button.php'); ?>


        </tbody>
      </form>

      </table>














    </div>
  </div>
</div>




<?php require('../includes/footer.php') ?>
