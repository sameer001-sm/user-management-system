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
    // खुद को delete न कर सके इसलिए
    if($id != $_SESSION['user_id']){ 
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html>
    <body style="font-family:Arial; padding:20px;">
<h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
<a href="profile.php">Edit Profile</a>
<p>Your Role: <b><?php echo ($_SESSION['role_id']==1) ? "Admin" : "User"; ?></b></p>
<a href="logout.php">Logout</a>

<form method="GET" style="margin-bottom:10px;">
    <input type="text" name="search" placeholder="Search by Name or Email" value="<?php echo isset($_GET['search'])?$_GET['search']:''; ?>">
    <button type="submit">Search</button>
</form>

<h3>All Users List</h3>
<table border="1" cellpadding="10">
<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT u.id, u.name, u.email, r.role_name 
        FROM users u 
        JOIN roles r ON u.role_id = r.id 
        WHERE u.name LIKE '%$search%' OR u.email LIKE '%$search%'";
$result = $conn->query($sql);
?>
<?php

while($row = $result->fetch_assoc()){
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['role_name']}</td>";
    if($_SESSION['role_id']==1 && $row['id'] != $_SESSION['user_id'])
        echo "<td><a href='edit_user.php?id={$row['id']}'>Edit</a> | <a href='dashboard.php?delete={$row['id']}' onclick='return confirm(\"Delete this user?\")'>Delete</a></td>";
    elseif($_SESSION['role_id']==1)
        echo "<td>-</td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>