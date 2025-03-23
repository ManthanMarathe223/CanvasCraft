<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Art Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <a href="index.php" class="logo">Canvas Craft</a>
            <nav class="nav-links">
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Welcome Back</h1>
            
            <div class="form-container">
                <h2 class="form-title">Login to Your Account</h2>
                
                <form action="" method="POST">
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="user" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="pass" class="form-control" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    </div>
                    
                    <p class="text-center mt-3">
                        Don't have an account? <a href="register.php" class="cart-action">Register here</a>
                    </p>
                </form>
            </div>
        </div>
    </main>

    <?php
    if (isset($_POST["submit"])) {
        if (!empty($_POST['user']) && !empty($_POST['pass'])) {
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            
            $con = mysqli_connect('localhost', 'root', 'root', 'art') or die(mysqli_error($con));
            $query = mysqli_query($con, "SELECT * FROM user WHERE name='$user' AND password='$pass'");
            
            if (mysqli_num_rows($query) > 0) {
                session_start();
                $_SESSION['sess_user'] = $user;
                header("Location: cart.php");
            } else {
                echo "<div class='alert alert-danger container' style='max-width: 500px; margin: 20px auto;'>Invalid username or password!</div>";
            }
        } else {
            echo "<div class='alert alert-danger container' style='max-width: 500px; margin: 20px auto;'>All fields are required!</div>";
        }
    }
    ?>
</body>
</html>