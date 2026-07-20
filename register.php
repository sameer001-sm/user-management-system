<?php
include 'db.php';
$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role_id = 2; 

    // Prepared Statement 
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $password, $role_id);

    if($stmt->execute()){
        $msg = "Registration Successful! <a href='login.php'>Login here</a>";
    } else {
        $msg = "Error: Email already exists!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body style="font-family:Arial; text-align:center; margin-top:50px;">
    <h2>Register New User</h2>
    <p style="color:green"><?php echo $msg; ?></p>
    <form method="POST">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>