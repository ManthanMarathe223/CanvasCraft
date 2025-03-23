<?php 
session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    require 'PHPMailer-master/src/Exception.php';

        
$connect = mysqli_connect("localhost", "root", "root", "art");

// Fetch user details from database
$query = mysqli_query($connect, "SELECT * FROM user WHERE name='" . $_SESSION['sess_user'] . "'");
$numrows = mysqli_num_rows($query);

$name = $num = $em = $city = "";
if ($numrows != 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $name = $row['name'];
        $num = $row['contact'];
        $em = $row['email'];
        $city = $row['city'];
    }
}

$total = $_SESSION['tot'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Online Art Gallery</title>
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
            <h1 class="page-title">Complete Your Order</h1>
            
            <div class="checkout-form">
                <h2 class="form-title">Shipping Information</h2>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="user" class="form-control" value="<?php echo $name; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="text" id="contact" name="contact" class="form-control" value="<?php echo $num; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $em; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" class="form-control" value="<?php echo $city; ?>" required>
                    </div>
                    
                    <div class="order-summary">
                        <h3 class="form-title">Order Summary</h3>
                        <p class="total-amount">Total Amount: ₹<?php echo number_format($total, 2); ?></p>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-accent">Confirm Order</button>
                        <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php 
    if (isset($_POST["submit"])) {
        $n = $_POST["user"];
        $c = $_POST["contact"];
        $e = $_POST["email"];
        $ci = $_POST["city"];

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = 'true';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 25;
        $mail->Username = "your-mail-id@gmail.com";
        $mail->Password = "your-app-password";
        $mail->setFrom('your-mail-id@gmail.com');
        $mail->addAddress($e);
        $mail->IsHTML(true);
        
        $mail->Subject = 'Your order has been placed successfully.';
        $mail->Body = "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                <h2 style='color: #5d4037; text-align: center;'>Order Confirmation</h2>
                <p>Dear $n,</p>
                <p>Thank you for your order from the Online Art Gallery. Your order details are as follows:</p>
                
                <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                    <tr style='background-color: #f2f2f2;'>
                        <th style='padding: 10px; text-align: left; border-bottom: 1px solid #ddd;'>Detail</th>
                        <th style='padding: 10px; text-align: left; border-bottom: 1px solid #ddd;'>Information</th>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'><strong>Name:</strong></td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$n</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'><strong>Email:</strong></td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$e</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'><strong>Contact:</strong></td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$c</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'><strong>Shipping Address:</strong></td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$ci</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'><strong>Total Amount:</strong></td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>₹$total</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'><strong>Estimated Delivery:</strong></td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>2-3 business days</td>
                    </tr>
                </table>
                
                <p>If you have any questions about your order, please contact our customer service.</p>
                <p>Thank you for shopping with us!</p>
                <p style='text-align: center; margin-top: 30px; color: #777;'>© Online Art Gallery</p>
            </div>
        </body>
        </html>";
        
        if (!$mail->send()) {
            echo "<div class='alert alert-danger container' style='max-width: 600px; margin: 20px auto;'>ERROR: " . $mail->ErrorInfo . "</div>";
        } else {
            $sql = "INSERT INTO order_place (name, contact, email, city, total) VALUES ('$n', '$c', '$e', '$ci', '$total')";
            $retval = mysqli_query($connect, $sql);
            
            if ($retval) {
                echo "<div class='alert alert-success container' style='max-width: 600px; margin: 20px auto;'>
                    <h3>Order Successfully Placed!</h3>
                    <p>Thank you for your purchase. A confirmation email has been sent to your email address.</p>
                    <p>Your order will be processed and shipped within 24 hours.</p>
                </div>";
            } else {
                echo "<div class='alert alert-danger container' style='max-width: 600px; margin: 20px auto;'>Error: " . $sql . "<br>" . mysqli_error($connect) . "</div>";
            }
        }
    }
    ?>
</body>
</html>