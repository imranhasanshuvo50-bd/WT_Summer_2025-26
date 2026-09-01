<?php
session_start();
include "config.php";

$message = "";
$email = $_SESSION["user-Email"] ?? "";
$patient_id = 0;


/* Logged-in patient ID বের করা */
$sql = "SELECT p.patient_id
        FROM patients p
        INNER JOIN users u
            ON p.user_id = u.id
        WHERE u.email = ?
        AND u.role = 'patient'
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $patient_id = $row["patient_id"];
}

mysqli_stmt_close($stmt);


/* Review submit */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = (int)$_POST["doctor_id"];
    $rating = (int)$_POST["rating"];
    $review = trim($_POST["review"]);

    if ($patient_id == 0) {

        $message = "Patient account not found.";

    } elseif ($rating < 1 || $rating > 5) {

        $message = "Rating must be between 1 and 5.";

    } else {

        $sql = "INSERT INTO ratings
                (doctor_id, patient_id, rating, review)
                VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "iiis",
            $doctor_id,
            $patient_id,
            $rating,
            $review
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Doctor review submitted successfully.";
        } else {
            $message = "Failed to submit review.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Reviews</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>Submit Doctor Review</label>
    </div>

    <?php if (!empty($message)) { ?>

        <p id="message">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>

    <form method="post">

        <select name="doctor_id" required>

            <option value="">Select Doctor</option>

            <?php

            $sql = "SELECT 
                        d.doctor_id,
                        u.name
                    FROM doctors d
                    INNER JOIN users u
                        ON d.user_id = u.id
                    WHERE u.role = 'doctor'
                    AND u.status = 'Active'
                    ORDER BY u.name";

            $result = mysqli_query($conn, $sql);

            while ($doctor = mysqli_fetch_assoc($result)) {

                echo "<option value='" . $doctor["doctor_id"] . "'>";
                echo htmlspecialchars($doctor["name"]);
                echo "</option>";
            }

            ?>

        </select>


        <select name="rating" required>

            <option value="">Select Rating</option>
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Very Good</option>
            <option value="3">3 - Good</option>
            <option value="2">2 - Average</option>
            <option value="1">1 - Poor</option>

        </select>


        <textarea
            name="review"
            placeholder="Write your review..."
            required></textarea>


        <button type="submit" class="normalBtn">
            Submit Review
        </button>

    </form>


    <div class="actionGroup">

        <a href="billing&feedback_dashboard.php">
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
    align-items: center;
    min-height: 100vh;
    background-color: #cfedfa;
    font-family: Arial, sans-serif;
}

.container {
    width: 500px;
    padding: 50px;
    background-color: white;
    border: 2px solid #aeadad;
    border-radius: 8px;
}

#heading {
    text-align: center;
    font-size: 24px;
    margin-bottom: 30px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

select,
textarea {
    width: 300px;
    padding: 12px;
    margin: 8px;
    font-size: 16px;
    border: 1px solid #aeadad;
    border-radius: 4px;
}

textarea {
    height: 110px;
    resize: none;
}

.normalBtn {
    width: 300px;
    padding: 12px;
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

#message {
    text-align: center;
    margin-bottom: 15px;
    color: #28a745;
}

.actionGroup {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 25px;
}

#backBtn,
#logoutBtn {
    width: 145px;
    padding: 10px;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#backBtn {
    background-color: #28a745;
}

#logoutBtn {
    background-color: #dc3545;
}

</style>

</body>
</html>