<?php

session_start();
include "config.php";

/* Check if doctor is logged in */

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$error_message = "";
$success_message = "";


/* Change Password */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $current_password = trim($_POST["current_password"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);


    /* Check empty fields */

    if ($current_password == "" || $new_password == "" || $confirm_password == "") {

        $error_message = "All fields are required.";

    } else {

        /* Get current password from database */

        $sql = "SELECT pass FROM users WHERE id = $user_id";

        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {

            $user = mysqli_fetch_assoc($result);

            $stored_password = $user["pass"];


            /* Check current password */

            if ($current_password != $stored_password) {

                $error_message = "Current password is incorrect.";

            }

            /* Check new password length */

            elseif (strlen($new_password) < 6) {

                $error_message = "New password must be at least 6 characters.";

            }

            /* Check password confirmation */

            elseif ($new_password != $confirm_password) {

                $error_message = "New Password and Confirm Password do not match.";

            }

            /* Update password */

            else {

                $update_sql = "UPDATE users 
                               SET pass = '$new_password' 
                               WHERE id = $user_id";

                if (mysqli_query($connection, $update_sql)) {

                    $success_message = "Password changed successfully.";

                } else {

                    $error_message = "Password change failed.";

                }
            }

        } else {

            $error_message = "User not found.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>MediCare | Change Password</title>


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


        

        .main-content {
            flex: 1;
            padding: 30px;
            max-width: 500px;
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


        /* Form */

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


        .box input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        .box button {
            margin-top: 20px;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            color: white;
            background-color: #145a8a;
            cursor: pointer;
        }


        .box button:hover {
            background-color: #0b3d66;
        }

    </style>

</head>


<body>


    <!-- Sidebar -->

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>


        <a href="Doctor_dashboard.php">
            Dashboard
        </a>


        <a href="Doctor_patients.php">
            Patients
        </a>


        <a href="Doctor_consultation.php">
            Consultation
        </a>


        <a href="Doctor_prescriptions.php">
            Prescriptions
        </a>


        <a href="Doctor_patient_flow.php">
            Patient Flow
        </a>


        <hr>


        <a href="Doctor_profile.php">
            Profile
        </a>


        <a href="Doctor_change_password.php" class="active">
            Change Password
        </a>


        <hr>


        <a href="Doctor_logout.php">
            Logout
        </a>

    </div>


    <!-- Main Content -->

    <div class="main-content">

        <h1>Change Password</h1>


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


        <form
            class="box"
            method="post"
            action="Doctor_change_password.php"
        >


            <label for="current_password">
                Current Password
            </label>

            <input
                type="password"
                id="current_password"
                name="current_password"
                required
            >


            <label for="new_password">
                New Password
            </label>

            <input
                type="password"
                id="new_password"
                name="new_password"
                required
            >


            <label for="confirm_password">
                Confirm Password
            </label>

            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                required
            >


            <button type="submit">
                Change Password
            </button>


        </form>

    </div>


</body>

</html>
