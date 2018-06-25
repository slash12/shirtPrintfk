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
            echo "<td><a class='btn btn-primary' href='tshirt_addAttributes.php?".$tblname."-update=".$row["$col_id"]."'>Update</a> | <a class='btn btn-warning' href='tshirt_addAttributes.php?".$tblname."-delete=".$row["$col_id"]."'>Delete</a></td></tr>";
        }
        mysqli_free_result($qry);
    }
//make of datatables

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
//to display selected field in the textbox

//update and insert of tshirt attributes
    function upadd($dbc, $txtfield, $msgheader, $rqbrand, $hffield, $colname, $tblname, $col_id, $upattr, $inattr, $uniqattr)
    {
        $attribute = mysqli_real_escape_string($dbc , trim($_POST[$txtfield]));  
        if(empty($attribute))
        {
            echo "<script>   $.confirm({
                title: '".$msgheader."',
                content: '".$rqbrand."',
                type: 'orange',
                typeAnimated: true,
                buttons: {
                    TryAgain:{
                        text: 'Try again',
                        btnClass: 'btn-orange',
                    },
                }
            });</script>";
        }
        else
        {
            if($_GET)
            {
                $attr_id = $_POST[$hffield];
                $sql_up = "UPDATE ".$tblname." SET ".$colname."='$attribute' WHERE ".$col_id."='$attr_id'";
                $qry_up = mysqli_query($dbc, $sql_up);
                if($qry_up)
                {
                    echo "<script>   $.confirm({
                        title: '".$msgheader."',
                        content: '".$upattr."',
                        type: 'green',
                        typeAnimated: true,
                        buttons: {
                            OK: function () {
                                window.location='tshirt_addAttributes.php'
                            },
                        }
                    });</script>";
                }
            }
            else
            {
                $sql_check = "SELECT ".$colname." FROM ".$tblname." WHERE ".$colname."='$attribute'";
                $sql_qry = mysqli_query($dbc, $sql_check);

                if(mysqli_num_rows($sql_qry) == 0)
                {
                    $sql_add = "INSERT INTO ".$tblname."(".$colname.") VALUES ('$attribute')";
                    $qry_add = mysqli_query($dbc, $sql_add);
                    if($qry_add)
                    {
                        echo "<script>$.confirm({
                            title: 'Notice',
                            content: '".$inattr."',
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                OK: function () {
                                    window.location='tshirt_addAttributes.php'
                                },
                            }
                        });</script>";
                    }
                    else
                    {
                        echo "<script>$.confirm({
                            title: 'Error',
                            content: 'Database Error',
                            type: 'orange',
                            typeAnimated: true,
                            buttons: {
                                TryAgain:{
                                    text: 'Try again',
                                    btnClass: 'btn-orange',
                                },
                            }
                        });</script>";
                    }
                }
                else
                {
                    echo "<script>$.confirm({
                            title: 'Notice',
                            content: '".$uniqattr."',
                            type: 'orange',
                            typeAnimated: true,
                            buttons: {
                                TryAgain:{
                                    text: 'Try again',
                                    btnClass: 'btn-orange',
                                },
                            }
                        });</script>";
                }
                
            }
        }
    }
//update and insert of tshirt attributes

//delete tshirt attributes
    function deltshirt($tblname, $col_id, $qry_id, $dbc, $delmsg)
    {
        $sql_delete = "DELETE FROM ".$tblname." WHERE ".$col_id." =".$qry_id;
        $qry_delete = mysqli_query($dbc, $sql_delete);
        if($qry_delete)
        {
            echo "<script>$.confirm({
                title: 'Notice',
                content: '".$delmsg."',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    close: function () {
                        window.location='tshirt_addAttributes.php'
                    }
                }
            });</script>";
        }
        else
        {
            echo "<script>$.confirm({
                title: 'Error',
                content: 'Database Error',
                type: 'orange',
                typeAnimated: true,
                buttons: {
                    TryAgain:{
                        text: 'Try again',
                        btnClass: 'btn-orange',
                        action: funtion ()
                        {
                            window.location='tshirt_addAttributes.php'
                        }
                    },
                }
            });</script>";
        }
    }
//delete t-shirt attributes
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
    <link rel="stylesheet" href="../css/jquery-confirm.min.css">

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap337.min.js"></script>
    <script src="../js/bootstrap337.min.js"></script>
    <script src="../js/jquery-confirm.min.js"></script>
    <script src="../js/popper.js"></script>
