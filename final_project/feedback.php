<?php
session_start();
include "config.php";

$message = "";
$email = $_SESSION["user-Email"] ?? "";
$patient_id = 0;


/* Logged-in patient বের করা */

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


/* Feedback insert */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $feedback = trim($_POST["feedback"]);

    if ($patient_id == 0) {

        $message = "Patient account not found.";

    } elseif (empty($feedback)) {

        $message = "Please write your feedback.";

    } else {

        $sql = "INSERT INTO feedback
                (patient_id, message)
                VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "is",
            $patient_id,
            $feedback
        );

        if (mysqli_stmt_execute($stmt)) {

            $message = "Feedback submitted successfully.";

        } else {

            $message = "Failed to submit feedback.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Provide Feedback</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>Provide Feedback</label>
    </div>


    <?php if (!empty($message)) { ?>

        <p id="message">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>


    <form method="post">

        <textarea
            name="feedback"
            placeholder="Write your feedback..."
            required></textarea>

        <button type="submit" class="normalBtn">
            Submit Feedback
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

textarea {
    width: 300px;
    height: 130px;
    padding: 12px;
    margin: 8px;
    font-size: 16px;
    border: 1px solid #aeadad;
    border-radius: 4px;
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