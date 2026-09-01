<?php
include "config.php";

if (isset($_POST["delete_department"])) {
    $department_id = $_POST["delete_department"];
    $sql = "DELETE FROM departments WHERE department_id='$department_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: departmentManagement.php");
        exit();
    } else {
        die("Delete failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["edit_department"])) {
    $department_id = $_POST["department_id"];
    $department_name = $_POST["department_name"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $sql = "UPDATE departments SET department_name='$department_name', description='$description', status='$status' WHERE department_id='$department_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: departmentManagement.php");
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["add_department"])) {
    $department_name = $_POST["department_name"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $sql = "INSERT INTO departments (department_name, description, status) VALUES ('$department_name', '$description', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: departmentManagement.php");
        exit();
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}

$editDepartment = null;
if (isset($_GET["edit_department"])) {
    $department_id = $_GET["edit_department"];
    $editResult = mysqli_query($conn, "SELECT * FROM departments WHERE department_id='$department_id'");
    $editDepartment = mysqli_fetch_assoc($editResult);
}

$departmentResult = mysqli_query($conn, "SELECT * FROM departments");
if (!$departmentResult) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>

<head>
    <a href="dashbord_admin.php" class="back-btn">Back to Dashboard</a>
    <title>Department Management</title>
    <style>
        body {
            background-color: #cfedfa;
            font-family: Arial, sans-serif;
        }

        input,
        select,
        textarea,
        button {
            padding: 8px;
            margin: 4px;
        }

        button {
            background-color: #1714af;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #1714af;
            padding: 8px;
            background-color: #d0d0d0;
        }

        th {
            background-color: #1714af;
            color: white;
        }

        .layout td {
            vertical-align: top;
            padding: 10px;
        }

        .form-table {
            width: auto;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 15px;
            background: #1714af;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

    </style>
</head>

<body>
    <h1>Department Management</h1>
    <table class="layout">
        <tr>
            <td>
                <h2>Departments</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Department Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Doctors</th>
                        <th>Action</th>
                    </tr>
                    <?php for ($i = 0; $i < mysqli_num_rows($departmentResult); $i++) {
                        $department = mysqli_fetch_assoc($departmentResult);
                        ?>
                        <tr>
                            <td><?php echo $department["department_id"]; ?></td>
                            <td><?php echo $department["department_name"]; ?></td>
                            <td><?php echo $department["description"]; ?></td>
                            <td><?php echo $department["status"]; ?></td>
                            <td>0</td>
                            <td>
                                <form method="GET">
                                    <button type="submit" name="edit_department"
                                        value="<?php echo $department["department_id"]; ?>">Edit</button>
                                </form>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete?');">
                                    <button type="submit" name="delete_department"
                                        value="<?php echo $department["department_id"]; ?>">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td>

                <h2><?php echo $editDepartment ? "Edit Department" : "Add New Department"; ?></h2>
                <form method="POST">
                    <table class="form-table">
                        <?php if ($editDepartment): ?>
                            <input type="hidden" name="department_id"
                                value="<?php echo $editDepartment["department_id"]; ?>">
                        <?php endif; ?>
                        <tr>
                            <td>Department Name</td>
                            <td><input type="text" name="department_name"
                                    value="<?php echo $editDepartment["department_name"] ?? ""; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td><textarea
                                    name="description"><?php echo $editDepartment["description"] ?? ""; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><select name="status">
                                    <option <?php if (($editDepartment["status"] ?? "Active") == "Active")
                                        echo "selected"; ?>>Active</option>
                                    <option <?php if (($editDepartment["status"] ?? "") == "Inactive")
                                        echo "selected"; ?>>Inactive</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td colspan="2"><button type="submit"
                                    name="<?php echo $editDepartment ? "edit_department" : "add_department"; ?>"><?php echo $editDepartment ? "Save Changes" : "Add New Department"; ?></button>
                                <?php if ($editDepartment): ?>
                                    <a href="departmentManagement.php"><button type="button">Cancel Edit</button></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</body>

</html>