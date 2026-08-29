<?php
include "config.php";

if (isset($_POST["delete_department"])) {
    $department_id = $_POST["delete_department"];
    $sql = "DELETE FROM departments WHERE department_id='$department_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: doctorDepartment.php");
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
        header("Location: doctorDepartment.php");
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["add_department"])) {
    $department_name = $_POST["department_name"];
    $description = $_POST["description"];
    $status = $_POST["status"];

    $sql = "INSERT INTO departments (department_name, description, status)
            VALUES ('$department_name', '$description', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: doctorDepartment.php");
        exit();
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}

$departmentResult = mysqli_query($conn, "SELECT * FROM departments");
if (!$departmentResult) {
    die("Query failed: " . mysqli_error($conn));
}

$editDepartment = null;
if (isset($_GET["edit_department"])) {
    $department_id = $_GET["edit_department"];
    $editResult = mysqli_query($conn, "SELECT * FROM departments WHERE department_id='$department_id'");
    $editDepartment = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Doctor & Department Management</title>
    <style>
        body {
            background-color: #cfedfa;
            font-family: Arial, sans-serif;
        }

        input, select, textarea, button {
            padding: 8px;
            margin: 4px;
        }

        textarea {
            vertical-align: top;
        }

        button {
            background-color: #1714af;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0e0b7a;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #1714af;
            padding: 8px;
            background-color: #d0d0d0;
        }

        th {
            background-color: #1714af;
            color: white;
        }

        .tabs label {
            display: inline-block;
            padding: 10px 18px;
            margin: 4px 0;
            background-color: #d0d0d0;
            border: 1px solid #1714af;
            cursor: pointer;
        }

        .tab-content {
            display: none;
            margin-top: 10px;
        }

        #departments:checked ~ #department-content,
        #doctors:checked ~ #doctor-content {
            display: block;
        }

        #departments:checked + label,
        #doctors:checked + label {
            background-color: #1714af;
            color: white;
        }

        .form-table {
            width: auto;
            margin-top: 10px;
        }

        .form-table td:first-child {
            background-color: #1714af;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Doctor & Department Management</h1>

    <div class="tabs">
        <input type="radio" id="departments" name="tab" checked>
        <label for="departments">Departments</label>
        <input type="radio" id="doctors" name="tab">
        <label for="doctors">Doctors</label>

        <div id="department-content" class="tab-content">
            <h2>Departments</h2>
            
            <table><tr><td>
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
                            <a href="doctorDepartment.php?edit_department=<?php echo $department["department_id"]; ?>">Edit</a>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete?');">
                                <button type="submit" name="delete_department" value="<?php echo $department["department_id"]; ?>">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            </td>
            <td>
            <h2><?php echo $editDepartment ? "Edit Department" : "Add New Department"; ?></h2>
            <form method="POST" id="department-form">
                <table class="form-table">
                    <?php if ($editDepartment): ?>
                        <input type="hidden" name="department_id" value="<?php echo $editDepartment["department_id"]; ?>">
                    <?php endif; ?>
                    <tr><td>Department Name</td><td><input type="text" name="department_name" value="<?php echo $editDepartment["department_name"] ?? ""; ?>" required></td></tr>
                    <tr><td>Description</td><td><textarea name="description"><?php echo $editDepartment["description"] ?? ""; ?></textarea></td></tr>
                    <tr><td>Status</td><td><select name="status">
                        <option <?php if (($editDepartment["status"] ?? "Active") == "Active") echo "selected"; ?>>Active</option>
                        <option <?php if (($editDepartment["status"] ?? "") == "Inactive") echo "selected"; ?>>Inactive</option>
                    </select></td></tr>
                    <tr><td colspan="2">
                        <button type="submit" name="<?php echo $editDepartment ? "edit_department" : "add_department"; ?>"><?php echo $editDepartment ? "Save Changes" : "Save"; ?></button>
                        <?php if ($editDepartment): ?>
                            <a href="doctorDepartment.php"><button type="button">Cancel Edit</button></a>
                        <?php endif; ?>
                    </td></tr>
                </table>
            </form>
                    </td></tr>


            </table>

            
        </div>

        <div id="doctor-content" class="tab-content">
            <h2>Doctors</h2>
            <button type="button">Scan for new Doctors</button>
            <input type="text" placeholder="Search Doctor">
            <select>
                <option>Department Filter</option>
            </select>

            <table>
                <tr>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Specialization</th>
                    <th>Qualification</th>
                    <th>Fee</th>
                    <th>Action</th>
                </tr>
            </table>

            <h2>Edit Doctor</h2>
            <table class="form-table">
                <tr><td>Doctor Name</td><td><input type="text" name="doctor_name"></td></tr>
                <tr><td>Assign Department</td><td><select name="department"><option>Select Department</option></select></td></tr>
                <tr><td>Specialization</td><td><input type="text" name="specialization"></td></tr>
                <tr><td>Qualification</td><td><input type="text" name="qualification"></td></tr>
                <tr><td>Experience</td><td><input type="number" name="experience"> Years</td></tr>
                <tr><td>Consultation Fee</td><td><input type="number" name="consultation_fee"></td></tr>
                <tr><td>Bio</td><td><textarea name="bio"></textarea></td></tr>
                <tr><td colspan="2"><button type="button">Save Changes</button></td></tr>
            </table>
        </div>
    </div>
</body>
</html>
