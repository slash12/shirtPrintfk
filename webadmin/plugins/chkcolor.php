<?php
  require('../../includes/dbconnect.php');
  $addcolor = $_POST["add_value"];
  if(isset($addcolor))
  {
    $sql ="SELECT * FROM tbl_color WHERE color ='$addcolor';";
    $res_color = mysqli_query($dbc, $sql);
    if(mysqli_num_rows($res_color) > 0)
    {
      echo "true";
    }
    else
    {
      echo "false";
    }
  }
  else
  {
    echo "qry no run";
  }
?>
