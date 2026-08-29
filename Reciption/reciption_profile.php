<?php

$name = "Nusrat Jahan";
$email = "nusrat@gmail.com";
$phone = "017XXXXXXXX";
$department = "Reception";
$role = "Receptionist";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Receptionist Profile</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fa;
            color: #172b4d;
        }


        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #17375e;
            padding-top: 25px;
        }

        .logo {
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 0 25px 35px;
        }

        .menu a {
            display: block;
            padding: 14px 25px;
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        .menu a:hover {
            background: #24558b;
        }


        .main {
            margin-left: 230px;
            min-height: 100vh;
        }

    

        .topbar {
            height: 70px;
            background: white;
            border-bottom: 1px solid #ddd;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            padding: 0 30px;
        }

        .profile-link {
            display: flex;
            align-items: center;
            gap: 10px;

            text-decoration: none;
            color: #172b4d;
        }

        .profile-photo {
            width: 40px;
            height: 40px;

            border-radius: 50%;
            background: #17375e;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;
        }

        .profile-name {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .profile-name strong {
            font-size: 13px;
        }

        .profile-name span {
            font-size: 11px;
            color: #666;
        }

        /* CONTENT */

        .content {
            padding: 30px 35px;
            max-width: 950px;
        }

        .page-title {
            color: #17375e;
            font-size: 26px;
            margin-bottom: 5px;
        }

        .page-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }


        .profile-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;

            padding: 25px;

            display: flex;
            align-items: center;

            margin-bottom: 25px;
        }

        .large-profile {
            width: 80px;
            height: 80px;

            border-radius: 50%;
            background: #17375e;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 28px;
            font-weight: bold;

            margin-right: 20px;
        }

        .profile-info h2 {
            color: #17375e;
            font-size: 21px;
            margin-bottom: 6px;
        }

        .profile-info p {
            color: #666;
            font-size: 14px;
        }


        .info-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;

            padding: 25px;
            margin-bottom: 25px;
        }

        .info-card h2 {
            color: #17375e;
            font-size: 19px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            gap: 20px;
            margin-bottom: 18px;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;

            font-size: 13px;
            color: #555;

            margin-bottom: 7px;
        }

        .form-group input {
            width: 100%;

            padding: 11px;

            border: 1px solid #ccc;
            border-radius: 6px;

            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2878c8;
        }

        .save-button {
            background: #2878c8;
            color: white;

            border: none;

            padding: 11px 20px;

            border-radius: 6px;

            cursor: pointer;
        }

        .save-button:hover {
            background: #1d65a8;
        }


        .security-card {
            background: white;

            border: 1px solid #ddd;
            border-radius: 10px;

            padding: 25px;
        }

        .security-card h2 {
            color: #17375e;
            font-size: 19px;

            margin-bottom: 6px;
        }

        .security-card p {
            color: #666;
            font-size: 13px;

            margin-bottom: 18px;
        }

        details {
            margin-top: 10px;
        }

        summary {
            display: inline-block;

            background: #17375e;
            color: white;

            padding: 11px 20px;

            border-radius: 6px;

            cursor: pointer;

            font-size: 14px;

            list-style: none;
        }

        summary:hover {
            background: #24558b;
        }

        summary::-webkit-details-marker {
            display: none;
        }


        .password-form {
            margin-top: 20px;

            padding: 20px;

            background: #f8fafc;

            border: 1px solid #ddd;

            border-radius: 8px;
        }

        .password-form h3 {
            color: #17375e;

            font-size: 17px;

            margin-bottom: 18px;
        }

        .password-group {
            margin-bottom: 15px;
        }

        .password-group label {
            display: block;

            font-size: 13px;
            color: #555;

            margin-bottom: 7px;
        }

        .password-group input {
            width: 100%;

            padding: 11px;

            border: 1px solid #ccc;

            border-radius: 6px;
        }

        .update-button {
            background: #2878c8;

            color: white;

            border: none;

            padding: 11px 20px;

            border-radius: 6px;

            cursor: pointer;
        }

        .update-button:hover {
            background: #1d65a8;
        }

    </style>

</head>


<body>

    <div class="sidebar">

        <div class="logo">Medicare </div>

        <div class="menu">

            <a href="dashboard_reciption.php"> Dashboard </a>
            <a href="reciption_appointments.php"> Appointments </a>
            <a href="reciption_patients.php"> Patients </a>
            <a href="billing.php"> Billing </a>
            <a href="reciption_queue.php">  Queue </a>
            <a href="logout">   Logout </a>

        </div>

    </div>



 <div class="main">

    <div class="topbar">

        <a href="reciption_profile.php" class="profile-link">

            <div class="profile-photo"> N </div>

            <div class="profile-name">

                <strong> <?php echo $name; ?> </strong>
                <span>  <?php echo $role; ?>  </span>

            </div>

        </a>

    </div>

    <div class="content">

        <h1 class="page-title"> Profile  </h1>

        <p class="page-text"> Manage your profile information.  </p>


        <div class="profile-card">

            <div class="large-profile"> N </div>

            <div class="profile-info">

                <h2> <?php echo $name; ?> </h2>

                <p>
                    <?php echo $role; ?> |
                    <?php echo $department; ?>
                </p>

            </div>

        </div>


        <div class="info-card">

            <h2> Personal Information </h2>

            <div class="info-row">

                <div class="form-group">
                    <label> Name</label>
                    <input type="text" value="<?php echo $name; ?>" >
                </div>

                <div class="form-group">
                    <label> Email </label>
                    <input type="email" value="<?php echo $email; ?>">
                </div>

            </div>


            <div class="info-row">

                <div class="form-group">

                    <label> Phone </label>
                    <input type="text" value="<?php echo $phone; ?>" >

                </div>


                <div class="form-group">

                    <label> Department </label>
                    <input type="text" value="<?php echo $department; ?>">

                </div>

            </div>

            <button type="button" class="save-button" > Save Changes </button>

        </div>



        <div class="security-card">

            <h2>Security </h2>
            <p>Update your password to keep your account secure. </p>

            <details>
                <summary>  Change Password</summary>

                <div class="password-form">

                    <h3> Change Password</h3>

                    <div class="password-group">

                        <label> Current Password </label>
                        <input type="password"  placeholder="Enter current password">

                    </div>


                    <div class="password-group">

                        <label> New Password</label>
                        <input type="password" placeholder="Enter new password">
                    
                    </div>


                    <div class="password-group">

                        <label> Confirm New Password  </label>
                        <input type="password" placeholder="Confirm new password">

                    </div>

                    <button type="button" class="update-button"> Update password </button>

                </div>

            </details>

        </div>

    </div>

</div>

</body>

</html>