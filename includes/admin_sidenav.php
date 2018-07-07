<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>ShirtPrints <small>Admin</small></h3>
    </div>
    <ul class="list-unstyled components">
        <li>
            <a href="#tshirtmenu" data-toggle="collapse" aria-expanded="false">Manage T-shirt</a>
            <ul class="collapse list-unstyled" id="tshirtmenu">
                <li><a href="manageTshirt.php">View T-Shirt</a></li>
                <li><a href="crudtshirt.php">Add T-Shirt</a></li>
            </ul>
        </li>
        <li>
            <a href="#tshirtattributemenu" data-toggle="collapse" aria-expanded="false">T-shirt Attributes</a>
            <ul class="collapse list-unstyled" id="tshirtattributemenu">
                <li><a href="tshirt_addAttributes.php">Attributes</a></li>
                <li><a href="otsattr.php">Other Attributes</a></li>
            </ul>
        </li>
        <li>
            <a href="#usersettingmenu" data-toggle="collapse" aria-expanded="false">User Configurations</a>
            <ul class="collapse list-unstyled" id="usersettingmenu">
                <li><a href="crudcountry.php">Country</a></li>
            </ul>
        </li>
        <li>
            <a href="#">About</a>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Portfolio</a>
        </li>
        <li>
            <a href="#">Contact</a>
        </li>
    </ul>
    <ul class="list-unstyled CTAs">
        <li><a href="admin_logout.php" class="lgout">Log Out</a></li>
    </ul>
</nav>