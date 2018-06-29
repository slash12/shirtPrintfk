<?php 
require('../includes/dbconnect.php'); 
require('plugins/image/SimpleImage.php');
//FUNCTIONS
//make of datatables
    function makeDatatbl($col_id, $col, $cold, $tblname, $dbc)
    {
        $sql = "SELECT $col_id, $col, $cold FROM $tblname;";
        $qry = mysqli_query($dbc, $sql);

        while($row = mysqli_fetch_array($qry))
        {
            echo "<tr><td>".$row["$col"]."</td><td>".$row["$cold"]."</td>";
            echo "<td><a class='btn btn-primary' href='otsattr.php?".$tblname."-update=".$row["$col_id"]."'>Update</a> | <a class='btn btn-warning' href='otsattr.php?".$tblname."-delete=".$row["$col_id"]."'>Delete</a></td></tr>";
        }
        mysqli_free_result($qry);
    }
//make of datatables

//to display selected field in the textbox
    function displdata($qry_str_param, $qry_id, $frmname, $btnname, $hfname, $colname, $colname2, $tblname, $colid, $dbc, $flname, $fl2name)
    {
        echo "<script>document.getElementById('".$frmname."').action='otsattr.php?".$qry_str_param."=".$qry_id."'</script>";
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
                                window.location='otsattr.php'
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
                                    window.location='otsattr.php'
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
                        window.location='otsattr.php'
                    }
                }
            });</script>";
        }
        else
        {
            echo "<script>$.confirm({
                title: 'Error',
                content: 'Delete Database Error',
                type: 'orange',
                typeAnimated: true,
                buttons: {
                    TryAgain:{
                        text: 'Try again',
                        btnClass: 'btn-orange',
                        action: function ()
                        {
                            window.location='otsattr.php'
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
    <title>ShirtPrints | Manage Attributes</title>

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
//Color Validation
    if(@$_POST["btnaddcol"])
    {
        upadd($dbc, "txtcol", "txtcold", "Notice", "Color and Color Code(optional) are required", "hfcol", "color", "color_code", "tbl_color", "color_id", "Color Updated", "Color Inserted", "Color Already Exists");
    }
//Color Validation

//Size Validation
    if(@$_POST["btnaddsize"])
    {
        upadd($dbc, "txtsize", "txtdsize", "Notice", "Size and Size Description(optional) are required", "hfsize", "size", "size_desc", "tbl_size", "size_id", "Size Updated", "Size Inserted", "Size Already Exists");
    }
//Size Validation

//Pattern Validation
    if(@$_POST["btnaddpattern"])
    {
        $pattern_id = $_POST["hfpattern"];
        //retrieve pattern name from input box
        $pattern = mysqli_real_escape_string($dbc , trim($_POST["txtpat"])); 
    //Pattern name empty validation
        if(empty($pattern))
        {
            echo "<script>   $.confirm({
                title: 'Notice',
                content: 'Pattern Name and Pattern Image (optional) are required',
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
    //Pattern name empty validation
        elseif(count($_GET)==0)
    //insertion of pattern
        //Pattern Image
        {
            if($_FILES['imgpat']['name'] != "")
            {
        //Pattern Image Validation
                $check_num = 0;
                $target_dir_pat = "../images/tshirt_pattern/";
                $target_file_pat = $target_dir_pat . basename($_FILES["imgpat"]["name"]);
                $imageFileType_pat = strtolower(pathinfo($target_file_pat,PATHINFO_EXTENSION));
        
                //Size Validation(>500 kb denied)
                if ($_FILES["imgpat"]["size"] > 500000 || $_FILES["imgpat"]["error"] == 1)
                {
                    echo "<script>$.confirm({
                    title: 'Error Image Upload',
                    content: 'Image should be less than 500kb',
                    type: 'orange',
                    typeAnimated: true,
                    buttons: {
                        TryAgain:{
                            text: 'Try again',
                            btnClass: 'btn-orange',
                        },
                    }
                    });</script>";
                    $check_num = 1;
                }
                //Image Format Validation
                if($imageFileType_pat != "jpg" && $imageFileType_pat != "png" && $imageFileType_pat != "jpeg")
                {
                echo "<script>   $.confirm({
                    title: 'Error Image Upload',
                    content: 'only JPG, JPEG and PNG Image format are allowed',
                    type: 'orange',
                    typeAnimated: true,
                    buttons: {
                        TryAgain:{
                            text: 'Try again',
                            btnClass: 'btn-orange',
                            },
                        
                    });</script>";
                    $check_num = 1;
                }
        //Pattern Image Validation
    
                if($check_num == 0)
                {
            //Insertion and Resize of Pattern Image
                    $sql_unique = "SELECT * FROM tbl_pattern WHERE pattern = '$pattern'";
                    $qry_unique = mysqli_query($dbc, $sql_unique);

                    if(mysqli_num_rows($qry_unique)==0)
                    {
                        move_uploaded_file($_FILES["imgpat"]["tmp_name"], $target_file_pat);
                        $img_pat = new claviska\SimpleImage($target_file_pat);
                        try 
                        {
                        $img_pat->fromFile($target_file_pat);
                        $pat_path = "../images/tshirt_pattern/".$pattern.".".$imageFileType_pat;
                        unlink($target_file_pat);
                        $img_pat->resize(100, 100)->toFile($pat_path);
                        } 
                        catch(Exception $err) 
                        {
                            echo "<script>   $.confirm({
                                title: 'Error Image Upload Resize',
                                content: 'Error: '".$e->getMessage()."',
                                type: 'orange',
                                typeAnimated: true
                                buttons: {
                                    TryAgain:{
                                        text: 'Try again',
                                        btnClass: 'btn-orange',
                                    },
                                }
                            });</script>";
                        }
                        $sql_pat_two = "INSERT INTO tbl_pattern(pattern, p_img_path) VALUES('$pattern', '$pat_path');";
                        $addpattern_qry = mysqli_query($dbc, $sql_pat_two);
                        if($addpattern_qry)
                        {
                            echo "<script>$.confirm({
                                title: 'Notice',
                                content: 'Pattern Image resize and uploaded',
                                type: 'Green',
                                typeAnimated: true,
                                buttons: {
                                    OK:{
                                        text: 'OK',
                                        btnClass: 'btn-success',
                                        action: function ()
                                        {
                                            window.location='otsattr.php'
                                        }
                                    },
                                }
                            });</script>";
                        }
                    } 
                    else
                    {
                        echo "<script>$.confirm({
                            title: 'Notice',
                            content: 'Pattern Name already exist!',
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
            //Insertion and Resize of Pattern Image
                }
            }
            else
            {
                //Insertion of only pattern
                $sql_unique = "SELECT * FROM tbl_pattern WHERE pattern = '$pattern'";
                $qry_unique = mysqli_query($dbc, $sql_unique);

                if(mysqli_num_rows($qry_unique)==0)
                {
                        $sql_pat_two = "INSERT INTO tbl_pattern(pattern) VALUES('$pattern');";
                        $addpattern_qry = mysqli_query($dbc, $sql_pat_two);
                        if($addpattern_qry)
                        {
                            echo "<script>$.confirm({
                                title: 'Notice',
                                content: 'New Pattern Added',
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                    OK:{
                                        text: 'OK',
                                        btnClass: 'btn-success',
                                        action: function ()
                                        {
                                            window.location='otsattr.php'
                                        }
                                    },
                                }
                            });</script>";
                //Insertion of only pattern
                        }
                        else
                        {
                //Error of only pattern insertion
                        echo "<script>$.confirm({
                            title: 'Database Pattern Insert Error',
                            content: '".mysqli_error($dbc)."',
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                OK:{
                                    text: 'OK',
                                    btnClass: 'btn-success',
                                    action: function ()
                                    {
                                        window.location='otsattr.php'
                                    }
                                },
                            }
                        });</script>";
                //Error of only pattern insertion
                        }
                }
                else
                {
                    echo "<script>$.confirm({
                        title: 'Notice',
                        content: 'Pattern Name already exist!',
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
    //insertion of pattern
        if($_GET)
        {
            if(empty($pattern))
            {
            //Pattern name empty validation
                echo "<script>$.confirm({
                    title: 'Update fails',
                    content: 'Pattern Name and Pattern Image (optional) are required',
                    type: 'orange',
                    typeAnimated: true,
                    buttons: {
                        TryAgain:{
                            text: 'Try again',
                            btnClass: 'btn-orange',
                        },
                    }
                });</script>";
            //Pattern name empty validation
            }
            else
            {
                //Pattern image validation
                if($_FILES['imgpat']['name'] != "")
                {
                //Pattern image validation
                    $check_nums = 0;
                    $target_dir_pat = "../images/tshirt_pattern/";
                    $target_file_pat = $target_dir_pat . basename($_FILES["imgpat"]["name"]);
                    $imageFileType_pat = strtolower(pathinfo($target_file_pat,PATHINFO_EXTENSION));
        
                    //Size Validation(>500 kb denied)
                    if ($_FILES["imgpat"]["size"] > 500000 || $_FILES["imgpat"]["error"] == 1)
                    {
                    echo "<script>   $.confirm({
                            title: 'Error Image Upload',
                            content: 'Image should be less than 500kb',
                            type: 'orange',
                            typeAnimated: true,
                            buttons: {
                                TryAgain:{
                                    text: 'Try again',
                                    btnClass: 'btn-orange',
                                },
                            }
                            });</script>";
                            $check_nums = 1;
                    }
                    //Image Format Validation
                    elseif($imageFileType_pat != "jpg" && $imageFileType_pat != "png" && $imageFileType_pat != "jpeg")
                    {
                        echo "<script>   $.confirm({
                                title: 'Error Image Upload',
                                content: 'only JPG, JPEG and PNG Image format are allowed',
                                type: 'orange',
                                typeAnimated: true,
                                buttons: {
                                    TryAgain:{
                                        text: 'Try again',
                                        btnClass: 'btn-orange',
                                    },
                                }
                        });</script>";
                        $check_nums = 1;
                    }
                //Pattern image validation
                    
                    if($check_nums == 0)
                    //update and Resize of Pattern Image
                    {
                            move_uploaded_file($_FILES["imgpat"]["tmp_name"], $target_file_pat);
                            $img_pat = new claviska\SimpleImage($target_file_pat);
                            try 
                            {
                                $img_pat->fromFile($target_file_pat);
                                $pat_path = "../images/tshirt_pattern/".$pattern.".".$imageFileType_pat;
                                unlink($target_file_pat);
                                $img_pat->resize(100, 100)->toFile($pat_path);
                            } 
                            catch(Exception $err) 
                            {
                                echo "<script>   $.confirm({
                                    title: 'Error Image Upload Resize',
                                    content: 'Error: '".$e->getMessage()."',
                                    type: 'orange',
                                    typeAnimated: true
                                    buttons: {
                                        TryAgain:{
                                            text: 'Try again',
                                            btnClass: 'btn-orange',
                                        },
                                    }
                                });</script>";
                            }
                            
                            $sql_up = "UPDATE tbl_pattern SET pattern='$pattern', p_img_path='$pat_path' WHERE pattern_id='$pattern_id'";
                            $qry_up = mysqli_query($dbc, $sql_up);
                            if($qry_up)
                            {
                                echo "<script>$.confirm({
                                    title: 'Notice',
                                    content: 'Pattern Image resize and updated',
                                    type: 'Green',
                                    typeAnimated: true,
                                    buttons: {
                                        OK:{
                                            text: 'OK',
                                            btnClass: 'btn-success',
                                            action: function ()
                                            {
                                                window.location='otsattr.php'
                                            }
                                        },
                                    }
                                });</script>";
                            }
                    }
                    //update and Resize of Pattern Image
                }
                else
                {
                    
                //update only pattern name
                            $pattern_id = $_POST["hfpattern"];
                            echo "<script>alert('empty file field, only pattern update ".$pattern_id."');</script>";
                            $sql_up = "UPDATE tbl_pattern SET pattern='$pattern' WHERE pattern_id='$pattern_id'";
                            $qry_up = mysqli_query($dbc, $sql_up);
                            if($qry_up)
                            {
                                echo "<script>$.confirm({
                                    title: 'Notice',
                                    content: 'Pattern Name updated',
                                    type: 'Green',
                                    typeAnimated: true,
                                    buttons: {
                                        OK:{
                                            text: 'OK',
                                            btnClass: 'btn-success',
                                            action: function ()
                                            {
                                                window.location='otsattr.php'
                                            }
                                        },
                                    }
                                });</script>";
                            }
                //update only pattern name
                }
            }
        }
    }    

               
        
           

        
    
