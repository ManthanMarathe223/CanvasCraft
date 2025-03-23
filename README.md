# CanvasCraft - Image Ordering Platform

## Project Overview
CanvasCraft is a simple image ordering platform where users can:
- Register and log in using their credentials.
- Browse and add paintings/images to their cart.
- Place orders for selected images.
- Receive email confirmations using PHPMailer.

## Installation & Setup
### 1. Clone the Repository
```sh
git clone https://github.com/yourusername/CanvasCraft.git
cd CanvasCraft
```

### 2. Set Up the Database
Create a MySQL database and run the following queries:
```sql
CREATE DATABASE art;
USE art;

CREATE TABLE user (
    name VARCHAR(30),
    contact VARCHAR(15),
    email VARCHAR(30),
    city VARCHAR(20),
    password VARCHAR(10)
);

CREATE TABLE tbl_product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

INSERT INTO tbl_product (name, price, image) VALUES
('Elephants', 250.00, 'elephants.jpg'),
('Greece', 300.00, 'greece.jpg'),
('Hare', 350.00, 'hare.jpg'),
('Parakeets', 400.00, 'parakeets.jpg');

CREATE TABLE order_place (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Configure Database Connection
Modify `config.php` with your database credentials:
```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "art";
$conn = new mysqli($servername, $username, $password, $database);
```

### 4. Set Up PHPMailer for Email Notifications
- Navigate to `PHPMailer-master` and include the required files in your project.
- Use an app password for Gmail SMTP authentication. 
- Update `mail_config.php` with:
```php
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 25;
```

### 5. Start the Server
Run XAMPP or any local server and place the project in the `htdocs` folder. Access it via:
```
http://localhost/CanvasCraft/
```

## Features
- Secure login and registration.
- Image selection and ordering.
- Email notifications using PHPMailer.
- Order history tracking.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributors
- [Manthan Marathe](https://github.com/ManthanMarathe223)

Happy Coding! 🎨✨

