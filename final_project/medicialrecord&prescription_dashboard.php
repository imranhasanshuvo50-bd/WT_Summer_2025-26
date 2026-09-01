<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Record & Prescription Management</title>
</head>

<body>

    <div class="medpreContainer">

        <div id="heading">
            <label>Medical Record & Prescription Management</label>
        </div>

        <a href="viewPrescription.php">
            <button class="normalBtn">View Prescription</button>
        </a>

        <a href="testReports.php">
            <button class="normalBtn">View Test Reports</button>
        </a>

        <a href="treatmentHistory.php">
            <button class="normalBtn">Previous Treatment History</button>
        </a>

        <a href="medicalRecords.php">
            <button class="normalBtn">Medical Records</button>
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

        .medpreContainer {
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
            text-align: center;
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