<!--/Imports-->


</head>

<!-- PHP Validations -->
<?php 
//Brand Validation
    if(@$_POST["btnsubbrand"])
    {
        upadd($dbc, "txtbrand", "Notice", "Brand is required", "hfbrand", "brand", "tbl_brand", "brand_id", "Brand Updated", "Brand Inserted", "Brand Already Exists");
    }
//Brand Validation

//Category Validation
    if(@$_POST["btnsubcat"])
    {
        upadd($dbc, "txtcat", "Notice", "Category is required", "hfcat", "cat_name", "tbl_category", "cat_id", "Category Updated", "Category Inserted", "Category Already Exists");
    }
//Category Validation

//Design Validation
    if(@$_POST["btnaddesign"])
    {
        upadd($dbc, "txtdesign", "Notice", "Design is required", "hfdesign", "design", "tbl_design", "design_id", "Design Updated", "Design Inserted", "Design Already Exists");
    }
//Design Validation

//Fabric Validation
    if(@$_POST["btnadfab"])
    {
        upadd($dbc, "txtfabric", "Notice", "Fabric is required", "hffab", "fabric", "tbl_fabric", "fabric_id", "Fabric Updated", "Fabric Inserted", "Fabric Already Exists");
    }
//Fabric Validation

//Feature Validation
    if(@$_POST["btnadfeat"])
    {
        upadd($dbc, "txtfeat", "Notice", "Feature is required", "hffeat", "feature", "tbl_feature", "feature_id", "Feature Updated", "Feature Inserted", "Feature Already Exists");
    }
//Feature Validation

//Type Validation
    if(@$_POST["btnadtype"])
    {
        upadd($dbc, "txttype", "Notice", "Type is required", "hftype", "type", "tbl_type", "type_id", "Type Updated", "Type Inserted", "Type Already Exists");
    }
//Type Validation
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
        <!-- Brand form -->
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmbrand">
                <input type="hidden" id="hfbrand" name="hfbrand" value="0"/>
                <div class="col-xs-6">
                    <b>Brand</b><br />
                    <!-- <span><?php //echo @$brand_alert; ?></span> -->
                    <input type="text" class="form-control" name="txtbrand" id="txtbrand" />
                    <input type="submit" class="btn btn-primary" id="btnsubbrand" name="btnsubbrand" Value="Add"/>
                    <button type="button" id="btnbrand" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modbrand">&#128270;</button> 
                    </div>
                </form>    
            </td>
        <!-- /Brand form -->
            <td>
                <div class="col-xs-3"></div>
            </td>
        <!-- Category form -->
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
        <!-- /Category form -->
        </tr>
        <tr>
        <!-- Design Form -->
            <td>
                <form id="frmdesign" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmdesign">
                <input type="hidden" id="hfdesign" name="hfdesign" value="0"/>
                <div class="col-xs-6">
                    <b>Design</b><br />
                    <span><?php echo @$design_alert; ?></span>
                    <input type="text" class="form-control" name="txtdesign" id="txtdesign" />
                    <input type="submit" class="btn btn-primary" id="btnaddesign" name="btnaddesign" Value="Add"/>
                    <button type="button" id="btndesign" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#moddesign">&#128270;</button> 
                    </div>
                </form>    
        <!-- /Design Form -->
            </td>
            <td>
                <div class="col-xs-3"></div>
            </td>
        <!-- Fabric Form -->
            <td>
                <form id="frmfab" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmfab">
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
        <!-- /Fabric Form -->
        </tr>
        <tr>
        <!-- Features Form -->
            <td>
                <form id="frmfeat" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmfeat">
                <input type="hidden" id="hffeat" name="hffeat" value="0"/>
                <div class="col-xs-6">
                    <b>Features</b><br />
                    <span><?php echo @$feat_alert; ?></span>
                    <input type="text" class="form-control" name="txtfeat" id="txtfeat" />
                    <input type="submit" class="btn btn-primary" id="btnadfeat" name="btnadfeat" Value="Add"/>
                    <button type="button" id="btnfeat" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modfeat">&#128270;</button> 
                    </div>
                </form>    
        <!-- /Features Form -->
            </td>
            <td>
                <div class="col-xs-3"></div>
            </td>
        <!-- Type Form -->
            <td>
                <form id="frmtype" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmtype">
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
        <!-- /Type Form -->
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

    <!-- Category Modal -->
        <div class="modal fade" id="modcat" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Category</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tblcat" class="display table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    makeDatatbl('cat_id', 'cat_name', 'tbl_category', $dbc);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Category Modal -->

    <!-- Design Modal -->
        <div class="modal fade" id="moddesign" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Design</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tbldesign" class="display table">
                            <thead>
                                <tr>
                                    <th>Design</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    makeDatatbl('design_id', 'design', 'tbl_design', $dbc);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Design Modal -->

    <!-- Fabric Modal -->
        <div class="modal fade" id="modfab" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Fabric</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tblfab" class="display table">
                            <thead>
                                <tr>
                                    <th>Fabric</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    makeDatatbl('fabric_id', 'fabric', 'tbl_fabric', $dbc);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Fabric Modal -->

    <!-- Features Modal -->
        <div class="modal fade" id="modfeat" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Features</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tblfeat" class="display table">
                            <thead>
                                <tr>
                                    <th>Feature</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    makeDatatbl('feature_id', 'feature', 'tbl_feature', $dbc);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Features Modal -->

    <!-- Type Modal -->
        <div class="modal fade" id="modtype" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Types</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tbltype" class="display table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    makeDatatbl('type_id', 'type', 'tbl_type', $dbc);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Features Modal -->

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
                    
                    case 'tbl_category':
                        displdata($qry_str_param, $qry_id, 'frmcat', 'btnsubcat', 'hfcat', 'cat_name', 'tbl_category', 'cat_id', $dbc, 'txtcat');
                        break;
                    
                    case 'tbl_design':
                        displdata($qry_str_param, $qry_id, 'frmdesign', 'btnaddesign', 'hfdesign', 'design', 'tbl_design', 'design_id', $dbc, 'txtdesign');
                        break;

                    case 'tbl_fabric':
                        displdata($qry_str_param, $qry_id, 'frmfab', 'btnadfab', 'hffab', 'fabric', 'tbl_fabric', 'fabric_id', $dbc, 'txtfabric');
                        break;
                    
                    case 'tbl_feature':
                        displdata($qry_str_param, $qry_id, 'frmfeat', 'btnadfeat', 'hffeat', 'feature', 'tbl_feature', 'feature_id', $dbc, 'txtfeat');
                        break;

                    case 'tbl_type':
                        displdata($qry_str_param, $qry_id, 'frmtype', 'btnadtype', 'hftype', 'type', 'tbl_type', 'type_id', $dbc, 'txttype');
                        break;
            }
        }
