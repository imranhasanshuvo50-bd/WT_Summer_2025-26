<?php
// ============================================
// STEP 1: Fake data (will come from database later)
// ============================================
// For now we just store the numbers in normal PHP variables.
// Later, these will be replaced by real database queries.

$doctor_name = "Dr. Imran";

$today_appointments = 8;
$pending_consultations = 3;
$admitted_patients = 5;

// A simple list of notifications.
// Later this could come from a "notifications" table.
$notifications = array(
    "New appointment assigned",
    "Lab report is ready",
    "Patient consultation pending"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MediCare | Doctor Dashboard</title>

<style>
    /* ============================================
       STEP 2: Basic page reset and layout
       ============================================ */
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

    /* ============================================
       STEP 3: Sidebar
       ============================================ */
    .sidebar {
        width: 220px;
        background-color: #0b3d66;
        color: white;
        padding: 20px 0;
    }

    .sidebar h2 {
        padding: 0 20px 20px 20px;
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

    /* This class marks the CURRENT page in the sidebar */
    .sidebar a.active {
        background-color: #145a8a;
        border-left: 4px solid #ffffff;
    }

    .sidebar hr {
        border: none;
        border-top: 1px solid #1e5580;
        margin: 15px 20px;
    }

    /* ============================================
       STEP 4: Main content area
       ============================================ */
    .main-content {
        flex: 1;
        padding: 30px;
    }

    .main-content h1 {
        color: #0b3d66;
        margin-bottom: 20px;
    }

    .main-content h2 {
        color: #0b3d66;
        margin-bottom: 15px;
        margin-top: 30px;
        font-size: 20px;
    }

    /* ============================================
       STEP 5: Summary cards
       ============================================ */
    .cards {
        display: flex;
        gap: 20px;
    }

    .card {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        flex: 1;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .card p.label {
        color: #0b3d66;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card p.number {
        font-size: 32px;
        color: #145a8a;
        font-weight: bold;
    }

    /* ============================================
       STEP 6: Quick links (buttons)
       ============================================ */
    .quick-links {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .quick-links a {
        background-color: #145a8a;
        color: white;
        text-decoration: none;
        padding: 15px;
        border-radius: 6px;
        flex: 1 1 45%;
        text-align: center;
        font-weight: bold;
    }

    .quick-links a:hover {
        background-color: #0b3d66;
    }

    /* ============================================
       STEP 7: Notifications box
       ============================================ */
    .notifications {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .notifications ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .notifications li {
        margin-bottom: 8px;
    }
</style>
</head>
<body>

    <!-- ============================================
         STEP 3: Sidebar HTML
         ============================================ -->
    <div class="sidebar">
        <h2>MediCare | Doctor</h2>

        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="patients.php">Patients</a>
        <a href="consultation.php">Consultation</a>
        <a href="prescriptions.php">Prescriptions</a>
        <a href="patient_flow.php">Patient Flow</a>

        <hr>

        <a href="profile.php">Profile</a>
        <a href="change_password.php">Change Password</a>

        <hr>

        <a href="logout.php">Logout</a>
    </div>

    <!-- ============================================
         STEP 4: Main content
         ============================================ -->
    <div class="main-content">
        <h1>Dashboard</h1>

        <!-- ============================================
             STEP 5: Summary cards
             PHP prints the variables set at the top of the file
             ============================================ -->
        <h2>Summary Cards</h2>
        <div class="cards">
            <div class="card">
                <p class="label">Today's Appointments</p>
                <p class="number"><?php echo $today_appointments; ?></p>
            </div>

            <div class="card">
                <p class="label">Pending Consultations</p>
                <p class="number"><?php echo $pending_consultations; ?></p>
            </div>

            <div class="card">
                <p class="label">Admitted Patients</p>
                <p class="number"><?php echo $admitted_patients; ?></p>
            </div>
        </div>

        <!-- ============================================
             STEP 6: Quick links
             ============================================ -->
        <h2>Quick Links</h2>
        <div class="quick-links">
            <a href="patients.php">View Patients</a>
            <a href="consultation.php">Consultation</a>
            <a href="prescriptions.php">Prescriptions</a>
            <a href="patient_flow.php">Patient Flow</a>
        </div>

        <!-- ============================================
             STEP 7: Notifications
             We loop through the $notifications array with foreach
             instead of writing each <li> by hand.
             ============================================ -->
        <h2>Notifications</h2>
        <div class="notifications">
            <ul>
                <?php foreach ($notifications as $note) { ?>
                    <li><?php echo $note; ?></li>
                <?php } ?>
            </ul>
        </div>

    </div>

</body>
</html>
