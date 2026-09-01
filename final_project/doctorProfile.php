<?php
session_start();
include "config.php";

$doctor = null;

if (isset($_GET["doctor_id"])) {

    $doctor_id = (int)$_GET["doctor_id"];

    $sql = "SELECT 
                doctors.doctor_id,
                users.name,
                doctors.specialization,
                doctors.qualification,
                doctors.experience,
                doctors.consultation_fee,
                departments.department_name
            FROM doctors
            INNER JOIN users 
                ON doctors.user_id = users.id
            LEFT JOIN departments 
                ON doctors.department_id = departments.department_id
            WHERE doctors.doctor_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $doctor_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $doctor = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Doctor Profile</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>Doctor Profile</label>
    </div>

    <form method="get">

        <select name="doctor_id" id="doctorSelect" required>

            <option value="">Select Doctor</option>

            <?php
            $sql = "SELECT doctors.doctor_id, users.name
                    FROM doctors
                    INNER JOIN users
                    ON doctors.user_id = users.id
                    WHERE users.role = 'doctor'
                    AND users.status = 'Active'";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["doctor_id"] . "'>";
                echo htmlspecialchars($row["name"]);
                echo "</option>";
            }
            ?>

        </select>

        <button type="submit" class="searchBtn">
            View Profile
        </button>

    </form>


    <?php if ($doctor) { ?>

        <div class="doctorBox">

            <h2>
                <?php echo htmlspecialchars($doctor["name"]); ?>
            </h2>

            <p>
                <b>Specialization:</b>
                <?php echo htmlspecialchars($doctor["specialization"] ?? "Not Available"); ?>
            </p>

            <p>
                <b>Department:</b>
                <?php echo htmlspecialchars($doctor["department_name"] ?? "Not Assigned"); ?>
            </p>

            <p>
                <b>Qualification:</b>
                <?php echo htmlspecialchars($doctor["qualification"] ?? "Not Available"); ?>
            </p>

            <p>
                <b>Experience:</b>
                <?php echo htmlspecialchars($doctor["experience"] ?? "Not Available"); ?> years
            </p>

            <p>
                <b>Consultation Fee:</b>
                <?php echo htmlspecialchars($doctor["consultation_fee"] ?? "Not Available"); ?>
            </p>

        </div>

    <?php } ?>

     <div class="actionGroup">

        <a href="doctor&appointment_dashbord.php">

            <button id="backBtn">
                Back
            </button>

        </a>


        <a href="logout.php">

            <button id="logoutBtn">
                Logout
            </button>

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
    align-items: center;
    min-height: 100vh;
    background-color: #cfedfa;
    font-family: Arial, sans-serif;
}

.container {
    display: flex;
    flex-direction: column;
    padding: 60px 50px;
    background-color: white;
    border: 2px solid #aeadad;
    border-radius: 8px;
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

#doctorSelect {
    width: 300px;
    padding: 12px;
    font-size: 16px;
}

.searchBtn {
    width: 130px;
    padding: 12px;
    margin-left: 10px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
}

.doctorBox {
    width: 440px;
    border: 1px solid #aeadad;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.doctorBox h2 {
    margin-bottom: 15px;
}

.doctorBox p {
    margin: 8px 0;
}

.actionGroup {
    display: flex;
    gap: 10px;
    margin-top: 20px;
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