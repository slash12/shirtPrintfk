<!-- <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css"> -->
<?php

function CheckCookieLogin($dbc)
{
  @$uname_cookie = $_COOKIE['uname'];
  if (!empty($uname_cookie))
  {
    $sql_check = "SELECT * FROM `tbl_user` WHERE `login_session`='$uname_cookie';";
    $sql_check_exe = mysqli_query($dbc, $sql_check);
    $res = mysqli_fetch_assoc($sql_check_exe);

    if(mysqli_num_rows($sql_check_exe) > 0)
    {
      $_SESSION['user_login'] = 1;
      $_SESSION['cookie'] = $uname_cookie;
      $_SESSION['uname'] = $res['username'];
      // reset expiry date
      setcookie("uname",$uname_cookie,time()+86400 * 30, "/");
    }
  }
}

if(empty($_SESSION['cookie']) && empty($_SESSION['user_login'])) {
    CheckCookieLogin($dbc);
}

function save_state($a)
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     @$b = $_POST['$a'];
     echo $_POST["$a"];
 }
}


  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $lg_err_arr = array();

    //lg-username
    @$lguname_cc = trim($_POST['txtlguname']);
    //Empty Validation
    if (empty($lguname_cc)) {
        $lg_err_arr[] = "Please Enter your Username";
    } else {
        $lguname = mysqli_real_escape_string($dbc, $lguname_cc);
        //echo "<script>alert('test1')</script>";
    }

    //lg-password
    @$lgpass_cc = trim($_POST['txtlgpass']);
    //Empty Validation
    if (empty($lgpass_cc)) {
        $lg_err_arr[] = "Please Enter your Password";
    } else {
        $lgpass = mysqli_real_escape_string($dbc, md5($lgpass_cc));
        //echo "<script>alert('test2')</script>";
    }


    if(empty($lg_err_arr))
    {
      $check_activation = "SELECT username, isEmailConfirmed FROM tbl_user WHERE username = '$lguname';";
      $check_activation_exe = mysqli_query($dbc, $check_activation);
      $rows = mysqli_fetch_assoc($check_activation_exe);

      if($rows['isEmailConfirmed'] == 0)
      {
        echo "<script> $(document).ready(function(){
            $('#frmlg').modal({show: true});
        }); </script>";
        @$lg_err = "<div id='lg-error'>Please activate your account to proceed</div>";
      }
      else
      {
        $lg_search = "SELECT username, password, user_id FROM tbl_user WHERE username = '$lguname' AND password = '$lgpass';";
        $lg_search_exe = mysqli_query($dbc, $lg_search);
        $result = mysqli_fetch_assoc($lg_search_exe);


        if($lg_search_exe)
        {

          if(mysqli_num_rows($lg_search_exe) > 0)
          {

            //Check if it is admin
            if($result['username'] == "tdcops")
            {
              session_start();
              $_SESSION['admin'] = $lguname;
              header('Location: webadmin/admin_home.php');
            }
            else
            {
              session_start();
              $_SESSION['uname'] = $lguname;
              //If checkbox 'Remember me' is click
                if($_POST['chklgrem'] == "1")
                {
                  $_SESSION['user_login'] = 1;
                  $cookiehash = md5(sha1($_SESSION['uname'].$result['user_id']));
                  setcookie("uname",$cookiehash,time()+86400 * 30, "/");
                  $login_status = "UPDATE tbl_user SET login_session = '$cookiehash' WHERE username='$lguname';";
                  $login_status_exe = mysqli_query($dbc, $login_status);
                }
              header('Location: index.php');
            }

          }
          else
          {
            //echo "<script>alert('test5')</script>";
            echo "<script> $(document).ready(function(){
                $('#frmlg').modal({show: true});
            }); </script>";
            @$lg_err = "<div id='lg-error'>Invalid username and password, Please try again</div>";
          }
        }
      }
    }
  }
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navShirtPrint" aria-controls="navShirtPrint" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <a class="navbar-brand" href="#">
      <img id="imglogo" data-toggle="magnify" src="images/shirtprints_logo.png"  class="d-inline-block align-top" />
    </a>
    <div class="collapse navbar-collapse" id="navShirtPrint">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Brower T-Shirt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Create T-Shirt</a>
        </li>
        <li class="nav-item">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">Group<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="dropdown-item"><a href="#">Men T-Shirt</a></li>
              <li class="dropdown-item"><a href="#">Women T-Shirt</a></li>
              <li class="dropdown-item"><a href="#">Kids T-Shirt</a></li>
              <li class="dropdown-item"><a href="#">Couples T-Shirt</a></li>
            </ul>
          </li>
        </li>
        <li class="nav-item">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">Help<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="dropdown-item"><a href="#">Contact us</a></li>
              <li class="dropdown-item"><a href="#">About us</a></li>
              <li class="dropdown-item"><a href="#">FAQ</a></li>
            </ul>
          </li>
        </li>
      </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php


          if(isset($_SESSION['uname']))
          {
            echo
            "<li class='nav-item'>
              <li class='dropdown'>
                <a href='#' class='dropdown-toggle nav-link pushleft' data-toggle='dropdown'>".@$_SESSION['uname']."<b class='caret'></b></a>
                <ul class='dropdown-menu'>
                  <li class='dropdown-item'><a href='logout.php'>Logout</a></li>
                </ul>
              </li>
              ";
          }
          else
          {
            echo "<li class='nav-item'>
                <a class='nav-link btn btn-default navbar-btn' data-toggle='modal' data-target='#frmlg'>Login</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link btn btn-default navbar-btn' href='Register.php'>Register</a>
            </li>";
          }

            ?>
        </ul>
    </div>
  </div>
  </nav>

  <!-- Forget Password Modal -->
  <div class="modal fade" id="frmfpass" name="frmfpass" tabindex="-1" role="dialog" aria-labelledby="frmfpasstitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Forget your Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">
            <form id="frmfpasscon" method="GET" action="resetPassword.php">
              <div class="form-group row">
                <div class="col-8">
                  <label for="txtfpemail">Email</label>
                  <input type="email" class="form-control" id="txtfpemail" name="txtfpemail" placeholder="E-mail..." required>
                </div>
              </div>
              <!--Submit Button-->
              <input type="submit" class="btn btn-primary" id="btnfpasssubmit" value="Reset Password">
            </form>
          </div>
        </div>
      </div>
    </div>

  <!-- Login Modal -->
  <div class="modal fade" id="frmlg" name="frmlg" tabindex="-1" role="dialog" aria-labelledby="frmlgtitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php echo @$lg_err; ?>
          <form method="post" id="frmlgcon" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!--Username-->
            <div class="form-group row">
              <div class="col-8">
                <label for="txtuname">Username</label>
                <input type="text" class="form-control" id="txtlguname" name="txtlguname" placeholder="Username..." value="<?php @save_state('txtlguname');?>" required>
              </div>
            </div>
              <!--Password-->
              <div class="form-group row">
                <div class="col-8">
                  <label for="txtpass">Password</label>
                  <input type="password" class="form-control" id="txtlgpass" name="txtlgpass" placeholder="Password..." >
                </div>
              </div>
                <!--Submit Button-->
                <input type="submit" class="btn btn-primary" id="btnlgsubmit" value="Sign-in">

                <script>
                  function modalClose()
                  {
                      $(document).ready(function(){
                        $('#frmlg').modal('toggle');
                    });
                  }
                </script>

                <!--Reset your Password-->
                <a href="#" onclick="modalClose();" class="alert-link" data-toggle='modal' data-target='#frmfpass' id="lkfgpass">Reset your Password</a>

                <!--Remember Me -->
                <div class="form-group">
                  <div class="form-check" id="chkremcont">
                      <input class="form-check-input" type="checkbox" value="1" id="chklgrem" name="chklgrem">
                      <label class="form-check-label" for="chklgrem">Remember me</label>
                  </div>
                </div>
          </form>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>


  <!-- <script src="../js/bootstrap.min.js"></script> -->
