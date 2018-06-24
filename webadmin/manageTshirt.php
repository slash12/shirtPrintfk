<?php require('../includes/dbconnect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ShirtPrints | Manage T-Shirt</title>
<!--Import-->
    <link rel="stylesheet" href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap337.min.css">
    <link rel="stylesheet" href="../css/dataTables.bootstrap337.min.css">
    <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap337.min.js"></script>
    <script src="../js/bootstrap337.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/main_admin.js"></script>
<!--/Import-->
</head>
<body>
<?php

        //Delete tshirt 
        if(isset($_GET['deltshirt']))
        {
            $shirt_id = $_GET['deltshirt'];

            $tshirt_sel_qry = mysqli_query($dbc, "SELECT img_front, img_back FROM tbl_tshirt WHERE tshirt_id=".$shirt_id.";");
            if($tshirt_sel_qry)
            {
                //select old img path
                $res_tshirt_sel = mysqli_fetch_array($tshirt_sel_qry, MYSQLI_ASSOC);
                $sel_img_front = $res_tshirt_sel['img_front'];
                $sel_img_back = $res_tshirt_sel['img_back'];

                //delete tshirt row
                $del_tshirt_sql = "DELETE FROM tbl_tshirt WHERE tshirt_id=".$shirt_id.";";
                $del_tshirt_qry = mysqli_query($dbc, $del_tshirt_sql);

                

                if($del_tshirt_qry)
                {
                    //delete old img of tshirt deleted
                    unlink($sel_img_front);
                    unlink($sel_img_back);
                    echo "<script>window.location.href='manageTshirt.php';</script>";
                }
            }
        }
    ?>

    <div class="wrapper">
    <!-- Include side nav -->
            <?php require('../includes/admin_sidenav.php') ?>

<!-- Page Content Holder -->
            <div id="content">
                <?php require('../includes/admin_navbar.php'); ?>
<!--Title of Datatable-->
        <div class="row">
            <div class="col-lg-12">
                <h2>T-Shirt Stock</h2>
            </div>
        </div>
<!--/Title of Datatable-->

<!--Datatable-->
        <table id="mtstbl" class="table nowrap">
        <thead>
            <tr>
                <th>Brand</th>
                <th>Category</th>
                <th>Design</th>
                <th>Pattern</th>
                <th>Type</th>
                <th>Colors</th>
                <th>Fabrics</th>
                <th>Features</th>
                <th>Images</th>
                <th>Size</th>
                <th>Price(MUR)</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        //Display Query
            $tshirt_select = "SELECT 
            ts.tshirt_id AS tshirt_id,
            ts.price AS Price,
            ts.quantity AS Quantity,
            ts.img_front AS imgf,
            ts.img_back AS imgb,
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
            GROUP BY ts.tshirt_id";
            $tshirt_select_qry = mysqli_query($dbc, $tshirt_select);
            
            while($row_msa = mysqli_fetch_array($tshirt_select_qry))
            {
                $imgf = $row_msa['imgf'];
                $imgb = $row_msa['imgb'];
                ?>
                <tr>
                <td><?php echo $row_msa['Brand'];?> </td>
                <td><?php echo $row_msa['Category'];?> </td>
                <td><?php echo $row_msa['Design'];?> </td>
                <td><?php echo $row_msa['Pattern'];?> </td>
                <td><?php echo $row_msa['Type'];?> </td>
                <td><?php echo $row_msa['Color'];?> </td>
                <td><?php echo $row_msa['Fabric'];?> </td>
                <td><?php echo $row_msa['Feature'];?> </td>
                <td>
                <a tabindex="0" class="btn btn-lg btn-danger btn-pop" role="button" data-container="body" data-toggle="popover" data-trigger="focus" data-content="<img src='<?php echo $imgf;?>' width='600' height='300'>">
                Front
                </a>
                <a tabindex="0" class="btn btn-lg btn-danger btn-pop" role="button" data-container="body" data-toggle="popover" data-trigger="focus" data-content="<img src='<?php echo $imgb; ?>' width='600' height='300'>">
                Back
                </a>
                </td>
                <td><?php echo $row_msa['Size'];?> </td>
                <td><?php echo $row_msa['Price'];?> </td>
                <td><?php echo $row_msa['Quantity'];?> </td>
                <td><a href="crudtshirt.php?uptshirt='<?php echo $row_msa['tshirt_id'] ?>'" class="btn btn-info">Modify</a> | 
                <a href="manageTshirt.php?deltshirt='<?php echo $row_msa['tshirt_id'] ?>'" class="btn btn-warning">Delete</a></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
        </table>
<!--/Datatable-->
        <div class="line"></div> 
</div>
</div>
    
</body>
</html>