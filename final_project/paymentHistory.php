<?php
session_start();
include "config.php";

$email = $_SESSION["user-Email"] ?? "";
$payments = [];

$sql = "SELECT 
            b.invoice_id,
            b.total_amount,
            b.payment_method,
            b.payment_status,
            b.bill_date,
            u.name AS doctor_name
        FROM bills b
        INNER JOIN patients p
            ON b.patient_id = p.patient_id
        INNER JOIN users pu
            ON p.user_id = pu.id
        LEFT JOIN doctors d
            ON b.doctor_id = d.doctor_id
        LEFT JOIN users u
            ON d.user_id = u.id
        WHERE pu.email = ?
        AND pu.role = 'patient'
        AND LOWER(b.payment_status) = 'paid'
        ORDER BY b.bill_date DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $payments[] = $row;
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment History</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>Payment History</label>
    </div>

    <?php if (count($payments) > 0) { ?>

        <?php foreach ($payments as $payment) { ?>

            <div class="paymentBox">

                <p>
                    <b>Invoice ID:</b>
                    <?php echo htmlspecialchars($payment["invoice_id"]); ?>
                </p>

                <p>
                    <b>Doctor:</b>
                    <?php echo htmlspecialchars($payment["doctor_name"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Paid Amount:</b>
                    <?php echo htmlspecialchars($payment["total_amount"]); ?>
                </p>

                <p>
                    <b>Payment Method:</b>
                    <?php echo htmlspecialchars($payment["payment_method"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Status:</b>
                    <?php echo htmlspecialchars($payment["payment_status"]); ?>
                </p>

                <p>
                    <b>Date:</b>
                    <?php echo htmlspecialchars($payment["bill_date"]); ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p id="noResult">No payment history found.</p>

    <?php } ?>

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

.paymentBox {
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f8f9fa;
    border: 1px solid #aeadad;
    border-radius: 5px;
}

.paymentBox p {
    margin: 7px 0;
}

#noResult {
    text-align: center;
    color: #dc3545;
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