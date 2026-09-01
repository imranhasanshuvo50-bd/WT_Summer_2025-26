<?php
session_start();
include "config.php";

$email = $_SESSION["user-Email"] ?? "";
$bills = [];

$sql = "SELECT 
            b.invoice_id,
            b.consultation_fee,
            b.other_fee,
            b.total_amount,
            b.payment_status,
            b.payment_method,
            b.bill_date,
            b.notes,
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
        ORDER BY b.bill_date DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $bills[] = $row;
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bills</title>
</head>

<body>

<div class="container">

    <div id="heading">
        <label>View Bills</label>
    </div>

    <?php if (count($bills) > 0) { ?>

        <?php foreach ($bills as $bill) { ?>

            <div class="billBox">

                <p>
                    <b>Invoice ID:</b>
                    <?php echo htmlspecialchars($bill["invoice_id"]); ?>
                </p>

                <p>
                    <b>Doctor:</b>
                    <?php echo htmlspecialchars($bill["doctor_name"] ?? "Not Available"); ?>
                </p>

                <p>
                    <b>Consultation Fee:</b>
                    <?php echo htmlspecialchars($bill["consultation_fee"]); ?>
                </p>

                <p>
                    <b>Other Fee:</b>
                    <?php echo htmlspecialchars($bill["other_fee"]); ?>
                </p>

                <p>
                    <b>Total Amount:</b>
                    <?php echo htmlspecialchars($bill["total_amount"]); ?>
                </p>

                <p>
                    <b>Payment Status:</b>
                    <?php echo htmlspecialchars($bill["payment_status"]); ?>
                </p>

                <p>
                    <b>Payment Method:</b>
                    <?php echo htmlspecialchars($bill["payment_method"] ?? "Not Paid"); ?>
                </p>

                <p>
                    <b>Bill Date:</b>
                    <?php echo htmlspecialchars($bill["bill_date"]); ?>
                </p>

                <p>
                    <b>Notes:</b>
                    <?php echo htmlspecialchars($bill["notes"] ?? "No Notes"); ?>
                </p>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p id="noResult">No bills found.</p>

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
    width: 550px;
    padding: 50px;
    margin: 20px;
    background-color: white;
    border: 2px solid #aeadad;
    border-radius: 8px;
}

#heading {
    text-align: center;
    font-size: 24px;
    margin-bottom: 30px;
}

.billBox {
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f8f9fa;
    border: 1px solid #aeadad;
    border-radius: 5px;
}

.billBox p {
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