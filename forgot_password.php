
<?php
require_once 'db_connection.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $error = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $token = bin2hex(random_bytes(50));
                    
                    $update_sql = "UPDATE users SET reset_token = ?, reset_token_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
                    if ($update_stmt = $mysqli->prepare($update_sql)) {
                        $update_stmt->bind_param("ss", $token, $email);
                        if ($update_stmt->execute()) {
                            $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
                            $to = $email;
                            $subject = "Password Reset Request";
                            $message = "Click the following link to reset your password: " . $reset_link;
                            $headers = "From: noreply@yourdomain.com";
                            
                            if (mail($to, $subject, $message, $headers)) {
                                $success = "A password reset link has been sent to your email address.";
                            } else {
                                $error = "Failed to send password reset email. Please try again later.";
                            }
                        } else {
                            $error = "Oops! Something went wrong. Please try again later.";
                        }
                        $update_stmt->close();
                    }
                } else {
                    $error = "No account found with that email address.";
                }
            } else {
                $error = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #1877f2;
        }
        form div {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input[type="email"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 0.5rem;
            background-color: #1877f2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #166fe5;
        }
        .error {
            color: red;
            margin-bottom: 1rem;
        }
        .success {
            color: green;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Forgot Password</h2>
        <?php 
        if (!empty($error)) {
            echo '<p class="error">' . $error . '</p>';
        }
        if (!empty($success)) {
            echo '<p class="success">' . $success . '</p>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <button type="submit">Reset Password</button>
            </div>
        </form>
        <div>
            <p><a href="index.php">Back to Login</a></p>
        </div>
    </div>
</body>
</html>

