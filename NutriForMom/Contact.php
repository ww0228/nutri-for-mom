<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('session_timeout.php');
require('mysqli_connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
    $errors = array(); // Array to store error messages
    
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
    
    // Message Validation
    if (empty($_POST['message'])) {
        $errors[] = 'You forgot to enter your message.';
    } else {
        $message = mysqli_real_escape_string($dbc, trim($_POST['message']));
    }
    
    // Process data if there are no errors
    if (empty($errors)) {
        
        // Insert data into the contact_form_submissions table
        $query = "INSERT INTO contact(c_name, c_email, c_message, submission_date)
                  VALUES ('$name', '$email', '$message', NOW())";
        
        $result = @mysqli_query($dbc, $query);
        
        if ($result) {
            // Display success message
            echo '<h1>Thank You!</h1>
                  <p>Your message has been sent successfully. We will get back to you shortly.</p>';
            echo '<script>setTimeout(function(){ window.location.href = "Contact.php"; }, 2000);</script>';
        } else {
            // Display error message
            echo '<h1>System Error</h1>
                  <p class="error">Your message could not be sent due to a system error. We apologize for any inconvenience.</p>';
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $query . '</p>';
        }
        exit();
    }
    
    // If there are validation errors, display them
    mysqli_close($dbc);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Contact</title>
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
          <h2>Contact Us</h2>
          <p class="subtitle">We'd love to hear from you!</p>
        </div>
        
        <!-- Display Errors -->
        <?php if (!empty($errors)): ?>
              <div class="error-messages">
                   <?php foreach ($errors as $error): ?>
                       <p style="color: red;"><?= $error ?></p>
                   <?php endforeach; ?>
              </div>
        <?php endif; ?>
        
        <!-- Contact Form -->
        <form class="contact-form" action="Contact.php" method="POST">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" />
            </div>
            
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
            </div>
            
            <div class="form-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" rows="5" value="<?php if (isset($_POST['message'])) echo $_POST['message']; ?>" /></textarea>
            </div>
            
            <div class="donate-button-container">
			  <button type="submit" class="submit-button">Send Message</button>
			</div>
			
         </form>
	        
	    
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