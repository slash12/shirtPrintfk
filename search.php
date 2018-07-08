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
        <!-- Type Combo -->
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
        <!-- /Type Combo -->
        <!-- Brand Combo -->
            <div class="form-group">
                <select name="sltbrand" class="selectpicker" id="sltbrand">
                    <option value="0" selected="true">Choose Brand</option>
                    <?php
                        $sql_brand = "SELECT * FROM tbl_brand;";
                        $qry_brand = mysqli_query($dbc, $sql_brand);
                        if($qry_brand)
                        {
                            while($res_brand = mysqli_fetch_array($qry_brand, MYSQLI_ASSOC))
                            {
                            ?>
                            <option value="<?php echo $res_brand['brand_id']; ?>"><?php echo $res_brand['brand'] ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </div>
        <!-- /Brand Combo -->
        <!-- Category Combo -->
            <div class="form-group">
                <select name="sltcat" class="selectpicker" id="sltcat">
                    <option value="0" selected="true">Choose Category</option>
                    <?php
                        $sql_cat = "SELECT * FROM tbl_category;";
                        $qry_cat = mysqli_query($dbc, $sql_cat);
                        if($qry_cat)
                        {
                            while($res_cat = mysqli_fetch_array($qry_cat, MYSQLI_ASSOC))
                            {
                            ?>
                            <option value="<?php echo $res_cat['cat_id']; ?>"><?php echo $res_cat['cat_name'] ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </div>
        <!-- /Category Combo -->
            <button type="submit" class="btn btn-secondary">Search</button>
            <button type="reset" onclick="window.location='search.php'" class="btn btn-warning">Reset</button>
        </form>
        <hr>

<!--Get Search values-->
    <?php


            if($_GET)
            {
            // Retrieve text search value
                @$search = mysqli_escape_string($dbc, trim($_GET["txtsearch"]));
            // Retrieve type value
                @$type_param = mysqli_escape_string($dbc, trim($_GET["slttype"]));
            // Retrieve brand value
                @$brand_param = mysqli_escape_string($dbc, trim($_GET["sltbrand"]));
            // Retrieve Category value
                @$cat_param = mysqli_escape_string($dbc, trim($_GET["sltcat"]));

            //Search Value Validation
                if(empty($search))
                {
                    $search_param = "";
                }
                else
                {
                    $search_param = "%$search%";
                }
            //Search Value Validation

                $sql_tshirt = "SELECT
                tshirt_id,
                price,
                img_front AS imgf,
                tshirt_title
                FROM tbl_tshirt WHERE type_id = '".@$type_param."'
                OR tshirt_title LIKE '".@$search_param."'
                OR brand_id = '".@$brand_param."'
                OR category_id = '".@$cat_param."'";
            }
            else
            {
                $sql_tshirt = "SELECT
                tshirt_id,
                price,
                img_front AS imgf,
                tshirt_title
                FROM tbl_tshirt";
            }

            $qry_tshirt = mysqli_query($dbc, $sql_tshirt);
            if(mysqli_affected_rows($dbc)>0)
            {
                while($res_tshirt = mysqli_fetch_array($qry_tshirt, MYSQLI_ASSOC))
                {
                    ?>
                    <div class="card card-tshirt">
                        <img src="<?php echo substr($res_tshirt['imgf'], 3); ?>" class="search-img" alt="Avatar">
                        <div class="container">
                            <h6><b><?php echo mb_strimwidth($res_tshirt["tshirt_title"], 0, 20, "..."); ?></b></h6>
                            <span>MUR <s><?php echo $res_tshirt["price"] + 100 ; ?></s> <?php echo $res_tshirt["price"]; ?></span>
                            <span>
                            <a class="btn btn-info" href="viewtshirt.php?id='<?php echo $res_tshirt['tshirt_id']; ?>'">Details</a>
                            <a class="btn btn-primary" href="#">Buy Now</a>
                            </span>
                        </div>
                    </div>
                    <?php
                }
            }
            elseif(mysqli_affected_rows($dbc)==0)
            {
                if($_GET){
                    echo   "<div class='jumbotron'>
                    <h1>No Result found</h1>
                    <p>Please, Retry!</p>
                </div>";
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
