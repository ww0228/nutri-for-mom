<?php 
require('session_timeout.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-About</title>
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

    <!-- About Section -->
    <section id="about" class="about">
        <div class="about-content">
            <h2>About NutriForMom</h2>
            <p>At NutriForMom, our mission is to empower new and expecting mothers with nutritious, ready-to-eat meals that support their health and the health of their babies. We believe that proper nutrition is key to a thriving family, and we're here to help make that easy.</p>
            <p>Our vision is a world where every mom has access to the nourishment she needs during the critical prenatal and postnatal periods.</p>

            <div class="about-image">
                <img src="pic/aboutpic2_NutriForMom.png" alt="NutriForMom team" />
            </div>

            <div class="mission">
                <h3>Our Mission</h3>
                <p>We are committed to providing convenient, delicious, and healthy meals that support the well-being of mothers and babies. Our services extend beyond just food; we aim to offer a support system for mothers throughout their journey of motherhood.</p>
            </div>
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