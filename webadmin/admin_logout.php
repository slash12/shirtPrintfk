<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

session_start();
session_destroy();
unset($_SESSION['admin']);

header('Location:../index.php');

?>
<?php require("../js/prevent_go_back_after_logout.js"); ?>
<?php require("no_redirect.php"); ?>
