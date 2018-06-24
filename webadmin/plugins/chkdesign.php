<?php
  require('../../includes/dbconnect.php');
  $adddesign = $_POST["add_value"];
  if(isset($adddesign))
  {
    $sql ="SELECT * FROM tbl_design WHERE design ='$adddesign';";
    $res_design = mysqli_query($dbc, $sql);
    if(mysqli_num_rows($res_design) > 0)
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
