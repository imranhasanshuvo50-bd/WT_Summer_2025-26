<?php

include "config.php";


// ADD QUEUE

if(isset($_POST['add_queue'])){


    $patient_id = $_POST['patient_id'];

    $doctor_id = $_POST['doctor_id'];



    // Generate token

    $token_result = mysqli_query($conn,

    "SELECT MAX(token_number) AS last_token 
    FROM queue");


    $token_data = mysqli_fetch_assoc($token_result);


    $token = $token_data['last_token'] + 1;



    mysqli_query($conn,


    "INSERT INTO queue

    (
        token_number,
        patient_id,
        doctor_id,
        status
    )

    VALUES

    (
        '$token',
        '$patient_id',
        '$doctor_id',
        'Waiting'
    )"

    );



    header("Location: reciption_queue.php");

    exit();


}




// NEXT PATIENT

if(isset($_GET['next'])){


    $queue_id=$_GET['next'];



    mysqli_query($conn,


    "UPDATE queue

    SET status='In Consultation'

    WHERE queue_id='$queue_id'"

    );



    header("Location: reciption_queue.php");

    exit();


}



?>



<!DOCTYPE html>

<html>

<head>


<title>Queue</title>


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

background:#1f426b;

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

}



.menu a:hover,
.menu .active{

background:#2f80c9;

}



.main{

margin-left:220px;

}



.topbar{

height:65px;

background:white;

display:flex;

justify-content:flex-end;

align-items:center;

padding:0 30px;

}



.profile{

color:#1f426b;

text-decoration:none;

font-weight:bold;

}



.content{

padding:30px;

}



h1{

color:#1f426b;

margin-bottom:5px;

}



p{

color:#64748b;

margin-bottom:25px;

}



.box,
.table-box{

background:white;

border:1px solid #dbeafe;

border-radius:8px;

padding:22px;

margin-bottom:25px;

}



.form-group{

margin-bottom:15px;

}



label{

display:block;

font-size:14px;

margin-bottom:6px;

}



input,
select{

width:100%;

padding:10px;

border:1px solid #cbd5e1;

border-radius:5px;

}



button{

background:#1f426b;

color:white;

border:none;

padding:10px 20px;

border-radius:5px;

cursor:pointer;

}



button:hover{

background:#2c5d91;

}



table{

width:100%;

border-collapse:collapse;

}



th{

background:#1f426b;

color:white;

padding:13px;

text-align:left;

}



td{

padding:13px;

border-bottom:1px solid #eee;

}



.action{

background:#2878c8;

color:white;

padding:7px 12px;

text-decoration:none;

border-radius:5px;

font-size:13px;

}


</style>


</head>


<body>



<div class="sidebar">


<div class="logo">

Medicare

</div>


<div class="menu">


<a href="dashboard_reciption.php">

Dashboard

</a>


<a href="reciption_appointments.php">

Appointments

</a>


<a href="reciption_patients.php">

Patients

</a>


<a href="billing.php">

Billing

</a>


<a href="reciption_queue.php" class="active">

Queue

</a>


<a href="logout">

Logout

</a>


</div>


</div>





<div class="main">


<div class="topbar">


<a href="reciption_profile.php" class="profile">

Nusrat Jahan | Receptionist

</a>


</div>
<div class="content">


<h1>
Queue Management
</h1>


<p>
Manage patient waiting queue.
</p>





<!-- ================= -->
<!-- ADD QUEUE -->
<!-- ================= -->


<div class="box">


<h2>
Add Patient To Queue
</h2>


<br>


<form method="post">



<div class="form-group">


<label>
Patient
</label>



<select name="patient_id" required>


<option>
Select Patient
</option>




<?php


$patients=mysqli_query($conn,


"SELECT patient_id,name

FROM patients

ORDER BY name ASC"

);



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


<label>
Doctor
</label>



<select name="doctor_id" required>



<option>
Select Doctor
</option>





<?php


$doctors=mysqli_query($conn,


"SELECT 

doctors.doctor_id,

users.name


FROM doctors


JOIN users


ON doctors.user_id = users.id


ORDER BY users.name ASC"

);





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







<button name="add_queue">

Add To Queue

</button>



</form>



</div>









<!-- ================= -->
<!-- QUEUE LIST -->
<!-- ================= -->



<div class="table-box">


<h2>

Current Queue

</h2>


<br>



<table>


<tr>

<th>
Token
</th>


<th>
Patient
</th>


<th>
Doctor
</th>


<th>
Status
</th>


<th>
Check In Time
</th>


<th>
Action
</th>


</tr>





<?php



$result=mysqli_query($conn,


"SELECT


queue.*,


patients.name AS patient_name,


users.name AS doctor_name



FROM queue




LEFT JOIN patients

ON queue.patient_id = patients.patient_id




LEFT JOIN doctors

ON queue.doctor_id = doctors.doctor_id




LEFT JOIN users

ON doctors.user_id = users.id




ORDER BY queue.queue_id ASC"

);





while($row=mysqli_fetch_assoc($result)){


?>



<tr>



<td>

<?php echo $row['token_number']; ?>

</td>





<td>

<?php echo $row['patient_name']; ?>

</td>





<td>

<?php echo $row['doctor_name']; ?>

</td>





<td>

<?php echo $row['status']; ?>

</td>





<td>

<?php echo $row['check_in_time']; ?>

</td>





<td>


<?php if($row['status']=="Waiting"){ ?>


<a class="action"

href="reciption_queue.php?next=<?php echo $row['queue_id']; ?>">

Next Patient

</a>


<?php } else { ?>


Completed


<?php } ?>



</td>



</tr>



<?php

}

?>




</table>



</div>

</div>
<!-- content end -->


</div>
<!-- main end -->



</body>

</html>