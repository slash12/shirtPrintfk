<?php
require('../includes/dbconnect.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Editor</title>
  <link rel="stylesheet" href="../css/bootstrap2.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link type="text/css" rel="stylesheet" href="../css/editorcss/editor.css" />
  <script src="../js/editorjs/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="../js/editorjs/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="../js/editorjs/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="../js/editorjs/fabric.js"></script>
  <script type="text/javascript" src="../js/editorjs/jquery.miniColors.min.js"></script>
  <script src="../js/editorjs/colorpicker.js"></script>
  <script type="text/javascript" src="../js/editorjs/dragndrop.js"></script>
  <script type="text/javascript" src="../js/editorjs/modernizr.min.js"></script>
  <script type="text/javascript" src="../js/ScrollToTop.js"></script>
  <link rel="stylesheet" href="../css/style.css">

  <script type="text/javascript">
  function msg()
  {
    alert('all your current work will be lost ');
  }
</script>

<script type="text/javascript" src="html2canvas.js"></script>
<script type="text/javascript" src="html2canvas.min.js"></script>
<script src="../js/editorjs/jquery2.min.js"></script>
<script src="../js/editorjs/jquery-ui.js"></script>
<script src="../js/editorjs/html2canvas.min.js"></script>
<script type="text/javascript">

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

      // alert(b);
      // link.download = 'new.jpg';
      // link.href='save.php';
      // link.click();
      // alert('screenshot taken sucessfully');
    }
  });
}
</script>
<style>
.logo td{
  padding: 5px;
}
</style>

</head>
<body>
  <?php include('../includes/navbar.php'); ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

    <div class="container">

      <div class="row">
        <table>
          <tr>
            <td><a href="tshirteditor.php">Male/Unisex</a>
            </td>
            <td><a href="female.php">Female </a></td>
            <td><a href="maleHoodiesFront.php" onclick="msg();">Front</a></td>
            <td><a href="maleHoodiesBack.php" onclick="msg();">Back</a></td>
          </tr>
        </table>
        <?php include('editor_includes/leftdiv.php'); ?>
        <div class="col-sm-6">

          <!--	logos  -->

          <div class="logo">
            <center>
              <table>
                <tr>
                  <td><a href="tshirteditor.php"><img src="images/logo/2.png" height=50px width=50px></a></td>
                  <td><a href="maleTankTopFront.php"><img src="images/logo/4.png" height=50px width=58px></a></td>
                  <td><a href="maleHoodiesFront.php"><img src="images/logo/3.png" height=50px width=50px> </a></td>
                  <td><a href="maleLongsleeveFront.php"><img src="images/logo/5.png" height=50px width=50px></a></td>
                </tr>
                <tr>
                  <td>Tshirt</td>
                  <td>Tank Tops</td>
                  <td>Hoodies</td>
                  <td>LongSleeves</td>
                </tr>
              </table>
            </center>
          </div>
          <!--	Tshirt  -->

          <div id="tshirt" >
            <div id="shirtDiv" style="width: 530px; height: 550px; position: relative;  background-color: rgb(255, 255, 255);">
              <img src="images/hoodies/male/mens_hoodie_front.png" id="myimage" width="530px" height="550px"  ></img>
              <div id="canvas-container">
                <canvas id="canvas" width="190" height="300"></canvas>
              </div>
            </div>
          </div>

          <input type="hidden" name="hfpath" id="hfpath">
          <!-- <center>
          <button type="button" onclick="takeScreenShot();" id="btnsave" name="btnsave">Save</button>
          <button  id="btncomplete" name="btncomplete" >Continue</button>
        </center> -->

        <input type="hidden" name="hfcol" id="hfcol"/>
        <input type="hidden" name="hoodie" id="hoodie" value="Hoodie"/>
        <input type="hidden" name="hoodiemen_front" id="hoodiemen_front" value="Front"/>
        <input type="hidden" name="gender" id="gender" value="Male"/>


        <?php

        if(isset($_SERVER['uname']))
        {
        if(isset($_POST["btncomplete"]))
        {


          $color = $_POST['hfcol'];
          $color_name = $_POST['hfcol2'];

          $category = $_POST['hoodie'];
          $position = $_POST['hoodiemen_front'];
          $gender = $_POST['gender'];

          $size = $_POST['size'];
          $fontsize = $_POST['fontsize'];
          $fontcolor = $_POST['fontcolor'];
          $fontfamily = $_POST['fontfamily'];

          $upload_dir = "images/customImage/";
          $img = $_POST['hfpath'];
          //    echo "<script>alert('valpost".$img."');</script>";
          $img = str_replace('data:image/png;base64,', '', $img);
          $img = str_replace(' ', '+', $img);
          $data = base64_decode($img);
          $file = $upload_dir.uniqid().".png";
          $success = file_put_contents($file, $data);

          if(empty($color))
          {
            echo "Error please select a color";
          }
          else if  (empty($size))
          {
            echo "Error please select a size";
          }
          else {
            if($success)
            {

              for($i=0; $i<count($_FILES["file"]["name"]); $i++)
              {
                $filetmp = $_FILES["file"]["tmp_name"] [$i];
                $filename = $_FILES["file"]["name"] [$i];
                $filetype = $_FILES["file"]["type"] [$i];
                $filepath ="uploads/".$filename;
                move_uploaded_file($filetmp,$filepath);
              }
              $sql = "INSERT into addcustomizedtshirt(color, img_path, size, category, position,gender,uploadedimg,fontsize,fontfamily,fontcolor,color_name) values ('$color', '$file','$size', '$category','$position','$gender', '$filepath','$fontsize', '$fontfamily', '$fontcolor','$color_name')";
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
        }
      }
        else {

          echo "<p style=color:red;>You must first login </p>";

        }
        ?>
      </div>
    </div>
  </div>
</form>

</div>
</div>

<?php   include($_SERVER['DOCUMENT_ROOT'].'/shirtprintfk/includes/footer.php'); ?>
</body>
</html>