//Pattern Validation

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
                    <h2>Other Attributes</h2>
                    <hr />
                </div>
            </div>
<!--/Main Page Title-->

<!--Main Content -->
    <!-- Color Form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmcol" class="form-inline">
                <div class="form-group">
                    <input type="hidden" id="hfcol" name="hfcol" value="0"/>
                    <label>Color</label>
                    <input type="text" class="form-control" name="txtcol" id="txtcol" />
                </div>
                <div class="form-group">
                    <label>Color Code</label>
                    <input type="text" class="form-control" id="txtcold" name="txtcold"/>
                </div>
            <input type="submit" Value="Add" class="btn btn-primary" id="btnaddcol" name="btnaddcol">
            <a href="otsattr.php" class="btn btn-info">Reset</a>
            <button type="button" id="btncol" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modcol">&#128270;</button> 
        </form>  
    <!-- /Color Form -->

    <hr/>

    <!-- Size Form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmsize" class="form-inline">
                    <div class="form-group">
                        <input type="hidden" id="hfsize" name="hfsize" value="0"/>
                        <label>Size</label>
                        <input type="text" class="form-control" name="txtsize" id="txtsize" />
                    </div>
                    <div class="form-group">
                        <label>Size Description</label>
                        <input type="text" class="form-control" id="txtdsize" name="txtdsize"/>
                    </div>
                <input type="submit" Value="Add" class="btn btn-primary" id="btnaddsize" name="btnaddsize">
                <a href="otsattr.php" class="btn btn-info">Reset</a>
                <button type="button" id="btnsize" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modsize">&#128270;</button> 
            </form>  
    <!-- /Size Form -->

    <hr/>
    <!-- Pattern Form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="frmpat" class="form-inline" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" id="hfpattern" name="hfpattern" value="0"/>
                        <label>Pattern</label>
                        <input type="text" class="form-control" name="txtpat" id="txtpat" />
                    </div>
                    <div class="form-group">
                        <label>Pattern Image</label>
                        <input type="file" class="form-control" id="imgpat" name="imgpat">
                    </div>
            <input type="submit" Value="Add" class="btn btn-primary" id="btnaddpattern" name="btnaddpattern">
            <a href="otsattr.php" class="btn btn-info">Reset</a>
            <button type="button" id="btnsize" class="btn btn-info btn-lg btnpad" data-toggle="modal" data-target="#modpattern">&#128270;</button> 
        </form>  
    <!-- /Pattern Form -->
