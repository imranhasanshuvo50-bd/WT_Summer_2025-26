<?php
session_start();
include "config.php";

if (isset($_SESSION["user-Email"])) {
    header("Location: dashbord.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $role = $_POST["role"];
    if ($role == "patient") {
        $status = "Active";
    } else {
        $status = "";
    }

    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $error = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (name, email, pass, role, status)
                VALUES ('$name', '$email', '$pass', '$role', '$status')";

        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful! Please login.";
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #e0f2fe;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        #signup {
            background-color: #ffffff;
            padding: 40px 30px;
            width: 100%;
            max-width: 420px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        #header {
            font-size: 32px;
            font-weight: 700;
            color: #0284c7;
            display: block;
        }

        #subheader {
            font-size: 15px;
            color: #64748b;
            margin-top: 4px;
            display: block;
        }

        .form {
            margin-bottom: 18px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            display: block;
            margin-bottom: 6px;
        }

        select,
        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            color: #0f172a;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .passwordSection {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .passwordSection input {
            padding-right: 45px;
        }

        #showPasswordBtn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: #64748b;
            padding: 5px;
        }

        #signupBtn {
            width: 100%;
            background-color: #0284c7;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        #signupBtn:hover {
            background-color: #0369a1;
        }

        .error-message {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 18px;
            text-align: center;
        }

        .success-message {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 18px;
            text-align: center;
        }

        .link-section {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #64748b;
        }

        .link-section a {
            color: #0284c7;
            text-decoration: none;
            font-weight: 600;
        }

        .link-section a:hover {
            color: #0369a1;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <form method="post" action="" id="signup">
        <div class="header">
            <label id="header">MediCare</label>
            <label id="subheader">Create your account</label>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="form">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter name" required>
        </div>

        <div class="form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required>
        </div>

        <div class="form">
            <label for="password">Password</label>
            <div class="passwordSection">
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <button type="button" id="showPasswordBtn" onclick="viewPassword()">Show</button>
            </div>
        </div>

        <div class="form">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
                <option value="receptionist">Receptionist</option>
            </select>
        </div>

        <input type="submit" id="signupBtn" value="Sign Up">

        <div class="link-section">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </form>

    <script>
        function viewPassword() {
            var passwordInput = document.getElementById("password");
            var showPasswordBtn = document.getElementById("showPasswordBtn");
            if (passwordInput.type == "password") {
                passwordInput.type = "text";
                showPasswordBtn.textContent = "Hide";
            } else {
                passwordInput.type = "password";
                showPasswordBtn.textContent = "Show";
            }
        }
    </script>
</body>

</html>