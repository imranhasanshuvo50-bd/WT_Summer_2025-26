<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if (isset($_POST["change_password"])) {
    $current = $_POST["current_password"];
    $new = $_POST["new_password"];
    $confirm = $_POST["confirm_password"];

    $sql = "SELECT pass FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($data["pass"] != $current) {
        $error = "Current password is wrong";
    } elseif ($new != $confirm) {
        $error = "New passwords do not match";
    } else {
        $sql = "UPDATE users SET pass='$new' WHERE id='$user_id'";

        if (mysqli_query($conn, $sql)) {
            $success = "Password changed successfully";
        }
    }
}

if (isset($_POST["change_name"])) {
    $new_name = mysqli_real_escape_string($conn, trim($_POST["new_name"]));

    $sql = "UPDATE users SET name='$new_name' WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION["username"] = $new_name;
        $name_success = "Name changed successfully";
    }
}

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
</head>

<body>

<div class="profile">

    <h2>My Profile</h2>

    <div class="info">
        <p><b>Name:</b> <?php echo $user["name"]; ?></p>
        <p><b>Email:</b> <?php echo $user["email"]; ?></p>
        <p><b>Role:</b> <?php echo $user["role"]; ?></p>
        <p><b>Status:</b> <?php echo $user["status"]; ?></p>
    </div>

    <hr>

    <h3>Change Password</h3>

    <?php if (isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <?php if (isset($success)) { ?>
        <p class="success"><?php echo $success; ?></p>
    <?php } ?>

    <form method="POST">

        <label>Current Password</label>
        <input type="password" name="current_password" required>

        <label>New Password</label>
        <input type="password" name="new_password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="change_password">
            Change Password
        </button>

    </form>

    <hr>

    <h3>Change Name</h3>

    <?php if (isset($name_success)) { ?>
        <p class="success"><?php echo $name_success; ?></p>
    <?php } ?>

    <form method="POST">

        <label>New Name</label>

        <input
            type="text"
            name="new_name"
            value="<?php echo $user["name"]; ?>"
            required
        >

        <button type="submit" name="change_name">
            Change Name
        </button>

    </form>

</div>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    background-color: #e0f2fe;
    font-family: Arial, sans-serif;
}

.profile {
    width: 400px;
    max-width: 90%;
    margin: 50px auto;
    background-color: white;
    padding: 30px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
}

h2 {
    text-align: center;
    color: #0284c7;
    margin-bottom: 25px;
}

h3 {
    color: #334155;
    margin-top: 20px;
    margin-bottom: 15px;
}

.info p {
    background-color: #f8fafc;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
    color: #334155;
}

hr {
    border: none;
    border-top: 1px solid #cbd5e1;
    margin: 25px 0;
}

label {
    display: block;
    margin-top: 12px;
    margin-bottom: 5px;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
}

input {
    width: 100%;
    padding: 11px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    outline: none;
    font-size: 14px;
}

input:focus {
    border-color: #0284c7;
}

button {
    width: 100%;
    margin-top: 20px;
    padding: 11px;
    background-color: #0284c7;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
}

button:hover {
    background-color: #0369a1;
}

.error {
    color: #dc2626;
    background-color: #fef2f2;
    padding: 10px;
    border-radius: 5px;
}

.success {
    color: #15803d;
    background-color: #f0fdf4;
    padding: 10px;
    border-radius: 5px;
}

</style>

</body>
</html>