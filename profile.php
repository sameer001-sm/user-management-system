<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit(); }
include 'db.php';

$msg = "";
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $id = $_SESSION['user_id'];
    
    // Profile pic upload with Validation
if($_FILES['profile_pic']['name'] != ""){
    $target = "uploads/".basename($_FILES['profile_pic']['name']);
    $file_type = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    $file_size = $_FILES['profile_pic']['size'];
    
    // 1. Size Check - 2MB
    if($file_size > 2000000){
        $msg = "Error: File size must be less than 2MB";
    }
    // 2. Type Check - only jpg jpeg png
    elseif($file_type != "jpg" && $file_type != "jpeg" && $file_type != "png"){
        $msg = "Error: Only JPG, JPEG & PNG files allowed";
    }
    else{
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);
        $stmt = $conn->prepare("UPDATE users SET name=?,email=? , profile_pic=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $email, $target, $id);
    }
}
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $stmt->bind_param("si", $name, $email, $id);
    }
    $stmt->execute();
    $_SESSION['name'] = $name;
    $msg = "Profile Updated!";
}

$result = $conn->query("SELECT * FROM users WHERE id=".$_SESSION['user_id']);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html><body style="padding:20px;">
<h2>Edit Profile</h2>
<p style="color:green"><?php echo $msg; ?></p>
<form method="POST" enctype="multipart/form-data">
    Name: <input type="text" name="name" value="<?php echo $user['name']; ?>"><br><br>
    Profile Pic: <input type="file" name="profile_pic"><br>
    Email: <input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
    <?php if($user['profile_pic']) echo "<img src='{$user['profile_pic']}' width='100'>"; ?><br><br>
    <button name="update">Update</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>
</body></html>