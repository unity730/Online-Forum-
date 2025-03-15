<?php
session_start();
include('database/db_connection.php'); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

       
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; 
            
            if ($user['role'] == 'admin') {
                
                header("Location: admin_dashboard.php");
            } else {
                
                header("Location: user_dashboard.php");
            }
            exit; 
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/sstyle.css">
   
</head>
<body>
    <div class="login-container">
        <h2>WELCOME</h2>

    <form method="post">
    <input class="input-field" type="email" name="email" placeholder="Email" required><BR>
    <input class="input-field" type="password" name="password" placeholder="Password" required><BR>
    <button class="submit-btn" type="submit">Login</button>
    </form>

    </div>
</body>
</html>

 


