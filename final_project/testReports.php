<?php
session_start();
include "config.php";

$email = $_SESSION["user-Email"] ?? "";
$patient_id = 0;
$reports = [];

$sql = "SELECT p.patient_id
        FROM patients p
        INNER JOIN users u
            ON p.user_id = u.id
        WHERE u.email = ?
        AND u.role = 'patient'
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $patient_id = $row["patient_id"];
}

mysqli_stmt_close($stmt);

if ($patient_id > 0) {

    $sql = "SELECT
                t.report_id,
                t.test_name,
                t.test_date,
                t.result,
                t.remarks,
                u.name AS doctor_name
            FROM test_reports t
            LEFT JOIN doctors d
                ON t.doctor_id = d.doctor_id
            LEFT JOIN users u
                ON d.user_id = u.id
            WHERE t.patient_id = ?
            ORDER BY t.test_date DESC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $reports[] = $row;
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Reports</title>
</head>

<body>

<div class="container">

    <div id="heading">
        View Test Reports
    </div>

    <?php if (count($reports) > 0) { ?>

        <?php foreach ($reports as $report) { ?>

            <div class="recordBox">

                <p>
                    <b>Test:</b>
                    <?php echo htmlspecialchars($report["test_name"]); ?>
                </p>

                <p>
                    <b>Doctor:</b>
                    <?php echo htmlspecialchars($report["doctor_name"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Test Date:</b>
                    <?php echo htmlspecialchars($report["test_date"]); ?>
                </p>

                <p>
                    <b>Result:</b>
                    <?php echo htmlspecialchars($report["result"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Remarks:</b>
                    <?php echo htmlspecialchars($report["remarks"] ?? "No Remarks"); ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p id="noResult">No test reports found.</p>

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