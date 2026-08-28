<?php
session_start();
?>

<!DOCTYPE html>

<html>
<head>
    <title>Patient Dashboard</title>
</head>

<body>

```
<div class="logoutContainer">

    <div id="welcome">
        Hello, <?php echo $_SESSION["user-Email"]; ?>
    </div>

    <div id="heading">
        <label>Patient Dashboard</label>
    </div>

    <a href="doctorAppointment.php">
        <button class="normalBtn">Doctor & Appointment</button>
    </a>

    <a href="medicalRecordPrescription.php">
        <button class="normalBtn">Medical Record & Prescription</button>
    </a>

    <a href="billingFeedback.php">
        <button class="normalBtn">Billing & Feedback</button>
    </a>

    <a href="logout.php">
        <button id="logoutBtn">Logout</button>
    </a>

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
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
        background-color: #cfedfa;
        font-family: Arial, sans-serif;
    }

    .logoutContainer {
        display: flex;
        flex-direction: column;
        padding: 60px 50px;
        margin: 20px;
        background-color: #ffffff;
        border: 2px solid #aeadad;
        border-radius: 8px;
        justify-content: center;
        align-items: center;
    }

    #welcome {
        color: #333;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    #heading {
        color: #333;
        font-size: 24px;
        margin-bottom: 30px;
    }

    .normalBtn {
        width: 300px;
        padding: 12px 20px;
        margin: 8px;
        font-size: 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .normalBtn:hover {
        background-color: #0056b3;
    }

    #logoutBtn {
        width: 300px;
        padding: 12px 20px;
        margin-top: 25px;
        font-size: 16px;
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
```

</body>
</html>
