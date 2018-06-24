<?php require('../includes/dbconnect.php'); 
require('plugins/image/SimpleImage.php');
error_reporting(E_ALL & ~E_WARNING);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ShirtPrints | Manage T-Shirt</title>
<!--Imports-->
        <link rel="stylesheet" href="../css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap337.min.css">
        <link rel="stylesheet" href="../css/bootstrap-select.min.css">
        <link rel="stylesheet" href="../css/file-upload-with-preview.css">
        <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/jquery.form.js"></script>
        <script src="../js/popper-select.js"></script>
        <script src="../js/bootstrap337.min.js"></script>
        <script src="../js/bootstrap-select.min.js"></script>
        <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="../js/main_admin.js"></script>
<!--/Imports-->
    </head>
<!--functions-->
    <?php
    //save state + update state render functions
    function savStatetxt($txtname, $upid, $upval)
    {
        if(isset($txtname))
        {
        echo $txtname;
        }
        elseif(isset($upid))
        {
        echo $upval;
        }
    }

    function savStatemul($postmul, $dbval, $upid, $sqlarr)
    {
        if(isset($postmul))
        {
        foreach(@$postmul as $col)
        {
            if($col==$dbval)
            {
            echo "selected";
            }
        }
        } 
        if(isset($upid))
        {
        foreach ($sqlarr as $col_key => $col_av)
        {
            if($col_av==$dbval)
            {
            echo "selected";
            }
        }
        }
    }

    function savStatesin($slt, $sqlid, $upid, $acid)
    {
        if(@$slt==$sqlid)
        {
        echo 'selected';
        } 
        elseif(isset($upid))
        {
        if($sqlid == $acid)
        {
            echo 'selected';
        }
        }
    }

    //update functions
    function updateasso($tablename, $shirt_id, $sltcc, $columnname, $dbc)
    {
        $del_qry = mysqli_query($dbc, "DELETE FROM $tablename WHERE tshirt_id=".$shirt_id);
        if(del_qry)
        {
        foreach ($sltcc as $value)
        {
            $res_up_ = mysqli_query($dbc, "INSERT INTO $tablename(tshirt_id, $columnname) VALUES($shirt_id, '$value');");
        }
        }
        if($res_up_)
        {
        mysqli_commit($dbc);
        }
        else{
        mysqli_rollback($dbc);
        echo mysqli_error($dbc);
        }
    }
    ?>
<!--/functions-->

<!--Update T-Shirt function-->
    <?php
    if(isset($_GET['uptshirt']))
    {
      
    //Retrieve T-Shirt id,brand,category,design,type,size
      $shirt_id_up = $_GET['uptshirt'];
      //For form submit action attr
      $form_apath = "?uptshirt=".$shirt_id_up;
      $tshirt_sel_sql = "SELECT * FROM tbl_tshirt WHERE tshirt_id =".$shirt_id_up;
      $tshirt_sel_qry = mysqli_query($dbc, $tshirt_sel_sql);
      $res_sel = mysqli_fetch_assoc($tshirt_sel_qry);
      if(tshirt_sel_qry)
      {
        $shirtid_av = $res_sel['tshirt_id'];
        $shirtprice_av = $res_sel['price'];
        $shirtqty_av = $res_sel['quantity'];
        $shirtbrand_av = $res_sel['brand_id'];
        $shirtcat_av = $res_sel['category_id'];
        $shirtdesign_av = $res_sel['design_id'];
        $shirttype_av = $res_sel['type_id'];
        $shirtsize_av = $res_sel['size_id'];
        $shirtimgf_av = $res_sel['img_front'];
        $shirtimgb_av = $res_sel['img_back'];
      }
    //Retrieve T-Shirt id,brand,category,design,type,size//

    //Retrieve T-Shirt Color
      $tshirt_color_sql = "SELECT * FROM tbl_tshirt_color WHERE tshirt_id =".$shirt_id_up;  
      $tshirt_color_qry = mysqli_query($dbc, $tshirt_color_sql);
      if(tshirt_color_qry)
      {
        $col_arry = array();
        while($row_col = mysqli_fetch_array($tshirt_color_qry))
        {
          $col_arry[] = $row_col['color_id'];
        }
      }
    //Retrieve T-Shirt Color//

    //Retrieve T-Shirt Features
      $tshirt_features_sql = "SELECT * FROM tbl_tshirt_features WHERE tshirt_id =".$shirt_id_up;  
      $tshirt_features_qry = mysqli_query($dbc, $tshirt_features_sql);
      if(tshirt_features_qry)
      {
        $features_arry = array();
        while($row_feat = mysqli_fetch_array($tshirt_features_qry))
        {
          $feat_arry[] = $row_feat['feature_id'];
        }
      }
    //Retrieve T-Shirt Features//
    
    //Retrieve T-Shirt Fabric
      $tshirt_fabric_sql = "SELECT * FROM tbl_tshirt_fabric WHERE tshirt_id =".$shirt_id_up;  
      $tshirt_fabric_qry = mysqli_query($dbc, $tshirt_fabric_sql);
      if(tshirt_fabric_qry)
      {
        $fabric_arry = array();
        while($row_fab = mysqli_fetch_array($tshirt_fabric_qry))
        {
          $fabric_arry[] = $row_fab['fabric_id'];
        }
      }
    //Retrieve T-Shirt Fabric//
    
    //Retrieve T-Shirt Pattern
      $tshirt_pattern_sql = "SELECT * FROM tbl_tshirt_pattern WHERE tshirt_id =".$shirt_id_up;  
      $tshirt_pattern_qry = mysqli_query($dbc, $tshirt_pattern_sql);
      if(tshirt_pattern_qry)
      {
        $patter_arry = array();
        while($row_pat = mysqli_fetch_array($tshirt_pattern_qry))
        {
          $patter_arry[] = $row_pat['pattern_id'];
        }
      }
    //Retrieve T-Shirt Pattern//
    }
  ?>
<!--/Update T-Shirt function-->

