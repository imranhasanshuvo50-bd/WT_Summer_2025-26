<?php
include "config.php";

$doctor_id = $_GET["doctor_id"] ;

if (isset($_POST["delete_availability"])) {
    $availability_id = $_POST["delete_availability"];
    $sql = "DELETE FROM doctor_availability WHERE availability_id='$availability_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: doctorAvailability.php?doctor_id=$doctor_id");
        exit();
    } else {
        die("Delete failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["add_availability"])) {
    $day_of_week = $_POST["day_of_week"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $sql = "INSERT INTO doctor_availability (doctor_id, day_of_week, start_time, end_time)
            VALUES ('$doctor_id', '$day_of_week', '$start_time', '$end_time')";

    if (mysqli_query($conn, $sql)) {
        header("Location: doctorAvailability.php?doctor_id=$doctor_id");
        exit();
    } else {
        die("Insert failed: " . mysqli_error($conn));
    }
}

if (isset($_POST["edit_availability"])) {
    $availability_id = $_POST["availability_id"];
    $day_of_week = $_POST["day_of_week"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $sql = "UPDATE doctor_availability SET day_of_week='$day_of_week', start_time='$start_time', end_time='$end_time' WHERE availability_id='$availability_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: doctorAvailability.php?doctor_id=$doctor_id");
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}

$doctorResult = mysqli_query($conn, "SELECT doctors.doctor_id, users.name FROM doctors INNER JOIN users ON doctors.user_id=users.id WHERE doctors.doctor_id='$doctor_id'");
$doctor = mysqli_fetch_assoc($doctorResult);

$availabilityResult = mysqli_query($conn, "SELECT * FROM doctor_availability WHERE doctor_id='$doctor_id'");
if (!$availabilityResult) {
    die("Query failed: " . mysqli_error($conn));
}

$editAvailability = null;
if (isset($_GET["edit_availability"])) {
    $availability_id = $_GET["edit_availability"];
    $editResult = mysqli_query($conn, "SELECT * FROM doctor_availability WHERE availability_id='$availability_id'");
    $editAvailability = mysqli_fetch_assoc($editResult);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Doctor Availability</title>
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
    <h1>Doctor Availability</h1>
    <a href="doctorManagement.php"><button type="button">Back to Doctors</button></a>

    <table class="layout">
        <tr>
            <td>
                <h2><?php echo $doctor["name"] ?? "Doctor"; ?></h2>
                <table>
                    <tr>
                        <th>Availability ID</th>
                        <th>Doctor ID</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                    <?php for ($i = 0; $i < mysqli_num_rows($availabilityResult); $i++) {
                        $availability = mysqli_fetch_assoc($availabilityResult);
                        ?>
                        <tr>
                            <td><?php echo $availability["availability_id"]; ?></td>
                            <td><?php echo $availability["doctor_id"]; ?></td>
                            <td><?php echo $availability["day_of_week"]; ?></td>
                            <td><?php echo $availability["start_time"]; ?></td>
                            <td><?php echo $availability["end_time"]; ?></td>
                            <td>
                                <form method="GET">
                                    <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                                    <button type="submit" name="edit_availability"
                                        value="<?php echo $availability["availability_id"]; ?>">Edit</button>
                                </form>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete?');">
                                    <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                                    <button type="submit" name="delete_availability"
                                        value="<?php echo $availability["availability_id"]; ?>">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td>
                <h2><?php echo $editAvailability ? "Edit Availability" : "Add Availability"; ?></h2>
                <form method="POST">
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                    <?php if ($editAvailability): ?>
                        <input type="hidden" name="availability_id"
                            value="<?php echo $editAvailability["availability_id"]; ?>">
                    <?php endif; ?>
                    <table class="form-table">
                        <tr>
                            <td>Doctor ID</td>
                            <td><input type="text" value="<?php echo $doctor_id; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td>Day of Week</td>
                            <td><input type="text" name="day_of_week"
                                    value="<?php echo $editAvailability["day_of_week"] ?? ""; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Start Time</td>
                            <td><input type="time" name="start_time"
                                    value="<?php echo $editAvailability["start_time"] ?? ""; ?>" required></td>
                        </tr>
                        <tr>
                            <td>End Time</td>
                            <td><input type="time" name="end_time"
                                    value="<?php echo $editAvailability["end_time"] ?? ""; ?>" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit"
                                    name="<?php echo $editAvailability ? "edit_availability" : "add_availability"; ?>"><?php echo $editAvailability ? "Save Changes" : "Save"; ?></button>
                                <?php if ($editAvailability): ?>
                                    <a href="doctorAvailability.php?doctor_id=<?php echo $doctor_id; ?>"><button
                                            type="button">Cancel Edit</button></a>
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