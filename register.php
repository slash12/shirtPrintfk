<?php
session_start();
if(isset($_SESSION['uname']))
{
  header('Location: index.php');
}
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require('includes/dbconnect.php');

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registration - ShirtPrints</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-magnify.css" type="text/css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-magnify.js"></script>

    <script>
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>
  </head>
  <?php
    function err_check($a)
    {
      if (@$_POST['btnregsubmit'] == "Register")
      {
        if(isset($a))
        {
          echo "is-invalid";
        }
        else
        {
          echo "is-valid";
        }
      }
    }

    if (@$_POST['btnregsubmit'] == "Register") {
        $error_arr = array();

        //Last Name
        @$lname_cc = trim($_POST['txtlname']);
        //Empty Validation
        if (empty($lname_cc)) {
            $error[] = "Please Enter your Last Name";
            @$lname_err = "<div class='invalid-feedback'>Please Enter your Last Name</div>";
        } else {
            $lname = mysqli_real_escape_string($dbc, $lname_cc);
        }
        /*-----------------------------------------------------------------*/
        //First Name
        @$fname_cc = trim($_POST['txtfname']);
        //Empty Validation
        if (empty($fname_cc)) {
            $error[]= "Please Enter your First Name";
            $fname_err = "<div class='invalid-feedback'>Please Enter your First Name</div>";
        } else {
            $fname = mysqli_real_escape_string($dbc, $fname_cc);
        }
        /*-----------------------------------------------------------------*/
        //Country
        $country = $_POST['sltcountry'];
        if($country == "0")
        {
          $error[]= "Please select your Country";
          $country_err = "<div class='invalid-feedback'>Please select your Country</div>";
        }


        /*-----------------------------------------------------------------*/
        //Address
        @$address_cc = trim($_POST['txtaddress']);
        //Empty Valdation
        if (empty($address_cc)) {
            $error[] = "Please Enter your Address";
            $address_err = "<div class='invalid-feedback'>Please Enter your Street Address</div>";
        } else {
            $address = mysqli_real_escape_string($dbc, $address_cc);
        }
        /*-----------------------------------------------------------------*/
        //Postal Code
        @$pcode_cc = trim($_POST['txtpcode']);
        if (empty($pcode_cc)) {
            $error[]="Please Enter your Postal Code";
            $pcode_err = "<div class='invalid-feedback'>Please Enter your Postal Code</div>";
        } else {
            $pcode = mysqli_real_escape_string($dbc, $pcode_cc);
        }
        /*-----------------------------------------------------------------*/
        //Email
        @$email_cc = trim($_POST['txtemail']);
        if (empty($email_cc)) {
            $error[] = "Please Enter your E-mail Address";
            $email_err = "<div class='invalid-feedback'>Please Enter your E-mail Address</div>";
        } else {
            $email = mysqli_real_escape_string($dbc, $email_cc);
        }
        /*-----------------------------------------------------------------*/
        //username
        @$uname_cc = trim($_POST['txtuname']);
        //Empty Validation
        if (empty($uname_cc)) {
            $error[]="Please Enter your username";
            $uname_err = "<div class='invalid-feedback'>Please Enter your username</div>";
        } else {
            $uname = mysqli_real_escape_string($dbc, $uname_cc);
        }
        /*-----------------------------------------------------------------*/
        //Check for Password
        @$password_c = trim($_POST['txtpassword']);
        if (empty($password_c)) {
            $error[] = "Please fill out Password field";
            $pass_err = "<div class='invalid-feedback'>Please fill out Password field</div>";
        } elseif (strlen($password_c) < 8) {
            $error[] = "Password is too short (should be greater than 8 characters)";
            $pass_err = "<div class='invalid-feedback'>Password is too short (should be greater than 8 characters)</div>";
        } elseif (strlen($password_c) > 20) {
            $error[] = "Password is too Long (should not be larger than 20 characters)";
            $pass_err = "<div class='invalid-feedback'>Password is too Long (should not be larger than 20 characters)</div>";
        } elseif (!preg_match("#[a-z]+#", $password_c)) {
            $error[]= "Password must include at least one short letter!";
            $pass_err = "<div class='invalid-feedback'>Password must include at least one short letter!</div>";
        } elseif (!preg_match("#[A-Z]+#", $password_c)) {
            $error[]= "Password must include at least one CAPS!";
            $pass_err = "<div class='invalid-feedback'>Password must include at least one CAPS!</div>";
        }
        /*-----------------------------------------------------------------*/
        //Confirm Password
        @$pc_c = trim($_POST['txtcpassword']);
        if (empty($pc_c)) {
            $error[] = "Please fill out Confirm Password field";
            $cpass_err = "<div class='invalid-feedback'>Please fill out Confirm Password field</div>";
        } elseif (@$password_c != $pc_c) {
            $error[] = "Passwords not the same, Retry!";
            $cpass_err = "<div class='invalid-feedback'>Passwords not the same, Retry!</div>";
        } else {
            $pc_e = md5($pc_c);
            $password = mysqli_real_escape_string($dbc, $pc_e);
        }

        /*-----------------------------------------------------------------*/
        if (empty($error)) {
            //Generated token
            $token = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789!$/()*";
            $token = str_shuffle($token);
            $token = substr($token, 0, 10);

            $register_query = "INSERT INTO tbl_user(l_name, f_name, country_id, address, postal_code, e_mail, username, password, isEmailConfirmed, token) VALUES('$lname', '$fname', '$country', '$address', '$pcode', '$email', '$uname','$password', '0', '$token');";
            $register_query_run = mysqli_query($dbc, $register_query);

            if ($register_query_run) {
                include_once("plugins/phpMailer/PHPMailer.php");
                include_once("plugins/phpMailer/Exception.php");
                include_once("plugins/phpMailer/SMTP.php");
                $mail = new PHPMailer();
                //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com;';                    // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->SMTPSecure = false;
                $mail->Username = 'testappui357@gmail.com';                 // SMTP username
            $mail->Password = 'qwert1234';                           // SMTP password
            //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;
                $mail->setFrom('testappui357@gmail.com', 'ShirtPrints(no-reply email)');
                $mail->addAddress($email, 'User');
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'ShirtPrints E-mail Verification';
                $mail->Body    = "
                Hello $uname, <br>
                Please Click on the link below to activate your Account: <br><br>
                <a href=\"http://localhost:8001/merge220318/tdsmerge220318/emailVerified.php?email=$email&token=$token\">Activate your account</a>
            ";

                if ($mail->send()) {
                    header('Location:register_success.php');
                } else {
                    echo $mail->ErrorInfo;
                }
                // header('Location: register.php');
            }
            else {
                echo "qry not run<br>";
                echo mysqli_error($dbc);
            }
        }
    }