<!-- Form Validation PHP-->
    <?php
        if(isset($_POST['btnsubas']))
        {
          $arr_err = array();

          //Brand Validation
          $brand_cc = $_POST['sltbrand'];
          if($brand_cc == "0")
          {
            $arr_err[] = "Please choose a brandname";
            $brand_err = "Please choose a brandname";
          }
          else
          {
            $brand = mysqli_real_escape_string($dbc, $brand_cc);
          }

          // Category Validation
          $cat_cc = $_POST['sltcat'];
          if($cat_cc == "0")
          {
            $arr_err[] = "Please choose a category";
            $cat_err = "Please choose a category";
          }
          else
          {
            $category = mysqli_real_escape_string($dbc, $cat_cc);
          }

          // Design Validation
          $design_cc = $_POST['sltdesign'];
          if($design_cc == "0")
          {
            $arr_err[] = "Please choose a design";
            $design_err = "Please choose a design";
          }
          else
          {
            $design = mysqli_real_escape_string($dbc, $design_cc);
          }

          // Type Validation
          $type_cc = $_POST['slttype'];
          if($type_cc == "0")
          {
            $arr_err[] = "Please choose a type";
            $type_err = "Please choose a type";
          }
          else
          {
            $type = mysqli_real_escape_string($dbc, $type_cc);
          }

          if ($_FILES['uplfimg']['error'] == 0)
          {
            //Image Front Validation
            $uploadfile_imgf=$_FILES["uplfimg"]["tmp_name"];
            $folder_imgf="../images/tshirt/";
            @$target_file_imgf = $folder_imgf.basename($_FILES["uplfimg"]["name"]);
            $imageFileType_imgf = pathinfo($target_file_imgf, PATHINFO_EXTENSION);

            //Size Validation(>500 kb denied)
           if ($_FILES["uplfimg"]["size"] > 500000)
            {
              $img_f_err = "Sorry, Image Front is too large.";
              $arr_err[] = "Sorry, Image Front is too large.";
              echo "<script> $(document).ready(function(){
                $('#imgfval').modal({show: true});
                  }); </script>";
            }

            //Image front format check
            if($imageFileType_imgf != "jpg" && $imageFileType_imgf != "png" && $imageFileType_imgf != "jpeg")
            {
              $img_f_err = "Sorry, only JPG, JPEG and PNG front image are allowed.";
              $arr_err[] = "Sorry, only JPG, JPEG and PNG front image are allowed.";
              echo "<script> $(document).ready(function(){
                $('#imgfval').modal({show: true});
                  }); </script>";
            }
          }
          else
          {
            $img_f_err = "Image Front Upload Error";
            if(empty($_GET['uptshirt']))
            {
              $arr_err[] = "Image Front Upload Error";
              echo "<script> $(document).ready(function(){
                $('#imgfval').modal({show: true});
                  }); </script>";
            }
          }
          
          if ($_FILES['uplbimg']['error']== 0)
          {
            //Image Back Validation
            $uploadfile_imgb=$_FILES["uplbimg"]["tmp_name"];
            $folder_imgb="../images/tshirt/";
            @$target_file_imgb = $folder_imgb.basename($_FILES["uplbimg"]["name"]);
            $imageFileType_imgb = pathinfo($target_file_imgb, PATHINFO_EXTENSION);

            
              //Size Validation(>500 kb denied)
              if ($_FILES["uplbimg"]["size"] > 500000)
              {
                $img_b_err = "Sorry, your image back is too large.";
                $arr_err[] = "Sorry, your image back is too large.";
                echo "<script> $(document).ready(function(){
                  $('#imgbval').modal({show: true});
                    }); </script>";
              }

              //image back format check
              if($imageFileType_imgb != "jpg" && $imageFileType_imgb != "png" && $imageFileType_imgb != "jpeg")
              {
                $img_b_err = "Sorry, only JPG, JPEG and PNG back image are allowed.";
                $arr_err[] = "Sorry, only JPG, JPEG and PNG back image are allowed.";
                echo "<script> $(document).ready(function(){
                  $('#imgbval').modal({show: true});
                    }); </script>";
              } 
             
          }
          else
          {
            $img_b_err = "Image Back Upload Error";
            if(empty($_GET['uptshirt']))
            {
              $arr_err[] = "Image Back Upload Error";
              echo "<script> $(document).ready(function(){
                $('#imgbval').modal({show: true});
                  }); </script>";
            }
          }


          // Price Validation
          $price_cc = trim($_POST['txtprice']);
          if(empty($price_cc))
          {
            $arr_err[] = "Please enter a Price";
            $price_err = "Please enter a Price";
          }
          elseif(!preg_match("/[0-9]+/", $price_cc))
          {
            $arr_err[] = "Please enter an appropriate value";
            $price_err = "Please enter an appropriate value";
          }
          else
          {
            $price = mysqli_real_escape_string($dbc, $price_cc);
          }

          // Size Validation
          $size_cc = $_POST['sltsize'];
          if($size_cc == "0")
          {
            $arr_err[] = "Please choose a size";
            $size_err = "Please choose a size";
          }
          else
          {
            $size = mysqli_real_escape_string($dbc, $size_cc);
          }

          // Quantity Validation
          $qty_cc = trim($_POST['txtqty']);
          if(empty($qty_cc))
          {
            $arr_err[] = "Please enter a quantity value (> 0)";
            $qty_err = "Please enter a quantity value (> 0)";
          }
          elseif(!preg_match("/[1-9]+/", $qty_cc))
          {
            $arr_err[] = "Please enter an appropriate quantity value";
            $qty_err = "Please enter an appropriate quantity value";
          }
          else
          {
            $qty = mysqli_real_escape_string($dbc, $qty_cc);
          }

          @$color_cc = $_POST["ddcolor"];
            if(empty($color_cc))
              {
                $color_err = "Please select a color";
              }

            @$features_cc = $_POST['sltfeature'];
            if(empty($features_cc))
              {
                $features_err = "Please select a feature";
              }

            $fabric_cc = @$_POST['sltfabric'];
            if(empty($fabric_cc))
              {
                $fabric_err = "Please select a fabric";
              }

            $pattern_cc = @$_POST['sltpat'];
            if(empty($pattern_cc))
            {
              $pattern_err = "Please enter a pattern";
            }

          if(empty($arr_err))
          {
          
            mysqli_autocommit($dbc,FALSE);

  //Update Tshirt
              if(isset($_GET['uptshirt']))
              {
                //update tshirt details from tbl_shirt
                $sql_update_tshirt = "UPDATE tbl_tshirt SET brand_id = '$brand', category_id='$category', design_id='$design', type_id='$type', price='$price', size_id='$size', quantity='$qty' ";

                //check if imgf is changed
                if(isset($target_file_imgf))
                {
                  $sql_update_tshirt .= " ,img_front='$target_file_imgf'";
                }

                //check if imgb is changed
                if(isset($target_file_imgb))
                {
                  unlink($shirtimgb_av);
                  $sql_update_tshirt .= " ,img_back='$target_file_imgb'";
                }

                //Run query update
                $sql_update_tshirt .= " WHERE tshirt_id=".$shirt_id_up;
                $update_tshirt_qry = mysqli_query($dbc, $sql_update_tshirt);
                if($update_tshirt_qry)
                {
                  unlink($shirtimgf_av);
                  //Update tshirt colors 
                    updateasso("tbl_tshirt_color", $shirt_id_up, $color_cc, "color_id", $dbc);
                  //Update tshirt colors//
                    
                  //Update tshirt features 
                    updateasso("tbl_tshirt_features", $shirt_id_up, $features_cc, "feature_id", $dbc);
                  //Update tshirt features//
                  
                  //Update tshirt fabric 
                  updateasso("tbl_tshirt_fabric", $shirt_id_up, $fabric_cc, "fabric_id", $dbc);
                  //Update tshirt colors//

                  //Update tshirt pattern 
                  updateasso("tbl_tshirt_pattern", $shirt_id_up, $pattern_cc, "pattern_id", $dbc);
                  //Update tshirt pattern//

                  

                  //Image font move to img location + resize
                  if(isset($target_file_imgf) && $update_tshirt_qry)
                  {
                    move_uploaded_file($_FILES["uplfimg"]["tmp_name"], $target_file_imgf);

                    $imgupf = new claviska\SimpleImage($target_file_imgf);
                    
                  try {
                    $imgupf->fromFile($target_file_imgf);
                    $imgupf_path = trim("../images/tshirt/uptshirtimgf".uniqid().".".$imageFileType_imgf);
                    unlink($target_file_imgf);
                    $imgupf->resize(680, 680)->toFile($imgupf_path);
                    
                    } catch(Exception $err) {
                    echo "<script>alert('Error: '" .$err->getMessage()."');</script>";
                    }

                    $imgf_pUp = mysqli_query($dbc, "UPDATE tbl_tshirt SET img_front = '$imgupf_path' WHERE tshirt_id=$shirt_id_up");
                  }

                  //Image back move to img location + back
                  if(isset($target_file_imgb) && $update_tshirt_qry)
                  {
                    move_uploaded_file($_FILES["uplbimg"]["tmp_name"], $target_file_imgb);

                    $imgupb = new claviska\SimpleImage($target_file_imgb);
                  try {
                    $imgupb->fromFile($target_file_imgb);
                    $imgupb_path = trim("../images/tshirt/uptshirtimgb".uniqid().".".$imageFileType_imgb);
                    unlink($target_file_imgb);
                    $imgupb->resize(680, 680)->toFile($imgupb_path);
                    
                    } catch(Exception $err) {
                    echo "<script>alert('Error: '" .$err->getMessage()."');</script>";
                    }

                    $imgb_pUp = mysqli_query($dbc, "UPDATE tbl_tshirt SET img_back = '$imgupb_path' WHERE tshirt_id=$shirt_id_up");
                  }
                  
                  echo "<script>alert('done');</script>";
                  mysqli_commit($dbc);
                  echo "<script>window.location.href='manageTshirt.php';</script>";
                }
                else
                {
                  echo "fail";
                  echo mysqli_error($dbc);
                }
              }
  //Update Tshirt//
              else
              {
  //Insert new Tshirt
              $insert_qry= "INSERT INTO `tbl_tshirt` (`brand_id`, `category_id`, `design_id`, `type_id`, `img_front`, `img_back`, `price`, `size_id`, `quantity`) VALUES ('$brand', '$category', '$design', '$type', '$target_file_imgf', '$target_file_imgb', '$price', '$size', '$qty');";
              $insert_qry_exe = mysqli_query($dbc, $insert_qry);

              if($insert_qry_exe)
              {
                //take the last t-shirt generated id
                $shirt_id = mysqli_insert_id($dbc);
              
                if(isset($color_cc))
                {
                  foreach ($color_cc as $color)
                  {
                    $res_color = mysqli_query($dbc, "INSERT INTO tbl_tshirt_color(tshirt_id, color_id) VALUES('$shirt_id', '$color');");
                  }
                }
                else
                {
                  mysqli_rollback($dbc);
                }

                //Features Validation + insert to features associative
                if(isset($features_cc))
                {
                  foreach ($features_cc as $feature)
                  {
                    $res_feature = mysqli_query($dbc, "INSERT INTO tbl_tshirt_features(tshirt_id, feature_id) VALUES('$shirt_id', '$feature');");
                  }
                }
                else
                {
                  mysqli_rollback($dbc);
                }

                // Fabric Validation + insert to fabric associative
                if(isset($fabric_cc))
                {
                  foreach ($fabric_cc as $fabric)
                  {
                    $res_fabric = mysqli_query($dbc, "INSERT INTO tbl_tshirt_fabric(tshirt_id, fabric_id) VALUES('$shirt_id', '$fabric');");
                  }
                }
                else
                {
                  mysqli_rollback($dbc);
                }

              // Pattern Validation + insert to features associative
              if(isset($pattern_cc))
              {
                foreach ($pattern_cc as $pattern)
                {
                  $res_pattern = mysqli_query($dbc, "INSERT INTO tbl_tshirt_pattern(tshirt_id, pattern_id) VALUES('$shirt_id', '$pattern');");
                }

              }
              else
              {
                //$pattern_err = "Please enter a pattern";
                mysqli_rollback($dbc);
              }           

              //pattern associative insert check
                if($res_color && $res_feature && $res_fabric && $res_pattern)
                {
                  if ($_FILES['uplbimg']['error']== 0)
                  {
                    move_uploaded_file($_FILES["uplfimg"]["tmp_name"], $target_file_imgf);
                  }
                  if ($_FILES['uplbimg']['error']== 0)
                  {
                    move_uploaded_file($_FILES["uplbimg"]["tmp_name"], $target_file_imgb);
                  }
                  
                  

                  $imgf = new claviska\SimpleImage($target_file_imgf);
                  try {
                    $imgf->fromFile($target_file_imgf);
                    $imgf_path = "../images/tshirt/tshirtimgfin".uniqid().".".$imageFileType_imgf;
                    unlink($target_file_imgf);
                    $imgf->resize(680, 680)->toFile($imgf_path);
                    
                    } catch(Exception $err) {
                    echo "<script>alert('Error: '" .$err->getMessage()."');</script>";
                    }
                  
                    $imgb = new claviska\SimpleImage($target_file_imgb);
                    try {
                      $imgb->fromFile($target_file_imgb);
                      $imgb_path = "../images/tshirt/tshirtimgbin".uniqid().".".$imageFileType_imgb;
                      unlink($target_file_imgb);
                      $imgb->resize(680, 680)->toFile($imgb_path);
                      
                      } catch(Exception $err) {
                      echo "<script>alert('Error: '" .$err->getMessage()."');</script>";
                      }
                  
                    $img_update_sql = "UPDATE tbl_tshirt SET img_front='$imgf_path', img_back='$imgb_path' WHERE tshirt_id = '$shirt_id'";
                    $img_update_qry = mysqli_query($dbc, $img_update_sql);
                    
                      if(img_update_qry)
                      {
                        echo "<script> $(document).ready(function(){
                          $('#addshirtsuc').modal({show: true});
                            }); </script>";
                        mysqli_commit($dbc);
                        echo "<script>window.location.href='manageTshirt.php';</script>";
                      }
                      else
                      {
                        mysqli_rollback($dbc);
                        echo "<script>alert('fail');</script>";
                      }
                }
              }
  //Insert new Tshirt//
            }

          }
        }
        ?>
