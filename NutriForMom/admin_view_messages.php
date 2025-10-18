<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Messages</title>
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
        
        // This script retrieves all the records from the contact table.
        $page_title = 'View Contact Submissions';
        
        echo '<section class="about">
                <div class="about-content">
                  <h2>Contact Submission</h2>
                </div>';
        
        // Number of records to show per page:
        $display = 10;
        
        // Determine how many pages there are...
        if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
            $pages = $_GET['p'];
        } else { // Need to determine.
            // Count the number of records:
            $q = "SELECT COUNT(c_id) FROM contact";
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
        
        // Define the query for contact submissions:
        $q = "SELECT c_id, c_name, c_email, c_message, submission_date FROM contact ORDER BY submission_date DESC LIMIT $start, $display";
        $r = @mysqli_query($dbc, $q); // Run the query.
        
        // Table header for contact submissions:
        echo '
        <div id ="shopping-cart">
        <table align="center" cellspacing="0" cellpadding="5" width="75%">
        <tr>
            <td align="left"><b>Name</b></td>
            <td align="left"><b>Email</b></td>
            <td align="left"><b>Message</b></td>
            <td align="left"><b>Submission Date</b></td>
        </tr>
        ';
        
        // Fetch and print all the records...
        $bg = '#eeeeee';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr bgcolor="' . $bg . '">
                <td align="left">' . htmlspecialchars($row['c_name']) . '</td>
                <td align="left">' . htmlspecialchars($row['c_email']) . '</td>
                <td align="left">' . nl2br(htmlspecialchars($row['c_message'])) . '</td>
                <td align="left">' . htmlspecialchars($row['submission_date']) . '</td>
            </tr>';
        } // End of WHILE loop.
        
        echo '</table></section></div>';
        
        // Make the links to other pages, if necessary.
        if ($pages > 1) {
            echo '<br /><p>';
            $current_page = ($start / $display) + 1;
            
            // If it's not the first page, make a Previous button:
            if ($current_page != 1) {
                echo '<a href="admin_view_messages.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
            }
            
            // Make all the numbered pages:
            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="admin_view_messages.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            } // End of FOR loop.
            
            // If it's not the last page, make a Next button:
            if ($current_page != $pages) {
                echo '<a href="admin_view_messages.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
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
