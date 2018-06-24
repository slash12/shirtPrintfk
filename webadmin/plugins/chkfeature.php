<?php
  require('../../includes/dbconnect.php');
  $addfeature = $_POST["add_value"];
  if(isset($addfeature))
  {
    $sql ="SELECT * FROM tbl_feature WHERE feature ='$addfeature';";
    $res_feature = mysqli_query($dbc, $sql);
    if(mysqli_num_rows($res_feature) > 0)
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
