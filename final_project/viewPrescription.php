<?php
session_start();
include "config.php";

$email = $_SESSION["user-Email"] ?? "";
$user_id = 0;
$prescriptions = [];

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
                p.prescription_id,
                p.medicine_name,
                p.dosage,
                p.duration,
                p.instructions,
                u.name AS doctor_name
            FROM prescriptions p
            LEFT JOIN doctors d
                ON p.doctor_id = d.doctor_id
            LEFT JOIN users u
                ON d.user_id = u.id
            WHERE p.patient_id = ?
            ORDER BY p.prescription_id DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $prescriptions[] = $row;
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Prescription</title>
</head>

<body>

<div class="container">

    <div id="heading">
        View Prescription
    </div>

    <?php if (count($prescriptions) > 0) { ?>

        <?php foreach ($prescriptions as $prescription) { ?>

            <div class="recordBox">

                <p>
                    <b>Doctor:</b>
                    <?php echo htmlspecialchars($prescription["doctor_name"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Medicine:</b>
                    <?php echo htmlspecialchars($prescription["medicine_name"]); ?>
                </p>

                <p>
                    <b>Dosage:</b>
                    <?php echo htmlspecialchars($prescription["dosage"]); ?>
                </p>

                <p>
                    <b>Duration:</b>
                    <?php echo htmlspecialchars($prescription["duration"]); ?>
                </p>

                <p>
                    <b>Instructions:</b>
                    <?php echo htmlspecialchars($prescription["instructions"]); ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p id="noResult">No prescription found.</p>

    <?php } ?>

    <div class="actionGroup">

        <a href="medicalRecordPrescription.php">
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
    width: 550px;
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
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    color: white;
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