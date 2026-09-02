<?php

// Database
session_start();

$conn = mysqli_connect("localhost", "root", "", "projec");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


// Check login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


// Check doctor role
if (
    !isset($_SESSION["user_role"]) ||
    $_SESSION["user_role"] != "doctor"
) {
    die("Access denied. Doctor login required.");
}


// Get logged-in user
$user_id = $_SESSION["user_id"];


// Get doctor information
$doctor_id = 0;

$sql = "SELECT doctor_id
        FROM doctors
        WHERE user_id = ?
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $doctor = mysqli_fetch_assoc($result);
        $doctor_id = $doctor["doctor_id"];
    }

    mysqli_stmt_close($stmt);
}


// Testing
$testing_message = "Logged-in User ID: " . $user_id;


// Get patients
$patients = array();

$sql = "SELECT DISTINCT
               users.id,
               users.name
        FROM users
        INNER JOIN appointments
            ON users.id = appointments.patient_id
        WHERE users.role = 'patient'
        AND appointments.doctor_id = ?
        ORDER BY users.name ASC";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $patients[$row["id"]] = $row["name"];
        }
    }

    mysqli_stmt_close($stmt);
}


// Select patient
$selected_patient = "";

if (isset($_GET["patient"])) {
    $selected_patient = $_GET["patient"];
}

if (
    $selected_patient == "" &&
    count($patients) > 0
) {
    $selected_patient = array_key_first($patients);
}


// Status option
$status_options = array(
    "Pending",
    "Waiting",
    "In Consultation",
    "Completed",
    "Cancelled"
);

$success_message = "";
$error_message = "";


// Update appointment status
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $selected_patient = $_POST["patient_id"] ?? "";
    $new_status = $_POST["new_status"] ?? "";

    if ($selected_patient == "") {

        $error_message = "Please select a patient.";

    } elseif ($new_status == "") {

        $error_message = "Please select a new status.";

    } else {

        $sql = "UPDATE appointments
                SET status = ?
                WHERE doctor_id = ?
                AND patient_id = ?
                ORDER BY id DESC
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "sii",
                $new_status,
                $user_id,
                $selected_patient
            );

            if (mysqli_stmt_execute($stmt)) {

                if (mysqli_stmt_affected_rows($stmt) > 0) {

                    $success_message =
                        "Patient status updated successfully.";

                } else {

                    $error_message =
                        "No appointment was changed.";
                }

            } else {

                $error_message =
                    "Error updating patient status.";
            }

            mysqli_stmt_close($stmt);

        } else {

            $error_message =
                "Could not prepare update query.";
        }
    }
}


// Get current status
$current_status = "No appointment";

if ($selected_patient != "") {

    $sql = "SELECT status
            FROM appointments
            WHERE doctor_id = ?
            AND patient_id = ?
            ORDER BY id DESC
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $user_id,
            $selected_patient
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (
            $result &&
            mysqli_num_rows($result) > 0
        ) {

            $row = mysqli_fetch_assoc($result);

            $current_status = $row["status"];
        }

        mysqli_stmt_close($stmt);
    }
}


// Get patient history
$patient_history = array();

if ($selected_patient != "") {

    $sql = "SELECT status, created_at
            FROM appointments
            WHERE doctor_id = ?
            AND patient_id = ?
            ORDER BY id DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $user_id,
            $selected_patient
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result) {

            while ($row = mysqli_fetch_assoc($result)) {
                $patient_history[] = $row;
            }
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        MediCare | Patient Flow
    </title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f6f8;
        }

        .sidebar {
            width: 220px;
            background-color: #0b3d66;
            color: white;
            padding: 20px 0;
        }

        .sidebar h2 {
            padding: 0 20px 20px;
            font-size: 18px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
        }

        .sidebar a:hover {
            background-color: #145a8a;
        }

        .sidebar a.active {
            background-color: #145a8a;
            border-left: 4px solid white;
        }

        .sidebar hr {
            border: none;
            border-top: 1px solid #1e5580;
            margin: 15px 20px;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            max-width: 750px;
        }

        .main-content h1 {
            color: #0b3d66;
            margin-bottom: 20px;
        }

        .main-content h2 {
            color: #0b3d66;
            margin-top: 25px;
            margin-bottom: 12px;
        }

        .success {
            background-color: #e3f8e9;
            color: #1c7c3c;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .error {
            background-color: #fdeaea;
            color: #b32424;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .testing {
            background-color: #eef3f7;
            color: #0b3d66;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .box label {
            display: block;
            font-weight: bold;
            color: #0b3d66;
            margin-top: 12px;
            margin-bottom: 6px;
        }

        .box select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .current-status {
            background-color: #eef3f7;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-weight: bold;
            color: #0b3d66;
        }

        .box button {
            margin-top: 15px;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            color: white;
            background-color: #145a8a;
            cursor: pointer;
        }

        .box button:hover {
            background-color: #0b3d66;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #0b3d66;
            color: white;
        }

        .no-history {
            background-color: white;
            padding: 15px;
        }

    </style>

