<?php
session_start();

if (!isset($_SESSION['queue'])) {
    $_SESSION['queue'] = [
        ["01", "John Doe", "Dr. Rashedin", "10 minutes", "Waiting"],
        ["02", "Sara Ahmed", "Dr. Karim", "18 minutes", "Waiting"],
        ["03", "Rahim Hasan", "Dr. Rashedin", "25 minutes", "Waiting"],
        ["04", "Nusrat Jahan", "Dr. Karim", "32 minutes", "Waiting"]
    ];
}

$queue = $_SESSION['queue'];
$currentPatient = $_SESSION['current_patient'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Waiting Queue</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f9ff;
            color: #172b4d;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #1f426b;
            padding-top: 25px;
        }

        .logo {
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 0 20px 35px;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            font-size: 14px;
        }

        .menu a:hover {
            background: #1556b0;
        }

        .menu a.active {
            background: #0b5ed7;
            border-left: 4px solid white;
        }

        .main {
            margin-left: 220px;
        }

        .topbar {
            height: 65px;
            background: white;
            border-bottom: 1px solid #dbe3ec;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 30px;
        }

        .profile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #172b4d;
        }

        .profile-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1f426b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .profile-name {
            display: flex;
            flex-direction: column;
        }

        .profile-name strong {
            font-size: 13px;
        }

        .profile-name span {
            font-size: 11px;
            color: #666;
        }

        .content {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 25px;
            color: #1f426b;
        }

        .page-header p {
            margin-top: 6px;
            color: #64748b;
            font-size: 14px;
        }

        .next-area {
            text-align: center;
        }

        .next-button {
            background: #1f426b;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .next-button:hover {
            background: #1556b0;
        }

        .waiting-count {
            margin-top: 7px;
            font-size: 12px;
            color: #64748b;
        }

        .current-patient {
            background: white;
            border: 1px solid #dbeafe;
            border-left: 4px solid #1f426b;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .queue-box {
            background: white;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #1f426b;
            color: white;
            text-align: left;
            padding: 15px;
            font-size: 13px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #edf2f7;
            font-size: 13px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #f8fbff;
        }

        .token,
        .status {
            color: #1f426b;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            color: #64748b;
        }

    </style>

</head>

<body>

    <div class="sidebar">

        <div class="logo">Medicare </div>

        <div class="menu">

            <a href="dashboard_reciption.php"> Dashboard </a>
            <a href="reciption_appointments.php"> Appointments </a>
            <a href="reciption_patients.php"> Patients </a>
            <a href="billing.php"> Billing </a>
            <a href="reciption_queue.php" class="active">  Queue </a>
            <a href="logout">   Logout </a>

        </div>

    </div>


    <div class="main">

        <div class="topbar">

            <a href="reciption_profile.php" class="profile-link">

                <div class="profile-photo"> N </div>
                <div class="profile-name">
                    <strong>Nusrat Jahan</strong>
                    <span> Receptionist</span>
                </div>

            </a>
        </div>


        <div class="content">

            <div class="page-header">

                <div>
                    <h1> Waiting Queue</h1>
                    <p> Manage patients currently waiting for consultation. </p>
                </div>


                <div class="next-area">
                    <form action="next_patient.php" method="post">
                        <button type="submit" class="next-button">  Next Patient</button>
                    </form>

                    <div class="waiting-count">
                        <?php echo count($queue); ?> Patients Waiting
                    </div>
                </div>
            </div>


            <?php if ($currentPatient) { ?>

                <div class="current-patient">

                    <strong>Current Patient: </strong>

                    Token <?php echo $currentPatient[0]; ?> -
                    <?php echo $currentPatient[1]; ?>  |
                    <?php echo $currentPatient[2]; ?>

                </div>

            <?php } ?>


            <div class="queue-box">
                <table>

                    <tr>
                        <th>Token</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Waiting Time</th>
                        <th>Status</th>
                    </tr>

                    <?php if (!empty($queue)) { ?>

                        <?php foreach ($queue as $patient) { ?>

                            <tr>
                                <td class="token">  <?php echo $patient[0]; ?> </td>
                                <td> <?php echo $patient[1]; ?> </td>
                                <td> <?php echo $patient[2]; ?> </td>
                                <td> <?php echo $patient[3]; ?> </td>

                                <td class="status"> <?php echo $patient[4]; ?> </td>
                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="5" class="empty"> No patients waiting. </td>
                        </tr>

                    <?php } ?>
                </table>

            </div>

        </div>

    </div>

</body>

</html>