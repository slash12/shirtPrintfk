<?php require('../includes/navbar.php'); ?>

<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
require("../includes/dbconnect.php");

$sql = "SELECT user_id, username FROM tbl_user WHERE showing ='1'";
$uname = $_SESSION['uname'];
$sql_check = "SELECT * FROM tbl_user WHERE username='$uname' AND type='admin';";
$sql_check_exe = mysqli_query($dbc, $sql_check);
if(mysqli_num_rows($sql_check_exe)>0)
{
  $sql .="AND type='user'";
}
else
{
  $sql .="AND type='admin'";
}
$result = mysqli_query($dbc, $sql);

if(!$result)
{
  echo mysqli_error($dbc);
}

$options="";

while ($row=mysqli_fetch_array($result )) {
  $USERid= $row['user_id'];
  $USERname =$row['username'];
  $options.= "<OPTION VALUE=\"$USERid\">".$USERname."</OPTION>";
}
?>
<?php include("pm_check.php"); ?>
</br>


<div class="container">
  <div class="row">
    <div class="col-sm">

      <center>

      <div class="select">
        <h1>Select a user to proceed</h1>

      <form name="form" id="form" method="post" action="pm_send_to.php" >
          <select name="to_userid" id="to_userid" class="form-control form-control-lg">
            <option>Select</option>
          <option value =0>
            <?php echo $options; ?>
          </option>
          </select>
    </br>
          <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Select User" class="select_button"  required/>


    </form>
  </div>
  </center>



    </div>

  </div>
</div>

<?php require('../includes/footer.php'); ?>
