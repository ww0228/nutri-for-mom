<?php
session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['id'])) {   
    // Need the functions:
    require ('login_functions.inc.php');
    redirect_user();
    
} else { // Cancel the session:
    $_SESSION = ARRAY();
    session_destroy();    
}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';
// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>";
echo '<script>setTimeout(function(){ window.location.href = "Login.php"; }, 2000);</script>';
?>