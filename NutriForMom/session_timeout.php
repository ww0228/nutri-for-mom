<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$session_timeout = 3600; // Timeout duration in seconds

if (isset($_SESSION['login_time'])) {
    if (time() - $_SESSION['login_time'] > $session_timeout) {
        session_unset();
        session_destroy();
        header("Location: Login.php?timeout=true"); // Redirect to login with a timeout flag
        exit();
    }
}

$_SESSION['login_time'] = time();
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        let timeout = <?php echo $session_timeout * 1000; ?>; // Convert PHP timeout to milliseconds
        let timeoutHandle;

        function resetTimer() {
            clearTimeout(timeoutHandle);
            timeoutHandle = setTimeout(logoutUser, timeout);
        }

        function logoutUser() {
            alert("You have been inactive for too long. Logging out...");
            window.location.href = "Login.php?timeout=true";
        }

        // Monitor user activity
        window.onload = resetTimer; // Reset timer on page load
        document.onmousemove = resetTimer; // Reset timer on mouse movement
        document.onkeypress = resetTimer; // Reset timer on key press
    </script>
</html>