<!--/Main Content Table-->

<!--Modals-->
    <!-- Color Modal -->
        <div class="modal fade" id="modcol" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Color</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tblcol" class="display table">
                            <thead>
                                <tr>
                                    <th>Color</th>
                                    <th>Color Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    makeDatatbl('color_id', 'color', 'color_code','tbl_color', $dbc);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Color Modal -->

    <!-- Size Modal -->
        <div class="modal fade" id="modsize" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Size</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tblsize" class="display table">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Size Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    makeDatatbl('size_id', 'size', 'size_desc','tbl_size', $dbc);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Size Modal -->

    <!-- Pattern Modal -->
        <div class="modal fade" id="modpattern" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content datatblcon">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pattern</h4>
                    </div>
                    <div class="modal-body"> 
                        <table id="tblpattern" class="display table">
                            <thead>
                                <tr>
                                    <th>Pattern Img</th>
                                    <th>Pattern</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql = "SELECT pattern_id, pattern, p_img_path FROM tbl_pattern;";
                                    $qry = mysqli_query($dbc, $sql);
                            
                                    while($row = mysqli_fetch_array($qry))
                                    {
                                        echo "<tr><td><img class='imgres' src='".$row["p_img_path"]."'/></td><td>".$row["pattern"]."</td>";
                                        echo "<td><a class='btn btn-primary' href='otsattr.php?tbl_pattern-update=".$row["pattern_id"]."'>Update</a> | <a class='btn btn-warning' href='otsattr.php?tbl_pattern-delete=".$row["pattern_id"]."'>Delete</a></td></tr>";
                                    }
                                    mysqli_free_result($qry);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Pattern Modal -->
