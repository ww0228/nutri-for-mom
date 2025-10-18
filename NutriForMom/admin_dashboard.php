<?php
require('mysqli_connect.php'); 
require('session_timeout.php'); 

// Fetch the user's data from the database using session ID
$user_id = $_SESSION['id'];
$q = "SELECT u_id, u_name, u_email,u_password FROM user WHERE u_id = '$user_id'";
$r = @mysqli_query($dbc, $q);
if ($r && mysqli_num_rows($r) == 1) {
    $user_data = mysqli_fetch_assoc($r);
} else {
    // Handle the case if no data is found
    echo "<p>Error: User data not found.</p>";
    exit();
}

// Handle form submission to update the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Validate and update name
    $name = mysqli_real_escape_string($dbc, $_POST['name']);
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    // Validate and update email
    $email = mysqli_real_escape_string($dbc, $_POST['email']);
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    // Handle password update
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($dbc, $_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $user_data['u_password']; // Use current password if not updated
    }
    
    // If no errors, update the user data in the database
    if (empty($errors)) {
        $update_q = "UPDATE user SET u_name='$name', u_email='$email', u_password='$hashed_password' WHERE u_id='$user_id'";
        if (@mysqli_query($dbc, $update_q)) {
            // Success, update session data
            $_SESSION['name'] = $name;
            $_SESSION['success_message'] = "Profile updated successfully!";
            header("Location: admin_dashboard.php"); // Reload the profile page with updated info
            exit();
        } else {
            $errors[] = "Error updating profile: " . mysqli_error($dbc);
        }
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
	<header class="navbar">
	  <div class="container">
	    <a href="#">
	      <img src="pic/logo_NutriForMom.png" alt="Brand Logo" class="logo">
	    </a>
	    <nav class="nav-links">
	      <a href="admin_view_users.php">Users</a>
	      <a href="admin_view_donation.php">Donations</a>
	      <a href="admin_view_messages.php">Messages</a>
	      <a href="admin_dashboard.php">Admin</a>
	      <a href="logout.php">Sign Out</a>
	    </nav>
	    <button class="nav-toggle" aria-label="Toggle navigation">
	      <span class="hamburger"></span>
	    </button>
	  </div>
	</header>
	
	<section id="about" class="about">
        <div class="about-content">
          <h2>Admin Profile</h2>
        </div>
        
         <div class="profile-card">
            <!-- Profile Photo -->
            <div class="profile-photo">
			    <img id="profileImage" src="pic/userIcon_NutriForMom.png" alt="User Photo">
			</div>
        
        <!-- Display Errors -->
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p style="color: red;"><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
         
        <!-- Display Success Message -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-message" style="color: green; font-size: 16px;">
                        <?php 
                            echo $_SESSION['success_message']; 
                            unset($_SESSION['success_message']); // Clear the message after displaying it
                        ?>
                    </div>
                <?php endif; ?>

            <!-- User Info Form -->
             <form class="profile-form" action="admin_dashboard.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $user_data['u_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php echo $user_data['u_email']; ?>">
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>    
    </section>

		<!-- Footer Section -->
		<footer class="footer">
		  <div class="footer-content">
		    <p>&copy; 2024 NutriForMom. All Rights Reserved.</p>
		  </div>
		</footer>
	    
	    <!-- Link to External JavaScript file -->
	    <script src="script.js"></script>
	    
</body>
</html>