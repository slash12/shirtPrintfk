<?php require('../includes/navbar.php') ?>
<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
require("../includes/dbconnect.php");

$sqlCommand = "SELECT user_id, username FROM tbl_user WHERE username ='".$_SESSION['uname']."'";
$query = mysqli_query($dbc ,$sqlCommand);

while ($row = mysqli_fetch_array($query))
{
  # code...
  $pid =$row['user_id'];
  $username = $row['username'];
}
mysqli_free_result($query);


//check for all messages in the inbox
$sqlCommand = "SELECT COUNT(id) AS numbers FROM pm_inbox WHERE userid = '$pid'";
$query = mysqli_query($dbc , $sqlCommand);
$result = mysqli_fetch_assoc($query);

$inboxMessages = $result['numbers'];

?>

<?php include("pm_check.php"); ?>
</br>

<?php
// require_once "includes/connect.php";
$sql = "SELECT * FROM pm_inbox WHERE userid = '$pid' ORDER by id DESC";
$result = mysqli_query($dbc, $sql);
$count = mysqli_num_rows($result);
?>

<script type="text/javascript" src="../js/filter.js"></script>

<div class="container">
  <div class="row">

    <div class="col-sm">


      <table class="table" id="myTable">
        <form name="form1" action="pm_inbox.php" method="post">

        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Subject :</th>
            <th scope="col">From : <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by name"></th>

          </tr>
        </thead>
        <tbody>
          <?php
          while($rows=mysqli_fetch_array($result))
          {
          ?>
          <?php if($rows['viewed'] == 0){//show mesg in bold ?>
          <tr>
            <td><input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox" value="<?php echo $rows['id']; ?>" /> </td>
            <td ><a href="pm_view_in.php?in=<?php echo $rows['id'];?>"><b><?php echo $rows['title']; ?> </b> </a></td>
            <td ><?php echo $rows['from_username'];?> </td>
          </tr>
        <?php } else if ($rows['viewed'] == 1) {?>

          <tr>
            <td width= "10" height="10" align="left"><input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox" value="<?php echo $rows['id']; ?>" /> </td>
            <td ><a href="pm_view_in.php?in=<?php echo $rows['id'];?>"><?php echo $rows['title']; ?></a></td>
            <td ><?php echo $rows['from_username'];?> </td>
          </tr>
        <?php } ?>
        <?php }?>


          <tr>
            <td colspan="3" align="center">  <center> <?php if($inboxMessages > 0){ ?> <input type="submit" name="delete" id="delete"  class="btn btn-primary" value="Delete Selected Messages" /><?php } else { echo "There are no messages in your Inbox"; } ?></center></td>


          </tr>
          <?php require('inbox_delete_button.php'); ?>
      <!-- pagination NOT YET IMPLEMENTED -->
      <!-- <tr>
        <td><nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Previous</span>
            </a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              <span class="sr-only">Next</span>
            </a>
          </li>
        </ul>
      </nav></td>
      </tr> -->
        </tbody>
      </form>

      </table>
    </div>

  </div>
</div>


<?php require('../includes/footer.php') ?>