<!--/Modals-->

<!--Display Data-->
    <?php 
        if($_GET)
        {
            $keys = array_keys($_GET);
            $qry_str_param = $keys[0];
            $qs_qrr = explode("-", $qry_str_param);
        
            if($qs_qrr[1]=="update")
            {
                $qry_id = mysqli_real_escape_string($dbc ,trim($_GET[$keys[0]]));
                    switch ($qs_qrr[0]) 
                    {
                        case 'tbl_color':
                            displdata($qry_str_param, $qry_id, 'frmcol', 'btnaddcol', 'hfcol', 'color', 'color_code', 'tbl_color', 'color_id', $dbc, 'txtcol', 'txtcold');
                            break;
                        
                        case 'tbl_size':
                            displdata($qry_str_param, $qry_id, 'frmsize', 'btnaddsize', 'hfsize', 'size', 'size_desc', 'tbl_size', 'size_id', $dbc, 'txtsize', 'txtdsize');
                            break;

                        case 'tbl_pattern':
                            echo "<script>document.getElementById('frmpat').action='otsattr.php?".$qry_str_param."=".$qry_id."';</script>";
                            echo "<script>document.getElementById('btnaddpattern').value='Update';</script>";
                            echo "<script>document.getElementById('hfpattern').value = '".$qry_id."';</script>";
                            $sql_dis = "SELECT * from tbl_pattern where pattern_id='$qry_id'";
                            $qry_dis = mysqli_query($dbc, $sql_dis);
                            if($qry_dis)
                            {
                                $result = mysqli_fetch_assoc($qry_dis);
                            echo "<script>document.getElementById('txtpat').value='".$result["pattern"]."'</script>";
                            }
                            break;
                    }
            }
    ?>
<!--/Display Data-->

<!-- Delete Function -->
    <?php
            if($qs_qrr[1]=="delete")
            {
                $qry_id = mysqli_real_escape_string($dbc ,trim($_GET[$keys[0]]));
                switch ($qs_qrr[0]) 
                {
                    case 'tbl_color':
                        deltshirt("tbl_color", "color_id", $qry_id, $dbc, "Color is Deleted");
                        break;
                    
                    case 'tbl_size':
                        deltshirt("tbl_size", "size_id", $qry_id, $dbc, "Size is Deleted");
                        break;
                    
                    case 'tbl_pattern':
                        $sql_pat = "SELECT p_img_path FROM tbl_pattern WHERE pattern_id='$qry_id';";
                        $qry_pat = mysqli_query($dbc, $sql_pat);
                        $res = mysqli_fetch_assoc($qry_pat);
                        if($qry_pat)
                        {
                            unlink($res["p_img_path"]);
                            deltshirt("tbl_pattern", "pattern_id", $qry_id, $dbc, "Pattern is Deleted");
                        }
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
            $('#tblcol, #tblsize, #tblpattern').DataTable(
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