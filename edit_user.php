<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1){ header("Location: login.php"); exit(); }
include 'db.php';

$id = $_GET['id'];
$msg = "";

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $role = $_POST['role_id'];
    $stmt = $conn->prepare("UPDATE users SET name=?, role_id=? WHERE id=?");
    $stmt->bind_param("sii", $name, $role, $id);
    $stmt->execute();
    $msg = "User Updated!";
}

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html><body style="padding:20px;">
<h2>Edit User</h2>
<p style="color:green"><?php echo $msg; ?></p>
<form method="POST">
    Name: <input type="text" name="name" value="<?php echo $user['name']; ?>"><br><br>
    Role: 
    <select name="role_id">
        <option value="2" <?php if($user['role_id']==2) echo "selected"; ?>>User</option>
        <option value="1" <?php if($user['role_id']==1) echo "selected"; ?>>Admin</option>
    </select><br><br>
    <button name="update">Update</button>
</form>
<a href="dashboard.php">Back</a>
</body></html>