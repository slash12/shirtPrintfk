<?php

if(isset($_POST['delete']))
{
  $checkbox =$_POST['checkbox'];
  $delete = $_POST['delete'];
  if($delete)
  {
    for($i=0;$i<$count; $i++)
    {
      $del_id = $checkbox[$i];

      $sql = "DELETE FROM pm_inbox WHERE id='$del_id'";
      $result = mysqli_query($dbc, $sql);
      if($result)
      {
        echo "<meta http-equiv=\"refresh\"content=\"0;URL=pm_inbox.php\">";
      }
    }
  }
}
?>
