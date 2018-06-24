<?php session_start(); ?>
<!-- <script src="../js/jquery.min.js"></script> -->



<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="admin_nav">
  <div class="container-fluid">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navShirtPrint" aria-controls="navShirtPrint" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <a class="navbar-brand" href="admin_home.php"><img src="../images/icons/admin_logo.png"  class="d-inline-block align-top" /> Admin Area </a>
    <div class="collapse navbar-collapse" id="navShirtPrint">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin_home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pm_inbox.php">Messages</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
            <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> Hi..!<?php  if(isset($_SESSION['admin'])){echo $_SESSION['admin'];}else{ echo 'Session not set';}?></a>
      <div class="dropdown-menu">
      <a class="nav-link btn btn-default navbar-btn" href="#">Settings</a>
      <div class="dropdown-divider"></div>
      <!-- <a class="nav-link btn btn-default navbar-btn" href="../webadmin/change_password_admin.php">Change Password</a> -->
      <!-- Button trigger modal -->
    <a class="nav-link btn btn-default navbar-btn" href="#" data-toggle="modal" data-target="#change_pass_modal">

Change Password
  </a>
      <a class="nav-link btn btn-default navbar-btn" href="#">Language Settings</a>

      <div class="dropdown-divider"></div>
      <a class="nav-link btn btn-default navbar-btn" href="#">Deactivate my account</a>
      <a class="nav-link btn btn-default navbar-btn" href="admin_logout.php">Logout</a>
      </div>
      </li>
      </ul>
      &nbsp;  &nbsp;   &nbsp;  &nbsp;   &nbsp;  &nbsp;   &nbsp;  &nbsp;
    </div>
  </div>
  </nav>

<!-- Modal for change password -->
<div class="modal fade" id="change_pass_modal" tabindex="-1" role="dialog" aria-labelledby="change_pass_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="change_pass_modal">Reset Your Password Here!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <script type="text/javascript" src="../js/password_strength.js"></script>

      <div class="modal-body">

        <div class="container2">

          <div class="row">
            <div class="col-sm">
              <div class="change_password_admin">

                  <form method="post">
                    <div class="form-group">
                      <label for="old_pass">Old Password </label>

                          <input type="password" class="form-control" name="old_pass" placeholder="Old Password..." value="" required />
                    </div>
                    <div class="form-group">
                      <label for="new_pass">New Password </label>
                      <input type="password" name="new_pass" id="password" placeholder="New Password..." value=""  class="form-control pwd"  required />
                      <small id="passwordHelpInline" class="text-muted">
                        Must be 8-20 characters long.
                      </small>
                      <div class="progress">
                                         <div class="progress-bar progress-bar-danger" id="password-progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
                                             <span class="sr-only">0% Complete (danger)</span>
                                         </div>
                      </div>

                    </div>
                    <div class="form-group">
                      <label for="re_pass">Confirm Password </label>
                      <input type="password" name="re_pass" placeholder="Retype New Password..." value="" class="form-control"   required/>

                    </div>
                    <input type="submit" class="btn btn-primary" value="Reset Password" name="re_password" required/>

                  </form>
              </div>

            </div>
          </div>
        </div>

<!--Php for change password -->

        <?php require("../includes/dbconnect.php"); ?>
        <?php
        if(isset($_POST['re_password'])) //when click on reset password
        {
        $old_pass=$_POST['old_pass']; //get from form
        $new_pass=$_POST['new_pass']; //get from form

        if($old_pass == $new_pass)
        {
        	echo "<script> alert ('Old password cannot be the same as New password!!!')</script>";
        }
        else{
        	$old_pass =md5($old_pass); //Encrypt pasw

        	//validating password...!!!
        	if(strlen($new_pass) <=8 )
        	{
        		echo "<script> alert (' Password should be at least 8 characters, too short password!!');</script>";
        	}
        	else if (strlen($new_pass) >25 )
        	{
        		echo "<script> alert (' Password too long'); </script>";
        	}
        	else if( !preg_match("#[0-9]+#", $new_pass) ) {
        		echo "<script > alert ('Password must include at least one number!'); </script>";
        	}
        	else if( !preg_match("#[a-z]+#", $new_pass) ) {
        		echo " <script> alert ('Password must include at least one letter!'); </script>";
        	}
        	else if( !preg_match("#[A-Z]+#", $new_pass) ) {
        		echo "<script> alert ('Password must include at least one UPPERCASE character! ');</script>";
        	}
        	else if( !preg_match("#\W+#", $new_pass) ) {
        		echo "<script> alert ('Password must include at least one symbol!')</script>";
        	}

        	else
        	{
        		$new_pass =md5($new_pass);//Encrypt pasw

        		$re_pass=$_POST['re_pass']; //get from form
        		$re_pass =md5($re_pass);//Encrypt pasw

        		$change_pwd=mysqli_query($dbc,"select * from tbl_user where user_id='1'"); //select admin with id = 1
        		$change_pwd1=mysqli_fetch_array($change_pwd);// fetch for e.g 12345

        		$data_pwd=$change_pwd1['password']; // retrieve 1234

        		if($data_pwd==$old_pass){ //compare paswrd in db and in form

        			if($new_pass==$re_pass){ // compare if both match

        				$update_pwd=mysqli_query($dbc,"update tbl_user set password='$new_pass' where user_id='1'");
        				echo "<script>alert('Password Update Sucessfully'); window.location='admin_home.php'</script>";
        			}
        			else{
        				echo "<script>alert('Your new and Retype Password is not match'); window.location='admin_home.php'</script>";
        			}
        		}
        		else //if old not equal to db then wrong mesg
        		{
        			echo "<script>alert('Your old password is wrong'); window.location='admin_home.php'</script>";
        		}}}}
        		?>


      </div>

    </div>
  </div>
</div>






























  <script src="../js/bootstrap.min.js"></script>
