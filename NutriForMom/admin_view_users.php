<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Users</title>
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
	
    <?php
    require('mysqli_connect.php');
    require('session_timeout.php');
    
    // This script retrieves all the records from the user table.
    $page_title = 'View the Current Users';
    
    echo '<section class="about">
            <div class="about-content">
             <h2>Registered Users</h2>
            </div>';
    
    // Number of records to show per page:
    $display = 10;
    
    // Determine how many pages there are...
    if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
        $pages = $_GET['p'];
    } else { // Need to determine.
        // Count the number of records:
        $q = "SELECT COUNT(u_id) FROM user";
        $r = @mysqli_query($dbc, $q);
        $row = @mysqli_fetch_array($r, MYSQLI_NUM);
        $records = $row[0];
        // Calculate the number of pages...
        if ($records > $display) { // More than 1 page.
            $pages = ceil($records / $display);
        } else {
            $pages = 1;
        }
    } // End of p IF.
    
    // Determine where in the database to start returning results...
    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
        $start = $_GET['s'];
    } else {
        $start = 0;
    }
    
    // Determine the sort...
    // Default is by name.
    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
    
    // Determine the sorting order:
    switch ($sort) {
        case 'name':
            $order_by = 'u_name ASC';
            break;
        case 'email':
            $order_by = 'u_email ASC';
            break;
        case 'registration-date':
            $order_by = 'u_registration_date ASC';
            break;
        default:
            $order_by = 'u_name ASC';
            $sort = 'name';
            break;
    }
    
    // Define the query:
    $q = "SELECT u_id, u_name, u_email, u_registration_date, u_is_admin FROM user ORDER BY u_is_admin DESC,$order_by LIMIT $start, $display";
    $r = @mysqli_query($dbc, $q); // Run the query.
    
    // Table header:
    echo '<div id ="shopping-cart">
    <table align="center" cellspacing="0" cellpadding="5" width="75%">
    <tr>
        <td align="left"><b>Edit</b></td>
        <td align="left"><b>Delete</b></td>
        <td align="left"><b><a href="admin_view_users.php?sort=name">Name</a></b></td>
        <td align="left"><b><a href="admin_view_users.php?sort=email">Email</a></b></td>
        <td align="left"><b><a href="admin_view_users.php?sort=registration-date">Registration Date</b></td>
    </tr>
    ';
    
    // Fetch and print all the records...
    $bg = '#eeeeee';
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
        echo '<tr bgcolor="' . $bg . '">
            <td align="left"><a href="admin_edit_user.php?id=' . $row['u_id'] . '">Edit</a></td>
            <td align="left"><a href="admin_delete_user.php?id=' . $row['u_id'] . '">Delete</a></td>
            <td align="left">' . htmlspecialchars($row['u_name']) . 
                ($row['u_is_admin'] ? ' <strong>(Admin)</strong>' : '') . '</td>
            <td align="left">' . htmlspecialchars ($row['u_email']) . '</td>
            <td align="left">' . htmlspecialchars ($row['u_registration_date']). '</td>
        </tr>';
    } // End of WHILE loop.
    
    echo '</table></section></div>';
    
    // Make the links to other pages, if necessary.
    if ($pages > 1) {
        echo '<br /><p>';
        $current_page = ($start / $display) + 1;
        
        // If it's not the first page, make a Previous button:
        if ($current_page != 1) {
            echo '<a href="admin_view_users.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
        }
        
        // Make all the numbered pages:
        for ($i = 1; $i <= $pages; $i++) {
            if ($i != $current_page) {
                echo '<a href="admin_view_users.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
            } else {
                echo $i . ' ';
            }
        } // End of FOR loop.
        
        // If it's not the last page, make a Next button:
        if ($current_page != $pages) {
            echo '<a href="admin_view_users.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
        }
        
        echo '</p>'; // Close the paragraph.
    } // End of links section.
    mysqli_free_result($r);
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
