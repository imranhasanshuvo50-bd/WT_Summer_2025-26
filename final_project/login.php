
<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_Email = $_POST["user-Email"];
    $pass = $_POST["password"];
    $remember = isset($_POST["remember"]);

    $sql = "SELECT * FROM USERS WHERE EMAIL = '$user_Email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if ($user["pass"] == $pass) {

            $_SESSION["user-Email"] = $user["email"];
            $_SESSION["user_id"] = $user["id"];

            if ($remember) {
                setcookie(
                    "user-Email",$user_Email,time() + (86400 * 30),"/");
            }

            if ($user["role"] == "admin" && $user["status"] == "Active") {
                header("Location: dashbord_admin.php");
                exit();
            }

        } else {
            $error = "Invalid user-Email or password";
        }

    } else {
        $error = "Invalid user-Email or password";
    }
}
?>


<!DOCTYPE html>
<html>

<head>

    <title>Login</title>

</head>

<body>

    <form method="post" action="" id="login">
        <div class="header">
            <label id="header">MediCare</label>
            <label id="subheader">Login to your portal</label>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>



        <div class="form">
            <label for="user-Email">user-Email</label>
            <input type="text" id="user-Email" name="user-Email" placeholder="Enter user-Email" required>
        </div>

        <div class="form">
            <label for="password">Password</label>
            <div class="passwordSection">
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <button type="button" id="showPasswordBtn" onclick="viewPassword()">Show</button>
            </div>
        </div>

        <div class="checkbox-wrapper">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>
        </div>

        <input type="submit" id="loginBtn" value="Login"><br>
        <div class="link-section">
           <br> Don't have an account? <a href="signup.php">Sign up here</a>
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

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;

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
        #link {
           width: 100%;
            background-color: #0284c7;
            color: white;
            border: none;
            padding: 5px;
            font-size: 10px;
            font-weight: 800;
            border-radius: 8px;
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
            font-size: 14px;
            color: #64748b;
            padding: 5px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }

        .checkbox-wrapper input {
            width: 16px;
            height: 16px;

        }

        .checkbox-wrapper label {
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;

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