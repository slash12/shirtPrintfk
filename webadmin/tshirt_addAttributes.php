<?php 
require('../includes/dbconnect.php'); 
//FUNCTIONS
//make of datatables
function makeDatatbl($col_id, $col,$tblname, $dbc)
{
    $sql = "SELECT $col_id, $col FROM $tblname;";
    $qry = mysqli_query($dbc, $sql);

    while($row = mysqli_fetch_array($qry))
    {
        echo "<tr><td>".$row["$col"]."</td>";
        echo "<td><a class='btn btn-primary' href='tshirt_addAttributes.php?".$tblname."-update=".$row["$col_id"]."'>Update</a> | <a class='btn btn-warning' href='tdatatbl.php?".$tblname."-delete=".$row["$col_id"]."' onclick='return confirm('Are You Sure?');'>Delete</a></td></tr>";
    }
    mysqli_free_result($qry);
}

//to display selected field in the textbox
function displdata($qry_str_param, $qry_id, $frmname, $btnname, $hfname, $colname, $tblname, $colid, $dbc, $flname)
{
    echo "<script>document.getElementById('".$frmname."').action='tshirt_addAttributes.php?".$qry_str_param."=".$qry_id."'</script>";
    echo "<script>document.getElementById('".$btnname."').value='Update'</script>";
    echo "<script>document.getElementById('".$hfname."').value = '".$qry_id."'</script>";
    $sql_dis = "SELECT $colname from $tblname where $colid='$qry_id'";
    $qry_dis = mysqli_query($dbc, $sql_dis);
    if($qry_dis)
    {
        $result = mysqli_fetch_assoc($qry_dis);
       echo "<script>document.getElementById('".$flname."').value='".$result["$colname"]."'</script>";
    }
}
?>
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
<!--/Imports-->

<!--styles temp-->
<style>
        td
        {
            border:1px solid black;
        }
</style>
<!--/styles temp-->
</head>

<!-- PHP Validations -->
<?php 
//Brand Validation
    if(@$_POST["btnsubbrand"])
    {
        $brand = mysqli_real_escape_string($dbc , trim($_POST["txtbrand"]));  
        if(empty($brand))
        {
            $brand_alert = "<div class='alert alert-danger alert-dismissible'>Enter a Brand <a class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";
        }
        else
        {
            if($_GET)
            {
                $brand_id = $_POST["hfbrand"];
                $sql_up = "UPDATE tbl_brand SET brand='$brand' WHERE brand_id='$brand_id'";
                $qry_up = mysqli_query($dbc, $sql_up);
                if($qry_up)
                {
                $brand_alert = "<div class='alert alert-success alert-dismissible'>Brand Updated<a class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";
                header('refresh:2; url=tshirt_addAttributes.php');
                }
            }
            else
            {
                $sql_check = "SELECT brand FROM tbl_brand WHERE brand='$brand'";
                $sql_qry = mysqli_query($dbc, $sql_check);

                if(mysqli_num_rows($sql_qry) == 0)
                {
                    $sql_add = "INSERT INTO `tbl_brand`(`brand`) VALUES ('$brand')";
                    $qry_add = mysqli_query($dbc, $sql_add);
                    if($qry_add)
                    {
                        $brand_alert = "<div class='alert alert-success alert-dismissible'>Brand Added<a class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";
                        header('refresh:2; url=tshirt_addAttributes.php');
                    }
                    else
                    {
                        $brand_alert = "<div class='alert alert-warning alert-dismissible'>Database Error, Please try again<a class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";
                    }
                }
                else
                {
                    $brand_alert = "<div class='alert alert-warning alert-dismissible'>Brand Already Exists<a class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>";
                    header('refresh:2; url=tdatatbl.php');
                }
            }
        }
    }
//Brand Validation
?>
<!-- /PHP Validations -->

<body>
    <div class="wrapper">
    <!-- Include side nav -->
        <?php require('../includes/admin_sidenav.php') ?>

    <!-- Page Content Holder -->
        <div id="content">
            <?php require('../includes/admin_navbar.php'); ?>

<!--Main Page Title-->
            <div class="row">
                <div class="col-md-6">
                    <h2>Shirt Attributes</h2>
                </div>
            </div>
<!--/Main Page Title-->

