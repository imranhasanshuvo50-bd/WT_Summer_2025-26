<?php

$appointments = [
    ["10:00 AM", "John Doe", "Dr. Rashedin", "Confirmed"],
    ["10:30 AM", "Sara Ahmed", "Dr. Karim", "Waiting"],
    ["11:00 AM", "Rahim Hasan", "Dr. Rashedin", "Confirmed"],
    ["11:30 AM", "Nusrat Jahan", "Dr. Karim", "Pending"]
];

$showAddAppointment = false;

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $showAddAppointment = true;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF_8">
        <meta name="viewport" content="width=device-width ,initial-scale =1.0">
        <title> Appointments</title>

        <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif
         }

        body{
            background:#f5f9ff;
            color:#1e293b
        }
        
        .sidebar{
            width:220px;
            height:100vh;
            position:fixed;
            top:0;
            left:0;
            background:#1f426b;
            padding-top:25px;
        }

        .logo{
            color:#fff;
            font-size:20px;
            font-weight:bold;
            padding:0 20px 25px
        }
        
        .menu a{
            display:block;
            color:#fff;
            text-decoration:none;
            padding:14px 20px;
            font-size:15px;
        }

        .menu a:hover{
            background:#2c5d91
        }

        .menu a.active{
            background:#2f80c9
        }

        .main{
            margin-left:220px
        }

        .topbar{
            height:65px;
            background:#fff;
            border-bottom:1px solid #dbe3ec;
            display:flex;
            align-items:center;
            justify-content:flex-end;
            padding:0 30px;
        }

        .profile{
            font-size:14px;
            color:#1f426b;
            text-decoration:none;
            font-weight:bold
        }

        .content{
            padding:30px
        }

        .page-title{
            margin-bottom:25px
        }

        .page-title h1{
            font-size:25px;
            color:#1f426b;
            margin-bottom:5px
        }

        .page-title p{
            font-size:14px;
            color:#64748b
        }

       .button-area{
         display:grid;
         grid-template-columns:1fr 1fr;
         gap:20px; 
         margin-bottom:30px;
        }

        .page-button{
             min-height:95px;
             background:#1f426b;
             color:#fff;
             border:0;
             border-radius:8px;
             padding:18px;
             text-align:left;
             cursor:pointer;
             font-size:16px;
             font-weight:bold;
            }

        .page-button:hover{
            background:#2c5d91
        }

       .page-button span{
          display:block;
          font-size:13px;
          font-weight:normal;
          margin-top:7px;
          color:#dbeafe
        }

        .form-box,.table-box{
             background:#fff;
             border:1px solid #dbeafe;
             border-radius:8px;
             padding:22px;
             margin-bottom:25px;
        }

        .form-box h2,.section-title{
            font-size:19px;
            color:#1f426b;
            margin-bottom:18px
        }

        .form-group{
            margin-bottom:15px
        }

        .form-group label{
            display:block;
            font-size:13px;
            margin-bottom:6px
        }

        .form-group input,.form-group select{
            width:100%;
            padding:10px;
            border:1px solid #cbd5e1;
            border-radius:5px;
        }

        .submit-button{
             background:#1f426b;
             color:#fff;
             border:0;
             padding:11px 20px;
             border-radius:5px;
             cursor:pointer;
        }

        .submit-button:hover{
            background:#2c5d91
        }

        .hidden{
            display:none
        }

        table{
            width:100%;
            border-collapse:collapse
        }

        th{
            background:#1f426b;
            color:#fff;
            text-align:left;
            padding:13px;
            font-size:13px
        }

        td{
            padding:13px;
            border-bottom:1px solid #edf2f7;
            font-size:13px
        }

        tr:last-child td{
            border-bottom:0
        }
        </style>
    </head>

    <body>
      <div class="sidebar">
          <div class="logo">Medicare</div>
           <div class="menu">
               <a href="dashboard_reciption.php">Dashboard</a>
               <a href="reciption_appointments.php" class="active">Appointments</a>
               <a href="reciption_patients.php">Patients</a>
               <a href="billing.php">Billing</a>
               <a href="reciption_queue.php">Queue</a>
               <a href="logout">Logout</a>
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
            <button class="page-button" onclick="showSection('addAppointment')">
                Add Appointment
                <span>Create a new patient appointment</span>
            </button>

            <button class="page-button" onclick="showSection('todayAppointment')">
                Today's Appointments
                <span>View today's appointment list</span>
            </button>

            <button class="page-button" onclick="showSection('upcomingAppointment')">
                Upcoming Appointments
                <span>View upcoming appointments</span>
            </button>

            <button class="page-button" onclick="showSection('allAppointment')">
                All Appointments
                <span>View all appointment records</span>
            </button>
          </div> 

           <div id="addAppointment" class="form-box"
             style="<?php echo $showAddAppointment ? 'display:block;' : 'display:none;'; ?>">
             <h2>Add Appointment</h2>

             <div class="form-group">
                <label>Patient Name</label>
                <input type="text" placeholder="Enter patient name">
             </div>

             <div class="form-group">
                <label>Doctor</label>
                <select>
                    <option>Select Doctor</option>
                    <option>Dr. Rashedin</option>
                    <option>Dr. Karim</option>
                </select>
             </div>
             
             <div class="form-group">
                <label>Date</label>
                <input type="date">
             </div>

             <div class="form-group">
                <label>Time</label>
                <input type="time">
             </div>

             <button class="submit-button">Save Appointment</button>
            </div>
            
            <div id="todayAppointment" class="hidden">
             <h2 class="section-title">Today's Appointments</h2>
             <div class="table-box">
                <table>
                    <tr><th>Time</th><th>Patient</th><th>Doctor</th><th>Status</th></tr>
                    <?php foreach ($appointments as $a) { ?>
                    <tr>
                        <td><?= $a[0] ?></td>
                        <td><?= $a[1] ?></td>
                        <td><?= $a[2] ?></td>
                        <td><?= $a[3] ?></td>
                    </tr>
                    <?php } ?>
                </table>
             </div>
            </div>

            <div id="upcomingAppointment" class="hidden">
             <h2 class="section-title">Upcoming Appointments</h2>
             <div class="table-box">
                <table>
                    <tr><th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th></tr>
                    <tr><td>27 Aug 2026</td><td>10:00 AM</td><td>John Doe</td><td>Dr. Rashedin</td></tr>
                    <tr><td>27 Aug 2026</td><td>11:00 AM</td><td>Sara Ahmed</td><td>Dr. Karim</td></tr>
                </table>
             </div>
            </div>

            <div id="allAppointment" class="hidden">
             <h2 class="section-title">All Appointments</h2>
             <div class="table-box">
                <table>
                    <tr><th>Time</th><th>Patient</th><th>Doctor</th><th>Status</th></tr>
                    <?php foreach ($appointments as $a) { ?>
                    <tr>
                        <td><?= $a[0] ?></td>
                        <td><?= $a[1] ?></td>
                        <td><?= $a[2] ?></td>
                        <td><?= $a[3] ?></td>
                    </tr>
                    <?php } ?>
                </table>
              </div>
            </div>
          </div>
        </div>

     <script>
        function showSection(id){
         ['addAppointment','todayAppointment','upcomingAppointment','allAppointment']
         .forEach(x => document.getElementById(x).style.display='none');
           document.getElementById(id).style.display='block';
        }
     </script> 
    </body>
</html>
