<?php

include "config.php";


$tab = $_GET['tab'] ?? "list";


if(isset($_POST['add_patient'])){


    $patient_code = $_POST['patient_code'];

    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $doctor_id = $_POST['doctor_id'];
    $password = "1234";
    $user_sql = "INSERT INTO users (name,email,phone,pass,role,status) VALUES ('$name','$email','$phone','$password','Patient','active')";
    mysqli_query($conn,$user_sql);



    $user_id = mysqli_insert_id($conn);



    $patient_sql = "INSERT INTO patients

    (

    user_id,

    patient_code,

    name,

    age,

    phone,

    email,

    address,

    doctor_id

    )


    VALUES


    (

    '$user_id',

    '$patient_code',

    '$name',

    '$age',

    '$phone',

    '$email',

    '$address',

    '$doctor_id'

    )";




    mysqli_query($conn,$patient_sql);

    header("Location: reciption_patients.php");

    exit();


}
// SEARCH


$search = "";

if(isset($_GET['search'])){

    $search = $_GET['search'];

}


?>



<!DOCTYPE html>

<html>

<head>

<title>Patients</title>


<style>


*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}


body{

background:#f5f7fa;

color:#172b4d;

}


.sidebar{

width:230px;

height:100vh;

position:fixed;

background:#17375e;

padding-top:25px;

}



.logo{

color:white;

font-size:22px;

font-weight:bold;

padding:0 25px 35px;

}


.menu a{

display:block;

padding:14px 25px;

color:white;

text-decoration:none;

}


.menu a:hover,
.menu .active{

background:#2878c8;

}



.main{

margin-left:230px;

}



.topbar{

height:70px;

background:white;

display:flex;

justify-content:flex-end;

align-items:center;

padding:0 30px;

}



.profile{

text-decoration:none;

color:#17375e;

}



.content{

padding:30px;

}



h1{

color:#17375e;

margin-bottom:10px;

}


p{

color:#666;

margin-bottom:20px;

}



.box,
.table-box{

background:white;

padding:25px;

border-radius:10px;

border:1px solid #ddd;

margin-bottom:20px;

}



input,
select{

width:100%;

padding:10px;

border:1px solid #ccc;

border-radius:5px;

}



.form-row{

display:flex;

gap:20px;

margin-bottom:15px;

}



.form-group{

width:50%;

}



button,
.add-btn{

background:#2878c8;

color:white;

border:none;

padding:10px 18px;

border-radius:5px;

cursor:pointer;

text-decoration:none;

}



table{

width:100%;

border-collapse:collapse;

}



th{

background:#17375e;

color:white;

padding:12px;

text-align:left;

}



td{

padding:12px;

border-bottom:1px solid #ddd;

}



.action{

text-decoration:none;

background:#2878c8;

color:white;

padding:6px 10px;

border-radius:5px;

font-size:13px;

}



.delete{

background:#dc3545;

}



.search{

display:flex;

gap:10px;

margin-bottom:20px;

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


<a href="reciption_patients.php"
class="active">

Patients

</a>


<a href="billing.php">Billing</a>


<a href="reciption_queue.php">

Queue

</a>


<a href="logout">

Logout

</a>


</div>


</div>




<div class="main">


<div class="topbar">

<a href="reciption_profile.php"
class="profile">

Nusrat Jahan | Receptionist

</a>

</div>




<div class="content">
<h1>Patients</h1>


<p>
Manage patient information
</p>




<?php if($tab=="add"){ ?>



<div class="box">


<h2>Add Patient</h2>


<form method="post">



<div class="form-row">


<div class="form-group">

<label>Patient ID</label>

<input type="text"
name="patient_code"
placeholder="P001">

</div>



<div class="form-group">

<label>Name</label>
<input type="text" name="name">
</div>


</div>





<div class="form-row">


<div class="form-group">

<label>Age</label>

<input type="number"
name="age">

</div>



<div class="form-group">

<label>Phone</label>

<input type="text"
name="phone">

</div>



</div>





<div class="form-row">


<div class="form-group">

<label>Email</label>

<input type="email"
name="email">

</div>



<div class="form-group">

<label>Doctor</label>


<select name="doctor_id">


<option>Select Doctor</option>


<?php


$doctors=mysqli_query($conn,

"SELECT doctors.doctor_id,
users.name

FROM doctors

JOIN users

ON doctors.user_id=users.id");


while($d=mysqli_fetch_assoc($doctors)){


echo "

<option value='".$d['doctor_id']."'>
".$d['name']."
</option>";


}


?>


</select>


</div>



</div>





<div class="form-row">

<div class="form-group">

<label>Address</label>

<input type="text"
name="address">


</div>


</div>




<button name="add_patient">

Save Patient

</button>



</form>


</div>



<?php } ?>







<?php if($tab=="list"){ ?>



<a href="reciption_patients.php?tab=add"
class="add-btn">

Add New Patient

</a>



<br><br>




<form class="search">


<input type="text"
name="search"
placeholder="Search patient">


<button>
Search
</button>


</form>




<div class="table-box">


<h2>
Patient List
</h2>


<table>


<tr>

<th>ID</th>

<th>Name</th>

<th>Age</th>

<th>Phone</th>

<th>Action</th>


</tr>



<?php


$sql="SELECT *

FROM patients

WHERE name LIKE '%$search%'";


$result=mysqli_query($conn,$sql);



while($row=mysqli_fetch_assoc($result)){


?>


<tr>


<td>
<?php echo $row['patient_code']; ?>
</td>


<td>
<?php echo $row['name']; ?>
</td>


<td>
<?php echo $row['age']; ?>
</td>


<td>
<?php echo $row['phone']; ?>
</td>



<td>


<a class="action"
href="reciption_patients.php?delete=<?php echo $row['patient_id']; ?>">

Delete

</a>


</td>


</tr>



<?php } ?>



</table>


</div>


<?php } ?>



</div>


</div>


</body>


</html>