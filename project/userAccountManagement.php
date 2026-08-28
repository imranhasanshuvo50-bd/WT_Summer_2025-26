<?php
include "config.php";

if (isset($_POST["delete_user"])) {
    $id = $_POST["id"];
    $sql = "DELETE FROM users WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: userAccountManagement.php");
        exit();
    } else {
        die("Delete failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["add_user"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $role = $_POST["role"];
    $status = $_POST["status"];

    $sql = "INSERT INTO users (name, email, pass, role, status)
            VALUES ('$name', '$email', '$pass', '$role', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: userAccountManagement.php");
        exit();
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["edit_user"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $status = $_POST["status"];

    $sql = "UPDATE users SET name='$name', email='$email', role='$role', status='$status' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: userAccountManagement.php");
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}

$searchValue = trim($_GET["search"] ?? "");
$editUser = null;

if (isset($_GET["edit"])) {
    $editId = $_GET["edit"];
    $editResult = mysqli_query($conn, "SELECT * FROM users WHERE id='$editId'");
    $editUser = mysqli_fetch_assoc($editResult);
}

$sql = "SELECT * FROM users";

if ($searchValue !== "") {
    $sql .= " WHERE id LIKE '%$searchValue%'
              OR name LIKE '%$searchValue%'
              OR email LIKE '%$searchValue%'";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> User Account Management</title>
</head>


<body>
<h2>Search Account</h2>
<form method="GET">
        <input type="text" name="search" placeholder="Search by ID, name or email" value="<?php echo $searchValue; ?>">
        <button type="submit">Search</button>
        <a href="userAccountManagement.php">Clear</a>
</form>

<h2>User Accounts List</h2>
<table style="border-collapse: collapse; width: 100%; text-align: left; border: 1px solid #1714af;">
<tr>
<td>    
<table style="border-collapse: collapse; width: 100%; text-align: left; border: 5px solid #1714af;">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
       
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {

        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_assoc($result);
    ?>

        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            
            <td><?php echo $row["role"]; ?></td>
            <td><?php echo $row["status"]; ?></td>
            <td>
                <form method="GET">
                    <button type="submit" name="edit" value="<?php echo $row["id"]; ?>">Edit</button>
                </form>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete?');">
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                    <button type="submit" name="delete_user">Delete</button>
                </form>
            </td>
        </tr>

    <?php
        }

    } else {
        echo "<tr><td colspan='6'>No User Accounts found</td></tr>";
    }
    ?>



    </td>

</table>
</td>
    <td>
        <table>
            <tr>
        <td colspan="6">
            <form method="POST">
                <input type="text" name="name" placeholder="Name" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="patient">Patient</option>
                    <option value="doctor">Doctor</option>
                    <option value="receptionist">Receptionist</option>
                </select><br>
                <select name="status" required>
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select><br>
                <button type="submit" name="add_user">Add New</button>
            </form><br><br>
           
    <h2>Edit User Details</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $editUser["id"]; ?>"><br>
        <input type="text" name="name" value="<?php echo $editUser["name"]; ?>" required><br>
        <input type="email" name="email" value="<?php echo $editUser["email"]; ?>" required><br>
        <select name="role" required>
            <option value="admin" <?php if ($editUser["role"] == "admin") echo "selected"; ?>>Admin</option>
            <option value="patient" <?php if ($editUser["role"] == "patient") echo "selected"; ?>>Patient</option>
            <option value="doctor" <?php if ($editUser["role"] == "doctor") echo "selected"; ?>>Doctor</option>
            <option value="receptionist" <?php if ($editUser["role"] == "receptionist") echo "selected"; ?>>Receptionist</option>
        </select><br>
        <select name="status" required>
            <option value="Active" <?php if ($editUser["status"] == "Active") echo "selected"; ?>>Active</option>
            <option value="Inactive" <?php if ($editUser["status"] == "Inactive") echo "selected"; ?>>Inactive</option>
        </select><br>
        <button type="submit" name="edit_user">Save Changes</button>
    </form>

<button><a href="userAccountManagement.php">Clear</a></button>
        </td>
        </tr>
</table>


</table>




  <style>
        th, td {
            
            border: 1px solid #1714af;
            padding: 8px;
            background-color: #d0d0d0;
        }
        th {
            background-color: #1714af;
            color: white;
        }
        </style>
</body>
</html>
