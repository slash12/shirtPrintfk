<?php 
require('../includes/dbconnect.php'); 
//FUNCTIONS
//make of datatables
    function makeDatatbl($col_id, $col, $cold, $tblname, $dbc)
    {
        $sql = "SELECT $col_id, $col, $cold FROM $tblname;";
        $qry = mysqli_query($dbc, $sql);

        while($row = mysqli_fetch_array($qry))
        {
            echo "<tr><td>".$row["$col"]."</td><td>".$row["$cold"]."</td>";
            echo "<td><a class='btn btn-primary' href='crudcountry.php?".$tblname."-update=".$row["$col_id"]."'>Update</a> | <a class='btn btn-warning' href='crudcountry.php?".$tblname."-delete=".$row["$col_id"]."'>Delete</a></td></tr>";
        }
        mysqli_free_result($qry);
    }
//make of datatables

//update and insert of tshirt attributes
    function upadd($dbc, $txtfield, $txtfield2, $msgheader, $rqbrand, $hffield, $colname, $colname2, $tblname, $col_id, $upattr, $inattr, $uniqattr)
    {
        $attribute = mysqli_real_escape_string($dbc , trim($_POST[$txtfield]));
        $attribute2 = mysqli_real_escape_string($dbc , trim($_POST[$txtfield2]));  
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
                $sql_up = "UPDATE ".$tblname." SET ".$colname."='$attribute', ".$colname2."='$attribute2' WHERE ".$col_id."='$attr_id'";
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
                                window.location='crudcountry.php'
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
                    $sql_add = "INSERT INTO ".$tblname."(".$colname.", ".$colname2.") VALUES ('$attribute', '$attribute2')";
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
                                    window.location='crudcountry.php'
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

//to display selected field in the textbox
    function displdata($qry_str_param, $qry_id, $frmname, $btnname, $hfname, $colname, $colname2, $tblname, $colid, $dbc, $flname, $fl2name)
    {
        echo "<script>document.getElementById('".$frmname."').action='crudcountry.php?".$qry_str_param."=".$qry_id."'</script>";
        echo "<script>document.getElementById('".$btnname."').value='Update'</script>";
        echo "<script>document.getElementById('".$hfname."').value = '".$qry_id."'</script>";
        $sql_dis = "SELECT $colname, $colname2 from $tblname where $colid='$qry_id'";
        $qry_dis = mysqli_query($dbc, $sql_dis);
        if($qry_dis)
        {
            $result = mysqli_fetch_assoc($qry_dis);
        echo "<script>document.getElementById('".$flname."').value='".$result["$colname"]."'</script>";
        echo "<script>document.getElementById('".$fl2name."').value='".$result["$colname2"]."'</script>";
        }
    }
//to display selected field in the textbox

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
                            window.location='crudcountry.php'
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
                                window.location='crudcountry.php'
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
    <title>ShirtPrints | Manage Country</title>

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
    <script src="../js/main_admin.js"></script>
<!--/Imports-->


</head>

<!-- PHP Validations -->
<?php 
//Country Validation
    if(@$_POST["btnaddcon"])
    {
        upadd($dbc, "txtccod", "txtcon", "Notice", "Country Name and Country Code are required", "hfcon", "country_code", "country_name", "country", "country_id", "Country Updated", "Country Inserted", "Country Already Exists");
    }
//Country Validation
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
                    <h2>Country List</h2>
                </div>
            </div>
<!--/Main Page Title-->

<!--Main Attributes Table-->
    <table class="table">
        <tr>
        <!-- Country form -->
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmcon" class="form-inline">
                    <div class="form-group">
                        <input type="hidden" id="hfcon" name="hfcon" value="0"/>
                        <label>Country Code</label>
                        <input type="text" class="form-control" name="txtccod" id="txtccod" />
                    </div>
                    <div class="form-group">
                        <label>Country Name</label>
                        <input type="text" class="form-control" id="txtcon" name="txtcon"/>
                    </div>
                    <input type="submit" Value="Add" class="btn btn-primary" id="btnaddcon" name="btnaddcon">
                    <a href="crudcountry.php" class="btn btn-info">Reset</a>
                </form>  
            </td>
        <!-- /Country form -->
        </tr>
    </table>
<!--/Main Attributes Table-->

<!--Country Datatable-->
    <table id="tblcon" class="display table">
        <thead>
            <tr>
                <th>Country Code</th>
                <th>Country</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                makeDatatbl('country_id', 'country_code', 'country_name','country', $dbc);
            ?>
        </tbody>
    </table>
<!--/Country Datatable-->



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
                    case 'country':
                    displdata($qry_str_param, $qry_id, 'frmcon', 'btnaddcon', 'hfcon', 'country_code', 'country_name', 'country', 'country_id', $dbc, 'txtccod', 'txtcon');
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
                    case 'country':
                        deltshirt("country", "country_id", $qry_id, $dbc, "Country is Deleted");
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
            $('#tblcon').DataTable(
            {
                "pageLength": 4
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