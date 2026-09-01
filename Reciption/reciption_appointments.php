<?php

include "config.php";


$showAddAppointment = false;

if(isset($_GET['action']) && $_GET['action']=="add")
{
    $showAddAppointment = true;
}

if(isset($_POST['save_appointment']))
{


    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    $sql = "INSERT INTO appointments (patient_id,doctor_id,appointment_date,appointment_time,status ) VALUES ( '$patient_id', '$doctor_id', '$date', '$time', 'Pending')";
     mysqli_query($conn,$sql);
    header("Location: reciption_appointments.php");
    exit();

}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Appointments</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{

    background: #f5f9ff;
    color: #1e293b;

}

.sidebar{

    width:220px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background: #1f426b;
    padding-top:25px;

}

.logo{

    color:white;
    font-size:20px;
    font-weight:bold;
    padding:0 20px 25px;
}

.menu a{

    display:block;
    color:white;
    text-decoration:none;
    padding:14px 20px;
    font-size:15px;
}

.menu a:hover{
    background: #2c5d91;
}

.menu a.active{
    background: #2f80c9;
}

.main{
    margin-left:220px;
}

.topbar{

    height:65px;
    background:white;
    border-bottom:1px solid #dbe3ec;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    padding:0 30px;

}

.profile{

    text-decoration:none;
    color: #1f426b;
    font-weight:bold;
    font-size:14px;

}

.content{
    padding:30px;
}


.page-title h1{

    color: #1f426b;
    font-size:25px;
    margin-bottom:5px;
}

.page-title p{
    color: #64748b;
    font-size:14px;
    margin-bottom:25px;
}


.button-area{

    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:30px;

}



.page-button{
    min-height:95px;
    background: #1f426b;
    color:white;
    border:none;
    border-radius:8px;
    padding:18px;
    text-align:left;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;

}

.page-button:hover{

    background: #2c5d91;
}

.page-button span{

    display:block;

    font-size:13px;

    margin-top:7px;

    color: #dbeafe;

}

.form-box,
.table-box{

    background:white;

    border:1px solid #dbeafe;

    border-radius:8px;

    padding:22px;

    margin-bottom:25px;

}

.form-box h2,
.section-title{

    color: #1f426b;
    font-size:19px;
    margin-bottom:18px;
}

.form-group{

    margin-bottom:15px;
}



.form-group label{

    display:block;
    font-size:13px;
    margin-bottom:6px;

}



.form-group input,
.form-group select{
    width:100%;
    padding:10px;
    border:1px solid #cbd5e1;
    border-radius:5px;
}

.submit-button{
    background: #1f426b;
    color:white;
    border:none;
    padding:11px 20px;
    border-radius:5px;
    cursor:pointer;
}

.submit-button:hover{

    background: #2c5d91;

}

.hidden{

    display:none;

}

table{

    width:100%;
    border-collapse:collapse;

}


th{
    background: #1f426b;
    color:white;
    text-align:left;
    padding:13px;
    font-size:13px;

}

td{
    padding:13px;
    border-bottom:1px solid #edf2f7;
    font-size:13px;
}

tr:last-child td{
    border-bottom:none;
}

</style>

</head>
<body>



