<?php
session_start();
$connect = mysqli_connect("localhost", "root", "root", "art");
$tot = 0;

// Add to cart functionality
if (isset($_POST["add_to_cart"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        } else {
            echo '<script>alert("Item Already Added")</script>';
        }
    } else {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

// Remove item from cart
if (isset($_GET["action"]) && $_GET["action"] == "delete") {
    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        if ($values["item_id"] == $_GET["id"]) {
            unset($_SESSION["shopping_cart"][$keys]);
            echo '<script>alert("Item Removed")</script>';
        }
    }
}

if (isset($_POST["submit"])) {
    header("Location: bill.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Online Art Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <a href="index.php" class="logo">ONLINE ART GALLERY</a>
            <div class="user-welcome">
                <span>Welcome, <?= $_SESSION['sess_user']; ?>!</span>
                <a href="login.php">Logout</a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Browse Our Collection</h1>
            
            <div class="products-grid">
                <?php
                $query = "SELECT * FROM tbl_product ORDER BY id ASC";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                <div class="product-card">
                    <form method="post" action="cart.php?action=add&id=<?= $row['id']; ?>">
                        <img src="images/<?= $row['image']; ?>" alt="<?= $row['name']; ?>" class="product-image">
                        <div class="product-details">
                            <h3 class="product-title"><?= $row['name']; ?></h3>
                            <p class="product-price">₹<?= $row['price']; ?></p>
                            <div class="product-quantity">
                                <label for="quantity-<?= $row['id']; ?>">Quantity:</label>
                                <input type="number" id="quantity-<?= $row['id']; ?>" name="quantity" value="1" min="1" class="form-control">
                            </div>
                            <input type="hidden" name="hidden_name" value="<?= $row['name']; ?>">
                            <input type="hidden" name="hidden_price" value="<?= $row['price']; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                        </div>
                    </form>
                </div>
                <?php
                    }
                }
                ?>
            </div>
            
            <h2 class="page-title">Your Shopping Cart</h2>
            
            <?php if (!empty($_SESSION["shopping_cart"])): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                            $item_total = $values["item_quantity"] * $values["item_price"];
                            $total += $item_total;
                        ?>
                        <tr>
                            <td><?= $values["item_name"]; ?></td>
                            <td><?= $values["item_quantity"]; ?></td>
                            <td>₹<?= $values["item_price"]; ?></td>
                            <td>₹<?= number_format($item_total, 2); ?></td>
                            <td><a href="cart.php?action=delete&id=<?= $values['item_id']; ?>" class="cart-action">Remove</a></td>
                        </tr>
                        <?php
                        }
                        $_SESSION["tot"] = $total;
                        ?>
                        <tr class="total-row">
                            <td colspan="3" align="right">Total:</td>
                            <td>₹<?= number_format($total, 2); ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="text-align: center;">
                    <form method="post">
                        <button type="submit" name="submit" class="btn btn-accent">Proceed to Checkout</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-info" style="text-align: center;">Your cart is empty. Add some beautiful artwork!</div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>