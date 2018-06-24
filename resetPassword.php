<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require('includes/dbconnect.php');

  if(isset($_GET['txtfpemail']))
  {
    $email = $_GET['txtfpemail'];
    //echo $email."<br>";

    $token = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789!$/()*";
    $token = str_shuffle($token);
    $res_pass = substr($token, 0, 8);
    //echo $res_pass."<br>";

    $res_pass_en =  md5($res_pass);
    //echo $res_pass_en;

    $user_check = "SELECT * FROM tbl_user WHERE e_mail = '$email';";
    $user_check_exe = mysqli_query($dbc, $user_check);
    $res = mysqli_fetch_assoc($user_check_exe);
    $uname = $res['username'];

    $sql_r_pass = "UPDATE tbl_user SET password = '$res_pass_en' WHERE e_mail = '$email';";
    $sql_r_pass_exe = mysqli_query($dbc, $sql_r_pass);

    if($sql_r_pass_exe)
    {
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
      $mail->Subject = 'ShirtPrints Reset Password';
      $mail->Body    = "
      Hello $uname, <br>
      Please find your reset Password Below: <br><br>
      Password: $res_pass <br><br>
      <small>* It is recommended that once you login, you change your password </small>
  ";

      if ($mail->send())
      {
          header('Location: resetPassword_success.php');
      } else
      {
          echo $mail->ErrorInfo;
      }
    }
  else
  {
    echo "qry not run<br>";
  }
}
?>
