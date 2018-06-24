<?php
  require('../../includes/dbconnect.php');
  $addbrand = $_POST["add_value"];
  if(isset($addbrand))
  {
    $sql ="SELECT * FROM tbl_brand WHERE brand ='$addbrand';";
    $res = mysqli_query($dbc, $sql);
    if(mysqli_num_rows($res) > 0)
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
