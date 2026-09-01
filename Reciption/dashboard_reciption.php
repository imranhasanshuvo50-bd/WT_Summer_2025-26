<?php

session_start();

include "config.php";


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();

}

$receptionist_name = $_SESSION['name'];

$patients=mysqli_query($conn,"SELECT COUNT(*) AS total FROM patients");
$total_patients=mysqli_fetch_assoc($patients)['total'];

$appointments=mysqli_query($conn,"SELECT COUNT(*) AS total FROM appointments WHERE appointment_date = CURDATE()");

$today_appointments=mysqli_fetch_assoc($appointments)['total'];

$queue=mysqli_query($conn,"SELECT COUNT(*) AS total FROM queue WHERE status='Waiting'");
$waiting_queue=mysqli_fetch_assoc($queue)['total'];
$pending=mysqli_query($conn,"SELECT COUNT(*) AS total FROM appointments WHERE status='Pending'");
$pending_bills=mysqli_fetch_assoc($pending)['total'];


$overview=mysqli_query($conn,"SELECT appointments.appointment_time,patients.name AS patient_name,users.name AS doctor_name,appointments.status FROM appointments
                              LEFT JOIN patients ON appointments.patient_id = patients.patient_id LEFT JOIN doctors ON appointments.doctor_id = doctors.doctor_id
                              LEFT JOIN users ON doctors.user_id = users.id WHERE appointments.appointment_date = CURDATE() ORDER BY appointments.appointment_time ASC LIMIT 5");

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Receptionist Dashboard</title>

<style>


*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f5f9ff;
color:#1e293b;
}

.sidebar{
width:220px;
height:100vh;
position:fixed;
left:0;
top:0;
background:#1f426b;
padding-top:25px;
}

.logo{
color:white;
font-size:20px;
font-weight:bold;
padding:0 20px 35px;
}

.menu a{
display:block;
color:white;
text-decoration:none;
padding:14px 20px;
font-size:14px;
}

.menu a:hover,.menu a.active{
    background:#0b5ed7;
    border-left:4px solid white;
}

.main{
margin-left:220px;
}

.topbar{
height:70px;
background:white;
border-bottom:1px solid #dbe3ec;
display:flex;
align-items:center;
justify-content:flex-end;
padding:0 30px;
}

.profile-link{
display:flex;
align-items:center;
gap:10px;
text-decoration:none;
color:#1e293b;
}

.profile-photo{

width:40px;

height:40px;

border-radius:50%;

background:#0b3d91;

color:white;

display:flex;

align-items:center;

justify-content:center;

font-weight:bold;


}


.profile-name{

display:flex;
flex-direction:column;
}

.profile-name strong{
font-size:13px;
}

.profile-name span{
font-size:11px;
color:#64748b;
}

.content{
padding:30px;
}

.welcome{
margin-bottom:25px;
}

.welcome h1{
font-size:25px;
color:#0b3d91;
margin-bottom:7px;
}

.welcome p{
font-size:14px;
color:#64748b;
}

.summary{

display:flex;
gap:20px;
margin-bottom:35px;

}

.summary-card{
width:33.33%;
min-height:115px;
padding:20px;
border-radius:10px;
background:white;
border:1px solid #dbeafe;
}

.summary-card p{
font-size:14px;
color:#64748b;
margin-bottom:8px;

}

.summary-card h2{

font-size:28px;
color:#0b3d91;
}

.section-title{

font-size:19px;

color:#0b3d91;

margin-bottom:15px;
}

.actions{
display:grid;
grid-template-columns:1fr 1fr;
gap:18px;
margin-bottom:35px;

}

.action-card{

min-height:85px;
border-radius:10px;
padding:20px;
display:flex;
align-items:center;
justify-content:space-between;
text-decoration:none;
background:#1f426b;
}

.action-card:hover{
background:#1556b0;
}

.action-text{
font-size:14px;

color:white;

font-weight:bold;
}

.arrow{
font-size:22px;
color:white;
}

.overview{
background:white;
border:1px solid #dbeafe;
border-radius:10px;
overflow:hidden;
}

.overview-title{

background:#eaf3ff;

color:#0b3d91;

padding:15px 20px;

font-size:14px;

font-weight:bold;


}

.appointment{
display:grid;
grid-template-columns:1fr 2fr 2fr 1fr;
padding:15px 20px;
border-bottom:1px solid #edf2f7;
font-size:13px;
}

</style>
<body>
    <div class="sidebar">
        <div class="logo">Medicare</div>
        
        <div class="menu">
            <a href="dashboard_reciption.php" class="active">Dashboard</a>
            <a href="reciption_appointments.php">Appointments</a>
            <a href="reciption_patients.php">Patients</a>
            <a href="billing.php">Billing</a>
            <a href="reciption_queue.php">Queue</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="main">
        <div class="topbar">
            <a href="reciption_profile.php" class="profile-link">
                <div class="profile-photo">
                    <?php echo strtoupper(substr($receptionist_name,0,1)); ?>
                </div>
                
                <div class="profile-name">
                    <strong><?php echo $receptionist_name; ?></strong><span>Receptionist</span>
                </div>
            </a>
        </div>
        <div class="content">
            <div class="welcome">
                <h1>Welcome back, <?php echo $receptionist_name; ?>!</h1>
                <p>Here's what's happening today.</p>
            </div>
            
            <div class="summary">
                <div class="summary-card">
                    <p>Today's Appointments</p>
                    <h2><?php echo $today_appointments; ?></h2>
                </div>
                
                <div class="summary-card">
                    <p>Waiting Queue</p>
                    <h2><?php echo $waiting_queue; ?></h2>
                </div>
                
                <div class="summary-card">
                    <p>Pending Appointment</p>
                    <h2><?php echo $pending_bills; ?></h2>
                </div>
            </div>

            <h2 class="section-title">Quick Actions</h2>
            <div class="actions">
                <a href="reciption_appointments.php?action=add" class="action-card">
                    <div class="action-text">Book Appointment</div>
                    <div class="arrow"> > </div>
                </a>
                
                <a href="reciption_patients.php?tab=add" class="action-card">
                    <div class="action-text">Register Patient</div>
                    <div class="arrow">></div>
                </a>
                
                <a href="reciption_queue.php" class="action-card">
                      <div class="action-text">Check-in Patient</div>
                      <div class="arrow">> </div>
                </a>
                
                <a href="billing.php" class="action-card">
                    <div class="action-text">Generate Receipt</div>
                    <div class="arrow">></div>
                </a>
            </div>
            
            <h2 class="section-title">Today's Overview</h2>
            <div class="overview">
                <div class="overview-title">Today's appointments</div>
                <?php
                  if(mysqli_num_rows($overview)>0){
                    while($row=mysqli_fetch_assoc($overview)){
                ?>
                <div class="appointment">
                    <div><?php echo $row['appointment_time']; ?></div>
                    <div><?php echo $row['patient_name']; ?></div>
                    <div>Dr. <?php echo $row['doctor_name']; ?></div>
                    <div><?php echo $row['status']; ?></div>
                </div>
                <?php}
            }
            else{
                echo "<div style='padding:20px;color:#64748b'>No appointments today</div>";
                }
              ?>
            </div>
        </div>
    </div>
</body>
</html>