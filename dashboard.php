<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
include 'db.php';
?>
<h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
<a href="logout.php">Logout</a>

<h3>All Users List</h3>
<table border="1" cellpadding="10">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>
<?php
$result = $conn->query("SELECT u.id, u.name, u.email, r.role_name FROM users u JOIN roles r ON u.role_id = r.id");
while($row = $result->fetch_assoc()){
    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['role_name']}</td></tr>";
}
?>
</table>