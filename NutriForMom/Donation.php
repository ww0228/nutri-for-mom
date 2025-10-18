<?php
require('session_timeout.php');

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // If not logged in, redirect to the login page
    echo '<script>
        window.onload = function() {
            alert("You must log in to make a donation. Redirecting you to the login page.");
            window.location.href = "Login.php"; 
        };
    </script>';
    exit();
}

// Define variables
$donationAmount = 0;
$customAmount = 0;
$errorMsg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if a valid amount is selected or entered
    if (isset($_POST['donation_amount']) && $_POST['donation_amount'] != '0') {
        // If a donation amount is selected, get the value
        $donationAmount = $_POST['donation_amount'];
    } elseif (isset($_POST['custom_amount']) && $_POST['custom_amount'] > 0) {
        // If a custom amount is entered, get the value
        $customAmount = $_POST['custom_amount'];
        $donationAmount = $customAmount; // Override with custom amount
    } else {
        // Set error message if no valid amount is selected/entered
        $errorMsg = 'Please select or enter a valid donation amount.';
    }
    
    // If valid amount, store it in the session and prepare to send to payment.php
    if ($donationAmount > 0) {
        // Store the donation amount in a session variable
        $_SESSION['donation_amount'] = $donationAmount;
        
        // Output the value to confirm the session variable
        var_dump($_SESSION['donation_amount']); // Debugging to see the donation amount
        
        // Create a hidden form to send the data to payment.php using POST method
        echo "<form id='paymentForm' action='Payment.php' method='POST'>
                <input type='hidden' name='donation_amount' value='" . htmlspecialchars($donationAmount) . "'>
              </form>";
        
        // Auto-submit the form to send the data to payment.php
        echo "<script>document.getElementById('paymentForm').submit();</script>";
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Donation</title>
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
          <h2>Donate Now</h2>
          <p class="subtitle">Support mothers through nourishment and care</p>
        </div>
  
        <form class="donation-form" action="Donation.php" method="POST">
	        <div class="donation-options">
	          <div class="donation-card">
	            <h3>Financial Support</h3>
	            <p>Your financial contribution helps us provide nutritious meals to mothers in need.</p>
	            
	            <!-- Display Error Message -->
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $errorMsg): ?>
                    <p style="color: red;"><?php echo $errorMsg; ?></p>
                <?php endif; ?>
	            
	            <div class="amount-buttons">
		          <label for="amount-25">
		            <input type="radio" name="donation_amount" id="amount-25" value="25" onchange="clearCustomAmount()">
		            RM25
		          </label>
		          <label for="amount-50">
		            <input type="radio" name="donation_amount" id="amount-50" value="50" onchange="clearCustomAmount()">
		            RM50
		          </label>
		          <label for="amount-100">
		            <input type="radio" name="donation_amount" id="amount-100" value="100" onchange="clearCustomAmount()">
		            RM100
		          </label>
		        </div>
		        
		        <!-- Custom Amount -->
		        <div class="custom-amount">
		          <input type="number" name="custom_amount" placeholder="Custom amount" min="1" step="1" onchange="clearDropdown()">
		             <button type="submit" class="donate-button">Donate Now</button>
		    
		        </div>
		      </div>
		
		      <div class="donation-card">
		        <h3>Food Donation</h3>
		        <p>Donate meals or groceries directly to mothers in your community.</p>
		        
		        <!-- Food Donation Buttons -->
		        <a href="Groceries.php"><button type="button" class="donate-button">Donate Groceries</button></a>
		        <a href="Contact.php"><button type="button" class="donate-button">Contact for Food Donation</button></a>
		        
		        
		      </div>
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