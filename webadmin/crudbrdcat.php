<?php require('../includes/dbconnect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ShirtPrints | Manage Brands</title>

<!--Imports-->
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
<!--/Imports-->

</head>
<body>
    <?php 
    if(isset($_POST['btnmbrand']))
    {
        $arr_err = array();
        $brand_cc = trim($_POST['txtbrand']);
        if(empty($brand_cc))
        {
            $arr_err[] = "Please insert a brand";
        }
        else
        {
            $brand = mysqli_real_escape_string($dbc, $brand_cc);

            $brandadd_sql = "INSERT INTO tbl_brand(brand) VALUES('$brand')";
            $brandadd_qry = mysqli_query($dbc, $brandadd_sql);

            if(brandadd_qry)
            {
                echo "<meta http-equiv='refresh' content='0'>";
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

<!--Form Titles-->
    <div class="row">
            <div class="col-md-6">
                <h2>Brands List</h2>
            </div>
            <div class="col-md-6">
                <h2>Brands List</h2>
            </div>
        </div>
<!--/Form Titles-->

<!--Brand Form Frontend-->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="col-md-6">
            <table class="table-responsive tblspace" >
                <tr>
                    <!-- Brand Field -->
                    <td>
                        <label for="Brands">Brands</label>
                    </td>   
                    <td>
                        <input type="text" name="txtmbrand" id="txtmbrand" class="form-control">
                    </td>
                    <td>
                        <input type="submit" name="btnmbrand" id="btnmbrand" class="btn btn-primary">
                    </td>
                    <!-- /Brand Field -->
                </tr>
                <tr>
                    <td colspan="2"><span id="mbrand_availability" class="errfrm"><?php echo @$arr_err[0]; ?></span></td>
                </tr>
            </table>
        </div>
    </form>
<!--/Brand Form Frontend-->

<!--Brand AJAX Validation (Uniqueness)-->
    <script>
    uniqueval("btnmbrand", '#txtmbrand', "plugins/chkbrand.php", '#mbrand_availability', "Brand already exists!", "Enter a Brand");
    </script>
<!--/Brand AJAX Validation (Uniqueness)-->

<!--Brand Datatable-->
<table id="mbrdtbl" class="table">
        <thead>
            <tr>
                <th>Brand</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $brd_sql = "SELECT * FROM tbl_brand;";
                $brd_qry = mysqli_query($dbc, $brd_sql);

                while($row_brd = mysqli_fetch_array($brd_qry))
                {
                    ?>
                    <tr>
                        <td><?php echo $row_brd["brand"]; ?></td>
                        <td><a href="crudbrdcat.php?upbrd='<?php echo $row_brd['brand_id'] ?>'" class="btn btn-info">Modify</a> | 
                        <a href="crudbrdcat.php?delbrd='<?php echo $row_brd['brand_id'] ?>'" class="btn btn-warning">Delete</a></td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
</table>
<!--/Brand Datatable-->

        <div class="col-md-6">
            o
        </div>
    </div>


</body>
</html>