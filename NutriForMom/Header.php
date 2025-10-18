<?php if (isset($_SESSION['id'])): ?>
<a href="Profile.php">My Profile</a>
<a href="logout.php">Sign Out</a>
<?php else: ?>
    <!-- Login Link -->
    <a href="Login.php">Login</a>
<?php endif; ?>
