<?php
session_start();
include "config.php";

$message = "";

$email = $_SESSION["user-Email"] ?? "";

$patient_id = 0;

$sql = "SELECT patient_id
        FROM patients
        WHERE email = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $patient_id = $row["patient_id"];
}

mysqli_stmt_close($stmt);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $appointment_id = (int)$_POST["appointment_id"];

    $sql = "UPDATE appointments
            SET status = 'Cancelled'
            WHERE id = ?
            AND patient_id = ?
            AND status IN ('Pending', 'Waiting')";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $appointment_id,
        $patient_id
    );

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $message = "Appointment cancelled successfully.";
    } else {
        $message = "Appointment could not be cancelled.";
    }

    mysqli_stmt_close($stmt);
}


$appointments = [];

$sql = "SELECT 
            appointments.id,
            appointments.appointment_date,
            appointments.appointment_time,
            appointments.status,
            users.name AS doctor_name
        FROM appointments
        INNER JOIN doctors
            ON appointments.doctor_id = doctors.doctor_id
        INNER JOIN users
            ON doctors.user_id = users.id
        WHERE appointments.patient_id = ?
        AND appointments.status IN ('Pending', 'Waiting')
        ORDER BY appointments.id DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
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
    <title>Cancel Appointment</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>Cancel Appointment</label>
    </div>


    <?php if (!empty($message)) { ?>

        <p id="message">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>


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


                <form method="post">

                    <input 
                        type="hidden"
                        name="appointment_id"
                        value="<?php echo $appointment["id"]; ?>"
                    >

                    <button type="submit" class="cancelBtn">
                        Cancel Appointment
                    </button>

                </form>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p id="noResult">
            No cancellable appointments found.
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

.cancelBtn {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.cancelBtn:hover {
    background-color: #a71d2a;
}

#message {
    color: #28a745;
    margin-bottom: 15px;
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