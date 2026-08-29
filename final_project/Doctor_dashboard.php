<?php
$today_appointments = 8;
$pending_consultations = 3;
$admitted_patients = 5;

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
                <p class="label">Today's Appointments</p>
                <p class="number"><?php echo $today_appointments; ?></p>
            </div>

            <div class="card">
                <p class="label">Pending Consultations</p>
                <p class="number"><?php echo $pending_consultations; ?></p>
            </div>

            <div class="card">
                <p class="label">Admitted Patients</p>
                <p class="number"><?php echo $admitted_patients; ?></p>
            </div>
        </div>

        <h2>Quick Links</h2>

        <div class="quick-links">
            <a href="Doctor_patients.php">View Patients</a>
            <a href="Doctor_consultation.php">Consultation</a>
            <a href="Doctor_prescriptions.php">Prescriptions</a>
            <a href="Doctor_patient_flow.php">Patient Flow</a>
        </div>

        <h2>Notifications</h2>

        <div class="notifications">
            <ul>
                <?php
                foreach ($notifications as $note) {
                    echo "<li>$note</li>";
                }
                ?>
            </ul>
        </div>
    </div>

</body>
</html>