</head>

<body>

    <!-- Sidebar -->

    <div class="sidebar">

        <h2>
            MediCare | Doctor
        </h2>

        <a href="Doctor_dashboard.php">
            Dashboard
        </a>

        <a href="Doctor_patients.php">
            Patients
        </a>

        <a href="Doctor_consultation.php">
            Consultation
        </a>

        <a href="Doctor_prescriptions.php">
            Prescriptions
        </a>

        <a
            href="Doctor_patient_flow.php"
            class="active"
        >
            Patient Flow
        </a>

        <hr>

        <a href="Doctor_profile.php">
            Profile
        </a>

        <a href="Doctor_change_password.php">
            Change Password
        </a>

        <hr>

        <a href="logout.php">
            Logout
        </a>

    </div>


    <!-- Main Content -->

    <div class="main-content">

        <h1>
            Patient Flow
        </h1>


        <!-- Testing -->

        <div class="testing">

            Logged-in User ID:
            <strong>
                <?php echo $user_id; ?>
            </strong>

        </div>


        <?php if ($success_message != "") { ?>

            <div class="success">

                <?php
                echo htmlspecialchars(
                    $success_message
                );
                ?>

            </div>

        <?php } ?>


        <?php if ($error_message != "") { ?>

            <div class="error">

                <?php
                echo htmlspecialchars(
                    $error_message
                );
                ?>

            </div>

        <?php } ?>


        <!-- Select patient -->

        <div class="box">

            <form
                method="get"
                action="Doctor_patient_flow.php"
            >

                <label>
                    Select Patient
                </label>


                <?php if (count($patients) > 0) { ?>

                    <select name="patient">

                        <?php
                        foreach (
                            $patients
                            as $id => $name
                        ) {
                        ?>

                            <option
                                value="<?php echo $id; ?>"
                                <?php

                                if (
                                    $id ==
                                    $selected_patient
                                ) {
                                    echo "selected";
                                }

                                ?>
                            >

                                <?php
                                echo htmlspecialchars(
                                    $name
                                );
                                ?>

                                (ID:
                                <?php echo $id; ?>
                                )

                            </option>

                        <?php } ?>

                    </select>


                    <button type="submit">

                        Select Patient

                    </button>


                <?php } else { ?>

                    <p>
                        No patients with appointments found.
                    </p>

                <?php } ?>

            </form>

        </div>


        <?php if ($selected_patient != "") { ?>


            <!-- Update status -->

            <div class="box">

                <label>
                    Current Status
                </label>


                <div class="current-status">

                    <?php
                    echo htmlspecialchars(
                        $current_status
                    );
                    ?>

                </div>


                <form
                    method="post"
                    action="Doctor_patient_flow.php?patient=<?php echo $selected_patient; ?>"
                >

                    <input
                        type="hidden"
                        name="patient_id"
                        value="<?php echo $selected_patient; ?>"
                    >


                    <label>
                        New Status
                    </label>


                    <select name="new_status">

                        <option value="">
                            -- Select Status --
                        </option>


                        <?php
                        foreach (
                            $status_options
                            as $status
                        ) {
                        ?>

                            <option
                                value="<?php echo htmlspecialchars($status); ?>"
                            >

                                <?php
                                echo htmlspecialchars(
                                    $status
                                );
                                ?>

                            </option>

                        <?php } ?>

                    </select>


                    <button type="submit">

                        Update Status

                    </button>

                </form>

            </div>


            <!-- Patients history -->

            <h2>
                Patient Flow History
            </h2>


            <?php
            if (
                count($patient_history) > 0
            ) {
            ?>


                <table>

                    <tr>

                        <th>
                            Date
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>


                    <?php
                    foreach (
                        $patient_history
                        as $flow
                    ) {
                    ?>

                        <tr>

                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $flow["created_at"]
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $flow["status"]
                                );
                                ?>

                            </td>

                        </tr>

                    <?php } ?>

                </table>


            <?php } else { ?>


                <p class="no-history">

                    No appointment history
                    for this patient yet.

                </p>


            <?php } ?>


        <?php } ?>

    </div>


</body>

</html>
