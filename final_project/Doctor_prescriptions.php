<?php

// Database
include "config.php";
session_start();


// Get patients
$patients = array();

$sql = "SELECT id, name FROM users WHERE role='patient' AND status='Active'";

$result = mysqli_query($connection, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $patients[$row["id"]] = $row["name"];
}


// Select patient
$selected_patient = "";

if (isset($_GET["patient"])) {
    $selected_patient = $_GET["patient"];
} else {
    foreach ($patients as $id => $name) {
        $selected_patient = $id;
        break;
    }
}


// Session
if (!isset($_SESSION["prescription_items"])) {
    $_SESSION["prescription_items"] = array();
}

$error_message = "";
$success_message = "";


// Add medicine
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["action"] == "add") {

        $medicine_name = trim($_POST["medicine_name"]);
        $dosage = trim($_POST["dosage"]);
        $frequency = $_POST["frequency"];
        $instructions = trim($_POST["instructions"]);

        if ($medicine_name == "" || $dosage == "") {
            $error_message = "Please enter medicine name and dosage.";
        } else {

            $_SESSION["prescription_items"][] = array(
                "medicine" => $medicine_name,
                "dosage" => $dosage,
                "frequency" => $frequency,
                "instructions" => $instructions
            );

            $success_message = "Medicine added successfully.";
        }
    }


    // Save prescription
    if ($_POST["action"] == "save") {

        if (count($_SESSION["prescription_items"]) == 0) {
            $error_message = "Please add at least one medicine.";
        } else {

            $doctor_id = 1;

            foreach ($_SESSION["prescription_items"] as $item) {

                $medicine_name = $item["medicine"];
                $dosage = $item["dosage"];
                $duration = $item["frequency"];
                $instructions = $item["instructions"];

                $sql = "INSERT INTO prescriptions
                        (doctor_id, patient_id, medicine_name, dosage, duration, instructions)
                        VALUES
                        ('$doctor_id', '$selected_patient', '$medicine_name', '$dosage', '$duration', '$instructions')";

                $result = mysqli_query($connection, $sql);

                if (!$result) {
                    $error_message = "Prescription could not be saved.";
                }
            }

            if ($error_message == "") {
                $success_message = "Prescription saved successfully.";
                $_SESSION["prescription_items"] = array();
            }
        }
    }
}


// Delete medicine
if (isset($_GET["delete"])) {

    $index = $_GET["delete"];

    if (isset($_SESSION["prescription_items"][$index])) {

        unset($_SESSION["prescription_items"][$index]);

        $_SESSION["prescription_items"] =
            array_values($_SESSION["prescription_items"]);

        $success_message = "Medicine deleted.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>MediCare | Prescriptions</title>

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

        .main-content h2 {
            color: #0b3d66;
            margin-top: 25px;
            margin-bottom: 12px;
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

        .box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .box label {
            display: block;
            font-weight: bold;
            color: #0b3d66;
            margin-top: 12px;
            margin-bottom: 6px;
        }

        .box input,
        .box select,
        .box textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .box button {
            margin-top: 15px;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            color: white;
            background-color: #145a8a;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #0b3d66;
            color: white;
        }

        .delete {
            color: #b32424;
            text-decoration: none;
        }

        .save-button {
            margin-top: 20px;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            color: white;
            background-color: #0b3d66;
            cursor: pointer;
        }

        .no-medicine {
            background-color: white;
            padding: 15px;
        }

    </style>

</head>

<body>

    <!-- Sidebar -->

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php">Dashboard</a>

        <a href="Doctor_patients.php">Patients</a>

        <a href="Doctor_consultation.php">Consultation</a>

        <a href="Doctor_prescriptions.php" class="active">
            Prescriptions
        </a>

        <a href="Doctor_patient_flow.php">Patient Flow</a>

        <hr>

        <a href="Doctor_profile.php">Profile</a>

        <a href="Doctor_change_password.php">
            Change Password
        </a>

        <hr>

        <a href="Doctor_logout.php">Logout</a>

    </div>


    <div class="main-content">

        <h1>Prescriptions</h1>


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


        <!-- Select patient -->

        <div class="box">

            <label>
                Patient
            </label>

            <form method="get" action="Doctor_prescriptions.php">

                <select name="patient">

                    <?php foreach ($patients as $id => $name) { ?>

                        <option
                            value="<?php echo $id; ?>"
                            <?php
                            if ($id == $selected_patient) {
                                echo "selected";
                            }
                            ?>
                        >
                            <?php
                            echo $name . " (Patient ID: " . $id . ")";
                            ?>
                        </option>

                    <?php } ?>

                </select>

                <button type="submit">
                    Select Patient
                </button>

            </form>

        </div>


        <!-- Add medicine -->

        <h2>Medicine Information</h2>

        <form
            class="box"
            method="post"
            action="Doctor_prescriptions.php?patient=<?php echo $selected_patient; ?>"
        >

            <label>
                Medicine Name
            </label>

            <input
                type="text"
                name="medicine_name"
                placeholder="Enter medicine name"
            >


            <label>
                Dosage
            </label>

            <input
                type="text"
                name="dosage"
                placeholder="Example: 500 mg"
            >


            <label>
                Frequency
            </label>

            <select name="frequency">

                <option value="1 time/day">
                    1 time/day
                </option>

                <option value="2 times/day">
                    2 times/day
                </option>

                <option value="3 times/day">
                    3 times/day
                </option>

            </select>


            <label>
                Instructions
            </label>

            <textarea
                name="instructions"
                rows="2"
                placeholder="Example: Take after food"
            ></textarea>


            <button
                type="submit"
                name="action"
                value="add"
            >
                Add Medicine
            </button>

        </form>


        <!-- Current prescription -->

        <h2>Current Prescription</h2>


        <?php if (count($_SESSION["prescription_items"]) > 0) { ?>

            <table>

                <tr>

                    <th>Medicine</th>

                    <th>Dosage</th>

                    <th>Frequency</th>

                    <th>Action</th>

                </tr>


                <?php foreach ($_SESSION["prescription_items"] as $index => $item) { ?>

                    <tr>

                        <td>
                            <?php
                            echo htmlspecialchars($item["medicine"]);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars($item["dosage"]);
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars($item["frequency"]);
                            ?>
                        </td>

                        <td>

                            <a
                                class="delete"
                                href="Doctor_prescriptions.php?patient=<?php echo $selected_patient; ?>&delete=<?php echo $index; ?>"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </table>


        <?php } else { ?>

            <p class="no-medicine">
                No medicines added yet.
            </p>

        <?php } ?>


        <!-- Save prescription -->

        <form
            method="post"
            action="Doctor_prescriptions.php?patient=<?php echo $selected_patient; ?>"
        >

            <button
                type="submit"
                name="action"
                value="save"
                class="save-button"
            >
                Save Prescription
            </button>

        </form>

    </div>

</body>

</html>
