<?php require('../includes/navbar.php'); ?>

<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
session_start();
require("../includes/dbconnect.php");


$sqlCommand = "SELECT user_id, username FROM tbl_user WHERE username ='".$_SESSION['uname']."'";
$query = mysqli_query($dbc ,$sqlCommand);


while ($row = mysqli_fetch_array($query)) {
  # code...
  $pid =$row['user_id'];
  $username = $row['username'];

  // echo $pid;
}
mysqli_free_result($query);


$user_rep= $_GET['from'];



$sqlCommands = "SELECT user_id, username FROM tbl_user  WHERE username='$user_rep';";
$query_s = mysqli_query($dbc, $sqlCommands);


  $rows = mysqli_fetch_assoc($query_s);
  $Toid = $rows['user_id'];
  $Touser = $rows['username'];

  // echo "user".$Toid."<br>";
  // echo "userid".$Touser;



mysqli_free_result($query);
?>

<?php include("pm_check.php"); ?>

</br>



<div class="container">
  <div class="row">
    <div class="col-sm">
      <form  action="pm_send_to.php" method="post">
        <div class="form-group row">
          <label for="sendingto" class="col-sm-2 col-form-label">Sending to: </label>
          <div class="col-sm-10">
            <input name ="to_username" readonly class="form-control-plaintext"  type="text" id="to_username"  Value="<?php print $Touser ?>"   />

          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">Subject: </label>
          <div class="col-sm-10">
            <input name ="title" type="text" id="title" class="form-control"  />
          </div>
        </div>

        <div class="form-group ">
         <label for="message"> Message</label></br>
         <textarea class="form-control" id="message" name="message" rows="5"></textarea>
       </div>


       <input type="submit" name="submit1" id="submit1" value="Send Message" class="btn btn-primary" />
       <input type="hidden" name ="to_userid" id="to_userid"  value="<?php print $Toid; ?> " class="btn btn-primary"/>
       <input type="hidden" name ="userid"  id="userid"  value="<?php print $pid; ?> " class="btn btn-primary"/>
       <input type="hidden" name ="from_username" id="from_username"  value="<?php print $username; ?> " class="btn btn-primary"/>
       <input type="hidden" name ="senddate"  id="senddate"  value="<?php echo  date("F j, Y, g:i a");  //date('Y/m/d H:i:s');//echo date('l, jS F Y, g:i:s a'); ?> " class="btn btn-primary" />


      </form>
    </div>

  </div>
</div>



      <?php
      if(isset($_POST['submit1']))
      {
        $to_username= $_POST['to_username'];
        $title =$_POST['title'];
        $message =$_POST['message'];
        $to_userid =$_POST['to_userid'];
        $userid =$_POST['userid'];
        $from_username =$_POST['from_username'];
        $senddate =$_POST['senddate'];
        $query =mysqli_query($dbc, "INSERT INTO pm_outbox(userid, username, to_userid, to_username , title , content, senddate) VALUES ('$userid','$from_username','$to_userid','$to_username','$title', '$message', '$senddate')");
        $query =mysqli_query($dbc, "INSERT INTO pm_inbox(userid, username , from_id, from_username, title, content, receive_date) VALUES ('$to_userid','$to_username','$userid','$from_username','$title', '$message', '$senddate')");
        echo "<meta http-equiv=\"refresh\"content=\"0;URL=pm_outbox.php\">";
        exit();
      }

    ?>

<?php require('../includes/footer.php'); ?>
