<?php
require('../includes/dbconnect.php');
?>
<link rel="stylesheet" href="../css/bootstrap2.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link type="text/css" rel="stylesheet" href="../css/editorcss/editor.css" />
<script src="../js/editorjs/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="../js/editorjs/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="../js/editorjs/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="../js/editorjs/fabric.js"></script>
<script type="text/javascript" src="../js/editorjs/jquery.miniColors.min.js"></script>
<script src="../js/editorjs/pattern.js"></script>

<?php include('../includes/navbar.php'); ?>

<div class="row">
  <div class="col-sm-6" style="background:#ABC;">
    <div class="row" >
      <div class="col-md-6" style="background:#DEF;">

        <?php
        $sql = "SELECT * FROM addpattern";
        $qry = mysqli_query($dbc, $sql);

        while($row = mysqli_fetch_array($qry))
        {
          echo " <img style=cursor:pointer;width:90px;height:120px; class=img-polaroid src='".$row['pattern']."'>";
        }

        ?>
        <br>

      </div>
      <div class="col-md-6" style="background:#CAD;">

        Size:
        <?php
        //size
        $sql = "SELECT * FROM tbl_size";
        $qry = mysqli_query($dbc, $sql);

        if($qry)
        {
          while ($row = mysqli_fetch_array($qry))
          {
            echo  $row['size'];
            echo " <input type=radio  name=size id=size  value = '".$row['size']."' /> ";
          }
        }
        ?>

        <center>
          <!--	bin  -->
          <a  href="#" id="delete" style="background-color:transparent;"><img src="images/icons/bin.png" height="50" width="50"></a>

          <button type="button" onclick="takeScreenShot();" id="btnsave" name="btnsave"  class="btn btn-danger">Save</button>
          <button  id="btncomplete" name="btncomplete"  class="btn btn-success" >Continue</button>
          <!--	reset canvas  -->
          <a href="#" onClick="window.location.reload();" class="btn btn-warning"> Reset </a>
        </center>

      </div>
    </div>
    <div>
    </div>
  </div>

  <div class="col-sm-6">
    <!--	EDITOR      -->
    <div id="shirtDiv" class="page" style="width:500px; height: 500px; position: relative;left:25%; background-color: rgb(255, 255, 255);">
      <img id="shirt" src="images/tshirt/female/front.png"width="530" height="550"></img>
      <canvas id="tcanvas"></canvas>
    </div>

  </div>

</div>
<?php include('../includes/footer.php'); ?>
