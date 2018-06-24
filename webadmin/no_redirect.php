<?php

function AdminOn() //check if admin is logged in
{
  session_start();
  if(isset($_SESSION['admin']))
  {
    header('Location:admin_home.php');
  }
}

function AdminOff() //check if admin is logged out ,if no session is created user is redirect to loginpage

{
  session_start();
  if(!isset($_SESSION['admin']))
  {
    header('Location:admin_login.php');
  }
}


 ?>
