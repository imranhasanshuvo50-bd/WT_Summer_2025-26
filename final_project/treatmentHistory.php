<?php
session_start();
include "config.php";

$email = $_SESSION["user-Email"] ?? "";
$user_id = 0;
$history = [];

$sql = "SELECT id
        FROM users
        WHERE email = ?
        AND role = 'patient'
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row["id"];
}

mysqli_stmt_close($stmt);

if ($user_id > 0) {

    $sql = "SELECT
                c.symptoms,
                c.temperature,
                c.blood_pressure,
                c.heart_rate,
                c.diagnosis,
                c.medical_history,
                u.name AS doctor_name
            FROM consultations c
            LEFT JOIN doctors d
                ON c.doctor_id = d.doctor_id
            LEFT JOIN users u
                ON d.user_id = u.id
            WHERE c.patient_id = ?
            ORDER BY c.consultation_id DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $history[] = $row;
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Previous Treatment History</title>
</head>

<body>

<div class="container">

    <div id="heading">
        Previous Treatment History
    </div>

    <?php if (count($history) > 0) { ?>

        <?php foreach ($history as $record) { ?>

            <div class="recordBox">

                <p>
                    <b>Doctor:</b>
                    <?php echo htmlspecialchars($record["doctor_name"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Symptoms:</b>
                    <?php echo htmlspecialchars($record["symptoms"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Diagnosis:</b>
                    <?php echo htmlspecialchars($record["diagnosis"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Temperature:</b>
                    <?php echo htmlspecialchars($record["temperature"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Blood Pressure:</b>
                    <?php echo htmlspecialchars($record["blood_pressure"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Heart Rate:</b>
                    <?php echo htmlspecialchars($record["heart_rate"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Medical History:</b>
                    <?php echo htmlspecialchars($record["medical_history"] ?? "Not Available"); ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p id="noResult">No previous treatment history found.</p>

    <?php } ?>

    <div class="actionGroup">

        <a href="medicialrecord&prescription_dashboard.php">
            <button id="backBtn">Back</button>
        </a>

        <a href="logout.php">
            <button id="logoutBtn">Logout</button>
        </a>

    </div>

</div>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #cfedfa;
    font-family: Arial, sans-serif;
}

.container {
    width: 600px;
    padding: 50px;
    margin: 20px;
    background-color: white;
    border: 2px solid #aeadad;
    border-radius: 8px;
}

#heading {
    text-align: center;
    font-size: 24px;
    margin-bottom: 30px;
}

.recordBox {
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f8f9fa;
    border: 1px solid #aeadad;
    border-radius: 5px;
}

.recordBox p {
    margin: 8px 0;
}

#noResult {
    text-align: center;
    color: #dc3545;
}

.actionGroup {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 25px;
}

#backBtn,
#logoutBtn {
    width: 145px;
    padding: 10px;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#backBtn {
    background-color: #28a745;
}

#logoutBtn {
    background-color: #dc3545;
}

</style>

</body>
</html>