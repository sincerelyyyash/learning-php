
<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];  
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? 1 : 0;

    $sql = "SELECT id, email, password FROM users WHERE email = ?";  
    
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $param_email);
        $param_email = $email;
        
        if ($stmt->execute()) {
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {                    
                $stmt->bind_result($id, $email, $hashed_password);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;  
                        
                        if ($remember == 1) {
                            setcookie("user_login", $email, time() + (10 * 365 * 24 * 60 * 60));
                        }
                        
                        header("location: welcome.php");
                        exit();
                    } else {
                        $login_err = "Invalid email or password.";
                    }
                }
            } else {
                $login_err = "Invalid email or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    }
    
    $mysqli->close();
}

if (isset($login_err)) {
    echo $login_err;
}
?>

