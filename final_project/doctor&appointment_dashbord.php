<?php
session_start();
include "config.php";

$search = "";
$doctors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $search = trim($_POST["search"]);

    if (!empty($search)) {

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
                WHERE users.name LIKE ?
                OR doctors.specialization LIKE ?
                OR departments.department_name LIKE ?";

        $stmt = mysqli_prepare($conn, $sql);

        $searchValue = "%" . $search . "%";

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $searchValue,
            $searchValue,
            $searchValue
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = $row;
        }

        mysqli_stmt_close($stmt);
    }
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

            <button type="submit" class="searchBtn">
                Search
            </button>

        </form>


        <?php if (!empty($search)) { ?>

            <div class="resultContainer">

                <?php if (count($doctors) > 0) { ?>

                    <?php foreach ($doctors as $doctor) { ?>

                        <div class="doctorBox">

                            <h3>
                                <?php echo htmlspecialchars($doctor["name"]); ?>
                            </h3>

                            <p>
                                Specialization:
                                <?php echo htmlspecialchars($doctor["specialization"] ?? "Not Available"); ?>
                            </p>

                            <p>
                                Department:
                                <?php echo htmlspecialchars($doctor["department_name"] ?? "Not Assigned"); ?>
                            </p>

                            <p>
                                Qualification:
                                <?php echo htmlspecialchars($doctor["qualification"] ?? "Not Available"); ?>
                            </p>

                            <p>
                                Experience:
                                <?php echo htmlspecialchars($doctor["experience"] ?? "Not Available"); ?>
                                years
                            </p>

                            <p>
                                Consultation Fee:
                                <?php echo htmlspecialchars($doctor["consultation_fee"] ?? "Not Available"); ?>
                            </p>

                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <p id="noResult">No doctor found.</p>

                <?php } ?>

            </div>

        <?php } ?>


        <a href="doctorProfile.php">
            <button class="normalBtn">
                View Doctor Profile
            </button>
        </a>

        <a href="checkAvailability.php">
            <button class="normalBtn">
                Check Availability
            </button>
        </a>

        <a href="bookAppointment.php">
            <button class="normalBtn">
                Book Appointment
            </button>
        </a>

        <a href="appointmentStatus.php">
            <button class="normalBtn">
                View Appointment Status
            </button>
        </a>

        <a href="cancelAppointment.php">
            <button class="normalBtn">
                Cancel Appointment
            </button>
        </a>


        <div class="actionGroup">

            <a href="patient_dashboard.php">
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
            width: 375px;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #aeadad;
            border-radius: 4px;
        }

        .searchBtn {
            width: 110px;
            padding: 12px;
            margin-left: 10px;
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

        .resultContainer {
            width: 485px;
            margin-bottom: 15px;
        }

        .doctorBox {
            border: 1px solid #aeadad;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }

        .doctorBox h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .doctorBox p {
            margin: 5px 0;
            color: #444;
        }

        #noResult {
            color: #dc3545;
            font-size: 16px;
            margin-bottom: 15px;
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