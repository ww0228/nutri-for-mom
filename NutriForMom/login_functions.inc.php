<?php 
function redirect_user ($page) {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

} // End of redirect_user() function.

function check_login($dbc, $email = '', $password = '') {
    
    $errors = array(); // Initialize error array.
    
    // Validate the email address:
    if (empty($email)) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        // Check if the email is in a valid format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email address is not in a valid format.';
        } else {
            $e = mysqli_real_escape_string($dbc, trim($email));
        }
    }
    
    // Validate the password:
    if (empty($password)) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $p = mysqli_real_escape_string($dbc, trim($password));
    }
    
    if (empty($errors)) { // If everything's OK.
        
        // Retrieve the user_id, name, and password hash for that email:
        $q = "SELECT u_id, u_name, u_password,u_is_admin FROM user WHERE u_email='$e'";
        $r = @mysqli_query ($dbc, $q); // Run the query.
        
        // Check the result:
        if (mysqli_num_rows($r) == 1) {
            
            // Fetch the record:
            $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
            // Verify the password against the hashed password
            if (password_verify($p, $row['u_password'])) {
                // Password is correct, return true and the user data
                return array(true, $row);
            } else {
                // Password doesn't match
                $errors[] = 'The email address and password entered do not match those on file.';
            }
            
        } else { // No matching email found
            $errors[] = 'The email address does not match any account.';
        }
        
    } // End of empty($errors) IF.
    
    // Return false and the errors:
    return array(false, $errors);
    
} // End of check_login() function.
?>