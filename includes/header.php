<?php 
 require_once("./utils/functions.php");
?>
<nav>
    <ul>
    <li><a href="#"><img src="logo.png"></a></li>
    <li><a href="#">Home</a></li>
    <li><a href="#">Contact Us</a></li>
    <li><a href="#">About Us</a></li>
    <li><a href="packages.php">Packages</a></li>

<?php
    if (is_logged_in()) {
?>
    <li><a href="<?php echo is_admin() ? './staff/index.php' : '/client/index.php'; ?>">Dashboard</a></li>
    <li><a href="../utils/logout.php">Log Out</a></li>
<?php
    } else {   
    ?>
    <li><a href="./staff/auth/login.php">Staff Login</a></li>
    <li><a href="./client/auth/login.php">Client Login</a></li>
    <?php
    }
?>
    </ul>
</nav>

