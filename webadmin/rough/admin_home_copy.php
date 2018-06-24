<?php require("no_redirect.php");?>
<?php require('../includes/admin_navbar.php'); ?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <!-- <li class="nav-item">
  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
</li> -->
<li class="nav-item">
  <a class="nav-link  active"  id="add_tshirt-tab" data-toggle="tab" href="#add_tshirt" role="tab" aria-controls="add_tshirt" aria-selected="true">Add</a>
</li>
<li class="nav-item">
  <a class="nav-link" id="modify_tshirt-tab" data-toggle="tab" href="#modify_tshirt" role="tab" aria-controls="modify_tshirt" aria-selected="false">Modify</a>
</li>
<li class="nav-item">
  <a class="nav-link" id="remove_tshirt-tab" data-toggle="tab" href="#remove_tshirt" role="tab" aria-controls="remove_tshirt" aria-selected="false">Remove</a>
</li>
<li class="nav-item">
  <a class="nav-link" id="view_tshirt-tab" data-toggle="tab" href="#view_tshirt" role="tab" aria-controls="view_tshirt" aria-selected="false">View</a>
</li>
</ul>
<div class="tab-content" id="myTabContent">

  <!-- <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">.1..</div> -->

  <div class="tab-pane fade  show active " id="add_tshirt" role="tabpanel" aria-labelledby="add_tshirt-tab">

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm">
          <form method="post">

            <label for="">Brands</label>

            <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="brand" name="brand">
              <option>Choose a brand..</option>
              <?php

              $sql ="Select * from brands";
              $query = mysqli_query($dbc,$sql);
              while ($row =mysqli_fetch_array($query)) {
                $id = $row['id'];
                $title = $row['title'];
                echo "<option value='$id'>$title</option>";
              }
              ?>
            </select>
            <!-- <div id="div_brand"></div>

            <input type="button" id="btnok" name="btnox" onclick="addBrand();" value="Other Brand" class="btn btn-secondary"/>
            <input type="submit" value="add" name="add_brand" class="btn btn-success">
            <br /> -->

            <!-- <script type="text/javascript">
            function addBrand()
            {

              var div_brand=document.getElementById("div_brand");
              div_brand.innerHTML="Please Specify: <input type='text' name='new_brand' required/>";

              var x = document.getElementById("div_brand");
            if (x.style.display === "none") {


            x.style.display = "block";
            } else {
            x.style.display = "none";
            }


            }

          </script> -->

          <?php


          // if(isset($_POST['add_brand']))
          // {
          //
          //   $add_brand= $_POST['new_brand'];
          //
          //
          //   $sql = "INSERT into brands(id,title) VALUES ('','$add_brand')  ";
          //   $query = mysqli_query($dbc, $sql);
          //
          //   if($query)
          //   {
          //     echo "<script> alert('A new brand was added'); </script>";
          //     echo "<meta http-equiv=\"refresh\"content=\"0;URL=admin_home.php\">";
          //
          //
          //   }
          //   else {
          //     echo "<script> alert('Sorry Something went wrong! Please try again later'); </script> </br>";
          //   }
          //
          // }


          ?>



          <label for="">Category</label>

          <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="category" name="category">
            <option>Choose a category..</option>
            <?php

            $sql ="Select * from category";
            $query = mysqli_query($dbc,$sql);
            while ($row =mysqli_fetch_array($query)) {
              $id = $row['id'];
              $title = $row['title'];
              echo "<option value='$id'>$title</option>";
            }
            ?>
          </select>
          <!-- <div id="div_category"></div>

          <input type="button" id="btnok" name="btnox" onclick="addCategory();" value="Other category" class="btn btn-secondary"/>
          <input type="submit" value="add" name="add_category" class="btn btn-success">
          <br /> -->

          <!-- <script type="text/javascript">
          function addCategory()
          {
            var div_category=document.getElementById("div_category");
            div_category.innerHTML="Please Specify: <input type='text' name='new_category' required/>";


            var x = document.getElementById("div_category");
            if (x.style.display === "none") {
              x.style.display = "block";
            } else {
              x.style.display = "none";
            }

          }



        </script>-->

        <?php


        // if(isset($_POST['add_category']))
        // {
        //
        //   $add_category= $_POST['new_category'];
        //
        //
        //   $sql = "INSERT into category(id,title) VALUES ('','$add_category')  ";
        //   $query = mysqli_query($dbc, $sql);
        //
        //   if($query)
        //   {
        //     echo "<script> alert('A new category was added'); </script>";
        //     echo "<meta http-equiv=\"refresh\"content=\"0;URL=admin_home.php\">";
        //
        //
        //   }
        //   else {
        //     echo "<script> alert('Sorry Something went wrong! Please try again later'); </script> </br>";
        //   }
        //
        // }


        ?>

        <label for="">Color(Front)</label>
        <input type="color"  id="" placeholder="Pick a color">
        <label for="">Color(Back)</label>
        <input type="color"  id="" placeholder="Pick a color">
      </br>
      <label for="">Design Title</label>
      <input type="text" class="form-control" id="" placeholder="Design Title (e.g Animal logo)">
      <label class="mr-sm-2" for="">Features</label>
      <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="feature" name="feature">
        <option>Choose a feature..</option>
        <?php

        $sql ="Select * from features";
        $query = mysqli_query($dbc,$sql);
        while ($row =mysqli_fetch_array($query)) {
          $id = $row['id'];
          $title = $row['title'];
          echo "<option value='$id'>$title</option>";
        }
        ?>
      </select>
      <!-- <div id="div_features"></div>

      <input type="button" id="btnok" name="btnox" onclick="addFeatures();" value="Other Feature" class="btn btn-secondary" />
      <input type="submit" value="add" name="add_features" class="btn btn-success">
      <br /> -->

      <!-- <script type="text/javascript">
      function addFeatures()
      {
        var div_features=document.getElementById("div_features");
        div_features.innerHTML="Please Specify: <input type='text' name='new_features'required />";

        var x = document.getElementById("div_features");
        if (x.style.display === "none") {
          x.style.display = "block";
        } else {
          x.style.display = "none";
        }



      }
    </script> -->

    <?php

    // if(isset($_POST['add_features']))
    // {
    //
    //   $add_features= $_POST['new_features'];
    //
    //
    //   $sql = "INSERT into features(id,title) VALUES ('','$add_features')  ";
    //   $query = mysqli_query($dbc, $sql);
    //
    //   if($query)
    //   {
    //     echo "<script> alert('A new feature was added'); </script>";
    //     echo "<meta http-equiv=\"refresh\"content=\"0;URL=admin_home.php\">";
    //
    //
    //   }
    //   else {
    //     echo "<script> alert('Sorry Something went wrong! Please try again later'); </script> </br>";
    //   }
    //
    // }



    ?>




  <!-- </form> -->

