<?php
require('../includes/dbconnect.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="../css/bootstrap2.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link type="text/css" rel="stylesheet" href="../css/editorcss/editor.css" />
  <script src="../js/editorjs/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="../js/editorjs/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="../js/editorjs/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="../js/editorjs/fabric.js"></script>
  <script type="text/javascript" src="../js/editorjs/jquery.miniColors.min.js"></script>
  <script src="../js/editorjs/pattern.js"></script>
  <script type="text/javascript">
  //code for screenshot image
  var takeScreenShot = function() {
    html2canvas(document.getElementById("tshirt"), {
      onrendered: function (canvas) {
        var tempcanvas=document.createElement('canvas');
        tempcanvas.width=350;
        tempcanvas.height=350;
        var context=tempcanvas.getContext('2d');
        var c=context.drawImage(canvas,10,10,230,280);
        // context.drawImage(img,sx,sy,swidth,sheight,x,y,width,height);
        var link=document.createElement("a");
        var b=link.href=tempcanvas.toDataURL('image/jpg');   // url of image
        document.getElementById('hfpath').value = b;
      }
    });
  }
  </script>
</head>
<body>
  <?php include('../includes/navbar.php'); ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

    <div class="row">
      <div class="col-sm-6" style="background:#ABC;">
        <div class="row" >
          <div class="col-md-6" style="background:#DEF;">
            <?php
            $sql = "SELECT * FROM addpattern";
            $qry = mysqli_query($dbc, $sql);
            while($row = mysqli_fetch_array($qry))
            {
              echo " <img style=cursor:pointer;width:90px;height:120px; id=pattern name=pattern class=img-polaroid src='".$row['pattern']."'>";
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
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
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
          <img id="shirt" src="images/tshirt/male/front.png"width="530" height="550"></img>
          <canvas id="tcanvas"></canvas>
        </div>
      </div>
    </div>
  </form>

  <input type="hidden" name="hfpath" id="hfpath">
  <input type="hidden" name="hfcol" id="hfcol"/>
  <input type="hidden" name="tshirt" id="tshirt" value="Tshirt"/>
  <input type="hidden" name="tshirt_front" id="tshirtmen_front" value="Front"/>
  <input type="hidden" name="gender" id="gender" value="Male"/>

  <?php
  if(isset($_POST["btncomplete"]))
  {
    $pattern = $_POST['hfcol'];
    $category = $_POST['tshirt'];
    $position = $_POST['tshirtmen_front'];
    $gender = $_POST['gender'];
    $size = $_POST['size'];

    $upload_dir = "images/customImage/";
    $img = $_POST['hfpath'];
    echo "<script>alert('valpost".$img."');</script>";
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = $upload_dir.uniqid().".png";
    $success = file_put_contents($file, $data);

    if($success)
    {

      $sql = "INSERT into addcustomizedtshirt(img_path, size, category, position,gender) values ( '$file','$size', '$category','$position','$gender')";
      $qry = mysqli_query($dbc, $sql);
      if($qry)
      {
        echo "<script>alert('success');</script>";
        echo "<meta http-equiv='refresh' content='0;url=save.php'>";
      }
      else
      {
        echo "<script>alert('failure');</script>";
      }
    }
    else
    {
      echo "<script>alert('fail_upload');</script>";
    }
  }
  ?>
  <?php include('../includes/footer.php'); ?>
</body>
</html>