<!--Main Attributes Table-->
    <table class="table">
        <tr>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmbrand">
                <input type="hidden" id="hfbrand" name="hfbrand" value="0"/>
                <div class="col-xs-6">
                    <b>Brand</b><br />
                    <span><?php echo @$brand_alert; ?></span>
                    <input type="text" class="form-control" name="txtbrand" id="txtbrand" />
                    <input type="submit" class="btn btn-primary" id="btnsubbrand" name="btnsubbrand" Value="Add"/>
                    <button type="button" id="btnbrand" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modbrand">&#128270;</button> 
                    </div>
                </form>    
                
            </td>
            <td>
                <div class="col-xs-3"></div>
            </td>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmcat">
                <input type="hidden" id="hfcat" name="hfcat" value="0"/>
                    <div class="col-xs-6">
                        <b>Category</b><br />
                        <span><?php echo @$cat_alert; ?></span>
                        <input type="text" class="form-control" name="txtcat" id="txtcat" />
                        <input type="submit" class="btn btn-primary" id="btnsubcat" name="btnsubcat" Value="Add"/>
                        <button type="button" id="btncat" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modcat">&#128270;</button>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmdesign">
                <input type="hidden" id="hfdesign" name="hfdesign" value="0"/>
                <div class="col-xs-6">
                    <b>Design</b><br />
                    <span><?php echo @$design_alert; ?></span>
                    <input type="text" class="form-control" name="txtdesign" id="txtdesign" />
                    <input type="submit" class="btn btn-primary" id="btnaddesign" name="btnaddesign" Value="Add"/>
                    <button type="button" id="btndesign" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#moddesign">&#128270;</button> 
                    </div>
                </form>    
                
            </td>
            <td>
                <div class="col-xs-3"></div>
            </td>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmfab">
                <input type="hidden" id="hffab" name="hffab" value="0"/>
                    <div class="col-xs-6">
                        <b>Fabric</b><br />
                        <span><?php echo @$fabric_alert; ?></span>
                        <input type="text" class="form-control" name="txtfabric" id="txtfabric" />
                        <input type="submit" class="btn btn-primary" id="btnadfab" name="btnadfab" Value="Add"/>
                        <button type="button" id="btnfab" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modfab">&#128270;</button>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmfeat">
                <input type="hidden" id="hffeat" name="hffeat" value="0"/>
                <div class="col-xs-6">
                    <b>Features</b><br />
                    <span><?php echo @$feat_alert; ?></span>
                    <input type="text" class="form-control" name="txtfeat" id="txtfeat" />
                    <input type="submit" class="btn btn-primary" id="btnadfeat" name="btnadfeat" Value="Add"/>
                    <button type="button" id="btnfeat" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modfeat">&#128270;</button> 
                    </div>
                </form>    
                
            </td>
            <td>
                <div class="col-xs-3"></div>
            </td>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmtype">
                <input type="hidden" id="hftype" name="hftype" value="0"/>
                    <div class="col-xs-6">
                        <b>Type</b><br />
                        <span><?php echo @$type_alert; ?></span>
                        <input type="text" class="form-control" name="txttype" id="txttype" />
                        <input type="submit" class="btn btn-primary" id="btnadtype" name="btnadtype" Value="Add"/>
                        <button type="button" id="btntype" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modtype">&#128270;</button>
                    </div>
                </form>
            </td>
        </tr>
    </table>
<!--/Main Attributes Table-->

<!-- Modals -->
    <!-- Brand Modal -->
        <div class="modal fade" id="modbrand" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content datatblcon">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Brands</h4>
                </div>
                <div class="modal-body"> 
                    <table id="tblbrand" class="display table">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                makeDatatbl('brand_id', 'brand', 'tbl_brand', $dbc);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    <!-- /Brand Modal -->
<!-- /Modals -->

<!-- Display Data -->

<?php 
    if($_GET)
    {
        $keys = array_keys($_GET);
        $qry_str_param = $keys[0];
        $qs_qrr = explode("-", $qry_str_param);
    
        if($qs_qrr[1]=="update")
        {
            $qry_id = mysqli_real_escape_string($dbc ,trim($_GET[$keys[0]]));
            switch ($qs_qrr[0]) {
                case 'tbl_brand':
                    displdata($qry_str_param, $qry_id, 'frmbrand', 'btnsubbrand', 'hfbrand', 'brand', 'tbl_brand', 'brand_id', $dbc, 'txtbrand');
                    break;
                
                // case 'tbl_category':
                //     displdata($qry_str_param, $qry_id, 'frmcat', 'btnsubcat', 'hfcat', 'cat_name', 'tbl_category', 'cat_id', $dbc, 'txtcat');
                //     break;
                
                default:
                    # code...
                    break;
            }
        }

        if($qs_qrr[1]=="delete")
        {
            $qry_id = mysqli_real_escape_string($dbc ,trim($_GET[$keys[0]]));
            switch ($qs_qrr[0]) {
                case 'brand':
                    $sql_delete = "DELETE FROM brand WHERE brand_id =".$qry_id;
                    $qry_delete = mysqli_query($dbc, $sql_delete);
                    if($qry_delete)
                    {
                        //echo "<script>document.getElementById('brandspan').innerHTML = '<div class=alert alert-success alert-dismissible'>Brand Deleted<a class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>';</script>";
                        // echo "success";
                        echo "<script>brandmsgmod();</script>";
                    }
                    else
                    {
                        echo "del fail";
                    }
                    break;
                
                // case 'tbl_category':
                //     echo "<script>document.getElementById('btnsubcat').value='Delete'</script>";
                //     break;
                
                default:
                    # code...
                    break;
            }
        }
    }
?>

<!-- /Display Data -->
        </div>
    <!--/Page Content Holder -->
</body>

<!-- Script to initialize datatables -->
    <script>
    $(document).ready(function() 
        {
            $('#tblbrand').DataTable();
        });
    </script>
<!-- Script to initialize datatables -->
</html>