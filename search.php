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
  <meta charset="utf-8">
  <title>ShirtPrints | Search</title>
  <!-- Imports -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-magnify.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-magnify.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    
    
  <!-- /Imports -->
</head>
<body>
<!-- navbar include -->
  <?php
  require("includes/navbar.php");
  ?>
<!-- /navbar include -->



<!-- content -->
    <div class="container-fluid body-container">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="get" class="form-inline">
            <div class="form-group">
                <input type="text" class="form-control" id="txtsearch" name="txtsearch" placeholder="Search...">
            </div>
            <div class="form-group">
                <select name="slttype" class="selectpicker" id="slttype">
                    <option value="0" selected="true">Choose Type</option>
                    <?php 
                        $sql_type = "SELECT * FROM tbl_type;";
                        $qry_type = mysqli_query($dbc, $sql_type);
                        if($qry_type)
                        {
                            while($res_type = mysqli_fetch_array($qry_type, MYSQLI_ASSOC))
                            {
                            ?>
                            <option value="<?php echo $res_type['type_id']; ?>"><?php echo $res_type['type'] ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">Search</button>
        </form> 
        <hr>
       
<!--Get Search values-->
    <?php 
        $sql_tshirt = "SELECT 
                        ts.tshirt_id AS tshirt_id,
                        ts.price AS Price,
                        ts.img_front AS imgf,
                        ts.model_no AS modno,
                        GROUP_CONCAT(DISTINCT tp.pattern) AS Pattern, 
                        GROUP_CONCAT(DISTINCT tf.fabric) As Fabric,
                        GROUP_CONCAT(DISTINCT te.feature) As Feature,
                        (SELECT brand FROM tbl_brand tb WHERE tb.brand_id = ts.brand_id) As Brand,
                        (SELECT cat_name FROM tbl_category tcat WHERE tcat.cat_id = ts.category_id) As Category,
                        (SELECT design FROM tbl_design tde WHERE tde.design_id = ts.design_id) As Design,
                        (SELECT type FROM tbl_type ty WHERE ty.type_id = ts.type_id) As Type
                        FROM tbl_tshirt_pattern tsp, tbl_pattern tp, tbl_tshirt ts, tbl_tshirt_color tsc, tbl_color tc, tbl_fabric tf, tbl_tshirt_fabric tsf, tbl_feature te, tbl_tshirt_features tfe
                        WHERE ts.tshirt_id = tsp.tshirt_id 
                        AND tsp.pattern_id = tp.pattern_id
                        AND ts.tshirt_id = tsc.tshirt_id
                        AND tsf.tshirt_id = ts.tshirt_id
                        AND tsf.fabric_id = tf.fabric_id
                        AND tfe.tshirt_id = ts.tshirt_id
                        AND tfe.feature_id = te.feature_id
                        GROUP BY ts.tshirt_id";
            
        $qry_tshirt = mysqli_query($dbc, $sql_tshirt);
        if($qry_tshirt)
        {
            while($res_tshirt = mysqli_fetch_array($qry_tshirt, MYSQLI_ASSOC))
            {
                ?>
                    <div class="card card-tshirt">
                        <img src="<?php echo substr($res_tshirt['imgf'], 3); ?>" class="search-img" alt="Avatar">
                        <div class="container">
                            <h4><b><?php echo $res_tshirt["modno"]; ?></b></h4> 
                            <p><?php echo  $res_tshirt["Brand"]." ,".$res_tshirt["Category"]." ,...";?></p>
                            <span><a class="btn btn-info" href="viewtshirt.php?id='<?php echo $res_tshirt['tshirt_id']; ?>'">Details</a></span> 
                        </div>
                    </div>
                <?php
            }
        }
    ?>
<!--/Get Search values-->
    </div>
<!-- /content -->
   
<!-- footer include -->
    <?php
    require("includes/footer.php");
    ?>
<!-- /footer include -->
  </body>
  </html>
