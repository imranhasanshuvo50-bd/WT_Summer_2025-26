<?php
include "config.php";

$sql = "SELECT * FROM users";
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

<h2>User Accounts List</h2>

<table style="border-collapse: collapse; width: 100%; text-align: le;">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
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
        </tr>

    <?php
        }

    } else {
        echo "<tr><td colspan='4'>No User Accounts found</td></tr>";
    }
    ?>

</table>

</body>
</html>
