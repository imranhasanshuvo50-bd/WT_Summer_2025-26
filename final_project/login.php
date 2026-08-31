<?php

session_start();

$conn = mysqli_connect("localhost", "root", "", "projec");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION["user_id"])) {

    if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "doctor") {
        header("Location: Doctor_dashboard.php");
        exit();
    } else {
        header("Location: dashbord.php");
        exit();
    }
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_Email = trim($_POST["user-Email"]);
    $pass = $_POST["password"];

    $sql = "SELECT id, name, email, role, status, pass
            FROM users
            WHERE email = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "s", $user_Email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {

            $user = mysqli_fetch_assoc($result);

            if ($pass == $user["pass"]) {

                if (strtolower($user["status"]) != "active") {

                    $error = "Your account is inactive.";

                } else {

                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user-Email"] = $user["email"];
                    $_SESSION["user_name"] = $user["name"];
                    $_SESSION["user_role"] = strtolower($user["role"]);

                    if (strtolower($user["role"]) == "doctor") {

                        $doctor_sql = "SELECT doctor_id
                                       FROM doctors
                                       WHERE user_id = ?
                                       LIMIT 1";

                        $doctor_stmt = mysqli_prepare($conn, $doctor_sql);

                        if ($doctor_stmt) {

                            mysqli_stmt_bind_param(
                                $doctor_stmt,
                                "i",
                                $user["id"]
                            );

                            mysqli_stmt_execute($doctor_stmt);

                            $doctor_result = mysqli_stmt_get_result($doctor_stmt);

                            if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {

                                $doctor = mysqli_fetch_assoc($doctor_result);

                                $_SESSION["doctor_id"] = $doctor["doctor_id"];

                            } else {

                                $error = "Doctor profile was not found.";

                                session_unset();
                                session_destroy();
                            }

                            mysqli_stmt_close($doctor_stmt);

                        } else {

                            $error = "Could not find doctor profile.";

                            session_unset();
                            session_destroy();
                        }

                        if ($error == "") {
                            header("Location: Doctor_dashboard.php");
                            exit();
                        }

                    } else {

                        header("Location: dashbord.php");
                        exit();
                    }
                }

            } else {

                $error = "Invalid user-Email or password.";
            }

        } else {

            $error = "Invalid user-Email or password.";
        }

        mysqli_stmt_close($stmt);

    } else {

        $error = "Login query failed.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login</title>

</head>

<body>

    <form method="post" action="" id="login">

        <div class="header">

            <label id="header">MediCare</label>

            <label id="subheader">Login to your portal</label>

        </div>

        <?php if ($error != "") { ?>

            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php } ?>

        <div class="form">

            <label for="user-Email">user-Email</label>

            <input
                type="text"
                id="user-Email"
                name="user-Email"
                placeholder="Enter user-Email"
                required
            >

        </div>

        <div class="form">

            <label for="password">Password</label>

            <div class="passwordSection">

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >

                <button
                    type="button"
                    id="showPasswordBtn"
                    onclick="viewPassword()"
                >
                    Show
                </button>

            </div>

        </div>

        <div class="checkbox-wrapper">

            <input
                type="checkbox"
                name="remember"
                id="remember"
            >

            <label for="remember">Remember me</label>

        </div>

        <input
            type="submit"
            id="loginBtn"
            value="Login"
        >

    </form>

    <script>

        function viewPassword() {

            var passwordInput = document.getElementById("password");
            var showPasswordBtn = document.getElementById("showPasswordBtn");

            if (passwordInput.type === "password") {

                passwordInput.type = "text";
                showPasswordBtn.textContent = "Hide";

            } else {

                passwordInput.type = "password";
                showPasswordBtn.textContent = "Show";
            }
        }

    </script>

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
        }

        #login {
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

        label {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            color: #0f172a;
            outline: none;
        }

        .passwordSection {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .passwordSection input {
            padding-right: 60px;
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

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
            margin-top: 15px;
        }

        .checkbox-wrapper input {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .checkbox-wrapper label {
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
        }

        #loginBtn {
            width: 100%;
            background-color: #0284c7;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
        }

        #loginBtn:hover {
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

    </style>

</body>

</html>

