<?php

$tab = "list";

if (isset($_GET["tab"])) {
    $tab = $_GET["tab"];
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Patients</title>

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
            padding: 0 20px 35px;
        }

        .logo span {
            display: block;
            font-size: 12px;
            font-weight: normal;
            margin-top: 5px;
            color: #dbeafe;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #17375e;
            padding-top: 25px;
        }

        .menu a {
            display: block;

            padding: 14px 25px;

            color: white;

            text-decoration: none;

            font-size: 15px;
        }

        .menu a:hover {
            background-color: #24558b;
        }


        .menu a.active {
            background-color: #2878c8;
        }

        .main {
            margin-left: 230px;
            min-height: 100vh;
        }

        .topbar {
            height: 70px;
            background-color: white;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 30px;
            gap: 20px;
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


        /* FORM BOX */

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


        input,
        select {
            width: 100%;

            padding: 11px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 14px;
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


        /* PATIENT LIST */

        .patient-list {
            background-color: white;

            padding: 25px;

            border: 1px solid #ddd;

            border-radius: 10px;
        }


        .patient-list h2 {
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
            background-color: #17375e;

            color: white;
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

            background-color: #2878c8;

            color: white;

            padding: 7px 12px;

            border-radius: 5px;

            font-size: 13px;

            margin-left: 5px;
        }


        .edit-button:hover {
            background-color: #1d65a8;
        }


        /* MOBILE */

        @media (max-width: 800px) {

            .sidebar {
                width: 190px;
            }


            .main {
                margin-left: 190px;
            }


            .form-row {
                flex-direction: column;
            }


            .form-group {
                width: 100%;
            }


            table {
                font-size: 12px;
            }

        }

    </style>

</head>


<body>

    <div class="sidebar">

        <div class="logo">Medicare </div>

        <div class="menu">

            <a href="dashboard_reciption.php"> Dashboard </a>
            <a href="reciption_appointments.php"> Appointments </a>
            <a href="reciption_patients.php" class="active"> Patients </a>
            <a href="billing.php"> Billing </a>
            <a href="reciption_queue.php">  Queue </a>
            <a href="logout">   Logout </a>

        </div>

    </div>


<div class="main">



    <div class="topbar">

        <div class="receptionist">  Receptionist </div>

        <a href="reciption_profile.php"  class="profile">Profile </a>

    </div>


    <div class="content">


        <h1 class="page-title">  Patients  </h1>

        <p class="page-text"> Manage patient information </p>


        <div class="search-box">

            <form class="search-form" method="get" action="reciption_patients.php" >

                <input type="text" name="search" placeholder="Search patient by name or ID" >
                <button type="submit" class="button" >  Search</button>

            </form>

        </div>


        <?php

        if ($tab == "add") {

        ?>
            <div class="box">

                <h2>Add New Patient </h2>
                <form  method="post" action="reciption_patients.php">
                    <div class="form-row">

                        <div class="form-group">

                            <label> Full Name </label>
                            <input  type="text"  name="name" placeholder="Enter patient name">

                        </div>

                        <div class="form-group">
                            <label> Patient ID </label>
                            <input type="text" name="patient_id"placeholder="Enter patient ID">
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group">

                            <label>  Age </label>
                            <input type="number"  name="age" placeholder="Enter age">

                        </div>

                        <div class="form-group">

                            <label>Phone </label>
                            <input type="text"  name="phone" placeholder="Enter phone number" >

                        </div>

                    </div>

                    <div class="form-row">


                        <div class="form-group">

                            <label>Email </label>
                            <input type="email" name="email" placeholder="Enter email" >

                        </div>

                        <div class="form-group">

                            <label>Doctor </label>
                            <select name="doctor">
                                <option value="">  Select Doctor </option>
                                <option value="Dr. Rahman">  Dr. Rahman</option>
                                <option value="Dr. Karim">   Dr. Karim </option>
                            </select>

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group">

                            <label> Address </label>
                            <input type="text" name="address" placeholder="Enter address"  >

                        </div>

                    </div>

                    <button type="submit"  class="button">Add Patient </button>

                    <a href="reciption_patients.php" class="back-button">   Cancel</a>
                    
                </form>

            </div>

        <?php } ?>


        <?php

        if ($tab == "list") {
        ?>
            <a href="reciption_patients.php?tab=add" class="add-button">  Add New Patient </a>
            
            <div class="patient-list">

                <h2>Patient List </h2>

                <table>


                    <tr>
                        <th> Patient ID </th>
                        <th> Name </th>
                        <th> Age </th>
                        <th> Phone </th>
                        <th> Doctor </th>
                        <th>Action</th>
                    </tr>

                    <tr>

                        <td>  P001 </td>
                        <td> John Doe </td>
                        <td> 25 </td>
                        <td>  01700000000 </td>
                        <td> Dr. Rahman</td>

                        <td>
                            <a href="reciption_patients.php?tab=view" class="view-button"> View </a>
                            <a href="reciption_patients.php?tab=edit" class="edit-button" > Edit </a>
                        </td>

                    </tr>

                    <tr>

                        <td> P002 </td>
                        <td> Sara Ahmed</td>
                        <td> 30 </td>
                        <td>01800000000 </td>
                        <td> Dr. Karim </td>

                        <td>
                            <a href="reciption_patients.php?tab=view" class="view-button" > View </a>
                            <a href="reciption_patients.php?tab=edit"  class="edit-button"> Edit </a>
                        </td>

                    </tr>

                    <tr>

                        <td> P003 </td>
                        <td> Rahim Khan </td>
                        <td>  28</td>
                        <td> 01900000000</td>
                        <td> Dr. Rahman </td>

                        <td>
                            <a href="reciption_patients.php?tab=view" class="view-button" > View </a>
                            <a href="reciption_patients.php?tab=edit"  class="edit-button">  Edit </a>

                        </td>

                    </tr>
                </table>
            </div>
        <?php } ?>

        <?php

        if ($tab == "view") {

        ?>
            <div class="box">
                <h2>Patient Details </h2>
                <p>
                 <strong>Patient ID:</strong>
                    P001
                </p>

                <br>

                <p>
                    <strong>Name:</strong>
                    John Doe
                </p>

                <br>

                <p>
                    <strong>Age:</strong>
                    25
                </p>

                <br>

                <p>
                    <strong>Phone:</strong>
                    01700000000
                </p>

                <br>

                <p>
                    <strong>Doctor:</strong>
                    Dr. Rahman
                </p>

                <br>

                <p>
                    <strong>Email:</strong>
                    john@gmail.com
                </p>

                <br>

                <p>
                    <strong>Address:</strong>
                    Dhaka, Bangladesh
                </p>

                <br>

                <a href="reciption_patients.php" class="back-button"> Back</a>

            </div>

        <?php } ?>

        <?php

        if ($tab == "edit") {

        ?>


            <div class="box">


                <h2> Edit Patient </h2>

                <form  method="post"  action="reciption_patients.php" >

                    <div class="form-row">

                        <div class="form-group">
                            <label>  Patient ID</label>
                            <input type="text"  value="P001" >
                        </div>

                        <div class="form-group">
                            <label> Full Name</label>
                            <input type="text" value="John Doe">
                        </div>


                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label> Age</label>
                            <input type="number" value="25" >
                        </div>

                        <div class="form-group">
                            <label> Phone </label>
                            <input type="text" value="01700000000">
                        </div>

                    </div>



                    <div class="form-row">

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="john@gmail.com">
                        </div>


                        <div class="form-group">

                            <label> Doctor </label>

                            <select>
                                <option selected> Dr. Rahman] </option>
                                <option> Dr. Karim </option>
                            </select>

                        </div>
                    </div>

                    <button type="submit" class="button" >  Save Changes  </button>
                    <a href="reciption_patients.php" class="back-button" > Cancel</a>

                </form>
            </div>

        <?php } ?>
    </div>

</div>

</body>

</html>