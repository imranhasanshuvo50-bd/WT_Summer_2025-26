<?php
session_start();
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

        <a href="searchDoctor.php">
         <button class="normalBtn">Search Doctor</button>
        </a>

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

        <a href="logout.php"> 
            <button id="logoutBtn">Logout</button> 
        </a>
        
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

        #welcome {
            color: #333;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        #heading {
            color: #333;
            font-size: 24px;
            margin-bottom: 30px;
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

        #logoutBtn { 
            width: 300px; 
            padding: 12px 20px; 
            margin-top: 25px; 
            font-size: 16px; 
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