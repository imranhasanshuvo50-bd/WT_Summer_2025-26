<?php

$name = "Dr. Imran Hasan";
$email = "imran.doctor@medicare.com";
$phone = "01711111111";
$department = "Medicine";

$success_message = "";
$error_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $department = trim($_POST["department"]);


    if ($name == "" || $email == "" || $phone == "" || $department == "") {

        $error_message = "All fields are required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error_message = "Please enter a valid email address.";

    } else {

        $success_message = "Profile updated successfully.";

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>MediCare | My Profile</title>


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
            max-width: 600px;
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


        /* Profile form */

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

        <a href="Doctor_profile.php" class="active">
            Profile
        </a>

        <a href="Doctor_change_password.php">
            Change Password
        </a>

        <hr>

        <a href="Doctor_logout.php">
            Logout
        </a>

    </div>


    <!-- Main content -->

    <div class="main-content">

        <h1>My Profile</h1>


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
            action="Doctor_profile.php"
        >


            <label for="name">
                Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo htmlspecialchars($name); ?>"
            >


            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo htmlspecialchars($email); ?>"
            >


            <label for="phone">
                Phone
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="<?php echo htmlspecialchars($phone); ?>"
            >


            <label for="department">
                Department
            </label>

            <input
                type="text"
                id="department"
                name="department"
                value="<?php echo htmlspecialchars($department); ?>"
            >


            <button type="submit">
                Update Profile
            </button>


        </form>

    </div>


</body>

</html>