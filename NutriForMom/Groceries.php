<?php
session_start();
require_once("dbcontroller2.php");
require('session_timeout.php');
$db_handle = new DBController2();

// Handle actions: add to cart, remove item, empty cart
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        
        case "add":
            if (!empty($_POST["quantity"])) {
                // Get product details by code
                $productByCode = $db_handle->runQuery("SELECT * FROM groceries WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array(
                    'name' => $productByCode[0]["name"],
                    'code' => $productByCode[0]["code"],
                    'quantity' => $_POST["quantity"],
                    'price' => $productByCode[0]["price"]
                ));

                // Check if cart already exists in session
                if (!empty($_SESSION["cart_item"])) {
                    // Check if the product already exists in the cart
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k)
                                $_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"]; // Update quantity
                        }
                    } else {
                        // Add the product to the cart
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    // If no cart, create a new one
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
            
        case "remove":
            // Remove item from cart
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
            
        case "empty":
            // Empty the cart
            unset($_SESSION["cart_item"]);
            $_SESSION['cart_total'] = 0;
            header("Location: Groceries.php");
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriForMom - Groceries</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header and navigation -->
    <header class="navbar">
        <div class="container">
            <a href="#"><img src="pic/logo_NutriForMom.png" alt="Brand Logo" class="logo"></a>
            <nav class="nav-links">
                <a href="Home.php">Home</a>
                <a href="About.php">About</a>
                <a href="Donation.php">Donation</a>
                <a href="Contact.php">Contact</a>
                <?php require('header.php');?>
            </nav>
        </div>
    </header>

    <!-- Shopping Cart -->
    <div id="shopping-cart">
        <div class="txt-heading">Shopping Cart <a id="btnEmpty" href="Groceries.php?action=empty">Empty Cart</a></div>
        <?php
        if (isset($_SESSION["cart_item"])) {
            $item_total = 0;
        ?>
        <table>
            <tbody>
            <tr>
                <th><strong>Name</strong></th>
                <th><strong>Code</strong></th>
                <th><strong>Quantity</strong></th>
                <th><strong>Unit Price</strong></th>
                <th><strong>Action</strong></th>
            </tr>
            <?php
            foreach ($_SESSION["cart_item"] as $item) {
            ?>
            <tr>
                <td><strong><?php echo $item["name"]; ?></strong></td>
                <td><?php echo $item["code"]; ?></td>
                <td><?php echo $item["quantity"]; ?></td>
                <td align="right">RM <?php echo $item["price"]; ?></td>
                <td><a href="Groceries.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction">Remove</a></td>
            </tr>
            <?php
            $item_total += ($item["price"] * $item["quantity"]);
            }
            ?>
            <tr>
                <td colspan="5" align="right"><strong>Total:</strong> RM <?php echo $item_total; ?></td>
            </tr>
            </tbody>
        </table>
        <?php
        // Store the cart total in session for use in Payment.php
        $_SESSION['cart_total'] = $item_total;
        }
        ?>
        
        <!-- Checkout Button -->
        <div id="checkout-container">
            <a href="Payment.php" class="btnCheckout">Proceed to Checkout</a>
        </div>
    </div>
    
    <!-- Product Grid -->
    <section class="groceries">
        <h2>Donate Groceries</h2>
        <div class="meals-grid">
            <?php
            // Fetch products from the database
            $product_array = $db_handle->runQuery("SELECT * FROM groceries ORDER BY id ASC");
            if (!empty($product_array)) {
                foreach ($product_array as $key => $value) {
            ?>
            <div class="meal-card">
                <form method="POST" action="Groceries.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                    <img src="<?php echo $product_array[$key]["image"]; ?>" alt="<?php echo $product_array[$key]["name"]; ?>">
                    <div class="meal-info">
                        <h3><?php echo $product_array[$key]["name"]; ?></h3>
                        <p><?php echo $product_array[$key]["weight"]; ?></p>
                        <p class="price">RM <?php echo $product_array[$key]["price"]; ?></p>
                        <div class="quantity-selector">
                            <label for="quantity-<?php echo $product_array[$key]["code"]; ?>">Qty:</label>
                            <input type="number" name="quantity" min="1" max="99" value="1" />
                        </div>
                        <input type="submit" value="Add to Cart" class="order-btn" />
                    </div>
                </form>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </section>

    <section class="newsletter">
        <div class="newsletter-content">
            <h2>Stay Updated</h2>
            <p>Join our newsletter to receive updates about our projects and impact.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email">
                <button type="submit" class="subscribe-btn">Subscribe</button>
            </form>
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

    <script src="script.js"></script>

</body>
</html>
