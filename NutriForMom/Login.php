<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('login_functions.inc.php');
    require('mysqli_connect.php');
       
    // Check the login:
    list($check, $data) = check_login($dbc, $_POST['email'], $_POST['password'],);
    
    if ($check) {
        // Set the session data:
        $_SESSION['id'] = $data['u_id'];
        $_SESSION['name'] = $data['u_name'];  
        $_SESSION['is_admin'] = $data['u_is_admin'];
        //Start count time when user login the page
        $_SESSION['login_time'] = time();
        
        $_SESSION['login_message'] = "Welcome back, {$_SESSION['name']}!";
        
        // Determine the redirect URL based on admin status
        $redirect_url = $_SESSION['is_admin'] == 1 ? 'admin_dashboard.php' : 'Profile.php';
        
        // Display success message and set redirect timer
        echo "<h1>Logged In!</h1>
              <p>You are now logged in, {$_SESSION['name']}!</p>
              <script>
                  setTimeout(function() {
                      window.location.href = '{$redirect_url}';
                  }, 2000); // Redirect after 2 seconds
              </script>";
        
    } else {
        $errors = $data;
    }
    
    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
	<header class="navbar">
	  <div class="container">
	    <a href="#">
	      <img src="pic/logo_NutriForMom.png" alt="Brand Logo" class="logo">
	    </a>
	    <nav class="nav-links">
	      <a href="Home.php">Home</a>
	      <a href="About.php">About</a>
	      <a href="Donation.php">Donation</a>
	      <a href="Contact.php">Contact</a>
	      <?php require('header.php');?>
	    </nav>
	    <button class="nav-toggle" aria-label="Toggle navigation">
	      <span class="hamburger"></span>
	    </button>
	  </div>
	</header>
	
	<section id="about" class="about">
        <div class="about-content">
          <h2>Welcome Back!</h2>
          <p class="subtitle">Sign in to your account</p>
        </div>      
        
           <!-- Display Errors -->
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p style="color: red;"><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            
        <!-- Login Form -->
         <form class="login-form" action="Login.php" method="POST">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"> 
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
            </div>    
            <div class="donate-button-container">
            	<button type="submit" class="submit-button" value="Login">Sign In</button>
            </div>
            
          </form>
          
          <div class="alternate-action">
            <p>Don't have an account? <a href="Signup.php">Sign up</a></p>
          </div>
	    
	  	
    </section>
    
    <!-- Footer Section -->
	<footer class="footer">
	  <div class="footer-content">
	    <p>&copy; 2024 NutriForMom. All Rights Reserved.</p>
	    <div class="footer-links">
	      <a href="contact.php">Contact Us</a>
	    </div>
	  </div>
	</footer>
	
	<!-- Link to External JavaScript file -->
    <script src="script.js"></script>
    
</body>
</html>