?>
<!-- /Display Data -->

<!-- Delete Function -->
<?php
        if($qs_qrr[1]=="delete")
        {
            $qry_id = mysqli_real_escape_string($dbc ,trim($_GET[$keys[0]]));
            switch ($qs_qrr[0]) {
                case 'tbl_brand':
                    deltshirt("tbl_brand", "brand_id", $qry_id, $dbc, "Brand is Deleted");
                    break;
                
                case 'tbl_category':
                    deltshirt("tbl_category", "cat_id", $qry_id, $dbc, "Category is Deleted");
                    break;
                
                case 'tbl_design':
                    deltshirt("tbl_design", "design_id", $qry_id, $dbc, "Design is Deleted");
                    break;

                case 'tbl_fabric':
                    deltshirt("tbl_fabric", "fabric_id", $qry_id, $dbc, "Fabric is Deleted");
                    break;

                case 'tbl_feature':
                    deltshirt("tbl_feature", "feature_id", $qry_id, $dbc, "Feature is Deleted");
                    break;
                
                case 'tbl_type':
                    deltshirt("tbl_type", "type_id", $qry_id, $dbc, "Type is Deleted");
                    break;
            }
        }
    }
?>
<!-- /Delete Function -->
        </div>
    <!--/Page Content Holder -->
</body>


<script>
//Script to initialize datatables 
    $(document).ready(function() 
        {
            $('#tblbrand, #tblcat, #tbldesign, #tblfab, #tblfeat, #tbltype').DataTable(
            {
                "pageLength": 5
            });
        });
// Script to initialize datatables

//on delete, this tigger confirmation box
    $('.btn-warning').on('click', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        $.confirm({
            title: 'Confirmation Message',
            content: 'Are you Sure?',
            type: 'red',
            typeAnimated: true,
            buttons: 
            {
                Yes: function () 
                {
                    window.location=href
                },
                No: function () 
                {
                    backgroundDismiss: true
                }
            }
        });
    });
//on delete, this tigger confirmation box
</script>

</html>