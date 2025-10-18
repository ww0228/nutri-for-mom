<?php
session_start();
$page_title = 'Register';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    require('mysqli_connect.php');
    
    $errors = array();
    
    // Name Validation
    if (empty($_POST['name'])) {
        $errors[] = 'You forgot to enter your name.';
    } else {
        $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors[] = 'Name should only contain alphabets.';
        }
    }
    
    // Email Validation
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }
    }
    
    // Password Validation
    if (empty($_POST['password'])) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
    }
    
    // Confirm Password Validation
    if (empty($_POST['confirm_password'])) {
        $errors[] = 'You forgot to confirm your password.';
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = 'Passwords do not match.';
    }
    
    if (empty($_POST['terms'])) {
        $errors[] = 'You must agree to the Terms of Service and Privacy Policy.';
    }
    
    // Process Data If No Errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert data into the user table
        $query = "INSERT INTO user (u_name, u_email, u_password, u_registration_date, u_is_admin)
                  VALUES ('$name', '$email', '$hashed_password', NOW(), 0)";
        
        $result = @mysqli_query($dbc, $query);
        
        if ($result) {
            echo '<h1>Thank you!</h1>
                  <p>You are now registered successfully.</p>';
            echo '<script>setTimeout(function(){ window.location.href = "Login.php"; }, 2000);</script>';
        } else {
            echo '<h1>System Error</h1>
                  <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>';
        }        
        exit();
    }
    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Signup</title>
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
          <h2>Create Account</h2>
          <p class="subtitle">Join our community of caring mothers</p>
        </div>
        
        <!-- Display Errors -->
        <?php if (!empty($errors)): ?>
              <div class="error-messages">
                   <?php foreach ($errors as $error): ?>
                       <p style="color: red;"><?= $error ?></p>
                   <?php endforeach; ?>
              </div>
        <?php endif; ?>
        
        <!-- Signup Form -->
         <form class="signup-form" action="Signup.php" method="POST">
         
         	<div class="form-group">
              <label for="name">Full Name</label>
              <input type="text" id="name" name="name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" />
            </div>
            
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" />
            </div>
            
            <div class="form-group">
              <label for="confirm-password">Confirm Password</label>
              <input type="password" id="confirm_password" name="confirm_password" value="<?php if (isset($_POST['confirm_password'])) echo $_POST['confirm_password']; ?>" />
            </div>
            
            <div class="form-options">
              <label class="terms">
                <input type="checkbox" name="terms" value="agree">
                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
              </label>
            </div>
            
            <div class="donate-button-container">
            	<button type="submit" class="submit-button">Create Account</button>
            </div>
            
          </form>
          
          <div class="alternate-action">
            <p>Already have an account? <a href="Login.php">Sign in</a></p>
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