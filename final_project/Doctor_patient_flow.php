<?php

session_start();

$patients = array(
    "P001" => "Rahim Ahmed",
    "P002" => "Karim Hasan",
    "P003" => "Nabila"
);

$default_status = array(
    "P001" => "Waiting",
    "P002" => "In Consultation",
    "P003" => "Admitted"
);

$selected_patient = "P001";

if (isset($_GET["patient"])) 
    {
        $selected_patient = $_GET["patient"];
    }


$status_options = array(
    "Waiting",
    "In Consultation",
    "Admitted",
    "Discharged",
    "Referred",
    "ICU",
    "CCU"
);


if (!isset($_SESSION["patient_flow"])) 
    {

        $_SESSION["patient_flow"] = array();

    }


$success_message = "";
$error_message = "";


/* patient status Update  */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_status = $_POST["new_status"];
    $note = trim($_POST["note"]);


    if ($new_status == "") {

        $error_message = "Please select a new status.";

    } else {

        $_SESSION["patient_flow"][] = array(
            "patient_id" => $selected_patient,
            "date" => date("d-m-Y"),
            "status" => $new_status,
            "note" => $note
        );

        $success_message = "Patient status updated successfully.";

    }

}


$current_status = $default_status[$selected_patient];


foreach ($_SESSION["patient_flow"] as $flow) 
    {

        if ($flow["patient_id"] == $selected_patient) {

            $current_status = $flow["status"];

    }

    }

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>MediCare | Patient Flow</title>


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



        .box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }


        .box label {
            display: block;
            font-weight: bold;
            color: #0b3d66;
            margin-top: 12px;
            margin-bottom: 6px;
        }


        .box select,
        .box textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        .current-status {
            background-color: #eef3f7;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-weight: bold;
            color: #0b3d66;
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


        .no-history {
            background-color: white;
            padding: 15px;
        }

    </style>

</head>


<body>


    <!-- Sidebar -->

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php"> Dashboard </a>
        <a href="Doctor_patients.php">Patients </a>
        <a href="Doctor_consultation.php">Consultation</a>
        <a href="Doctor_prescriptions.php">Prescriptions</a>
        <a href="Doctor_patient_flow.php" class="active">Patient Flow</a>

        <hr>

        <a href="Doctor_profile.php"> Profile</a>
        <a href="Doctor_change_password.php"> Change Password</a>

        <hr>

        <a href="Doctor_logout.php">Logout </a>

    </div>


    <!-- Main content -->

    <div class="main-content">

        <h1>Patient Flow</h1>


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

            <form method="get" action="Doctor_patient_flow.php">

                <label> Select Patient</label>

                <select name="patient">

                    <?php foreach ($patients as $id => $name) { ?>

                        <option
                            value="<?php echo $id; ?>"
                            <?php
                            if ($id == $selected_patient) {
                                echo "selected";
                            }
                            ?>>

                            <?php echo $name . " (" . $id . ")"; ?>

                        </option>

                    <?php } ?>

                </select>


                <button type="submit">Select Patient</button>

            </form>

        </div>


        <!-- Update status -->

        <div class="box">

            <label>Current Status</label>

            <div class="current-status">
                <?php echo $current_status; ?>
            </div>


            <form
                method="post"
                action="Doctor_patient_flow.php?patient=<?php echo $selected_patient; ?>">

                <label>New Status</label>

                <select name="new_status">

                    <option value="">
                        -- Select Status --
                    </option>

                    <?php foreach ($status_options as $status) { ?>

                        <option value="<?php echo $status; ?>">
                            <?php echo $status; ?>
                        </option>

                    <?php } ?>

                </select>


                <label>Reason / Note</label>

                <textarea
                    name="note"
                    rows="2"
                    placeholder="Enter reason or note"
                ></textarea>


                <button type="submit"> Update Status</button>

            </form>

        </div>


        <!-- Patient history -->

        <h2>Patient Flow History</h2>


        <?php

        $patient_history = array();

        foreach ($_SESSION["patient_flow"] as $flow) {

            if ($flow["patient_id"] == $selected_patient) {

                $patient_history[] = $flow;

            }

        }

        ?>


        <?php if (count($patient_history) > 0) { ?>

            <table>

                <tr>

                    <th>Date</th>

                    <th>Status</th>

                    <th>Note</th>

                </tr>


                <?php foreach ($patient_history as $flow) { ?>

                    <tr>

                        <td>
                            <?php echo $flow["date"]; ?>
                        </td>

                        <td>
                            <?php echo $flow["status"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($flow["note"]); ?>
                        </td>

                    </tr>

                <?php } ?>

            </table>


        <?php } else { ?>

            <p class="no-history">
                No status history for this patient yet.
            </p>

        <?php } ?>


    </div>


</body>

</html>