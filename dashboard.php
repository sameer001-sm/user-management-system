<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
include 'db.php';

// Delete user - सिर्फ Admin role_id=1 कर सकता है
if(isset($_GET['delete']) && $_SESSION['role_id'] == 1){
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php"); // Refresh
}
?>
<!DOCTYPE html>
<html><body>
<h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
<a href="logout.php">Logout</a>

<h3>All Users List</h3>
<table border="1" cellpadding="10">
<tr>
    <th>ID</th><th>Name</th><th>Email</th><th>Role</th>
    <?php if($_SESSION['role_id']==1) echo "<th>Action</th>"; ?>
</tr>
<?php
$result = $conn->query("SELECT u.id, u.name, u.email, r.role_name FROM users u JOIN roles r ON u.role_id = r.id");
while($row = $result->fetch_assoc()){
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['role_name']}</td>";
    if($_SESSION['role_id']==1) 
        echo "<td><a href='dashboard.php?delete={$row['id']}' onclick='return confirm(\"Delete?\")'>Delete</a></td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>