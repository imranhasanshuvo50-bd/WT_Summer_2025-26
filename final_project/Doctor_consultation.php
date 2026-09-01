<?php

include "config.php";

$patient_id = "";

if (isset($_GET["patient_id"])) {
    $patient_id = $_GET["patient_id"];
}

$doctor_id = 1;

$patient_name = "";
$patient_age = "";
$patient_found = false;

if ($patient_id != "") {

    $sql = "SELECT * FROM users WHERE id = '$patient_id' AND role = 'patient'";

    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $patient = mysqli_fetch_assoc($result);

        $patient_name = $patient["name"];
        $patient_age = "Not available";
        $patient_found = true;
    }
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

    $action = $_POST["action"];

    if ($patient_id == "") {

        $error_message = "No patient selected.";

    } elseif ($symptoms == "" || $diagnosis == "") {

        $error_message = "Please fill in Symptoms and Diagnosis.";

    } else {

        $sql = "INSERT INTO consultations 
                (doctor_id, patient_id, symptoms, temperature, blood_pressure, heart_rate, diagnosis, medical_history) 
                VALUES 
                ('$doctor_id', '$patient_id', '$symptoms', '$temperature', '$blood_pressure', '$heart_rate', '$diagnosis', '$history')";

        $result = mysqli_query($connection, $sql);

        if ($result) {

            if ($action == "save") {

                $success_message = "Consultation saved as draft.";

            } else {

                $success_message = "Consultation completed successfully.";
            }

        } else {

            $error_message = "Error saving consultation: " . mysqli_error($connection);
        }
    }
}

?>

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

        .main-content {
            flex: 1;
            padding: 30px;
            max-width: 750px;
        }

        .main-content h1 {
            color: #0b3d66;
            margin-bottom: 20px;
        }

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

        .patient-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .patient-info p {
            margin-bottom: 8px;
        }

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

<body>

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php">Dashboard</a>

        <a href="Doctor_patients.php">Patients</a>

        <a href="Doctor_consultation.php" class="active">Consultation</a>

        <a href="Doctor_prescriptions.php">Prescriptions</a>

        <a href="Doctor_patient_flow.php">Patient Flow</a>

        <hr>

        <a href="Doctor_profile.php">Profile</a>

        <a href="Doctor_change_password.php">Change Password</a>

        <hr>

        <a href="logout.php">Logout</a>

    </div>

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

        <div class="patient-info">

            <?php if ($patient_found == true) { ?>

                <p>
                    <strong>Patient ID:</strong>
                    <?php echo $patient_id; ?>
                </p>

                <p>
                    <strong>Patient Name:</strong>
                    <?php echo htmlspecialchars($patient_name); ?>
                </p>

                <p>
                    <strong>Age:</strong>
                    <?php echo $patient_age; ?>
                </p>

            <?php } else { ?>

                <p>
                    <strong>No patient selected.</strong>
                </p>

                <p>
                    Please go to the Patients page and select a patient.
                </p>

            <?php } ?>

        </div>

        <?php if ($patient_found == true) { ?>

            <form
                class="consult-form"
                method="post"
                action="Doctor_consultation.php?patient_id=<?php echo $patient_id; ?>"
            >

                <label for="symptoms">
                    Symptoms
                </label>

                <textarea
                    id="symptoms"
                    name="symptoms"
                    rows="3"
                ><?php echo htmlspecialchars($symptoms); ?></textarea>

                <label>
                    Vitals
                </label>

                <div class="vitals">

                    <input
                        type="text"
                        name="temperature"
                        placeholder="Temperature"
                        value="<?php echo htmlspecialchars($temperature); ?>"
                    >

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

                <label for="diagnosis">
                    Diagnosis
                </label>

                <textarea
                    id="diagnosis"
                    name="diagnosis"
                    rows="3"
                ><?php echo htmlspecialchars($diagnosis); ?></textarea>

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
                    >
                        Save Draft
                    </button>

                    <button
                        type="submit"
                        name="action"
                        value="complete"
                        class="complete"
                    >
                        Complete Consultation
                    </button>

                </div>

            </form>

        <?php } ?>

    </div>

</body>

</html>
