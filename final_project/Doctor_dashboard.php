<?php

session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (
    !isset($_SESSION["user_role"]) ||
    $_SESSION["user_role"] != "doctor"
) {
    die("Access denied. Doctor login required.");
}

$user_id = $_SESSION["user_id"];
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

if ($doctor_id == 0) {
    die("Doctor profile not found.");
}

$today_appointments = 0;
$pending_consultations = 0;
$waiting_patients = 0;

$sql = "SELECT
            SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) AS today_appointments,
            SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS pending_consultations,
            SUM(CASE WHEN status = 'Waiting' THEN 1 ELSE 0 END) AS waiting_patients
        FROM appointments
        WHERE doctor_id = ?";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $doctor_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $summary = mysqli_fetch_assoc($result);

        $today_appointments = (int) $summary["today_appointments"];
        $pending_consultations = (int) $summary["pending_consultations"];
        $waiting_patients = (int) $summary["waiting_patients"];
    }

    mysqli_stmt_close($stmt);
}

$notifications = array(
    "New appointment assigned",
    "Lab report is ready",
    "Patient consultation pending"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>MediCare | Doctor Dashboard</title>

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

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #145a8a;
        }

        .sidebar a.active {
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
        }

        .main-content h1,
        .main-content h2 {
            color: #0b3d66;
        }

        .main-content h1 {
            margin-bottom: 20px;
        }

        .main-content h2 {
            margin: 30px 0 15px;
            font-size: 20px;
        }

        .cards {
            display: flex;
            gap: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            flex: 1;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card .label {
            color: #0b3d66;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card .number {
            font-size: 32px;
            color: #145a8a;
            font-weight: bold;
        }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .quick-links a {
            background-color: #145a8a;
            color: white;
            text-decoration: none;
            padding: 15px;
            border-radius: 6px;
            flex: 1 1 45%;
            text-align: center;
            font-weight: bold;
        }

        .quick-links a:hover {
            background-color: #0b3d66;
        }

        .notifications {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .notifications ul {
            padding-left: 20px;
        }

        .notifications li {
            margin-bottom: 8px;
        }

    </style>

</head>

<body>

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php" class="active">Dashboard</a>

        <a href="Doctor_patients.php">Patients</a>

        <a href="Doctor_consultation.php">Consultation</a>

        <a href="Doctor_prescriptions.php">Prescriptions</a>

        <a href="Doctor_patient_flow.php">Patient Flow</a>

        <hr>
        <a href="Doctor_profile.php">Profile</a>

        <a href="Doctor_change_password.php">Change Password</a>

        <hr>

        <a href="logout.php">Logout</a>

    </div>


    <div class="main-content">

        <h1>Dashboard</h1>


        <h2>Summary</h2>


        <div class="cards">

            <div class="card">

                <p class="label">
                    Today's Appointments
                </p>

                <p class="number">
                    <?php echo $today_appointments; ?>
                </p>

            </div>


            <div class="card">

                <p class="label">
                    Pending Consultations
                </p>

                <p class="number">
                    <?php echo $pending_consultations; ?>
                </p>

            </div>


            <div class="card">

                <p class="label">
                    Waiting Patients
                </p>

                <p class="number">
                    <?php echo $waiting_patients; ?>
                </p>

            </div>

        </div>


        <h2>Quick Links</h2>


        <div class="quick-links">

            <a href="Doctor_patients.php">
                View Patients
            </a>

            <a href="Doctor_consultation.php">
                Consultation
            </a>

            <a href="Doctor_prescriptions.php">
                Prescriptions
            </a>

            <a href="Doctor_patient_flow.php">
                Patient Flow
            </a>

        </div>


        <h2>Notifications</h2>


        <div class="notifications">

            <ul>

                <?php

                foreach ($notifications as $note)
                    {

                        echo "<li>$note</li>";

                    }

                ?>

            </ul>

        </div>

    </div>

</body>

</html>
