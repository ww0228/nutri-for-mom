<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Edit</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
	<header class="navbar">
	  <div class="container">
	    <a href="#">
	      <img src="pic/logo_NutriForMom.png" alt="Brand Logo" class="logo">
	    </a>
	    <nav class="nav-links">
	      <a href="admin_view_users.php">Back</a>
	    </nav>
	    <button class="nav-toggle" aria-label="Toggle navigation">
	      <span class="hamburger"></span>
	    </button>
	  </div>
	</header>

    <?php
    // This page is for editing a user record.
    require('session_timeout.php');
    
    $page_title = 'Edit a User';
    echo '<div class="about">
        <h1>Edit a User</h1>';
    
    // Check for a valid user ID, through GET or POST:
    if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) { // From view_users.php
        $id = $_GET['id'];
    } elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) { // Form submission.
        $id = $_POST['id'];
    } else { // No valid ID, kill the script.
        echo '<p class="error">This page has been accessed in error.</p>';
        exit();
    }
    
    require('mysqli_connect.php');
    
    // Check if the form has been submitted:
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $errors = array();
        
        // Check for a user name:
        if (empty($_POST['u_name'])) {
            $errors[] = 'You forgot to enter the user name.';
        } else {
            $name = mysqli_real_escape_string($dbc, trim($_POST['u_name']));
        }
        
        // Check for an email address:
        if (empty($_POST['u_email'])) {
            $errors[] = 'You forgot to enter the email address.';
        } else {
            $email = mysqli_real_escape_string($dbc, trim($_POST['u_email']));
        }
            
        if (empty($errors)) { // If everything's OK.
            
            // Test for unique email address:
            $q = "SELECT u_id FROM user WHERE u_email='$email' AND u_id != $id";
            $r = @mysqli_query($dbc, $q);
            
            if (mysqli_num_rows($r) == 0) {
                
                // Make the query:
                $q = "UPDATE user SET u_name='$name', u_email='$email' WHERE u_id=$id LIMIT 1";
                $r = @mysqli_query($dbc, $q);
                
                if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
                    
                    // Print a message:
                    echo '<p>The user has been edited.</p>';
                    
                } else { // If it did not run OK.
                    echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
                    echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
                }
                
            } else { // Already registered.
                echo '<p class="error">The email address has already been registered.</p>';
            }
            
        } else { // Report the errors.
            
            echo '<p class="error">The following error(s) occurred:<br />';
            foreach ($errors as $msg) { // Print each error.
                echo " - $msg<br />\n";
            }
            echo '</p><p>Please try again.</p>';
            
        } // End of if (empty($errors)) IF.
        
    } // End of submit conditional.
    
    // Always show the form...
    
    // Retrieve the user's information:
    $q = "SELECT u_name, u_email FROM user WHERE u_id=$id";
    $r = @mysqli_query($dbc, $q);
    
    if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.
        
        // Get the user's information:
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        
        // Create the form:
        echo '<form action="admin_edit_user.php" method="post">
    <p>User Name: <input type="text" name="u_name" size="30" maxlength="100" value="' . $row['u_name'] . '" /></p>
    <p>Email Address: <input type="email" name="u_email" size="30" maxlength="100" value="' . $row['u_email'] . '"  /></p>
    <p><input type="submit" name="submit" value="Submit" /></p>
    <input type="hidden" name="id" value="' . $id . '" />
    </form></div>';
        
    } else { // Not a valid user ID.
        echo '<p class="error">This page has been accessed in error.</p>';
    }
    
    mysqli_close($dbc);
    
    ?>
 
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
 
