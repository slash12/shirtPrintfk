<?php
require('../includes/dbconnect.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <?php include ('../js/libraries/libraries.php'); ?>
  <style media="screen">
  .zoom {
    padding: 100px;
    padding-right: 100px;
    position: relative;
    left: 50px;
    transition: transform .5s;
    width: 500px;
    height: 500px;
  }
  .zoom:hover {
    -ms-transform: scale(1.5); /* IE 9 */
    -webkit-transform: scale(1.5); /* Safari 3-8 */
    transform: scale(1.5);
  }
  .detail td
  {
    padding: 5px;
  }
</style>
</head>
<body>

  <?php include('../includes/navbar.php'); ?>

  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="box-shadow: 4px 4px 5px  #aaaaaa">
        <center>
          <?php
          $sql = "SELECT * from addcustomizedtshirt  ORDER BY CustomizedTshirt_id DESC LIMIT 1";
          $qry = mysqli_query($dbc, $sql);

          if($qry)
          {
            while($row = mysqli_fetch_array($qry ))
            {
              echo "<img src='".$row['img_path']."' height= 100px width=100px class=zoom /> ";
            }
          }
          ?>
        </center>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"  style="box-shadow: 5px 5px 5px #aaaaaa;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >

          <?php

          $sql = "SELECT * from addcustomizedtshirt ORDER BY CustomizedTshirt_id DESC LIMIT 1  ";
          $qry = mysqli_query($dbc, $sql);

          if($qry)
          {

            echo "<div class=detail>";
            echo "<table>";
            echo "<h1>Details </h1>";
            while($row = mysqli_fetch_array($qry ))
            {

              echo "<tr>";

              echo " <td> Color code </td>";
              echo "<td>".$row['color']. "</td>";

              echo "</tr>";

              echo "<tr>";

              echo " <td> Color name </td>";
              echo "<td>".$row['color_name']. "</td>";

              echo "</tr>";

              echo "<tr>";

              echo " <td> Item size </td>";
              echo "<td>".$row['size']. "</td>";

              echo "</tr>";
              echo "<tr>";

              echo " <td> Item Category </td>";
              echo "<td>".$row['category']. "</td>";

              echo "</tr>";

              echo "<tr>";

              echo " <td> Position </td>";
              echo "<td>".$row['position']. "</td>";

              echo "</tr>";

              echo "<tr>";

              echo " <td> Gender </td>";
              echo "<td>".$row['gender']. "</td>";

              echo "</tr>";


              echo "<tr>";

              echo " <td> Font <b>(if any)</b> </td>";
              echo "<td>".$row['fontfamily']. "</td>";

              echo "</tr>";

              echo "<tr>";

              echo " <td> Font Size <b>(if any)</b> </td>";
              echo "<td>".$row['fontsize']. "</td>";

              echo "</tr>";

              echo "<tr>";

              echo " <td> Font Color <b>(if any)</b>  </td>";
              echo "<td>".$row['fontcolor']. "</td>";

              echo "</tr>";

              echo "<tr>";

              echo " <td> <h3>Total price </h3></td>";
              echo "<td>".$row['price']. "</td>";


              echo "<input type=hidden name=img_paths id=img_paths value= ".$row['img_path']." /> ";

            }
            echo "</table>";


            echo "</div>";


          }


          ?>


          <!-- Button trigger modal -->
          <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#exampleModal">

            Add to cart
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Quantity</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="number" name="txtqty" id="txtqty" placeholder="Enter item qty" class="form-control">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button  class="btn btn-primary"  name="btnaddtocart" id="btnaddtocart">Save changes</button>
                </div>
              </div>
            </div>
          </div>
          <button  class="btn btn-primary btn-lg" name="btnbuynow" id="btnbuynow">Buy Now</button>
          <button  class="btn btn-success btn-lg" name="btncancel" id="btncancel">Cancel</button>




        </div>
      </div>

    </div>
    <?php
    $query = "SELECT * from tbl_user where username = '{$_SESSION['uname']}'";
    $result = mysqli_query($dbc,$query);
    while($row=mysqli_fetch_assoc($result))
    {
    echo "<input type=hidden name=user_id id=user_id value='".$row['user_id']."' />";
    }
     ?>

    <?php
    $a = "SELECT CustomizedTshirt_id from addcustomizedtshirt";
    $b = mysqli_query($dbc, $sql);

    if($b){

      $row= mysqli_fetch_array($b);
      echo "<input type=hidden name=cid id=cid value= '".$row['CustomizedTshirt_id']."' / >";


    }

    //add to Cart (btnaddtocart)
    if(isset($_POST["btnaddtocart"]))
    {
      $cid = $_POST['cid'];
      $imgpaths = $_POST['img_paths'];
      $qty = $_POST['txtqty'];
      $user_id = $_POST['user_id'];

      $sql = "INSERT into addtocart (img_path, quantity , CustomizedTshirt_id, user_id) values('$imgpaths', '$qty', $cid ,'$user_id')";
      $qry = mysqli_query($dbc, $sql);


      if($qry)
      {
        echo "<script> alert('inserted'); </script>";
        echo "<meta http-equiv='refresh' content='0;url=shoppingcart.php'>";

      }
      else {
        echo "<script> alert('not inserted'); </script>";
      }



    }

    else if(isset ($_POST['btncancel']))
    {

      $sql = "DELETE FROM addcustomizedtshirt ORDER BY CustomizedTshirt_id DESC LIMIT 1 ";
      $qry = mysqli_query($dbc, $sql);
      if($qry)
      {
        echo "<h1>deleted</h1>";
        echo "<meta http-equiv='refresh' content='0;url=tshirteditor.php'>";
      }
      else {


        echo "<h1>Sorry could not delete</h1>";

      }
    }
    else if(isset ($_POST['btnbuynow']))
    {
      echo "<meta http-equiv='refresh' content='0;url=buynow.php'>";

    }

    ?>



  </form>



  <?php include('../includes/footer.php'); ?>

</body>
</html>
