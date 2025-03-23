<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Art Gallery</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <a href="index.php" class="logo">ONLINE ART GALLERY</a>
            <nav class="nav-links">
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1 class="page-title">Create an Account</h1>
            
            <div class="form-container">
                <h2 class="form-title">Registration Form</h2>
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">Full Name</label>
                        <input type="text" id="username" name="user" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="text" id="contact" name="contact" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="pass" class="form-control" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Register</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                    
                    <p class="text-center mt-3">
                        Already have an account? <a href="login.php" class="cart-action">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </main>

    <?php
    if (isset($_POST["submit"])) {
        if (!empty($_POST['user']) && !empty($_POST['contact']) && !empty($_POST['email']) && !empty($_POST['city']) && !empty($_POST['pass'])) {
            $user = $_POST['user'];
            $num = $_POST['contact'];
            $email = $_POST['email'];
            $city = $_POST['city'];
            $pass = $_POST['pass'];
            
            $con = mysqli_connect('localhost', 'root', 'root', 'art') or die(mysqli_error($con));
            $query = mysqli_query($con, "SELECT * FROM user WHERE name='$user'");
            
            if (mysqli_num_rows($query) == 0) {
                $sql = "INSERT INTO user(name, contact, email, city, password) VALUES('$user', '$num', '$email', '$city', '$pass')";
                $result = mysqli_query($con, $sql);
                
                if ($result) {
                    echo "<div class='alert alert-success container' style='max-width: 500px; margin: 20px auto;'>Account Successfully Created! <a href='login.php'>Login now</a></div>";
                } else {
                    echo "<div class='alert alert-danger container' style='max-width: 500px; margin: 20px auto;'>Registration Failed!</div>";
                }
            } else {
                echo "<div class='alert alert-danger container' style='max-width: 500px; margin: 20px auto;'>That username already exists! Please try again with another.</div>";
            }
        } else {
            echo "<div class='alert alert-danger container' style='max-width: 500px; margin: 20px auto;'>All fields are required!</div>";
        }
    }
    ?>
</body>
</html>