<!--/Form Validation PHP-->
    <body>


        <div class="wrapper">
            <?php require('../includes/admin_sidenav.php') ?>

<!-- Page Content Holder -->
            <div id="content">
                <?php require('../includes/admin_navbar.php'); ?>

<!--Form Frontend-->
    <form action="<?php echo $_SERVER['PHP_SELF'].@$form_apath; ?>" method="POST" enctype="multipart/form-data" >
    <div class="container-fluid">
    <table id="adshirttbl" class="table-responsive">
      <tr>
        <td>
          <!--Brand Field-->
            <!--Brands-->
              <label for="Brands">Brands</label>
            </td>
            <td>
              <select class="selectpicker" id="sltbrand" name="sltbrand" data-width="201px">
                <option value="0">Choose a brand..</option>
                <?php
                $sql ="Select * from tbl_brand";
                $query = mysqli_query($dbc,$sql);
                while ($row =mysqli_fetch_array($query)) {
                  $brand_id = $row['brand_id'];
                  $brand = $row['brand'];
                  ?>
                  <option value='<?php echo $brand_id;?>' <?php @savStatesin($_POST['sltbrand'], $brand_id, $shirt_id_up, $shirtbrand_av); ?>><?php echo $brand;?></option>";
                  <?php
                }
                ?>
              </select>
              <!-- Brand modal Trigger Button -->
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#brandmodal"><span class="glyphicon">&#x2b;</span></button>
          <!--/Brand Field-->
        </td>
        
        <td class="tdcoladjust">
          <!--Fabric Field-->
            <!--Fabric-->
            <!-- <div class="col-sm"> -->
              <label class="mr-sm-2" for="Fabrics">Fabrics</label>
            </td>
            <td>
              <select class="selectpicker" id="sltfabric" name="sltfabric[]" data-live-search="true" data-size="5" title="Choose fabric/s" data-width="201px"  multiple>
              <?php
              $sql_fabric ="Select * from tbl_fabric";
              $sql_fabric_exe = mysqli_query($dbc,$sql_fabric);
              while ($fabricrow =mysqli_fetch_array($sql_fabric_exe, MYSQLI_ASSOC))
              {
                ?>
                <option value="<?php echo $fabricrow['fabric_id'];?>" data-tokens="<?php echo $fabricrow['fabric'];?>" <?php @savStatemul(@$_POST['sltfabric'], @$fabricrow['fabric_id'], @$shirt_id_up, @$fabric_arry); ?>><?php echo $fabricrow['fabric'];?></option>
                <?php
              }
              ?>
              </select>
              <!-- Fabric modal Trigger Button -->
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#fabricmodal"><span class="glyphicon">&#x2b;</span></button>
          <!--Fabric Field-->
        </td>
        
        <td>
          <!--Pattern Field-->
              <!-- <div class="col-sm"> -->
              <!--Pattern-->
                <label for="Pattern">Pattern</label>
                </td>
                <td>
                <select class="selectpicker icon-menus" title="Select a pattern" id="sltpat" name="sltpat[]" data-live-search="true" data-size="5" data-width="201px" multiple>
                <?php
                $sql_pattern ="Select * from tbl_pattern;";
                $sql_pattern_exe = mysqli_query($dbc,$sql_pattern);
                while ($patternrow =mysqli_fetch_array($sql_pattern_exe, MYSQLI_ASSOC))
                {
                  ?>
                  <option data-content="<img src='<?php echo $patternrow['p_img_path']; ?>' width='15px' height='15px'> <?php echo $patternrow['pattern']; ?>" value="<?php echo $patternrow['pattern_id']; ?>" data-tokens="<?php echo $patternrow['pattern'] ?>" <?php @savStatemul(@$_POST['sltpat'], @$patternrow['pattern_id'], @$shirt_id_up, @$patter_arry); ?>></option>;
                  <?php
                }
                ?>
                </select>
                <!-- Pattern modal Trigger Button -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#patternmodal"><span class="glyphicon">&#x2b;</span></button>
          <!--/Pattern Field-->
        </td>
      </tr>

      <tr>
      <!--Error Msgs-->
        <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$brand_err; ?></span></td>
        <td colspan="2" class="tdadjust tdcoladjust"><span class="errfrm"><?php echo @$fabric_err; ?></span></td>
        <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$pattern_err; ?> </span></td>
      <!--/Error Msgs-->
      </tr>
      
      <tr>
        <td>
          <!--Category Field-->
              <!--Category-->
                <label for="Category">Category</label>
                </td>
                <td>
                <select class="selectpicker" id="sltcat" name="sltcat" data-width="201px">
                  <option value="0">Choose a category..</option>
                  <?php
                  $sql ="Select * from tbl_category";
                  $query = mysqli_query($dbc,$sql);
                  while ($row =mysqli_fetch_array($query)) {
                    $cat_id = $row['cat_id'];
                    $category = $row['cat_name'];
                    ?>
                    <option value='<?php echo $cat_id; ?>' <?php @savStatesin($_POST['sltcat'], $cat_id, $shirt_id_up, $shirtcat_av); ?>><?php echo $category; ?></option>";
                    <?php
                  }
                  ?>
                </select>
                <!-- Category modal Trigger Button -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#catmodal"><span class="glyphicon">&#x2b;</span></button>
          <!--/Category Field-->
        </td>
        
        <td class="tdcoladjust">
          <!--Type Field-->
              <!--Type-->
              <label for="Type">Type</label>
              </td>
              <td>
              <select class="selectpicker" id="slttype" name="slttype" data-width="201px">
                <option value="0">Choose a type..</option>
                  <?php
                  $sql ="Select * from tbl_type";
                  $query = mysqli_query($dbc,$sql);
                  while ($row =mysqli_fetch_array($query)) {
                  $type_id = $row['type_id'];
                  $type = $row['type'];
                  ?>
                  <option value='<?php echo $type_id;?>' <?php @savStatesin($_POST['slttype'], $type_id, $shirt_id_up, $shirttype_av); ?>><?php echo $type;?></option>";
                  <?php
                  }
                  ?>
              </select>
          <!--/Type Field-->
        </td>

        <td>
          <!--Size Field-->
            <!--Size-->
            <label for="size">Size</label>
            </td>
            <td>
            <select class="selectpicker" id="sltsize" name="sltsize" data-width="201px">
              <option value="0">Choose a Size...</option>
              <?php
              $sql ="Select * from tbl_size";
              $query = mysqli_query($dbc,$sql);
              while ($row =mysqli_fetch_array($query)) {
                $size_id = $row['size_id'];
                $size = $row['size'];
                ?>
                <option value='<?php echo $size_id; ?>' <?php @savStatesin($_POST['sltsize'], $size_id, $shirt_id_up, $shirtsize_av); ?>><?php echo $size; ?></option>";
                <?php
              }
              ?>
            </select>
            <!-- Size modal Trigger Button -->
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#sizemodal"><span class="glyphicon">&#x2b;</span></button>
          <!--/size Field-->
        </td>

      </tr>

      <tr>
      <!--Error Msgs-->
        <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$cat_err; ?></span></td>
        <td colspan="2" class="tdadjust tdcoladjust"><span class="errfrm"><?php echo @$type_err; ?></span></td>
        <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$size_err; ?></span></td>
      <!--/Error Msgs-->
      </tr>

      <tr>
        <td>
          <!--Color Field-->
            <!--Colour-->
              <label class="mr-sm-2" for="Color">Color</label>
            </td>
            <td>
              <select id="ddcolor" name="ddcolor[]" class="selectpicker" data-live-search="true" data-size="5" title="Choose a Color/s" data-width="201px"  multiple>
                <?php
                  $sql_color = "SELECT * FROM tbl_color;";
                  $sql_color_exe = mysqli_query($dbc, $sql_color);

                  while($colrow = mysqli_fetch_array($sql_color_exe, MYSQLI_ASSOC))
                  {?>
                      <option value="<?php echo $colrow['color_id']?>" data-tokens="<?php echo $colrow['color'];?>" data-subtext="<?php echo $colrow['color_code'];?>" style='background:<?php echo $colrow['color_code'];?>; color: black;' <?php @savStatemul(@$_POST['ddcolor'], @$colrow['color_id'], @$shirt_id_up, @$col_arry); ?>><?php echo $colrow['color'];?></option>;
                    <?php
                  }
                ?>
              </select>
              <!-- Color modal Trigger Button -->
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#colormodal"><span class="glyphicon">&#x2b;</span></button>
          <!--/Color Field-->
        </td>
        
        <td colspan="2" class="tdcoladjust">
          <!--Image front Field-->
            <div id="fade" class="black_overlay"></div>
              <div class="custom-file-container" data-upload-id="imgf">
              <label>T-Shirt Front <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
              
              <label class="custom-file-container__custom-file" >
                  <input type="file" id="uplfimg[]" name="uplfimg" class="custom-file-container__custom-file__custom-file-input">
                  <span class="custom-file-container__custom-file__custom-file-control"></span>
              </label>
              <br>
              
              <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Image Front Preview</a>
                <div id="light" class="custom-file-container__image-preview"><a class="closebtn" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a></div>
                </div>
          <!--/Image Front Field-->     
        </td>

        <td>
          <!--Price Field-->
            <!--Price-->
            <label for="Price">Price</label>
            </td>
            <td>
            <input type="type" name="txtprice" id="txtprice" class="form-control" placeholder="Price" value="<?php @savStatetxt(@$_POST['txtprice'], @$shirt_id_up, @$shirtprice_av); ?>">   
          <!--/Price Field-->
        </td>
      </tr>

      <tr>
  <!--Error Msg -->
      <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$color_err."<br>"; ?></span></td>
      <td colspan="2" class="tdadjust">&nbsp;</td>
      <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$price_err."<br>"; ?> </span></td>
  <!--/Error Msg -->
      </tr>

      <tr>
        <td>
          <!--Design Field-->                 
            <!--Design-->
            <label for="Design">Design</label>
            </td>
            <td>
            <select class="selectpicker" id="sltdesign" name="sltdesign" data-live-search="true" data-size="5" data-width="201px">
              <option value="0" selected>Choose Design..</option>
              <?php
              $sql_design ="Select * from tbl_design;";
              $sql_design_exe = mysqli_query($dbc,$sql_design);
              while ($designrow =mysqli_fetch_array($sql_design_exe, MYSQLI_ASSOC))
              {
                ?>
                <option value='<?php echo $designrow['design_id'];?>' data-tokens='<?php echo $designrow['design'];?>' <?php @savStatesin($_POST['sltdesign'], $designrow['design_id'], $shirt_id_up, $shirtdesign_av);?>><?php echo $designrow['design'];?></option>;
                <?php
              }
              ?>
            </select>
            <!-- Design modal Trigger Button -->
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#designmodal"><span class="glyphicon">&#x2b;</span></button>
          <!--/Design Field-->
        </td>
        
        <td colspan="2" class="tdcoladjust">
          <!--Image Back Field-->             
            <div class="custom-file-container" data-upload-id="imgb">
                    <label>T-Shirt Back <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                    <label class="custom-file-container__custom-file" >
                        <input type="file" id="uplbimg[]" name="uplbimg" class="custom-file-container__custom-file__custom-file-input">
                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                    </label>
                    <br>
                      <a href = "javascript:void(0)" onclick = "document.getElementById('light2').style.display='block';document.getElementById('fade').style.display='block'">Image Back Preview</a>
                      <div id="light2" class="custom-file-container__image-preview"><a class="closebtn" href = "javascript:void(0)" onclick = "document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'">Close</a>
                      </div>
                    </div>
            </div>
          <!--/Image Back Field-->
        </td>
        
        <td>
          <!--Quantity Field-->
            <!--Quantity-->
            <label for="">Quantity</label>
            </td>
            <td>
            <input type="text" name="txtqty" id="txtqty" class="form-control" placeholder="Quantity" value="<?php @savStatetxt(@$_POST['txtqty'], @$shirt_id_up, @$shirtqty_av); ?>">
          <!--/Quantity Field-->
        </td>
      </tr>

      <tr>
  <!--Error Msgs-->
        <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$design_err; ?></span></td>
        <td colspan="2" class="tdadjust">&nbsp;</td>
        <td colspan="2" class="tdadjust"><span class="errfrm"><?php echo @$qty_err; ?> </span></td>
  <!--/Error Msgs-->
      </tr>

      <tr>
        <td>
          <!--Features Field-->
            <!--features-->
            <label class="mr-sm-2" for="Features">Features</label>
            </td>
            <td>
            <select class="selectpicker" id="sltfeature" data-width="201px" name="sltfeature[]" data-live-search="true" data-size="5" title="Choose feature/s"  multiple>
              <?php
              $sql_feature ="Select * from tbl_feature;";
              $sql_feature_exe = mysqli_query($dbc,$sql_feature);
              while ($featurerow =mysqli_fetch_array($sql_feature_exe))
              {
                ?>
                <option value="<?php echo $featurerow['feature_id'];?>" data-tokens="<?php echo $featurerow['feature'];?>" <?php @savStatemul(@$_POST['sltfeature'], @$featurerow['feature_id'], @$shirt_id_up, @$feat_arry); ?>><?php echo $featurerow['feature'];?></option>;
                <?php
              }
              ?>
            </select>
            <!-- Features modal Trigger Button -->
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#featuresmodal"><span class="glyphicon">&#x2b;</span></button>
            <!-- </div> -->
          <!--/Features Field-->
        </td>
      </tr>

      <tr>
  <!--Error Msgs-->
        <td colspan="2"><span class="errfrm"><?php echo @$features_err; ?> </span></td>
  <!--/Error Msgs-->

        <td class="tdcoladjust">
  <!--Button Field-->
          <!--Submit Button-->
          <input type="submit" class="btn btn-primary" name="btnsubas" id="btnsubas">
          </td>
          <td class="tdcoladjust">
          <!--Reset Button-->
          <input class="btn btn-primary" name="btnreset" id="btnreset" type="button" onclick="clrfrm();" value="Reset">
  <!--/Button Field-->
        </td>
      </tr>
    </table>
      </div>
      </form>
