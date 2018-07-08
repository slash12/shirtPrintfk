<?php
include('../includes/dbconnect.php');
?>
<?php
include('../js/libraries/libraries.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <style media="screen">
  .row {
    display: flex;
  }
  .oftext{
    background-color: #e2e0e0;
    margin: 0;
    margin-bottom:0;
    padding: 12px;
    text-align: center;
  }
  .ofimg{
    margin: 0;
    margin-top:0;
    padding: 0;
  }

  td{
    padding: 5px;
  }


  i
  {
    height: 50px;
    width: 50px;
  }


</style>
<style type="text/css">
.icon-wrapper{
  position:relative;
  float:left;
  /* left: 800px;
  bottom: 45px; */
}

a{
  text-decoration: none;
}

.badge{
  background: red;
  width: auto;
  height: auto;
  margin: 0;
  border-radius: 100%;
  position:absolute;
  top:-12px;
  right:-9px;
  padding:3px;
}
</style>

<title></title>
</head>
<body>
  <?php include('../includes/navbar.php'); ?>

  <div class="container">


    <h5 style="text-align:center;">My Shopping Cart</h5>

    <div class="row">

      <div class="col">

      </div>
      <div class="col-">
        <div class="icon-wrapper">

          <img src="images/icons/shoppingcart.png" height="30px" width="30px" style="border-radius:40%;"> <span class="badge">
            <?php

            //count no of item in cart

            $sql = "select count(*) from addtocart";
            $qry = mysqli_query($dbc,$sql);

            if($qry)
            {
              $row = mysqli_fetch_array($qry);
              $total = $row[0];
              echo  $total;


            }
            else {
              echo "false";
            }

            ?>

          </span>
        </img>
      </div>
    </div>
    <div class="col">
    </div>
  </div>
</div>
<hr>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm-6 ofimg">
      <?php
      //pagination
      $record_per_page = 2;
      $page ='';
      if(isset($_GET["page"]))
      {
        $page =$_GET["page"];

      }
      else {

        $page=1;
      }

      $start_from = ($page-1)* $record_per_page;


      @$query = "SELECT * from tbl_user where username = '{$_SESSION['uname']}'";
      $result = mysqli_query($dbc,$query);
      $row=mysqli_fetch_assoc($result);
      //echo "<input type=text name=user_id id=user_id value='".$row['user_id']."' />";
      if($result){
        $user_id = $row["user_id"];
        // echo "<script>alert('test".$user_id."')</script>";
      }
      else
      {
        echo "<script>alert('test".mysqli_error($dbc)."')</script>";
      }



    //  $user_id = $_POST['user_id'];

      $sql = "SELECT * FROM addtocart WHERE user_id =$user_id order by cart_id DESC limit $start_from, $record_per_page";
      $qry = mysqli_query($dbc, $sql);
      if($qry)
      {


        while ($row = mysqli_fetch_array($qry)) {

          echo "
          <div class=card style=width: 18rem;>
          <img height=100px width=100px src='".$row['img_path']."' alt=Card image cap>
          <div class=card-body>

          <p class=card-text >

          Quantity : ".$row['quantity']."

          </p>

          <p class=card-text >

          <a href ='shoppingcart.php?edit=".$row['cart_id']."' ><button class='btn btn-outline-dark btn-sm' type='submit' id='edit' name='edit'> EDIT </button></a>
          <a href ='shoppingcart.php?del=".$row['cart_id']."' ><button class='btn btn-outline-dark btn-sm' type='submit' id='delete' name='delete'> DELETE </button></a>
          <a href ='shoppingcart.php?view=".$row['cart_id']."' ><button class='btn btn-outline-dark btn-sm' type='submit' id='view' name='view'> VIEW </button></a>
          </p>
          </div>
          </div>
          ";

        }
      }
      ?>

      <?php

      //pagination
      $page_query = "SELECT * FROM addtocart ORDER BY cart_id DESC";
      $page_result = mysqli_query($dbc, $page_query);
      $total_records = mysqli_num_rows($page_result);
      $total_pages = ceil($total_records/$record_per_page);

      echo "  <nav aria-label=Page navigation example>";
      echo "<ul class=pagination justify-content-end>";
      for ($i=1; $i<=$total_pages; $i++) {

        echo "   <li class=page-item>";
        echo "<a href='shoppingcart.php?page=".$i."' class=page-link  >".$i."</a>";
        echo "</li>";


      }

      echo "</ul>";
      ?>



    </div>
    <div class="col-sm-6 oftext">


      <center>


        <form action="shoppingcart.php" method="post" >

          <?php

          //delete records from database
          if(isset($_GET['del']))
          {
            $id = $_GET['del'];
            $sql = "DELETE FROM addtocart WHERE cart_id='$id'";
            $res = mysqli_query($dbc,$sql);
            echo "<script> alert('Item sucessfully removed from cart'); </script>";
            echo "<meta http-equiv='refresh' content='0;url=shoppingcart.php'>";

          }
          else if(isset($_GET['edit']))
          {

            $id = $_GET['edit'];
            $res= mysqli_query($dbc,"SELECT * FROM addtocart WHERE cart_id='$id'");
            $row= mysqli_fetch_array($res);
            echo "<input type=number name=txtqty2 value='".$row[2]."' class=form-control><button name=btnupdate id=btnupdate class= 'btn btn-success btn-sm '>  Update </button>";


          }
          else if(isset($_GET['view']))
          {

            $id = $_GET['view'];
            $res= mysqli_query($dbc,"SELECT * FROM addcustomizedtshirt,addtocart WHERE addtocart.CustomizedTshirt_id = addcustomizedtshirt.CustomizedTshirt_id  AND cart_id ='$id' ");
            $row= mysqli_fetch_array($res);

            echo "<h1>Item Descriptions</h1>";
            echo $row['size'];
            echo "<br>";
            echo $row['category'];
            echo "<br>";
            echo $row['position'];
            echo "<br>";
            echo $row['gender'];
            echo "<br>";
            echo $row['color_name'];
            echo "<br>";

          }

          if(isset($_POST['btnupdate']))
          {
            $qty = $_POST['txtqty2'];
            $id    = $_POST['cart_id'];


            $sql   = "UPDATE addtocart SET quantity='$qty' WHERE cart_id='$id'";

            $res   = mysqli_query($dbc,$sql);
            echo "<meta http-equiv='refresh' content='0;url=shoppingcart.php'>";
            echo "<script> alert('Records has been updated successfully') </script>";




          }



          ?>


          <input type="hidden" name="cart_id" value="<?php echo $row[0]; ?>">


        </form>


        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
          <div class="card-header">Cart Summary</div>
          <div class="card-body">
            <h5 class="card-title">Total MUR Rs. 0.00</h5>

          </div>
        </div>
      </center>

      <a class="btn btn-primary" href="#">Proceed to checkout</a>

      <br>

      <h2 style="text-align:center;">Customer information</h2>
      <table>

        <tr>

          <td>First Name</td>
        </tr>

        <tr>

          <td>Last  Name</td>
        </tr>

        <tr>

          <td>Contact info</td>
        </tr>


        <tr>

          <td>Shipping address</td>
        </tr>

        <tr>

          <td>Country</td>
          <td>Mobile : </td>
          <td>Home : </td>
          <td>Office : </td>
          <td>Email : </td>
        </tr>

        <tr>
          <td>Order number</td>
        </tr>

      </table>


    </div>

  </div>
</div>


    <?php
    // include('../includes/navbar.php');

    require($_SERVER['DOCUMENT_ROOT']."/shirtprintfk/includes/footer.php");


    ?>


</body>

</html>
