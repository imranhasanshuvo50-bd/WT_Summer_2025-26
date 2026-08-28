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

$search = trim($_GET["search"] ?? "");
$searchValue = mysqli_real_escape_string($conn, $search);
$sql = "SELECT * FROM users";

if ($search !== "") {
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
        <input type="text" name="search" placeholder="Search by ID, name or email" value="<?php echo $search; ?>">
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
        <th>Password</th>
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
            <td><?php echo $row["pass"]; ?></td>
            <td><?php echo $row["role"]; ?></td>
            <td><?php echo $row["status"]; ?></td>
            <td>
                <form method="POST" onsubmit="return confirm('Delete this user?');">
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                    <button type="submit" name="delete_user">Delete</button>
                </form>
            </td>
        </tr>

    <?php
        }

    } else {
        echo "<tr><td colspan='7'>No User Accounts found</td></tr>";
    }
    ?>

    <tr>
        <td colspan="7">
            <form method="POST">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="patient">Patient</option>
                    <option value="doctor">Doctor</option>
                    <option value="receptionist">Receptionist</option>
                </select>
                <select name="status" required>
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <button type="submit" name="add_user">Add New</button>
            </form>
        </td>
    </tr>

</table>
</td>
</tr>
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
