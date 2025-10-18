<?php
session_start();
require('session_timeout.php');
require('mysqli_connect.php');

// Initialize variables
$donationAmount = $_SESSION['donation_amount'] ?? 0; 
$cartTotal = $_SESSION['cart_total']  ?? 0;           
$totalAmount = $donationAmount + $cartTotal;          

$errors = [];
$paymentToken = '';
$termsAccepted = false; 

// Validate and process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-payment-btn'])) {
    // Validate card details
    $name = trim($_POST['name']);
    $cardNumber = trim($_POST['card_number']);
    $expiryDate = trim($_POST['expiry_date']);
    $cvv = trim($_POST['cvv']);
    $termsAccepted = isset($_POST['terms']) && $_POST['terms'] === 'on';
    
    // Validate form fields
    if (empty($name)) {
        $errors[] = 'Name is required.';
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = 'Name should only contain alphabets.';
    }
    
    if (empty($cardNumber)) {
        $errors[] = 'Card number is required.';
    } elseif (!preg_match('/^\d{16}$/', $cardNumber)) {
        $errors[] = 'Invalid card number. Must be 16 digits.';
    }
    
    if (empty($expiryDate)) {
        $errors[] = 'Expiry date is required.';
    }
    
    if (empty($cvv)) {
        $errors[] = 'CVV is required.';
    } elseif (!preg_match('/^\d{3}$/', $cvv)) {
        $errors[] = 'Invalid CVV. Must be 3 digits.';
    }
    
    if (!$termsAccepted) {
        $errors[] = 'You must agree to the terms and conditions.';
    }
    
    // If there are no errors, simulate payment and generate a payment token
    if (empty($errors)) {
        // Simulate payment token generation (for demo purposes)
        $paymentToken = bin2hex(random_bytes(16)); // Generate a random token

        $user_id = $_SESSION['id'];
       
        if ($user_id) {
            $query = "INSERT INTO donation (u_id, d_amount, d_payment_token) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($dbc, $query);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ids", $user_id, $totalAmount, $paymentToken);
                
                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        echo "<!DOCTYPE html>
                                <html>
                                <head>
                                    <title>Donation Success</title>
                                    <script>setTimeout(function() {window.location.href = 'Donation.php';}, 3000);</script>
                                    <style>
                                       body {
                                        color: green;
                                       }
                                    </style>
                                </head>
                                <body>
                                    <h3>Donation and Cart Total of RM $totalAmount processed successfully!</h1>
                                    <h4>Payment Token: $paymentToken</h3><p><br /></p>
                                </body>
                                </html>";
                        exit();
                    } else {
                        $errors[] = "Error processing your donation. Please try again.";
                    }
                    
                    mysqli_stmt_close($stmt);
                } else {
                    $errors[] = "Database error: " . mysqli_error($dbc);  // Corrected: mysqli_error($dbc)
                }
            } else {
                $errors[] = "Error preparing the query: " . mysqli_error($dbc);
            }
        } else {
            $errors[] = "User not logged in.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Payment</title>
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
          <h2>Pay with Card</h2>
          <p class="subtitle">Payment Info</p>
        </div>
        
        <!-- Display Errors -->
        <?php if (!empty($errors) && isset($_POST['submit-payment-btn'])): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p style="color: red;"><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Display the Total Amount (Donation + Cart Total) -->
        <div class="payment-summary">
            <p>Donation Amount: RM <?php echo $donationAmount; ?></p>
            <p>Shopping Cart Total: RM <?php echo $cartTotal; ?></p>
            <p><strong>Total Payment: RM <?php echo $totalAmount; ?></strong></p>
        </div>
        
        <!-- Payment Form -->
        <form id="paymentForm" class="signup-form" action="Payment.php" method="POST">
         
            <div class="form-group">
                <label for="name">Name On Card</label>
                <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="card-number">Card Number</label>
                <input id="card-number" name="card_number" type="text" placeholder="1111 2222 3333 4444" value="<?= isset($_POST['card_number']) ? htmlspecialchars($_POST['card_number']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="expiry-date">Expiry Date</label>
                <input id="expiry-date" name="expiry_date" type="month" value="<?= isset($_POST['expiry_date']) ? htmlspecialchars($_POST['expiry_date']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input id="cvv" name="cvv" type="text" placeholder="123" value="<?= isset($_POST['cvv']) ? htmlspecialchars($_POST['cvv']) : '' ?>">
            </div>
            
            <div class="form-options">
                <label class="terms">
                    <input type="checkbox" name="terms">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>
            
            <div class="donate-button-container">
                <button name="submit-payment-btn" type="submit" class="submit-button">Submit Payment</button>
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

    <script src="script.js"></script>
</body>
</html>
