<?php

include "config.php";

$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

$sql = "SELECT * FROM users WHERE role = 'patient'";

$result = mysqli_query($connection, $sql);

$selected_patient = null;

if (isset($_GET["view"])) {

    $patient_id = $_GET["view"];

    $sql2 = "SELECT * FROM users WHERE id = $patient_id AND role = 'patient'";

    $result2 = mysqli_query($connection, $sql2);

    $selected_patient = mysqli_fetch_assoc($result2);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>MediCare | Patients</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f6f8;
        }

        .sidebar {
            width: 220px;
            background-color: #0b3d66;
            color: white;
            padding: 20px 0;
        }

        .sidebar h2 {
            padding: 0 20px 20px;
            font-size: 18px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
        }

        .sidebar a:hover {
            background-color: #145a8a;
        }

        .sidebar a.active {
            background-color: #145a8a;
            border-left: 4px solid white;
        }

        .sidebar hr {
            border: none;
            border-top: 1px solid #1e5580;
            margin: 15px 20px;
        }

        .main-content {
            flex: 1;
            padding: 30px;
        }

        .main-content h1 {
            color: #0b3d66;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-form input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 220px;
        }

        .search-form button {
            padding: 8px 16px;
            background-color: #145a8a;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #0b3d66;
            color: white;
        }

        .view-btn {
            background-color: #145a8a;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
        }

        .patient-panel {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
        }

        .patient-panel h2 {
            color: #0b3d66;
            margin-bottom: 15px;
        }

        .patient-panel p {
            margin-bottom: 8px;
        }

        .consult-btn {
            display: inline-block;
            background-color: #0b3d66;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 4px;
        }

        .no-results {
            background-color: white;
            padding: 20px;
            margin-top: 10px;
            border-radius: 8px;
        }

    </style>

</head>

<body>

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php">Dashboard</a>

        <a href="Doctor_patients.php" class="active">Patients</a>

        <a href="Doctor_consultation.php">Consultation</a>

        <a href="Doctor_prescriptions.php">Prescriptions</a>

        <a href="Doctor_patient_flow.php">Patient Flow</a>

        <hr>

        <a href="Doctor_profile.php">Profile</a>

        <a href="Doctor_change_password.php">Change Password</a>

        <hr>

        <a href="logout.php">Logout</a>

    </div>

    <div class="main-content">

        <h1>Patients</h1>

        <form
            class="search-form"
            method="get"
            action="Doctor_patients.php"
        >

            <input
                type="text"
                name="search"
                placeholder="Search by name or ID"
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">Search</button>

        </form>

        <table>

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Email</th>

                <th>Status</th>

                <th>Action</th>

            </tr>

            <?php

            $found = false;

            while ($patient = mysqli_fetch_assoc($result)) {

                if (
                    $search == "" ||
                    strpos(strtolower($patient["name"]), strtolower($search)) !== false ||
                    strpos($patient["id"], $search) !== false
                ) {

                    $found = true;

            ?>

                    <tr>

                        <td>
                            <?php echo $patient["id"]; ?>
                        </td>

                        <td>
                            <?php echo $patient["name"]; ?>
                        </td>

                        <td>
                            <?php echo $patient["email"]; ?>
                        </td>

                        <td>
                            <?php echo $patient["status"]; ?>
                        </td>

                        <td>

                            <a
                                class="view-btn"
                                href="Doctor_patients.php?view=<?php echo $patient["id"]; ?>"
                            >
                                View
                            </a>

                        </td>

                    </tr>

            <?php

                }
            }

            ?>

        </table>

        <?php

        if ($found == false) {

            echo "<p class='no-results'>";
            echo "No patients found.";
            echo "</p>";

        }

        ?>

        <?php

        if ($selected_patient != null) {

        ?>

            <div class="patient-panel">

                <h2>
                    Patient Information
                </h2>

                <p>
                    <strong>Patient ID:</strong>
                    <?php echo $selected_patient["id"]; ?>
                </p>

                <p>
                    <strong>Name:</strong>
                    <?php echo $selected_patient["name"]; ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php echo $selected_patient["email"]; ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php echo $selected_patient["status"]; ?>
                </p>

                <a
                    class="consult-btn"
                    href="Doctor_consultation.php?patient_id=<?php echo $selected_patient["id"]; ?>"
                >
                    Start Consultation
                </a>

            </div>

        <?php

        }

        ?>

    </div>

</body>

</html>
