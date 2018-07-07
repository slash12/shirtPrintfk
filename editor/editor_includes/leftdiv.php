<div class="row">
<div class="col-sm-6" style="background:#ABC;">


  <div class="row" >
      <div class="col-md-6" style="background:#DEF;">
        <!--design-->
        <?php
        $sql = "SELECT * FROM adddesign";
        $query = mysqli_query($dbc, $sql);
        echo "<div class=row >";
        while ($row = mysqli_fetch_array ($query))
        {
        echo "<div class=col->";
        echo "<div id=images>";
        echo "<input type='hidden' name=design id=design>";
        echo "<img draggable=true src= '".$row['imagesUrl']."'  width=50 height=auto name=design id=design ></img>";
        echo "</input>";
        echo "</div>";
        echo "</div>";
        }
        echo "</div>";
        ?>
        <br>
        <a href="pattern.php" class="btn btn-dark"> Add Pattern </a>

      </div>
      <div class="col-md-6" style="background:#CAD;">
          <div class="col-md-12" style="background:#FAD;">
            <!--color picker-->
            <?php
            $sql = "SELECT * FROM tbl_color ";
            $query = mysqli_query($dbc,$sql);

            echo "<ul class=nav>";
            while ($row = mysqli_fetch_array($query)) {
            echo "<li class=color-preview  id=color name=color  title = ".$row['color']."  style= background-color:" .$row['color_code']. "> </li>" ;

            }
            echo "</ul>";
            ?>
           </div>
          <div class="col-md-12" style="background-color:lemonchiffon;">

            <!--add new text-->
            <input type="button" class="btn btn-primary btn-sm" id="add" name='add' value="Add new text">
            <br>

            <!--font family-->
            <?php
            $sql = "SELECT * from addfontfamily";
            $qry = mysqli_query($dbc, $sql);
            if($qry)
            {
            echo "<select class='select2 font-change ' data-type='fontFamily' name=fontfamily id=fontfamily>";
            echo "<option value=null > Font </option>";
            while($row = mysqli_fetch_array($qry))
            {
            echo "<option value ='".$row['fontfamily']."'>".$row['fontfamily']."</option> "  ;
            }
            }
            echo "</select>";
            ?><br>
            <!--font size-->
            <?php
            $sql = "SELECT * from addfontsize";
            $qry = mysqli_query($dbc, $sql);

            if($qry)
            {
            echo "<select class='select2 font-change ' id=fontsize name=fontsize data-type='fontSize'>";
            echo "<option value=null > Font Size.. </option>";
            while($row = mysqli_fetch_array($qry))
            {

            echo "<option value ='".$row['fontsize']."'>".$row['fontsize']."</option> " ;
            }

            echo "</select>";

            }
            ?>
            <br>
            <!--font color-->
            <?php
            $sql = "SELECT * from addfontcolor";
            $qry = mysqli_query($dbc, $sql);

            if($qry)
            {
            echo "<select class='select2 font-change ' data-type='color' id=fontcolor name=fontcolor>";
            echo "<option value=null >  Font Color.. </option>";
            while($row = mysqli_fetch_array($qry))
            {
            echo "<option value ='".$row['colorcode']."'.'".$row['fontcolor_id']."'>".$row['fontcolor']."</option> " ;
            }
            echo "</select>";
            }
            ?>
            <br>

            <!--	Alignments  -->
            <select class="select2 font-change" data-type="textAlign">

            <option value="left">Alignments</option>
            <option value="left">Left</option>
            <option value="center">Center</option>
            <option value="right">Right</option>
            </select>
            <br>
            <!--BIU -->
            <a href="#" id="btn-bold">B</a>
            <a href="#" id="btn-italic">I</a>
            <a href="#" id="btn-underline">U</a>

            <br>


           </div>

           <div class="col-md-12" style="background-color:aquamarine;">
             <!--	upload image  -->
             <input type="file" id="file" name="file[]" multiple >
             <br>
             Size:
             <?php
             //size
             $sql = "SELECT * FROM tbl_size";
             $qry = mysqli_query($dbc, $sql);

             if($qry)
             {
             while ($row = mysqli_fetch_array($qry))
             {
             echo  $row['size'];
             echo " <input type=radio  name=size id=size  value = '".$row['size']."' /> ";
             }
             }

             ?>
             <br>



         <!--	bin  -->
         <a  href="#" id="delete" style="background-color:transparent;"><img src="images/icons/bin.png" height="50" width="50"></a>
           </div>
          <div class="col-md-12" style="background:pink;">

                  <center>
                  <button type="button" onclick="takeScreenShot();" id="btnsave" name="btnsave"  class="btn btn-danger">Save</button>
            <button  id="btncomplete" name="btncomplete"  class="btn btn-success" disabled >Continue</button>
            <!--	reset canvas  -->
            <a href="#" onClick="window.location.reload();" class="btn btn-warning"> Reset </a>

<script type="text/javascript">


</script>
            </center>
          </div>
      </div>
  </div>
<div>
</div>
</div>
