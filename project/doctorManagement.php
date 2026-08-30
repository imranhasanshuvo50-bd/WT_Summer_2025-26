<?php
include "config.php";

if (isset($_POST["scan_doctors"])) {
    $sql = "INSERT INTO doctors (user_id) SELECT users.id FROM users LEFT JOIN doctors ON doctors.user_id=users.id WHERE users.role='doctor' AND doctors.user_id IS NULL";

    if (mysqli_query($conn, $sql)) {
        header("Location: doctorManagement.php");
        exit();
    } else {
        die("Scan failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["edit_doctor"])) {
    $doctor_id = $_POST["doctor_id"];
    $department_id = $_POST["department_id"];
    $specialization = $_POST["specialization"];
    $qualification = $_POST["qualification"];
    $experience = $_POST["experience"];
    $consultation_fee = $_POST["consultation_fee"];
    $sql = "UPDATE doctors SET department_id='$department_id', specialization='$specialization', qualification='$qualification', experience='$experience', consultation_fee='$consultation_fee' WHERE doctor_id='$doctor_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: doctorManagement.php");
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}

$departmentOptions = mysqli_query($conn, "SELECT * FROM departments");
$doctorResult = mysqli_query($conn, "SELECT doctors.*, users.name, departments.department_name FROM doctors INNER JOIN users ON doctors.user_id=users.id LEFT JOIN departments ON doctors.department_id=departments.department_id");
if (!$departmentOptions || !$doctorResult) {
    die("Query failed: " . mysqli_error($conn));
}

$editDoctor = null;
if (isset($_GET["edit_doctor"])) {
    $doctor_id = $_GET["edit_doctor"];
    $editResult = mysqli_query($conn, "SELECT doctors.*, users.name FROM doctors INNER JOIN users ON doctors.user_id=users.id WHERE doctors.doctor_id='$doctor_id'");
    $editDoctor = mysqli_fetch_assoc($editResult);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Doctor Management</title>
    <style>
        body {
            background-color: #cfedfa;
            font-family: Arial, sans-serif;
        }

        input,
        select,
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
    </style>
</head>

<body>
    <h1>Doctor Management</h1>
    <form method="POST">
        <button type="submit" name="scan_doctors">Scan for New Doctors</button>
    </form>

    <table class="layout">
        <tr>
            <td>
                <h2>Doctors</h2>
                <table>
                    <tr>
                        <th>Doctor ID</th>
                        <th>User ID</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>Qualification</th>
                        <th>Experience</th>
                        <th>Fee</th>
                        <th>Action</th>
                    </tr>
                    <?php for ($i = 0; $i < mysqli_num_rows($doctorResult); $i++) {
                        $doctor = mysqli_fetch_assoc($doctorResult);
                        ?>
                        <tr>
                            <td><?php echo $doctor["doctor_id"]; ?></td>
                            <td><?php echo $doctor["user_id"]; ?></td>
                            <td><?php echo $doctor["name"]; ?></td>
                            <td><?php echo $doctor["department_name"] ?? ""; ?></td>
                            <td><?php echo $doctor["specialization"] ?? ""; ?></td>
                            <td><?php echo $doctor["qualification"] ?? ""; ?></td>
                            <td><?php echo $doctor["experience"] ?? ""; ?></td>
                            <td><?php echo $doctor["consultation_fee"] ?? ""; ?></td>
                            <td>
                                <form method="GET">
                                    <button type="submit" name="edit_doctor"
                                        value="<?php echo $doctor["doctor_id"]; ?>">Edit Details</button>
                                </form>
                                <a href="doctorAvailability.php?doctor_id=<?php echo $doctor["doctor_id"]; ?>"><button
                                        type="button">Availability</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td>

                <?php if ($editDoctor): ?>
                    <h2>Edit Doctor Details</h2>
                    <form method="POST">
                        <input type="hidden" name="doctor_id" value="<?php echo $editDoctor["doctor_id"]; ?>">
                        <table class="form-table">
                            <tr>
                                <td>Doctor ID</td>
                                <td><input type="text" value="<?php echo $editDoctor["doctor_id"]; ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>User ID</td>
                                <td><input type="text" value="<?php echo $editDoctor["user_id"]; ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Doctor Name</td>
                                <td><input type="text" value="<?php echo $editDoctor["name"]; ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Department</td>
                                <td><select name="department_id" required>
                                        <option value="">Select Department</option>
                                        <?php for ($i = 0; $i < mysqli_num_rows($departmentOptions); $i++) {
                                            $department = mysqli_fetch_assoc($departmentOptions);
                                            ?>
                                            <option value="<?php echo $department["department_id"]; ?>" <?php if ($editDoctor["department_id"] == $department["department_id"])
                                                   echo "selected"; ?>><?php echo $department["department_name"]; ?></option>
                                        <?php } ?>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Specialization</td>
                                <td><input type="text" name="specialization"
                                        value="<?php echo $editDoctor["specialization"] ?? ""; ?>" required></td>
                            </tr>
                            <tr>
                                <td>Qualification</td>
                                <td><input type="text" name="qualification"
                                        value="<?php echo $editDoctor["qualification"] ?? ""; ?>" required></td>
                            </tr>
                            <tr>
                                <td>Experience</td>
                                <td><input type="number" name="experience"
                                        value="<?php echo $editDoctor["experience"] ?? ""; ?>" required></td>
                            </tr>
                            <tr>
                                <td>Consultation Fee</td>
                                <td><input type="number" name="consultation_fee"
                                        value="<?php echo $editDoctor["consultation_fee"] ?? ""; ?>" required></td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="submit" name="edit_doctor">Save Changes</button>
                                    <a href="doctorManagement.php"><button type="button">Cancel Edit</button></a>
                                </td>
                            </tr>
                        </table>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</body>

</html>