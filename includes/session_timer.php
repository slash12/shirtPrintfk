<?php
if (isset($_SESSION["LAST_ACTIVITY"]) && (time() - $_SESSION["LAST_ACTIVITY"] > 100))
{
  unset($_SESSION['uname']);
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>
