<?php
include "config.php";

$totalPatients = 0;
$activePatients = 0;
$inactivePatients = 0;

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='patient'");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalPatients = $row['total'];
}

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='patient' AND status='Active'");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $activePatients = $row['total'];
}

$inactivePatients = $totalPatients - $activePatients;

$totalRatings = 0;
$highestRating = 0;
$lowestRating = 0;
$averageRating = 0;

$result = mysqli_query($conn, "
    SELECT 
        COUNT(*) AS total,
        MAX(rating) AS highest,
        MIN(rating) AS lowest,
        AVG(rating) AS average
    FROM ratings
");

if ($result) {
    $row = mysqli_fetch_assoc($result);

    $totalRatings = $row['total'];
    $highestRating = $row['highest'];
    $lowestRating = $row['lowest'];
    $averageRating = $row['average'];
}

$totalAppointments = 0;
$completedAppointments = 0;
$pendingAppointments = 0;
$cancelledAppointments = 0;

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointments");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalAppointments = $row['total'];
}

$result = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM appointments 
    WHERE status='Completed'
");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $completedAppointments = $row['total'];
}

$result = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM appointments 
    WHERE status='Pending'
");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $pendingAppointments = $row['total'];
}

$result = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM appointments 
    WHERE status='Cancelled'
");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $cancelledAppointments = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Reports</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #cfedfa;
        }

        .container {
            width: 800px;
            margin: auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .report-box {
            background: white;
            padding: 20px;
            margin-bottom: 25px;
            border: 2px solid #aeadad;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #1714af;
            padding: 10px;
            background-color: #d0d0d0;
        }

        th {
            background-color: #1714af;
            color: white;
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

        .back-btn:hover {
            background: #0e0b7a;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="dashbord_admin.php" class="back-btn">Back to Dashboard</a>

    <h1>Clinic Monitoring & Reports</h1>

    <div class="report-box">

        <h2>Patient Statistics</h2>

        <table>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>

            <tr>
                <td>Total Patients</td>
                <td><?php echo $totalPatients; ?></td>
            </tr>

            <tr>
                <td>Active Patients</td>
                <td><?php echo $activePatients; ?></td>
            </tr>

            <tr>
                <td>Inactive Patients</td>
                <td><?php echo $inactivePatients; ?></td>
            </tr>
        </table>

    </div>

    <div class="report-box">

        <h2>Rating Statistics</h2>

        <table>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>

            <tr>
                <td>Total Number of Ratings</td>
                <td><?php echo $totalRatings; ?></td>
            </tr>

            <tr>
                <td>Highest Rating</td>
                <td><?php echo number_format($highestRating, 1); ?></td>
            </tr>

            <tr>
                <td>Lowest Rating</td>
                <td><?php echo number_format($lowestRating, 1); ?></td>
            </tr>

            <tr>
                <td>Average Rating</td>
                <td><?php echo number_format($averageRating, 1); ?></td>
            </tr>
        </table>

    </div>

    <div class="report-box">

        <h2>Appointment Statistics</h2>

        <table>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>

            <tr>
                <td>Total Appointments</td>
                <td><?php echo $totalAppointments; ?></td>
            </tr>

            <tr>
                <td>Completed Appointments</td>
                <td><?php echo $completedAppointments; ?></td>
            </tr>

            <tr>
                <td>Pending Appointments</td>
                <td><?php echo $pendingAppointments; ?></td>
            </tr>

            <tr>
                <td>Cancelled Appointments</td>
                <td><?php echo $cancelledAppointments; ?></td>
            </tr>
        </table>

    </div>

</div>

</body>
</html>