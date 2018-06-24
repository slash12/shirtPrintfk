<?php
  require('../../includes/dbconnect.php');
  $addpattern = $_POST["add_value"];
  if(isset($addpattern))
  {
    $sql ="SELECT * FROM tbl_pattern WHERE pattern ='$addpattern';";
    $res_pattern = mysqli_query($dbc, $sql);
    if(mysqli_num_rows($res_pattern) > 0)
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