?>
  <body>
    <?php require('includes/navbar.php'); ?>
    <div class="container-fluid" id="frm_container">

    <table>
      <tr>
        <td><h4>Registration Form </h4></td>
      </tr>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" id="frmreg">

        <tr>
          <td>
      <!--Last Name-->

          <label for="txtlname">Last Name</label>
          <input type="text" class="form-control <?php err_check(@$lname_err); ?>" id="txtlname" name="txtlname" placeholder="Last Name..." value="<?php @save_state('txtlname');?>">
          <?php echo @$lname_err; ?>

      </td>
      <td>
        <!--First Name-->

          <label for="txtfname">First Name</label>
          <input type="text" class="form-control <?php err_check(@$fname_err); ?>" id="txtfname" name="txtfname" placeholder="First Name..." value="<?php @save_state('txtfname');?>">
          <?php echo @$fname_err; ?>

      </td>
    </tr>
    <tr>

      <td>
        <!--Country-->

          <label>Country</label>
            <select class="form-control <?php err_check(@$country_err); ?>" id="sltcountry" name="sltcountry">
              <option value="0" selected>Choose a Country</option>
              <?php
              $all_country = "SELECT country_id, country_name FROM country;";
              $country_qry = mysqli_query($dbc, $all_country);


              while($row = mysqli_fetch_array($country_qry, MYSQLI_ASSOC))
              {
               echo "<option value=\"".$row['country_id']."\">".$row['country_name']."</option>";
              }
              ?>
            </select>
            <?php echo @$country_err; ?>

      </td>
      <td>
      <!--Postal Code-->

          <label for="txtpcode">Postal Code</label>
          <input type="text" class="form-control <?php err_check(@$pcode_err); ?>" id="txtpcode" name="txtpcode" placeholder="Postal Code..." value="<?php @save_state('txtpcode');?>">
          <?php echo @$pcode_err; ?>

      </td>
      <td>
      <!--Street Address-->

          <label for="txtaddress">Street Address</label>
          <input type="text" class="form-control <?php err_check(@$address_err); ?>" id="txtaddress" name="txtaddress" placeholder="Street Address..." value="<?php @save_state('txtaddress');?>">
          <?php echo @$address_err; ?>

      </td>
    </tr>
      <!--E-mail-->
      <script>
      //Check if email already exist
      function chckEmail(value)
      {
        $.ajax({
        type:"POST",
        url:"plugins/checkEmail.php",
        data:"txtemail="+value,
        success:function(data)
        {
          if(data == "false")
          {
            document.getElementById('msg1').innerHTML = "<span class='error'>&#9888; Email Already Existed</span>";
            document.getElementById("btnregsubmit").disabled = true;
            document.getElementById('txtemail').style.border="1px solid #FF0000";
          }
          if(data == "true")
          {
            document.getElementById('msg1').innerHTML = "<span style='color:green;'> &#x2611; Valid E-mail Address</span>";
            document.getElementById('txtemail').style.border="1px solid green";
            document.getElementById("btnregsubmit").disabled = false;
          }
        }
      });
      }
      </script>
      <tr>
        <td>

          <label for="txtemail">E-mail</label>
          <input type="email" class="form-control <?php err_check(@$email_err); ?>" id="txtemail" name="txtemail" placeholder="E-mail Address..." value="<?php @save_state('txtemail');?>" onkeyup="chckEmail(this.value)">
          <?php echo @$email_err; ?>
          <div id="msg1"></div>

      </td>


      <!--Username-->
      <script>
      //Check if username already exist
      function chckUsername(value)
      {
        $.ajax({
          type:"POST",
          url:"plugins/checkUsername.php",
          data:"txtuname="+value,
          success:function(data)
          {
            if(data == "false")
            {
              document.getElementById('msg2').innerHTML = "<span class='error'>&#9888; Username Already Existed</span>";
              document.getElementById('txtuname').style.border="1px solid #FF0000";
              document.getElementById("btnregsubmit").disabled = true;
            }
            if(data == "true")
            {
              document.getElementById('msg2').innerHTML = "<span style='color:green;'>&#x2611; Valid Username</span>";
              document.getElementById('txtuname').style.border="1px solid green";
              document.getElementById("btnregsubmit").disabled = false;
            }
          }
        });
      }
      </script>

        <td>

          <label for="txtuname">Username</label>
          <input type="text" class="form-control <?php err_check(@$uname_err); ?>" id="txtuname" name="txtuname" placeholder="Username..." value="<?php @save_state('txtuname');?>" onkeyup="chckUsername(this.value)">
          <?php echo @$uname_err; ?>
          <div id="msg2"></div>

        </td>
      </tr>

      <tr>
      <!--Password-->
      <td>

          <label for="txtpassword">Password</label>
          <input type="password" class="form-control <?php err_check(@$pass_err); ?>" id="txtpassword" name="txtpassword" placeholder="Password..." data-toggle="tooltip" data-placement="top" title="e.g Qwert1234!">
          <!-- <small class="text-muted">
            e.g Qwert1234!
          </small> -->
          <?php echo @$pass_err; ?>

      </td>
      <td>
        <!--Confirm Password-->

          <label for="txtcpassword">Confirm password</label>
          <input type="password" class="form-control <?php err_check(@$cpass_err); ?>" id="txtcpassword" name="txtcpassword" placeholder="Confirm Password...">
          <?php echo @$cpass_err; ?>

      </td>
    </tr>

    <tr>
      <td>
      <!--Submit Button-->
      <input type="submit" class="btn btn-primary" id="btnregsubmit" name="btnregsubmit" value="Register">
    </td>
      <script>
        function clrfrm()
        {
          location.reload();
        }
      </script>
      <td>
      <!--Reset Button-->
      <input class="btn btn-primary" name="btnregreset" id="btnregreset" type="button" onclick="clrfrm();" value="Reset">
    </td>
  </tr>

    </form>
    </table>
  </div>
  </body>
  <?php require('includes/footer.php') ?>
</html>