</div>
<div class="col-sm">

  <form enctype="multipart/form-data" method="post">

    <label class="mr-sm-2" for="">Fabrics</label>
    <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="fabric" name="fabric">
      <option>Choose a fabric..</option>
      <?php

      $sql ="Select * from fabrics";
      $query = mysqli_query($dbc,$sql);
      while ($row =mysqli_fetch_array($query)) {
        $id = $row['id'];
        $title = $row['title'];
        echo "<option value='$id'>$title</option>";
      }
      ?>
    </select>
<!--
    <div id="div_fabrics"></div>

    <input type="button" id="btnok" name="btnox" onclick="addFabrics();" value="Other Fabrics" class="btn btn-secondary" />
    <input type="submit" value="add" name="add_fabrics" class="btn btn-success">
    <br />

    <script type="text/javascript">
    function addFabrics()
    {
      var div_fabrics=document.getElementById("div_fabrics");
      div_fabrics.innerHTML="Please Specify: <input type='text' name='new_fabrics'required />";

      var x = document.getElementById("div_fabrics");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }



    }
  </script> -->

  <?php
  //
  // if(isset($_POST['add_fabrics']))
  // {
  //
  //   $add_fabrics= $_POST['new_fabrics'];
  //
  //
  //   $sql = "INSERT into fabrics(id,title) VALUES ('','$add_fabrics')  ";
  //   $query = mysqli_query($dbc, $sql);
  //
  //   if($query)
  //   {
  //     echo "<script> alert('A new fabric was added'); </script>";
  //     echo "<meta http-equiv=\"refresh\"content=\"0;URL=admin_home.php\">";
  //
  //
  //   }
  //   else {
  //     echo "<script> alert('Sorry Something went wrong! Please try again later'); </script> </br>";
  //   }
  //
  // }



  ?>


  <label for="">Type</label>
  <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="type" name="type">
    <option>Choose a type..</option>
    <?php

    $sql ="Select * from type";
    $query = mysqli_query($dbc,$sql);
    while ($row =mysqli_fetch_array($query)) {
      $id = $row['id'];
      $title = $row['title'];
      echo "<option value='$id'>$title</option>";
    }
    ?>
  </select>
  <!-- <div id="div_type"></div>

  <input type="button" id="btnok" name="btnox" onclick="addType();" value="Other Type" class="btn btn-secondary" />
  <input type="submit" value="add" name="add_type" class="btn btn-success">
  <br />

  <script type="text/javascript">
  function addType()
  {
    var div_type=document.getElementById("div_type");
    div_type.innerHTML="Please Specify: <input type='text' name='new_type'required />";

    var x = document.getElementById("div_type");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }



  }