<div class="sidebar">
    <div class="logo">
        Medicare
    </div>
    
    <div class="menu">
        <a href="dashboard_reciption.php">Dashboard</a>
        <a href="reciption_appointments.php" class="active">Appointments</a>
        <a href="reciption_patients.php">Patients</a>
        <a href="billing.php">Billing</a>
        <a href="reciption_queue.php">Queue</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="main">
    <div class="topbar">
        <a href="reciption_profile.php" class="profile">Nusrat Jahan | Receptionist</a>
    </div>
    
    <div class="content">
        <div class="page-title">
            <h1>Appointments</h1>
            <p>Manage patient appointments.</p>
        </div>
        
        <div class="button-area">
            <button class="page-button" onclick="showSection('addAppointment')">Add Appointment
                <span>Create a new patient appointment</span>
            </button>
            
            <button class="page-button" onclick="showSection('todayAppointment')">Today's Appointments
                <span>View today's appointment list</span>
            </button>
            
            <button class="page-button" onclick="showSection('upcomingAppointment')">Upcoming Appointments
                <span>View upcoming appointment list</span>
            </button>
            
            <button class="page-button" onclick="showSection('allAppointment')">All Appointments
                <span>View all records</span>
            </button>
        </div>
        
        <div id="addAppointment" class="form-box" style="<?php echo $showAddAppointment ? 'display:block;' : 'display:none;'; ?>">
            <h2>Add Appointment</h2>
            <form method="post">
                <div class="form-group">
                    <label>Patient</label>
                    <select name="patient_id">
                        <option>Select Patient</option>
                        <?php $patients = mysqli_query($conn,"SELECT patient_id,name FROM patients");
                        while($p=mysqli_fetch_assoc($patients)){
                            ?>
                        <option value="<?php echo $p['patient_id']; ?>">
                            <?php echo $p['name']; ?>
                        </option>
                        
                        <?php
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Doctor</label>
                    <select name="doctor_id">
                        <option>Select Doctor</option>
                        <?php
                        $doctors=mysqli_query($conn,"SELECT doctors.doctor_id,users.name FROM doctors JOIN users ON doctors.user_id = users.id");
                        while($d=mysqli_fetch_assoc($doctors)){
                        ?>
                        
                        <option value="<?php echo $d['doctor_id']; ?>">
                            <?php echo $d['name']; ?>
                        </option>
                        
                        <?php
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="appointment_date">
                </div>
                
                <div class="form-group">
                    <label>Time</label>
                    <input type="time" name="appointment_time">
                </div>
                <button class="submit-button" name="save_appointment">Save Appointment</button>
            </form>
        </div>
        
        <div id="todayAppointment" class="hidden">
            <h2 class="section-title">Today's Appointments</h2>
            <div class="table-box">
                <table>
                    <tr>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Status</th>
                    </tr>
                    <?php $today=mysqli_query($conn,"SELECT appointments.appointment_time,patients.name AS patient_name,
                                                    users.name AS doctor_name,appointments.status FROM appointments
                                                    LEFT JOIN patients ON appointments.patient_id = patients.patient_id
                                                    LEFT JOIN doctors ON appointments.doctor_id = doctors.doctor_id
                                                    LEFT JOIN users ON doctors.user_id = users.id
                                                    WHERE appointments.appointment_date = CURDATE()
                                                    ORDER BY appointments.appointment_time ASC");
                        while($row=mysqli_fetch_assoc($today)){
                    ?>
                        
                        <tr>
                            <td><?php echo $row['appointment_time']; ?></td>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo $row['doctor_name']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            
            <div id="upcomingAppointment" class="hidden">
                <h2 class="section-title">Upcoming Appointments</h2>
                <div class="table-box">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Status</th>
                        </tr>
                        
                        <?php $upcoming=mysqli_query($conn,"SELECT appointments.appointment_date,appointments.appointment_time,
                                                           patients.name AS patient_name,users.name AS doctor_name,appointments.status
                                                           FROM appointments LEFT JOIN patients ON appointments.patient_id = patients.patient_id
                                                           LEFT JOIN doctors ON appointments.doctor_id = doctors.doctor_id
                                                           LEFT JOIN users ON doctors.user_id = users.id
                                                           WHERE appointments.appointment_date > CURDATE()
                                                           ORDER BY appointments.appointment_date ASC");
                        while($row=mysqli_fetch_assoc($upcoming)){
                        ?>
                        <tr>
                            <td><?php echo $row['appointment_date']; ?></td>
                            <td><?php echo $row['appointment_time']; ?></td>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo $row['doctor_name']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    
                    </table>
                </div>
            </div>
            <div id="allAppointment" class="hidden">
                <h2 class="section-title">All Appointments</h2>
                <div class="table-box">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Status</th>
                        </tr>
                        
                        <?php $all=mysqli_query($conn,"SELECT appointments.appointment_date,appointments.appointment_time,patients.name AS patient_name,
                                                       users.name AS doctor_name,appointments.status FROM appointments LEFT JOIN patients ON appointments.patient_id = patients.patient_id
                                                       LEFT JOIN doctors ON appointments.doctor_id = doctors.doctor_id
                                                       LEFT JOIN users ON doctors.user_id = users.id ORDER BY appointments.id DESC");
                                while($row=mysqli_fetch_assoc($all)){
                                    ?>
                                    <tr>
                                        <td><?php echo $row['appointment_date']; ?></td>
                                        <td><?php echo $row['appointment_time']; ?></td>
                                        <td><?php echo $row['patient_name']; ?></td>
                                        <td><?php echo $row['doctor_name']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                    
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
            
         <script>
              function showSection(id){
                let sections = ['addAppointment','todayAppointment','upcomingAppointment','allAppointment'];
                sections.forEach(function(section){
                    document.getElementById(section).style.display="none";
                });
                
                document.getElementById(id).style.display="block";
               }
         </script>
        </body>
    </html>