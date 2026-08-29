<?php
$tab = $_GET["tab"] ?? "list";
?>

<!DOCTYPE html>
<html>

<head>

    <title>Billing</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #172b4d;
        }

        .logo {
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 0px 20px 35px;
        }

        .logo span {
            display: block;
            font-size: 12px;
            font-weight: normal;
            margin-top: 5px;
            color: #dbeafe;
        }


        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #1f426b;
            padding-top: 25px;
        }


        .menu a {
            display: block;
            padding: 14px 20px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            line-height: 1.5;
        }


        .menu a:hover {
            background-color: #28527f;
        }


        .menu a.active {
            background-color: #2f82cc;
        }

        .menu .logout-link {
            margin-top: 18px;
        }


        /* MAIN */

        .main {
            margin-left: 202px;
            min-height: 100vh;
        }


        /* TOP BAR */

        .topbar {
            height: 65px;

            background-color: white;

            border-bottom: 1px solid #ddd;

            display: flex;

            justify-content: flex-end;

            align-items: center;

            padding: 0 30px;

        }


        .receptionist {
            font-size: 15px;
        }


        .profile {
            text-decoration: none;

            color: #17375e;

            font-size: 14px;

            border: 1px solid #ddd;

            padding: 9px 15px;

            border-radius: 6px;
        }


        .profile:hover {
            background-color: #eef5fc;
        }


        /* CONTENT */

        .content {
            padding: 30px 35px;
        }


        .page-title {
            font-size: 25px;

            margin-bottom: 5px;
        }


        .page-text {
            color: #666;

            font-size: 14px;

            margin-bottom: 25px;
        }


        /* SEARCH */

        .search-box {
            background-color: white;

            padding: 20px;

            border: 1px solid #ddd;

            border-radius: 10px;

            margin-bottom: 20px;
        }


        .search-form {
            display: flex;

            gap: 10px;
        }


        .search-form input {
            flex: 1;

            padding: 11px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 14px;
        }


        .button {
            background-color: #2878c8;

            color: white;

            border: none;

            padding: 11px 20px;

            border-radius: 6px;

            font-size: 14px;

            cursor: pointer;

            text-decoration: none;

            display: inline-block;
        }


        .button:hover {
            background-color: #1d65a8;
        }


        /* ADD BILL BUTTON */

        .add-button {
            display: inline-block;

            text-decoration: none;

            background-color: #2878c8;

            color: white;

            padding: 11px 18px;

            border-radius: 6px;

            font-size: 14px;

            margin-bottom: 20px;
        }


        .add-button:hover {
            background-color: #1d65a8;
        }


        /* BOX */

        .box {
            background-color: white;

            padding: 25px;

            border: 1px solid #ddd;

            border-radius: 10px;

            margin-bottom: 20px;
        }


        .box h2 {
            font-size: 20px;

            margin-bottom: 20px;
        }


        /* FORM */

        .form-row {
            display: flex;

            gap: 20px;

            margin-bottom: 18px;
        }

        .form-group {
            width: 50%;
        }


        label {
            display: block;
            font-size: 14px;
            margin-bottom: 7px;
            color: #444;
        }

        input,select,textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }


        textarea {
            height: 90px;
            resize: none;
        }

        .bill-list {
            background-color: white;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .bill-list h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }


        th {
            background-color:   #1d65a8;
            color: white;
        }

        .paid {
            color: #16803c;
            background-color: #e8f7ee;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            color: #b36b00;
            background-color: #fff3d6;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }


        .view-button {
            text-decoration: none;
            background-color: #2878c8;
            color: white;
            padding: 7px 12px;
            border-radius: 5px;
            font-size: 13px;
        }

        .view-button:hover {
            background-color: #1d65a8;
        }

        .edit-button {
            text-decoration: none;
            background-color: #1d65a8;
            color: white;
            padding: 7px 12px;
            border-radius: 5px;
            font-size: 13px;
            margin-left: 5px;
        }


        .edit-button:hover {
            background-color: #1d65a8;
        }

        .back-button {
            display: inline-block;
            text-decoration: none;
            color: #17375e;
            border: 1px solid #17375e;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 14px;
            margin-left: 5px;
        }


        .back-button:hover {
            background-color: #eef5fc;
        }

        .bill-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .detail {
            padding: 12px;

            background-color: #f8fafc;

            border: 1px solid #ddd;

            border-radius: 6px;
        }


        .detail strong {
            display: block;

            font-size: 12px;

            color: #666;

            margin-bottom: 5px;
        }


        .detail span {
            font-size: 14px;

            color: #172b4d;
        }


        .total {
            margin-top: 20px;

            padding: 15px;

            background-color: #eef5fc;

            border-radius: 6px;

            text-align: right;

            font-size: 18px;

            font-weight: bold;

            color: #17375e;
        }


    </style>

</head>


<body>


<!-- ================================================= -->
<!-- SIDEBAR -->
<!-- ================================================= -->

<div class="sidebar">

    <div class="logo">

        Medicare

    </div>

    <div class="menu">


        <!-- DASHBOARD -->

        <a href="dashboard_reciption.php">
            Dashboard
        </a>


        <!-- APPOINTMENTS -->

        <a href="reciption_appointments.php">
            Appointments
        </a>


        <!-- PATIENTS -->

        <a href="reciption_patients.php">
            Patients
        </a>


        <!-- BILLING -->

        <a href="billing.php" class="active">
            Billing
        </a>


        <!-- QUEUE -->

        <a href="reciption_queue.php">
            Queue
        </a>


        <!-- LOGOUT -->

        <a href="logout" class="logout-link">
            Logout
        </a>


    </div>

</div>



<!-- ================================================= -->
<!-- MAIN -->
<!-- ================================================= -->

<div class="main">


    <!-- TOP BAR -->

    <div class="topbar">


        <div class="receptionist">
            Receptionist
        </div>


        <!-- PROFILE -->

        <a href="reciption_profile.php"
           class="profile">

            Profile

        </a>


    </div>



    <!-- ================================================= -->
    <!-- CONTENT -->
    <!-- ================================================= -->

    <div class="content">


        <h1 class="page-title">
            Billing
        </h1>


        <p class="page-text">
            Manage patient bills and payments
        </p>



        <!-- ================================================= -->
        <!-- BILL LIST -->
        <!-- ================================================= -->

        <?php if ($tab == "list") { ?>


            <!-- SEARCH -->

            <div class="search-box">


                <form
                    class="search-form"
                    method="get"
                    action="billing.php"
                >


                    <input
                        type="text"
                        name="search"
                        placeholder="Search by patient name or invoice ID"
                    >


                    <button
                        type="submit"
                        class="button"
                    >
                        Search
                    </button>


                </form>


            </div>



            <!-- ADD BILL -->

            <a
                href="billing.php?tab=add"
                class="add-button"
            >
                Add New Bill
            </a>



            <!-- BILL TABLE -->

            <div class="bill-list">


                <h2>
                    Billing List
                </h2>



                <table>


                    <tr>

                        <th>
                            Invoice ID
                        </th>

                        <th>
                            Patient
                        </th>

                        <th>
                            Doctor
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>



                    <tr>

                        <td>
                            INV001
                        </td>

                        <td>
                            John Doe
                        </td>

                        <td>
                            Dr. Rahman
                        </td>

                        <td>
                            ৳1,500
                        </td>

                        <td>

                            <span class="paid">
                                Paid
                            </span>

                        </td>

                        <td>

                            <a
                                href="billing.php?tab=view"
                                class="view-button"
                            >
                                View
                            </a>


                            <a
                                href="billing.php?tab=edit"
                                class="edit-button"
                            >
                                Edit
                            </a>

                        </td>

                    </tr>



                    <tr>

                        <td>
                            INV002
                        </td>

                        <td>
                            Sara Ahmed
                        </td>

                        <td>
                            Dr. Karim
                        </td>

                        <td>
                            ৳2,000
                        </td>

                        <td>

                            <span class="pending">
                                Pending
                            </span>

                        </td>

                        <td>

                            <a
                                href="billing.php?tab=view"
                                class="view-button"
                            >
                                View
                            </a>


                            <a
                                href="billing.php?tab=edit"
                                class="edit-button"
                            >
                                Edit
                            </a>

                        </td>

                    </tr>



                    <tr>

                        <td>
                            INV003
                        </td>

                        <td>
                            Rahim Khan
                        </td>

                        <td>
                            Dr. Rahman
                        </td>

                        <td>
                            ৳1,200
                        </td>

                        <td>

                            <span class="paid">
                                Paid
                            </span>

                        </td>

                        <td>

                            <a
                                href="billing.php?tab=view"
                                class="view-button"
                            >
                                View
                            </a>


                            <a
                                href="billing.php?tab=edit"
                                class="edit-button"
                            >
                                Edit
                            </a>

                        </td>

                    </tr>


                </table>


            </div>



        <!-- ================================================= -->
        <!-- ADD BILL -->
        <!-- ================================================= -->

        <?php } elseif ($tab == "add") { ?>


            <div class="box">


                <h2>
                    Add New Bill
                </h2>


                <form
                    method="post"
                    action="billing.php"
                >


                    <!-- ROW 1 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Invoice ID
                            </label>

                            <input
                                type="text"
                                name="invoice_id"
                                placeholder="Enter invoice ID"
                            >

                        </div>



                        <div class="form-group">

                            <label>
                                Patient Name
                            </label>

                            <input
                                type="text"
                                name="patient_name"
                                placeholder="Enter patient name"
                            >

                        </div>


                    </div>



                    <!-- ROW 2 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Doctor
                            </label>


                            <select name="doctor">

                                <option>
                                    Select Doctor
                                </option>

                                <option>
                                    Dr. Rahman
                                </option>

                                <option>
                                    Dr. Karim
                                </option>

                            </select>

                        </div>



                        <div class="form-group">

                            <label>
                                Bill Date
                            </label>


                            <input
                                type="date"
                                name="bill_date"
                            >

                        </div>


                    </div>



                    <!-- ROW 3 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Consultation Fee
                            </label>


                            <input
                                type="number"
                                name="consultation_fee"
                                placeholder="Enter amount"
                            >

                        </div>



                        <div class="form-group">

                            <label>
                                Medicine / Other Fee
                            </label>


                            <input
                                type="number"
                                name="other_fee"
                                placeholder="Enter amount"
                            >

                        </div>


                    </div>



                    <!-- ROW 4 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Payment Status
                            </label>


                            <select name="payment_status">

                                <option>
                                    Select Status
                                </option>

                                <option>
                                    Paid
                                </option>

                                <option>
                                    Pending
                                </option>

                            </select>

                        </div>



                        <div class="form-group">

                            <label>
                                Payment Method
                            </label>


                            <select name="payment_method">

                                <option>
                                    Select Method
                                </option>

                                <option>
                                    Cash
                                </option>

                                <option>
                                    Card
                                </option>

                                <option>
                                    Mobile Banking
                                </option>

                            </select>

                        </div>


                    </div>



                    <!-- NOTES -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Notes
                            </label>


                            <textarea
                                name="notes"
                                placeholder="Enter notes"
                            ></textarea>

                        </div>


                    </div>



                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="button"
                    >
                        Add Bill
                    </button>


                    <a
                        href="billing.php"
                        class="back-button"
                    >
                        Cancel
                    </a>


                </form>


            </div>



        <!-- ================================================= -->
        <!-- VIEW BILL -->
        <!-- ================================================= -->

        <?php } elseif ($tab == "view") { ?>


            <div class="box">


                <h2>
                    Bill Details
                </h2>


                <div class="bill-details">


                    <div class="detail">

                        <strong>
                            Invoice ID
                        </strong>

                        <span>
                            INV001
                        </span>

                    </div>



                    <div class="detail">

                        <strong>
                            Bill Date
                        </strong>

                        <span>
                            26 August 2026
                        </span>

                    </div>



                    <div class="detail">

                        <strong>
                            Patient Name
                        </strong>

                        <span>
                            John Doe
                        </span>

                    </div>



                    <div class="detail">

                        <strong>
                            Doctor
                        </strong>

                        <span>
                            Dr. Rahman
                        </span>

                    </div>



                    <div class="detail">

                        <strong>
                            Consultation Fee
                        </strong>

                        <span>
                            ৳1,000
                        </span>

                    </div>



                    <div class="detail">

                        <strong>
                            Other Fee
                        </strong>

                        <span>
                            ৳500
                        </span>

                    </div>



                    <div class="detail">

                        <strong>
                            Payment Method
                        </strong>

                        <span>
                            Cash
                        </span>

                    </div>



                    <div class="detail">

                        <strong>
                            Payment Status
                        </strong>

                        <span>
                            Paid
                        </span>

                    </div>


                </div>



                <div class="total">

                    Total Amount: ৳1,500

                </div>


                <br>


                <a
                    href="billing.php"
                    class="back-button"
                >
                    Back to Billing
                </a>


            </div>



        <!-- ================================================= -->
        <!-- EDIT BILL -->
        <!-- ================================================= -->

        <?php } elseif ($tab == "edit") { ?>


            <div class="box">


                <h2>
                    Edit Bill
                </h2>


                <form
                    method="post"
                    action="billing.php"
                >


                    <!-- ROW 1 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Invoice ID
                            </label>


                            <input
                                type="text"
                                name="invoice_id"
                                value="INV001"
                            >

                        </div>



                        <div class="form-group">

                            <label>
                                Patient Name
                            </label>


                            <input
                                type="text"
                                name="patient_name"
                                value="John Doe"
                            >

                        </div>


                    </div>



                    <!-- ROW 2 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Doctor
                            </label>


                            <select name="doctor">

                                <option selected>
                                    Dr. Rahman
                                </option>

                                <option>
                                    Dr. Karim
                                </option>

                            </select>

                        </div>



                        <div class="form-group">

                            <label>
                                Bill Date
                            </label>


                            <input
                                type="date"
                                name="bill_date"
                                value="2026-08-26"
                            >

                        </div>


                    </div>



                    <!-- ROW 3 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Consultation Fee
                            </label>


                            <input
                                type="number"
                                name="consultation_fee"
                                value="1000"
                            >

                        </div>



                        <div class="form-group">

                            <label>
                                Other Fee
                            </label>


                            <input
                                type="number"
                                name="other_fee"
                                value="500"
                            >

                        </div>


                    </div>



                    <!-- ROW 4 -->

                    <div class="form-row">


                        <div class="form-group">

                            <label>
                                Payment Status
                            </label>


                            <select name="payment_status">

                                <option selected>
                                    Paid
                                </option>

                                <option>
                                    Pending
                                </option>

                            </select>

                        </div>



                        <div class="form-group">

                            <label>
                                Payment Method
                            </label>


                            <select name="payment_method">

                                <option selected>
                                    Cash
                                </option>

                                <option>
                                    Card
                                </option>

                                <option>
                                    Mobile Banking
                                </option>

                            </select>

                        </div>


                    </div>



                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="button"
                    >
                        Save Changes
                    </button>


                    <a
                        href="billing.php"
                        class="back-button"
                    >
                        Cancel
                    </a>


                </form>


            </div>


        <?php } ?>


    </div>

</div>


</body>

</html>
