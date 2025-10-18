<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Delete</title>
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
    // This page is for deleting a user record.
    require('session_timeout.php');
    
    $page_title = 'Delete a User';
    echo '<div class="about">
            <h1>Delete a User</h1>';
    
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
        
        if ($_POST['sure'] == 'Yes') { // Delete the record.
            
            // Make the query:
            $q = "DELETE FROM user WHERE u_id=$id LIMIT 1";
            $r = @mysqli_query($dbc, $q);
            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
                
                // Print a message:
                echo '<p>The user has been deleted.</p>';
                
            } else { // If the query did not run OK.
                echo '<p class="error">The user could not be deleted due to a system error.</p>'; // Public message.
                echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';  // Debugging message.
            }
            
        } else { // No confirmation of deletion.
            echo '<p>The user has NOT been deleted.</p>';
        }
        
    } else { // Show the form.
        
        // Retrieve the user's information:
        $q = "SELECT u_name, u_email FROM user WHERE u_id=$id";
        $r = @mysqli_query($dbc, $q);
        
        if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.
            
            // Get the user's information:
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            
            // Display the record being deleted:
            echo "<h3>Name: {$row['u_name']}</h3>
            <p>Email: {$row['u_email']}</p>
            Are you sure you want to delete this user?";
            
            // Create the form:
            echo '<form action="admin_delete_user.php" method="post">
            <input type="radio" name="sure" value="Yes" /> Yes
            <input type="radio" name="sure" value="No" checked="checked" /> No
            <input type="submit" name="submit" value="Submit" />
            <input type="hidden" name="id" value="' . $id . '" />
            </form></div>';
            
        } else { // Not a valid user ID.
            echo '<p class="error">This page has been accessed in error.</p>';
        }
        
    } // End of the main submission conditional.
    
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