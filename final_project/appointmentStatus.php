<?php
session_start();
include "config.php";

$appointments = [];

$email = $_SESSION["user-Email"] ?? "";

$sql = "SELECT 
            appointments.id,
            appointments.appointment_date,
            appointments.appointment_time,
            appointments.status,
            users.name AS doctor_name
        FROM appointments
        INNER JOIN patients
            ON appointments.patient_id = patients.patient_id
        INNER JOIN doctors
            ON appointments.doctor_id = doctors.doctor_id
        INNER JOIN users
            ON doctors.user_id = users.id
        WHERE patients.email = ?
        ORDER BY appointments.id DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = $row;
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Appointment Status</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>Appointment Status</label>
    </div>


    <?php if (count($appointments) > 0) { ?>

        <?php foreach ($appointments as $appointment) { ?>

            <div class="appointmentBox">

                <p>
                    <b>Doctor:</b>
                    <?php echo htmlspecialchars($appointment["doctor_name"]); ?>
                </p>

                <p>
                    <b>Date:</b>
                    <?php echo htmlspecialchars($appointment["appointment_date"]); ?>
                </p>

                <p>
                    <b>Time:</b>
                    <?php echo htmlspecialchars($appointment["appointment_time"]); ?>
                </p>

                <p>
                    <b>Status:</b>
                    <?php echo htmlspecialchars($appointment["status"]); ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p id="noResult">
            No appointments found.
        </p>

    <?php } ?>


    <div class="actionGroup">

        <a href="doctor&appointment_dashbord.php">

            <button id="backBtn">
                Back
            </button>

        </a>


        <a href="logout.php">

            <button id="logoutBtn">
                Logout
            </button>

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
    padding: 60px 50px;
    background-color: white;
    border: 2px solid #aeadad;
    border-radius: 8px;
    text-align: center;
}

#heading {
    font-size: 24px;
    margin-bottom: 30px;
}

.appointmentBox {
    width: 400px;
    padding: 15px;
    margin-bottom: 12px;
    text-align: left;
    background-color: #f8f9fa;
    border: 1px solid #aeadad;
    border-radius: 5px;
}

.appointmentBox p {
    margin: 7px;
}

#noResult {
    color: #dc3545;
}

.actionGroup {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}


#backBtn {
    width: 145px;
    padding: 10px 15px;
    font-size: 14px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}


#backBtn:hover {
    background-color: #218838;
}


#logoutBtn {
    width: 145px;
    padding: 10px 15px;
    font-size: 14px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}


#logoutBtn:hover {
    background-color: #a71d2a;
}
</style>

</body>
</html>