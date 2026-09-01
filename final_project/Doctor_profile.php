
<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT users.name, users.email,
               doctors.specialization,
               doctors.qualification,
               doctors.experience,
               doctors.consultation_fee
        FROM users
        JOIN doctors ON users.id = doctors.user_id
        WHERE users.id = $user_id";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Doctor profile not found.");
}

$doctor = mysqli_fetch_assoc($result);

$name = $doctor["name"];
$email = $doctor["email"];
$specialization = $doctor["specialization"];
$qualification = $doctor["qualification"];
$experience = $doctor["experience"];
$consultation_fee = $doctor["consultation_fee"];

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $specialization = trim($_POST["specialization"]);
    $qualification = trim($_POST["qualification"]);
    $experience = trim($_POST["experience"]);
    $consultation_fee = trim($_POST["consultation_fee"]);

    if (
        $name == "" ||
        $email == "" ||
        $specialization == "" ||
        $qualification == "" ||
        $experience == "" ||
        $consultation_fee == ""
    ) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email.";
    } else {

        $sql1 = "UPDATE users
                 SET name = '$name',
                     email = '$email'
                 WHERE id = $user_id";

        $sql2 = "UPDATE doctors
                 SET specialization = '$specialization',
                     qualification = '$qualification',
                     experience = '$experience',
                     consultation_fee = '$consultation_fee'
                 WHERE user_id = $user_id";

        if (mysqli_query($connection, $sql1) && mysqli_query($connection, $sql2)) {

            $_SESSION["user_name"] = $name;
            $_SESSION["user-Email"] = $email;

            $success_message = "Profile updated successfully.";

        } else {
            $error_message = "Profile update failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        .sidebar {
            width: 220px;
            background-color: #0b3d66;
            color: white;
            padding: 20px 0;
            min-height: 100vh;
        }

        .sidebar h2 {
            padding: 0 20px 20px;
            font-size: 18px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
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
            max-width: 600px;
            padding: 30px;
        }

        .main-content h1 {
            color: #0b3d66;
            margin-bottom: 20px;
        }

        .success,
        .error {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .success {
            background-color: #e3f8e9;
            color: #1c7c3c;
        }

        .error {
            background-color: #fdeaea;
            color: #b32424;
        }

        .box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .box label {
            display: block;
            margin-top: 12px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #0b3d66;
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

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php">Dashboard</a>
        <a href="Doctor_patients.php">Patients</a>
        <a href="Doctor_consultation.php">Consultation</a>
        <a href="Doctor_prescriptions.php">Prescriptions</a>
        <a href="Doctor_patient_flow.php">Patient Flow</a>

        <hr>

        <a href="Doctor_profile.php" class="active">Profile</a>
        <a href="Doctor_change_password.php">Change Password</a>

        <hr>

        <a href="logout.php">Logout</a>

    </div>

    <div class="main-content">

        <h1>My Profile</h1>

        <?php if ($success_message != ""): ?>
            <div class="success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message != ""): ?>
            <div class="error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form class="box" method="post" action="Doctor_profile.php">

            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo htmlspecialchars($name); ?>"
                required
            >

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo htmlspecialchars($email); ?>"
                required
            >

            <label for="specialization">Specialization</label>
            <input
                type="text"
                id="specialization"
                name="specialization"
                value="<?php echo htmlspecialchars($specialization); ?>"
                required
            >

            <label for="qualification">Qualification</label>
            <input
                type="text"
                id="qualification"
                name="qualification"
                value="<?php echo htmlspecialchars($qualification); ?>"
                required
            >

            <label for="experience">Experience</label>
            <input
                type="number"
                id="experience"
                name="experience"
                value="<?php echo htmlspecialchars($experience); ?>"
                required
            >

            <label for="consultation_fee">Consultation Fee</label>
            <input
                type="number"
                id="consultation_fee"
                name="consultation_fee"
                value="<?php echo htmlspecialchars($consultation_fee); ?>"
                required
            >

            <button type="submit">Update Profile</button>

        </form>

    </div>

</body>
</html>

