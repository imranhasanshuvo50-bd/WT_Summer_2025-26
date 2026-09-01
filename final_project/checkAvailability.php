<?php
session_start();
include "config.php";

$doctor_id = "";
$day = "";
$availability = [];
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = (int)$_POST["doctor_id"];
    $day = $_POST["day"];

    if ($doctor_id > 0 && !empty($day)) {

        $sql = "SELECT start_time, end_time
                FROM doctor_availability
                WHERE doctor_id = ?
                AND LOWER(day_of_week) = LOWER(?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "is", $doctor_id, $day);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                $availability[] = $row;
            }

            mysqli_stmt_close($stmt);

        } else {
            $error = "Database query failed.";
        }
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>

    <title>Check Availability</title>

</head>

<body>

<div class="container">

    <div id="heading">
        <label>Check Doctor Availability</label>
    </div>


    <form method="post">

        <select name="doctor_id" required>

            <option value="">Select Doctor</option>

            <?php

            $sql = "SELECT 
                        doctors.doctor_id,
                        users.name
                    FROM doctors
                    INNER JOIN users
                        ON doctors.user_id = users.id
                    WHERE users.role = 'doctor'
                    AND users.status = 'Active'
                    ORDER BY users.name";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {

                $selected = "";

                if ($doctor_id == $row["doctor_id"]) {
                    $selected = "selected";
                }

                echo "<option value='" . $row["doctor_id"] . "' $selected>";
                echo htmlspecialchars($row["name"]);
                echo "</option>";
            }

            ?>

        </select>


        <select name="day" required>

            <option value="">Select Day</option>

            <option value="saturday"
                <?php if ($day == "saturday") echo "selected"; ?>>
                Saturday
            </option>

            <option value="sunday"
                <?php if ($day == "sunday") echo "selected"; ?>>
                Sunday
            </option>

            <option value="monday"
                <?php if ($day == "monday") echo "selected"; ?>>
                Monday
            </option>

            <option value="tuesday"
                <?php if ($day == "tuesday") echo "selected"; ?>>
                Tuesday
            </option>

            <option value="wednesday"
                <?php if ($day == "wednesday") echo "selected"; ?>>
                Wednesday
            </option>

            <option value="thursday"
                <?php if ($day == "thursday") echo "selected"; ?>>
                Thursday
            </option>

            <option value="friday"
                <?php if ($day == "friday") echo "selected"; ?>>
                Friday
            </option>

        </select>


        <button type="submit" class="normalBtn">
            Check Availability
        </button>

    </form>


    <?php if (!empty($error)) { ?>

        <div class="resultBox">

            <p id="noResult">
                <?php echo htmlspecialchars($error); ?>
            </p>

        </div>

    <?php } ?>


    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)) { ?>

        <div class="resultBox">

            <?php if (count($availability) > 0) { ?>

                <h3>Available Time</h3>

                <?php foreach ($availability as $row) { ?>

                    <p>

                        <?php
                        echo date(
                            "h:i A",
                            strtotime($row["start_time"])
                        );
                        ?>

                        -

                        <?php
                        echo date(
                            "h:i A",
                            strtotime($row["end_time"])
                        );
                        ?>

                    </p>

                <?php } ?>

            <?php } else { ?>

                <p id="noResult">
                    No availability found for this day.
                </p>

            <?php } ?>

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
    margin: 20px;
    background-color: white;
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
    flex-direction: column;
    align-items: center;
}


select {
    width: 300px;
    padding: 12px;
    margin: 8px;
    font-size: 16px;
    border: 1px solid #aeadad;
    border-radius: 4px;
    background-color: white;
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


.resultBox {
    width: 300px;
    margin-top: 15px;
    padding: 15px;
    background-color: #f8f9fa;
    border: 1px solid #aeadad;
    border-radius: 5px;
    text-align: center;
}


.resultBox h3 {
    color: #333;
    margin-bottom: 10px;
}


.resultBox p {
    margin: 8px;
    color: #444;
}


#noResult {
    color: #dc3545;
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