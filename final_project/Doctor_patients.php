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

        /* Sidebar */

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

        /* Main content */

        .main-content {
            flex: 1;
            padding: 30px;
        }

        .main-content h1 {
            color: #0b3d66;
            margin-bottom: 20px;
        }

        /* Search */

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-form input,
        .search-form select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-form input {
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

        /* Patient table */

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

        /* Patient information */

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

        .patient-panel ul {
            margin: 10px 0 15px 20px;
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


<?php

$patients = array(

    array(
        "id" => "P001",
        "name" => "Rahim Ahmed",
        "age" => 45,
        "gender" => "Male",
        "phone" => "01711111111",
        "department" => "Medicine",
        "status" => "Waiting",
        "history" => array("Diabetes","High blood pressure")
    ),

    array(
        "id" => "P002",
        "name" => "Karim Hasan",
        "age" => 52,
        "gender" => "Male",
        "phone" => "01722222222",
        "department" => "Cardiology",
        "status" => "Consultation",
        "history" => array( "Heart disease","High cholesterol")
    ),

    array(
        "id" => "P003",
        "name" => "Nabila",
        "age" => 30,
        "gender" => "Female",
        "phone" => "01733333333",
        "department" => "Medicine",
        "status" => "Admitted",
        "history" => array("Asthma")
    )

);


    $search = "";

    if (isset($_GET["search"])) 
    {
        $search = $_GET["search"];
    }


    $status = "All";

    if (isset($_GET["status"])) 
    {
        $status = $_GET["status"];
    }


    $selected_patient = null;

    if (isset($_GET["view"])) {

        foreach ($patients as $patient) {

            if ($patient["id"] == $_GET["view"]) {

                $selected_patient = $patient;

            }

        }

    }

?>


<body>


    <!-- Sidebar -->

    <div class="sidebar">

        <h2>MediCare | Doctor</h2>

        <a href="Doctor_dashboard.php"> Dashboard</a>
        <a href="Doctor_patients.php" class="active">Patients</a>
        <a href="Doctor_consultation.php"> Consultation</a>
        <a href="Doctor_prescriptions.php"> Prescriptions</a>
        <a href="Doctor_patient_flow.php"> Patient Flow</a>

        <hr>

        <a href="Doctor_profile.php"> Profile</a>
        <a href="Doctor_change_password.php"> Change Password </a>

        <hr>
        <a href="Doctor_logout.php">Logout</a>

    </div>


    <!-- Main content -->

    <div class="main-content">

        <h1>Patients</h1>


        <!-- Search form -->

        <form
            class="search-form"
            method="get"
            action="Doctor_patients.php">

            <input
                type="text"
                name="search"
                placeholder="Search by name or ID"
                value="<?php echo htmlspecialchars($search); ?>"
            >


            <select name="status">

                <option value="All">  All</option>

                <option value="Waiting"
                    <?php
                    if ($status == "Waiting") {
                        echo "selected";
                    }
                    ?>>Waiting
                </option>

                <option value="Consultation"
                    <?php
                    if ($status == "Consultation") {
                        echo "selected";
                    }
                    ?>>Consultation </option>

                <option value="Admitted"
                    <?php
                    if ($status == "Admitted") {
                        echo "selected";
                    }
                    ?>
                > Admitted</option>

            </select>

            <button type="submit">Search</button>

        </form>


        <!-- Patient table -->

        <table>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
                <th>Action</th>
            </tr>


            <?php

            $found = false;

            foreach ($patients as $patient) {

                $name = strtolower($patient["name"]);
                $id = strtolower($patient["id"]);
                $search_text = strtolower($search);

                $search_match = false;
                $status_match = false;


                if (
                    $search_text == "" ||
                    strpos($name, $search_text) !== false ||
                    strpos($id, $search_text) !== false
                ) {

                    $search_match = true;

                }


                if (
                    $status == "All" ||$patient["status"] == $status
                ) 
                {

                    $status_match = true;

                }


                if ($search_match && $status_match) 
                    {

                        $found = true;

                        echo "<tr>";

                        echo "<td>";
                        echo $patient["id"];
                        echo "</td>";

                        echo "<td>";
                        echo $patient["name"];
                        echo "</td>";

                        echo "<td>";
                        echo $patient["age"];
                        echo "</td>";

                        echo "<td>";
                        echo $patient["status"];
                        echo "</td>";

                        echo "<td>";

                        echo "<a class='view-btn' href='Doctor_patients.php?view=";
                        echo $patient["id"];
                        echo "'>";
                        echo "View";
                        echo "</a>";

                        echo "</td>";

                        echo "</tr>";

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


        <!-- Patient information -->

        <?php

        if ($selected_patient != null) {

        ?>

            <div class="patient-panel">

                <h2>
                    Patient Information
                </h2>


                <p>
                    <strong>Patient ID:</strong>

                    <?php
                    echo $selected_patient["id"];
                    ?>
                </p>


                <p>
                    <strong>Name:</strong>

                    <?php
                    echo $selected_patient["name"];
                    ?>
                </p>


                <p>
                    <strong>Age:</strong>

                    <?php
                    echo $selected_patient["age"];
                    ?>
                </p>


                <p>
                    <strong>Gender:</strong>

                    <?php
                    echo $selected_patient["gender"];
                    ?>
                </p>


                <p>
                    <strong>Phone:</strong>

                    <?php
                    echo $selected_patient["phone"];
                    ?>
                </p>


                <p>
                    <strong>Department:</strong>

                    <?php
                    echo $selected_patient["department"];
                    ?>
                </p>


                <p>
                    <strong>Previous Medical History:</strong>
                </p>


                <ul>

                    <?php

                    foreach ($selected_patient["history"] as $history) {

                        echo "<li>";
                        echo $history;
                        echo "</li>";

                    }

                    ?>

                </ul>


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