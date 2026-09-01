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

    $doctor_id = (int)$_POST["doctor_id"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];

    if ($patient_id == 0) {

        $message = "Patient account not found.";

    } else {

        $sql = "INSERT INTO appointments
                (doctor_id, patient_id, appointment_date, appointment_time, status)
                VALUES (?, ?, ?, ?, 'Pending')";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "iiss",
            $doctor_id,
            $patient_id,
            $appointment_date,
            $appointment_time
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Appointment booked successfully.";
        } else {
            $message = "Failed to book appointment.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Book Appointment</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>Book Appointment</label>
    </div>

    <?php if (!empty($message)) { ?>

        <p id="message">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>


    <form method="post">

        <select name="doctor_id" required>

            <option value="">Select Doctor</option>

            <?php

            $sql = "SELECT doctors.doctor_id, users.name
                    FROM doctors
                    INNER JOIN users
                    ON doctors.user_id = users.id
                    WHERE users.role = 'doctor'
                    AND users.status = 'Active'";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {

                echo "<option value='" . $row["doctor_id"] . "'>";
                echo htmlspecialchars($row["name"]);
                echo "</option>";
            }

            ?>

        </select>


        <input 
            type="date"
            name="appointment_date"
            required
        >


        <input 
            type="time"
            name="appointment_time"
            required
        >


        <button type="submit" class="normalBtn">
            Book Appointment
        </button>

    </form>


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

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

select,
input {
    width: 300px;
    padding: 12px;
    margin: 8px;
    font-size: 16px;
}

.normalBtn {
    width: 300px;
    padding: 12px;
    margin: 8px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
}

#message {
    margin-bottom: 15px;
    color: #28a745;
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