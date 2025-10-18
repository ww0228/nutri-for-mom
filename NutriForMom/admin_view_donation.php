<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom-Donations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header Navigation Bar -->
    <header class="navbar">
        <div class="container">
            <a href="#">
                <img src="pic/logo_NutriForMom.png" alt="Brand Logo" class="logo">
            </a>
            <nav class="nav-links">
                <a href="admin_view_users.php">Users</a>
                <a href="admin_view_donation.php" class="active">Donations</a>
                <a href="admin_view_messages.php">Messages</a>
                <a href="admin_dashboard.php">Admin</a>
                <a href="logout.php">Sign Out</a>
            </nav>
            <button class="nav-toggle" aria-label="Toggle navigation">
                <span class="hamburger"></span>
            </button>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="container">
        <section class="about">
            <div class="about-content">
                <h2>Donation Dashboard</h2>
            </div>

        <?php
        require('mysqli_connect.php');
        require('session_timeout.php');
        
        // Number of records per page
        $display = 10;
        
        // Determine the number of pages
        if (isset($_GET['p']) && is_numeric($_GET['p'])) { 
            $pages = $_GET['p'];
        } else { 
            // Count the total number of records
            $q = "SELECT COUNT(d_id) FROM donation";
            $r = @mysqli_query($dbc, $q);
            $row = @mysqli_fetch_array($r, MYSQLI_NUM);
            $records = $row[0];
            // Calculate the number of pages
            if ($records > $display) {
                $pages = ceil($records / $display);
            } else {
                $pages = 1;
            }
        }
        
        // Determine the starting record
        if (isset($_GET['s']) && is_numeric($_GET['s'])) {
            $start = $_GET['s'];
        } else {
            $start = 0;
        }
        
        // Query to fetch donations with pagination
        $q = "SELECT d.d_id, u.u_name, d.d_amount, d.d_payment_token, d.d_payment_date
              FROM donation d
              INNER JOIN user u ON d.u_id = u.u_id
              ORDER BY d.d_payment_date DESC LIMIT $start, $display";
        $r = @mysqli_query($dbc, $q);
        
        // Display donations in a table
        echo '<div id="shopping-cart">
                <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Donation Amount (RM)</th>
                <th>Payment Token</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>';
        
        $bg = '#eeeeee';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');
            echo '<tr style="background-color: ' . $bg . ';">
                <td>' . htmlspecialchars($row['u_name']) . '</td>
                <td>RM ' . htmlspecialchars(number_format($row['d_amount'], 2)) . '</td>
                <td>' . htmlspecialchars($row['d_payment_token']) . '</td>
                <td>' . htmlspecialchars($row['d_payment_date']) . '</td>
            </tr>';
        }
        
        echo '</tbody></table></section></div>';

        // Pagination Links
        if ($pages > 1) {
            echo '<br /><p>';
            $current_page = ($start / $display) + 1;
            
            // If not on the first page, add a "Previous" link
            if ($current_page != 1) {
                echo '<a href="admin_view_donation.php?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
            }
            
            // Display page numbers
            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="admin_view_donation.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }
            
            // If not on the last page, add a "Next" link
            if ($current_page != $pages) {
                echo '<a href="admin_view_donation.php?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
            }
            
            echo '</p>'; // Close the paragraph
        }

        mysqli_free_result($r);
        mysqli_close($dbc);
        ?>
    </div>

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
