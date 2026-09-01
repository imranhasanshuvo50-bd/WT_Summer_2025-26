<?php
session_start();

$search = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST["search"];
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Doctor & Appointment</title>
    </head>

    <body>

        <div class="docappContainer">

            <div id="heading">
                <label>Doctor & Appointment</label>
            </div>

            <form method="post">

                <input 
                    type="text" 
                    name="search" 
                    id="searchBox"
                    placeholder="Search Doctor, Specialization or Department"
                    value="<?php echo htmlspecialchars($search); ?>"
                >

                <button type="submit" class="searchBtn">Search</button>

            </form>

            <a href="doctorProfile.php">
                <button class="normalBtn">View Doctor Profile</button>
            </a>

            <a href="checkAvailability.php">
                <button class="normalBtn">Check Availability</button>
            </a>

            <a href="bookAppointment.php"> 
                <button class="normalBtn">Book Appointment</button> 
            </a>

            <a href="appointmentStatus.php"> 
                <button class="normalBtn">View Appointment Status</button> 
            </a>

            <a href="cancelAppointment.php"> 
                <button class="normalBtn">Cancel Appointment</button>
            </a>

            <div class="actionGroup">

                <a href="patient_dashboard.php"> 
                    <button id="backBtn">Back</button> 
                </a>

                <a href="logout.php"> 
                    <button id="logoutBtn">Logout</button> 
                </a>

            </div>

        </div>


        <style>

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
                min-height: 100vh;
                background-color: #cfedfa;
                font-family: Arial, sans-serif;
            }

            .docappContainer {
                display: flex;
                flex-direction: column;
                padding: 60px 50px;
                margin: 20px;
                background-color: #ffffff;
                border: 2px solid #aeadad;
                border-radius: 8px;
                justify-content: center;
                align-items: center;
            }

            #heading {
                color: #333;
                font-size: 24px;
                margin-bottom: 30px;
            }

            form {
                display: flex;
                margin-bottom: 20px;
            }

            #searchBox {
                width: 300px;
                padding: 12px;
                font-size: 16px;
                border: 1px solid #aeadad;
                border-radius: 4px;
                outline: none;
            }

            .searchBtn {
                padding: 12px 20px;
                margin-left: 8px;
                font-size: 16px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .searchBtn:hover {
                background-color: #0056b3;
            }

            .normalBtn {
                width: 300px;
                padding: 12px 20px;
                margin: 8px;
                font-size: 16px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .normalBtn:hover {
                background-color: #0056b3;
            }

            .actionGroup {
                display: flex;
                gap: 10px;
                margin-top: 15px;
            }

            #backBtn {
                width: 145px;
                padding: 10px 15px;
                font-size: 14px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            #backBtn:hover {
                background-color: #218838;
            }

            #logoutBtn { 
                width: 145px; 
                padding: 10px 15px; 
                font-size: 14px; 
                background-color: #dc3545; 
                color: white; 
                border: none; 
                border-radius: 4px; 
                cursor: pointer; 
            } 

            #logoutBtn:hover { 
                background-color: #a71d2a; 
            }

        </style>

    </body>
</html>