<!--/Form Frontend-->

<!-- Modals-->
  <!--Add Brand modal form-->
    <!--Brand Modal Body -->
    <div class="modal fade" id="brandmodal" tabindex="-1" role="dialog" aria-labelledby="mybrandmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add Brand</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline">
                <div class="form-group mb-3">
                  <span class="input-group-text">Brand</span>
                  <input type="text" class="form-control" placeholder="Brand.." aria-label="brand" name="txtabrand" id="txtabrand">
                </div>
                <input type="submit" class="btn btn-primary" id="btnabrand" name="btnabrand" Value="Add Brand">
              </form>
            </div>
            <div class="modal-footer">
            <span id="brand_availability"></span>
            </div>
          </div>
        </div>
      </div>
    <!--/Brand Modal Body -->

    <!--Brand AJAX Validation (Uniqueness)-->
      <script>
      uniqueval("btnabrand", '#txtabrand', "plugins/chkbrand.php", '#brand_availability', "Brand already exists!", "Enter a Brand");
      </script>
    <!--/Brand AJAX Validation (Uniqueness)-->

    <!--Insert Brand into DB-->
      <?php
      if(isset($_POST['btnabrand']))
      {
        $addbrand_cc = trim($_POST['txtabrand']);
        $addbrand = mysqli_real_escape_string($dbc, $addbrand_cc);
        $addbrand_qry = mysqli_query($dbc, "INSERT INTO tbl_brand(brand) VALUES('$addbrand');");
        if($addbrand_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      ?>
    <!--/Insert Brand into DB-->
  <!--Add Brand modal form-->

  <!--================================================================================================================================================= -->
  <!--add Category Modal form -->
    <!--Category Modal Body -->
      <div class="modal fade" id="catmodal" tabindex="-1" role="dialog" aria-labelledby="mycatmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add Category</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline">
                <div class="form-group mb-3">
                    <span class="input-group-text">Category</span>
                  <input type="text" class="form-control" name="txtacat" id="txtacat" placeholder="Category..">
                </div>
                <input type="submit" class="btn btn-primary" name="btnacat" id="btnacat" value="Add Category">
              </form>
            </div>
            <div class="modal-footer">
            <span id="cat_availability"></span>
            </div>
          </div>
        </div>
      </div>
    <!--/Category Modal Body -->

    <!--Category AJAX Validation (Uniqueness)-->
      <script>
      uniqueval("btnacat", '#txtacat', "plugins/chkcat.php", '#cat_availability', "Category already exists!", "Enter a Category");
        // $(document).ready(function(){
        //   document.getElementById("btnacat").disabled = true;
        //   $('#txtacat').blur(function(){
        //     var acat = $(this).val();
        //     $.ajax({
        //       url: "plugins/chkcat.php",
        //       method: "POST",
        //       data: {add_cat:acat},
        //       success:function(html)
        //       {
        //         if(html == "true")
        //         {
        //           if(acat == "")
        //           {
        //             $('#cat_availability').html('<span class="text-danger">Enter a Category!</span>');
        //             document.getElementById("btnacat").disabled = true;
        //           }
        //           else
        //           {
        //             $('#cat_availability').html('<span class="text-danger">Category already existed!</span>');
        //             document.getElementById("btnacat").disabled = true;
        //           }
        //         }

        //         if(html == "false")
        //         {
        //           if(acat == "")
        //           {
        //             $('#cat_availability').html('<span class="text-danger">Enter a Category!</span>');
        //             document.getElementById("btnacat").disabled = true;
        //           }
        //           else
        //           {
        //             $('#cat_availability').html('<span></span>');
        //             document.getElementById("btnacat").disabled = false;
        //           }
        //         }
        //       }
        //     })
        //   })
        // });
      </script>
    <!--/Category AJAX Validation (Uniqueness)-->

    <!--Insert Category into DB-->
      <?php
      if(isset($_POST['btnacat']))
      {
        $addcat_cc = $_POST['txtacat'];
        $addcat = mysqli_real_escape_string($dbc, $addcat_cc);
        $addcat_qry = mysqli_query($dbc, "INSERT INTO tbl_category(cat_name) VALUES('$addcat');");
        if($addcat_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      ?>
    <!--Insert Category into DB-->
  <!--add Category Modal form -->

  <!--================================================================================================================================================= -->
  <!--Add Color Modal form -->
    <!--Color Modal Body -->
      <div class="modal fade" id="colormodal" tabindex="-1" role="dialog" aria-labelledby="mycolormodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add Color</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline">
                <div class="form-group mb-3">
                  <span class="input-group-text">Color</span>
                  <input type="text" class="form-control" name="txtacolor" id="txtacolor" placeholder="Color..">
                </div>
                <input type="submit" class="btn btn-primary" name="btnacolor" id="btnacolor" value="Add Color">
              </form>
            </div>
            <div class="modal-footer">
            <span id="color_availability"></span>
            </div>
          </div>
        </div>
      </div>
    <!--/Color Modal Body -->

    <!--Color AJAX Validation (Uniqueness)-->
      <script>
        uniqueval("btnacolor", '#txtacolor', "plugins/chkcolor.php", '#color_availability', "Color already exists!", "Enter a Color");
      </script>
    <!--Color AJAX Validation (Uniqueness)-->

    <!--Insert Color into DB-->
      <?php
      if(isset($_POST['btnacolor']))
      {
        $addcolor_cc = trim($_POST['txtacolor']);
        $addcolor = mysqli_real_escape_string($dbc, $addcolor_cc);
        $addcolor_qry = mysqli_query($dbc, "INSERT INTO tbl_color(color) VALUES('$addcolor');");
        if($addcolor_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      ?>
    <!--Insert Color into DB-->
  <!--Add Color Modal form -->

  <!--================================================================================================================================================= -->
  <!--add Design Modal form -->
    <!--Design Modal Body -->
      <div class="modal fade" id="designmodal" tabindex="-1" role="dialog" aria-labelledby="mydesignmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add Design</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline">
                <div class="form-group mb-3">
                    <span class="input-group-text">Design</span>
                  <input type="text" class="form-control" name="txtadesign" id="txtadesign" placeholder="Design..">
                </div>
                <input type="submit" class="btn btn-primary" name="btnadesign" id="btnadesign" value="Add Design">
              </form>
            </div>
            <div class="modal-footer">
            <span id="design_availability"></span>
            </div>
          </div>
        </div>
      </div>
    <!--/Design Modal Body -->

    <!--Design AJAX Validation (Uniqueness)-->
      <script>
        uniqueval("btnadesign", '#txtadesign', "plugins/chkdesign.php", '#design_availability', "Design already exists!", "Enter a Design");
      </script>
    <!--/Design AJAX Validation (Uniqueness)-->

    <!--Insert Design into DB-->
      <?php
      if(isset($_POST['btnadesign']))
      {
        $adddesign_cc = $_POST['txtadesign'];
        $adddesign = mysqli_real_escape_string($dbc, $adddesign_cc);
        $adddesign_qry = mysqli_query($dbc, "INSERT INTO tbl_design(design) VALUES('$adddesign');");
        if($adddesign_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      ?>
    <!--/Insert Design into DB-->
  <!--add Design Modal form -->

  <!--================================================================================================================================================= -->
  <!--add Features Modal Form -->
    <!--Features Modal Body -->
      <div class="modal fade" id="featuresmodal" tabindex="-1" role="dialog" aria-labelledby="myfeaturesmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add Feature</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline">
                <div class="form-group mb-3">
                    <span class="input-group-text">Feature</span>
                  <input type="text" class="form-control" name="txtafeature" id="txtafeature" placeholder="Feature..">
                  <input type="submit" class="btn btn-primary" name="btnafeature" id="btnafeature" value="Add Feature">
                </div>
              </form>
            </div>
            <div class="modal-footer">
            <span id="feature_availability"></span>
            </div>
          </div>
        </div>
      </div>
    <!--/Features Modal Body -->

    <!--Feature AJAX Validation (Uniqueness)-->
      <script>
        uniqueval("btnafeature", '#txtafeature', "plugins/chkfeature.php", '#feature_availability', "Feature already exists!", "Enter a Feature");
      </script>
    <!--/Feature AJAX Validation (Uniqueness)-->

    <!--Insert Feature into DB-->
      <?php
      if(isset($_POST['btnafeature']))
      {
        $addfeature_cc = $_POST['txtafeature'];
        $addfeature = mysqli_real_escape_string($dbc, $addfeature_cc);
        $addfeature_qry = mysqli_query($dbc, "INSERT INTO tbl_feature(feature) VALUES('$addfeature');");
        if($addfeature_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      ?>
    <!--/Insert Feature into DB-->
  <!--/add Features Modal Form -->

  <!--================================================================================================================================================= -->
  <!--add fabric Modal form -->
    <!--fabric Modal Body -->
      <div class="modal fade" id="fabricmodal" tabindex="-1" role="dialog" aria-labelledby="myfabricmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add Fabric</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline">
                <div class="form-group mb-3">
                    <span class="input-group-text">Fabric</span>
                  <input type="text" class="form-control" name="txtafabric" id="txtafabric" placeholder="Fabric..">
                  <input type="submit" class="btn btn-primary" name="btnafabric" id="btnafabric" value="Add Fabric">
                </div>
              </form>
            </div>
            <div class="modal-footer">
            <span id="fabric_availability"></span>
            </div>
          </div>
        </div>
      </div>
    <!--/fabric Modal Body -->

    <!--Fabric AJAX Validation (Uniqueness)-->
      <script>
        uniqueval("btnafabric", '#txtafabric', "plugins/chkfabric.php", '#fabric_availability', "Fabric already exists!", "Enter a Fabric");
      </script>
    <!--/Fabric AJAX Validation (Uniqueness)-->

    <!--Insert Fabric into DB-->
      <?php
      if(isset($_POST['btnafabric']))
      {
        $addfabric_cc = $_POST['txtafabric'];
        $addfabric = mysqli_real_escape_string($dbc, $addfabric_cc);
        $addfabric_qry = mysqli_query($dbc, "INSERT INTO tbl_fabric(fabric) VALUES('$addfabric');");
        if($addfabric_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      ?>
    <!--/Insert Fabric into DB-->
  <!--add fabric Modal form -->

  <!--================================================================================================================================================= -->
  <!--add Pattern Modal form -->
    <!--Pattern Modal Body -->
      <div class="modal fade" id="patternmodal" tabindex="-1" role="dialog" aria-labelledby="mypatternmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add Pattern</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <span class="input-group-text">Pattern</span>
                  <input type="text" class="form-control" name="txtapattern" id="txtapattern" placeholder="Pattern..">
                  <input type="file" id="uplpatimg" name="uplpatimg">
                </div>
                <input type="submit" class="btn btn-primary" name="btnapattern" id="btnapattern" value="Add Pattern">
              </form>
            </div>
            <div class="modal-footer">
            <span id="pattern_availability"></span>
            </div>
          </div>
        </div>
      </div>
    <!--/Pattern Modal Body -->

    <!--Pattern AJAX Validation (Uniqueness)-->
      <script>
        uniqueval("btnapattern", '#txtapattern', "plugins/chkpattern.php", '#pattern_availability', "Pattern already exists!", "Enter a Pattern");
      </script>
    <!--/Pattern AJAX Validation (Uniqueness)-->

    <!--Insert Pattern into DB-->
      <?php
      if(isset($_POST['btnapattern']))
      {
        //Pattern Add image Validation
      $check_num = 0;
      $target_dir_pat = "../images/tshirt_pattern/";
      $target_file_pat = $target_dir_pat . basename($_FILES["uplpatimg"]["name"]);
      $imageFileType_pat = strtolower(pathinfo($target_file_pat,PATHINFO_EXTENSION));

      //Size Validation(>500 kb denied)
      if ($_FILES["uplpatimg"]["size"] > 500000 || $_FILES["uplpatimg"]["error"] == 1)
      {
        $txt_err = "Sorry, your image is too large.";
        echo "<script> $(document).ready(function(){
          $('#adpatvalsize').modal({show: true});
            }); </script>";
      $check_num = 1;
      }

      elseif($imageFileType_pat != "jpg" && $imageFileType_pat != "png" && $imageFileType_pat != "jpeg")
      {
        $txt_err = "Sorry, only JPG, JPEG and PNG files are allowed.";
        echo "<script> $(document).ready(function(){
          $('#adpatvalsize').modal({show: true});
            }); </script>";

        $check_num = 1;
      }

      if($check_num == 0)
      {
        move_uploaded_file($_FILES["uplpatimg"]["tmp_name"], $target_file_pat);
        $addpattern_cc = $_POST['txtapattern'];
        $addpattern = mysqli_real_escape_string($dbc, $addpattern_cc);
        //require('plugins/image/SimpleImage.php');
        
        $img = new claviska\SimpleImage($target_file_pat);
        
        try {
        $img->fromFile($target_file_pat);
        $pat_path = "../images/tshirt_pattern/".$addpattern.".".$imageFileType_pat;
        unlink($target_file_pat);
        $img->resize(100, 100)->toFile($pat_path);
        
        } catch(Exception $err) {
        echo "<script>alert('Error: '" .$e->getMessage()."');</script>";
        }

        }

        $addpattern_qry = mysqli_query($dbc, "INSERT INTO tbl_pattern(pattern, p_img_path) VALUES('$addpattern', '$pat_path');");
        if($addpattern_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }

      }
      ?>
    <!--/Insert Pattern into DB-->
  <!--/add Pattern Modal form -->

  <!--================================================================================================================================================= -->
  <!--add Size Modal form -->
    <!--Size Modal Body -->
      <div class="modal fade" id="sizemodal" tabindex="-1" role="dialog" aria-labelledby="mysizemodal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Add Size</h4>
                </div>
                <div class="modal-body">
                  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-inline">
                    <div class="form-group mb-3">
                        <span class="input-group-text">Size</span>
                      <input type="text" class="form-control" placeholder="Size.." aria-label="brand" name="txtasize" id="txtasize">
                      <input type="submit" class="btn btn-primary" id="btnasize" name="btnasize" Value="Add Size">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                <span id="size_availability"></span>
                </div>
              </div>
            </div>
        </div>
    <!--/Size Modal Body -->
        
    <!--Size AJAX Validation (Uniqueness)-->
      <script>
        uniqueval("btnasize", '#txtasize', "plugins/chksize.php", '#size_availability', "Size already exists!", "Enter a Size");
      </script>
    <!--/Size AJAX Validation (Uniqueness)-->

    <!--Insert Size into DB-->
      <?php
      if(isset($_POST['btnasize']))
      {
        $addsize_cc = trim($_POST['txtasize']);
        $addsize = mysqli_real_escape_string($dbc, $addsize_cc);
        $addsize_qry = mysqli_query($dbc, "INSERT INTO tbl_size(size) VALUES('$addsize');");
        if($addsize_qry)
        {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }
      ?>
    <!--/Insert Size into DB-->
  <!--add Size Modal form -->

  <!--================================================================================================================================================= -->

  <!-- Add pattern image size validation Modal -->
    <div class="modal fade" id="adpatvalsize" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="text-warning">Error</h4>
            </div>
            <div class="modal-body">
              <p><?php echo $txt_err ?></p>
            </div>
          </div>
        </div>
    </div>
  <!-- /Add pattern image size validation Modal -->

  <!-- image back validation Modal -->
    <div class="modal fade" id="imgbval" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="text-warning">Image Back Error</h4>
            </div>
            <div class="modal-body">
              <p><?php echo $img_b_err ?></p>
            </div>
          </div>
        </div>
    </div>
  <!-- /image back validation Modal -->

  <!-- image front validation Modal -->
    <div class="modal fade" id="imgfval" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="text-warning">Image Front Error</h4>
            </div>
            <div class="modal-body">
              <p><?php echo $img_f_err ?></p>
            </div>
          </div>
        </div>
    </div>
  <!-- /image front validation Modal -->

  <!-- New T-Shirt added Modal -->
    <div class="modal fade" id="addshirtsuc" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="text-success">Success!</h4>
            </div>
            <div class="modal-body">
              <p>New T-Shirt Added!</p>
            </div>
          </div>
        </div>
    </div>
  <!-- /New T-Shirt added Modal -->
<!-- /Modals-->

<!-- Image Preview Script-->
    <script src="../js/file-upload-with-preview.js"></script>
    <script>
      var upload1 = new FileUploadWithPreview('imgf');
      var upload2 = new FileUploadWithPreview('imgb');
    </script>
<!-- /Image Preview Script-->

<div class="line"></div>     
            </div>
<!-- /Page Content Holder -->
        </div>
    
    </body>
</html>
