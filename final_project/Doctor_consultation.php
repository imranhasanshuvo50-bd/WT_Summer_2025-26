<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MediCare | Consultation</title>

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

        /* Sidebar */

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

        .sidebar a:hover {
            background-color: #145a8a;
        }

        .sidebar a.active {
            background-color: #145a8a;
            border-left: 4px solid white;
        }

        .sidebar hr {
            border: none;
            border-top: 1px solid #1e5580;
            margin: 15px 20px;
        }

        /* Main content */

        .main-content {
            flex: 1;
            padding: 30px;
            max-width: 750px;
        }

        .main-content h1 {
            color: #0b3d66;
            margin-bottom: 20px;
        }

        /* Messages */

        .success {
            background-color: #e3f8e9;
            color: #1c7c3c;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .error {
            background-color: #fdeaea;
            color: #b32424;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        /* Patient information */

        .patient-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .patient-info p {
            margin-bottom: 8px;
        }

        /* Consultation form */

        .consult-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .consult-form label {
            display: block;
            font-weight: bold;
            color: #0b3d66;
            margin-top: 15px;
            margin-bottom: 6px;
        }

        .consult-form textarea,
        .consult-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .vitals {
            display: flex;
            gap: 10px;
        }

        .vitals input {
            flex: 1;
        }

        .buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .buttons button {
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        .save {
            background-color: #777;
        }

        .complete {
            background-color: #145a8a;
        }

    </style>

</head>


<?php

$patient_id = "P001";
$patient_name = "Rahim Ahmed";
$patient_age = 45;

if (isset($_GET["patient_id"])) 
    {
        $patient_id = $_GET["patient_id"];
    }


$symptoms = "";
$temperature = "";
$blood_pressure = "";
$heart_rate = "";
$diagnosis = "";
$history = "";

$success_message = "";
$error_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $symptoms = trim($_POST["symptoms"]);
    $temperature = trim($_POST["temperature"]);
    $blood_pressure = trim($_POST["blood_pressure"]);
    $heart_rate = trim($_POST["heart_rate"]);
    $diagnosis = trim($_POST["diagnosis"]);
    $history = trim($_POST["history"]);


    if ($symptoms == "" || $diagnosis == "") {

        $error_message = "Please fill in Symptoms and Diagnosis.";

    } else {

        if ($_POST["action"] == "save") {

            $success_message = "Consultation saved as draft.";

        }

        if ($_POST["action"] == "complete") {

            $success_message = "Consultation completed successfully.";

        }

    }

}

?>


<body>


    <!-- Sidebar -->

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php"> Dashboard</a>
        <a href="Doctor_patients.php"> Patients</a>
        <a href="Doctor_consultation.php" class="active">Consultation</a>
        <a href="Doctor_prescriptions.php">Prescriptions </a>
        <a href="Doctor_patient_flow.php">Patient Flow</a>

        <hr>

        <a href="Doctor_profile.php"> Profile</a>
        <a href="Doctor_change_password.php"> Change Password</a>

        <hr>

        <a href="Doctor_logout.php"> Logout</a>

    </div>


    <!-- Main content -->

    <div class="main-content">

        <h1>Consultation</h1>


        <?php if ($success_message != "") { ?>

            <div class="success">
                <?php echo $success_message; ?>
            </div>

        <?php } ?>


        <?php if ($error_message != "") { ?>

            <div class="error">
                <?php echo $error_message; ?>
            </div>

        <?php } ?>


        <!-- Patient information -->

        <div class="patient-info">

            <p>
                <strong>Patient ID:</strong>
                <?php echo $patient_id; ?>
            </p>

            <p>
                <strong>Patient Name:</strong>
                <?php echo $patient_name; ?>
            </p>

            <p>
                <strong>Age:</strong>
                <?php echo $patient_age; ?>
            </p>

        </div>


        <!-- Consultation form -->

        <form
            class="consult-form"
            method="post"
            action="Doctor_consultation.php?patient_id=<?php echo $patient_id; ?>"
        >


            <label for="symptoms"> Symptoms</label>

            <textarea id="symptoms" name="symptoms" rows="3">
                <?php echo htmlspecialchars($symptoms); ?>
            </textarea>


            <label> Vitals</label>

            <div class="vitals">

                <input type="text" name="temperature" placeholder="Temperature" value="<?php echo htmlspecialchars($temperature); ?>">

                <input
                    type="text"
                    name="blood_pressure"
                    placeholder="Blood Pressure"
                    value="<?php echo htmlspecialchars($blood_pressure); ?>"
                >

                <input
                    type="text"
                    name="heart_rate"
                    placeholder="Heart Rate"
                    value="<?php echo htmlspecialchars($heart_rate); ?>"
                >

            </div>


            <label for="diagnosis"> Diagnosis</label>

            <textarea id="diagnosis" name="diagnosis" rows="3">
                <?php echo htmlspecialchars($diagnosis); ?>
            </textarea>


            <label for="history">
                Previous Medical History
            </label>

            <textarea
                id="history"
                name="history"
                rows="2"
            ><?php echo htmlspecialchars($history); ?></textarea>


            <div class="buttons">

                <button
                    type="submit"
                    name="action"
                    value="save"
                    class="save"
                >Save Draft</button>


                <button
                    type="submit"
                    name="action"
                    value="complete"
                    class="complete"
                >Complete Consultation</button>

            </div>

        </form>

    </div>

</body>

</html>