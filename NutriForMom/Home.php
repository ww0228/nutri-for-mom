<?php 
require('session_timeout.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Home</title>
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
	
    <section class="hero">
        <div class="hero-content">
            <h1>Ready Meals, Ready Moms</h1>
            <p>Your generosity can change lives. Join us to support prenatal and postnatal care for mothers. </p>
            <a href="Donation.php" class="donate-btn">Donate Now</a>
        </div>
    </section>

    <section class="stats">
        <div class="stats-container">
            <div class="stat-card">
                <span class="stat-number">$2.5M+</span>
                <p>Donations Raised</p>
            </div>
            <div class="stat-card">
                <span class="stat-number">50K+</span>
                <p>Lives Impacted</p>
            </div>
            <div class="stat-card">
                <span class="stat-number">100+</span>
                <p>Active Projects</p>
            </div>
        </div>
    </section>

    <section class="causes">
        <h2>Featured Causes</h2>
        <div class="causes-grid">
            <div class="cause-card">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb" alt="Education">
                <h3>Maternal Education and Training</h3>
                <p>Help provide workshops and online resources to educate mothers on nutrition, parenting, and health to raise healthy families.</p>
                <a href="Donation.php"><button class="support-btn">Support Now</button></a>
            </div>
            <div class="cause-card">
                <img src="https://images.unsplash.com/photo-1649972904349-6e44c42644a7" alt="Healthcare">
                <h3>Disaster Relief and Support for Families</h3>
                <p>Help provide emergency supplies, food and recovery assistance to mothers and children affected by disasters or crises.</p>
                <a href="Donation.php"><button class="support-btn">Support Now</button></a>
            </div>
            <div class="cause-card">
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158" alt="Environment">
                <h3>Mental Health and Emotional Well-being for Mothers</h3>
                <p>Help support mothers through mental health initiatives, offering resources and assistance for postpartum depression and stress relief.</p>
                <a href="Donation.php"><button class="support-btn">Support Now</button></a>
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