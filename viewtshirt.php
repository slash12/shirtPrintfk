<?php
//include database connection
    require('includes/dbconnect.php');
//include database connection
//Session check and redirect
    session_start();

    if(!isset($_SESSION['user_login']))
    {
    require('includes/session_timer.php');
    }

    if(isset($_SESSION['admin']))
    {
    header('Location:webadmin/crudtshirt.php');
    }
//Session check and redirect
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ShirtPrints | T-Shirt Details</title>
  <!-- Imports -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-magnify.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/font-awesome-all.css">
    <link rel="stylesheet" href="css/slick.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-magnify.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script>
      $(document).ready(function()
      {
          $('.tshirt_carousel').slick(
          {
            autoplay: true,
            arrows:false
          }
        );
      });
    </script>
  <!-- /Imports -->
</head>
<body>
<!-- navbar include -->
  <?php
  require(realpath("includes/navbar.php"));
  ?>
<!-- /navbar include -->

<!-- Retrieve Data for Card -->
  <?php 
    if($_GET)
    {
      $tshirt_id = mysqli_escape_string($dbc, trim($_GET["ts_id"]));
      $sql_tshirt_retrieve ="SELECT 
                    ts.tshirt_id AS tshirt_id,
                    ts.price AS Price,
                    ts.quantity AS Quantity,
                    ts.img_front AS imgf,
                    ts.img_back AS imgb,
                    ts.model_no AS modno,
                    ts.tshirt_title AS ts_title,
                    GROUP_CONCAT(DISTINCT tp.pattern) AS Pattern, 
                    GROUP_CONCAT(DISTINCT tc.color) As Color,
                    GROUP_CONCAT(DISTINCT tf.fabric) As Fabric,
                    GROUP_CONCAT(DISTINCT te.feature) As Feature,
                    (SELECT brand FROM tbl_brand tb WHERE tb.brand_id = ts.brand_id) As Brand,
                    (SELECT cat_name FROM tbl_category tcat WHERE tcat.cat_id = ts.category_id) As Category,
                    (SELECT design FROM tbl_design tde WHERE tde.design_id = ts.design_id) As Design,
                    (SELECT type FROM tbl_type ty WHERE ty.type_id = ts.type_id) As Type,
                    (SELECT size FROM tbl_size tsi WHERE tsi.size_id = ts.size_id) As Size
                    FROM tbl_tshirt_pattern tsp, tbl_pattern tp, tbl_tshirt ts, tbl_tshirt_color tsc, tbl_color tc, tbl_fabric tf, tbl_tshirt_fabric tsf, tbl_feature te, tbl_tshirt_features tfe
                    WHERE ts.tshirt_id = tsp.tshirt_id 
                    AND tsp.pattern_id = tp.pattern_id
                    AND ts.tshirt_id = tsc.tshirt_id
                    AND tsc.color_id = tc.color_id
                    AND tsf.tshirt_id = ts.tshirt_id
                    AND tsf.fabric_id = tf.fabric_id
                    AND tfe.tshirt_id = ts.tshirt_id
                    AND tfe.feature_id = te.feature_id
                    AND ts.tshirt_id = '$tshirt_id'
                    GROUP BY ts.tshirt_id";
      $qry_tshirt_retrieve = mysqli_query($dbc, $sql_tshirt_retrieve);
      if($qry_tshirt_retrieve)
      {
        $res_retrieve = mysqli_fetch_assoc($qry_tshirt_retrieve);
      }
    }
  ?>
<!-- /Retrieve Data for Card -->

<!-- content -->
    <div class="container-fluid body-container">
        <div class="wrapper-card-tshirt">
            <div class="product-img">
              <div class="slider tshirt_carousel">
                <div>
                  <img src="<?php echo substr($res_retrieve['imgf'], 3); ?>">
                </div>
                <div>
                  <img src="<?php echo substr($res_retrieve['imgb'], 3); ?>">
                </div>
              </div>
            </div>
          <div class="product-info">
            <div class="product-text">
            <!-- Table for Display Title -->
              <table class="tbl-title">
                <tr>
                  <td><h1><?php echo $res_retrieve["ts_title"] ?></h1></td>
                  <td class="td-btnBack-card"><a href="search.php" class="btn btn-secondary">Back</a></td>
                </tr>
              </table>
            <!-- /Table for Display Title -->
            <!-- Main Tshirt Details -->
              <table class="table btn-tbl-mainContent">
                <tr>
                  <th>Brand</th>
                  <th>Type</th>
                  <th>Size</th>
                  <th>Category</th>
                </tr>
                <tr>
                  <td><?php echo $res_retrieve["Brand"]; ?></td>
                  <td><?php echo $res_retrieve["Type"]; ?></td>
                  <td><?php echo $res_retrieve["Size"]; ?></td>
                  <td><?php echo $res_retrieve["Category"]; ?></td>
                </tr>
              </table>
            <!-- /Main Tshirt Details -->
            <!-- Tshirt Price -->
              <table class="table-price">
                <tr>
                  <th><span>MUR <?php echo $res_retrieve["Price"].".00"; ?></span></th>
                  <td class="btn-table-price"><button class="btn btn-primary"><i class="far fa-credit-card"></i> Buy Now</button><button class="btn btn-info btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</button></td>                
                </tr>
              </table>
            <!-- /Tshirt Price -->
            <!-- Tab for all Tshirt Details -->
              <div class="tab-container">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" href="#tshirt_details" role="tab" data-toggle="tab">T-Shirt Details</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#tshirt_rating" role="tab" data-toggle="tab">Ratings</a>
                  </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="tshirt_details">
                    <table class="table">
                      <tr>
                        <th>Model Number</th>
                        <td><?php echo $res_retrieve["modno"]; ?></td>
                        <th>Feature</th>
                        <td><?php echo $res_retrieve["Feature"]; ?></td>
                      </tr>
                      <tr>
                        <th>Design</th>
                        <td><?php echo $res_retrieve["Design"]; ?></td>
                        <th>Pattern</th>
                        <td><?php echo $res_retrieve["Pattern"]; ?></td>
                      </tr>
                      <tr>
                        <th>Color</th>
                        <td><?php echo $res_retrieve["Color"]; ?></td>
                        <th>Fabric</th>
                        <td><?php echo $res_retrieve["Fabric"]; ?></td>
                      </tr>
                    </table>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="tshirt_rating">bbb</div>
                </div>
              </div>
            <!-- /Tab for all Tshirt Details -->
            </div>
          </div>
        </div>
    </div>
<!-- /content -->
   
<!-- footer include -->
    <?php
    require("includes/footer.php");
    ?>
<!-- /footer include -->

  </body>
  </html>
