<?php
session_start();
include 'db.php';
$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['name'] = $user['name'];
            header("Location: dashboard.php");
            exit();
        } else { $msg = "Invalid Password"; }
    } else { $msg = "User not found"; }
}
?>
<!DOCTYPE html>
<html>
    <body style="text-align:center; margin-top:50px;">
<h2>Login</h2>
<p style="color:red"><?php echo $msg; ?></p>
<form method="POST">
Email: <input type="email" name="email" required><br><br>
Password: <input type="password" name="password" required><br><br>
<input type="submit" value="Login">
</form>
<p>New user? <a href="register.php">Register here</a></p>
</body>
</html>