</script> -->

<?php

// if(isset($_POST['add_type']))
// {
//
//   $add_type= $_POST['new_type'];
//
//
//   $sql = "INSERT into type(id,title) VALUES ('','$add_type')  ";
//   $query = mysqli_query($dbc, $sql);
//
//   if($query)
//   {
//     echo "<script> alert('A new type was added'); </script>";
//     echo "<meta http-equiv=\"refresh\"content=\"0;URL=admin_home.php\">";
//
//
//   }
//   else {
//     echo "<script> alert('Sorry Something went wrong! Please try again later'); </script> </br>";
//   }
//
// }



?>







<label for="">Image (front)</label>
<input type="file" name="file" class="form-control"  placeholder="Image front"><br/>

<div class="container-fluid">

  <?php
  if(isset($_POST['Submit1']))
  {
    $filepath = "uploads/" . $_FILES["file"]["name"];

    $sql = "INSERT INTO images(images) VALUES ('$filepath')";
    mysqli_query($dbc, $sql); // store submitted data into db table: images and text


    if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath))
    {
      echo "<img src=".$filepath." height=100 width=100 />";
    }
    else
    {
      echo "Error !!";
    }
  }
  ?>

</div>

<label for="">Image (back)</label>
<input type="file" name="file2" class="form-control"  placeholder="Image back"><br/>


<div class="container-fluid">

  <?php
  if(isset($_POST['Submit1']))
  {
    $filepath = "uploads/" . $_FILES["file2"]["name"];

    $sql = "INSERT INTO images(images) VALUES ('$filepath')";
    mysqli_query($dbc, $sql); // store submitted data into db table: images and text


    if(move_uploaded_file($_FILES["file2"]["tmp_name"], $filepath))
    {
      echo "<img src=".$filepath." height=100 width=100 />";
    }
    else
    {
      echo "Error !!";
    }
  }
  ?>

</div>
<input type="submit" value="Upload image" class="btn btn-secondary" name="Submit1"> </br><br/>





<!-- </form> -->

</div>
<div class="col-sm">
  <!-- <form method="post"> -->

    <label for="">Pattern</label>
    <input type="text" class="form-control" id="" placeholder="Pattern">

    <label for="">Price</label>
    <input type="number" class="form-control" id="" placeholder="Price">

    <label for="">Size</label>
    <input type="text" class="form-control" id="" placeholder="Size">

    <label for="">Quantity</label>
    <input type="number" class="form-control" id="" placeholder="Quantity">



    <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>




  <!-- </form> -->

</div>


</div>
</div>



</div>
<div class="tab-pane fade" id="modify_tshirt" role="tabpanel" aria-labelledby="modify_tshirt-tab">.2..</div>
<div class="tab-pane fade" id="remove_tshirt" role="tabpanel" aria-labelledby="remove_tshirt-tab">..3.</div>
<div class="tab-pane fade" id="view_tshirt" role="tabpanel" aria-labelledby="view_tshirt-tab">..4.</div>
</div>
