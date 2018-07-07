<?php session_start();

if(!isset($_SESSION['admin']))
{
  header('Location:../index.php');
}

?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                <i class="glyphicon glyphicon-align-left"></i>
                <span>Menu</span>
            </button>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Welcome,</a></li>
                <li><a href="#"><?php echo $_SESSION['admin']; ?></a></li>
            </ul>
        </div>
    </div>
</nav>