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
                        tshirt_id,
                        price,
                        img_front AS imgf,
                        tshirt_title
                        FROM tbl_tshirt";

            if($_GET)
            {
                $sql_tshirt .= " WHERE ";
                $search_param = mysqli_escape_string($dbc, trim($_GET["txtsearch"]));
                if(empty($search_param))
                {
                    $sql_tshirt .= "";
                }
                else
                {
                    $sql_tshirt .= "tshirt_title LIKE '%".$search_param."%'";
                }

                if(isset($_GET["slttype"]) && !empty($search_param))
                {
                    $type_param = mysqli_escape_string($dbc, trim($_GET["slttype"]));
                    $sql_tshirt .= " OR type_id =".$type_param."; ";
                }
                else
                {
                    $type_param = mysqli_escape_string($dbc, trim($_GET["slttype"]));
                    $sql_tshirt .=" type_id =".$type_param.";";
                }
            }
        $qry_tshirt = mysqli_query($dbc, $sql_tshirt);
        if($qry_tshirt)
        {
            while($res_tshirt = mysqli_fetch_array($qry_tshirt, MYSQLI_ASSOC))
            {
                ?>
                    <div class="card card-tshirt">
                        <img src="<?php echo substr($res_tshirt['imgf'], 3); ?>" class="search-img" alt="Avatar">
                        <div class="container">
                            <h6><b><?php echo mb_strimwidth($res_tshirt["tshirt_title"], 0, 20, "..."); ?></b></h6> 
                            <span>MUR <s><?php echo $res_tshirt["price"] + 100 ; ?></s> <?php echo $res_tshirt["price"]; ?></span>
                            <span><a class="btn btn-info tsdetails" href="viewtshirt.php?id='<?php echo $res_tshirt['tshirt_id']; ?>'">Details</a></span> 
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
