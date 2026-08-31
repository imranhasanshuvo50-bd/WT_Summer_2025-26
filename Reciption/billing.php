<?php

include "config.php";


// CREATE BILL

if(isset($_POST['save_bill'])){


$invoice_id=$_POST['invoice_id'];
$patient_id=$_POST['patient_id'];
$doctor_id=$_POST['doctor_id'];
$consultation_fee=$_POST['consultation_fee'];
$payment_method=$_POST['payment_method'];
$notes=$_POST['notes'];



mysqli_query($conn,

"INSERT INTO bills

(
invoice_id,
patient_id,
doctor_id,
consultation_fee,
other_fee,
total_amount,
payment_status,
payment_method,
bill_date,
notes
)

VALUES

(
'$invoice_id',
'$patient_id',
'$doctor_id',
'$consultation_fee',
'0',
'$consultation_fee',
'Pending',
'$payment_method',
CURDATE(),
'$notes'
)

");


header("Location: billing.php");
exit();

}




// MARK PAID

if(isset($_GET['paid'])){


$id=$_GET['paid'];


mysqli_query($conn,

"UPDATE bills

SET payment_status='Paid'

WHERE bill_id='$id'"

);


header("Location: billing.php");
exit();

}



$search="";


if(isset($_GET['search'])){

$search=$_GET['search'];

}



?>



<!DOCTYPE html>

<html>

<head>

<title>Billing</title>


<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}


body{
background:#f5f9ff;
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
font-size:22px;
font-weight:bold;
padding:20px;

}



.menu a{

display:block;
padding:14px 20px;
color:white;
text-decoration:none;

}


.menu a:hover,
.active{

background:#2878c8;

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
padding:20px;

}


.profile{

text-decoration:none;
color:#1f426b;
font-weight:bold;

}



.content{

padding:30px;

}



.box{

background:white;
padding:25px;
border-radius:8px;
margin-bottom:25px;

}



input,select,textarea{

width:100%;
padding:10px;
margin-bottom:15px;

}


button{

background:#1f426b;
color:white;
padding:10px 20px;
border:0;
border-radius:5px;

}



table{

width:100%;
border-collapse:collapse;

}



th{

background:#1f426b;
color:white;
padding:12px;

}



td{

padding:12px;
border-bottom:1px solid #ddd;

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


<a class="active" href="billing.php">
Billing
</a>


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

<a class="profile" href="reciption_profile.php">

Nusrat Jahan | Receptionist

</a>

</div>



<div class="content">


<h1>Billing</h1>

<p>Create and manage patient bills</p>





<div class="box">


<h2>Create Bill</h2>


<form method="post">



<input 
type="text"
name="invoice_id"
placeholder="Invoice ID"
required>




<select name="patient_id">


<option>Select Patient</option>


<?php

$p=mysqli_query($conn,

"SELECT patient_id,name FROM patients");


while($row=mysqli_fetch_assoc($p)){

?>


<option value="<?php echo $row['patient_id'];?>">

<?php echo $row['name'];?>

</option>


<?php } ?>


</select>






<select name="doctor_id">


<option>Select Doctor</option>


<?php


$d=mysqli_query($conn,


"SELECT doctors.doctor_id,users.name

FROM doctors

JOIN users

ON doctors.user_id=users.id");


while($doc=mysqli_fetch_assoc($d)){


?>


<option value="<?php echo $doc['doctor_id'];?>">

<?php echo $doc['name'];?>

</option>


<?php } ?>


</select>





<input 
type="number"
name="consultation_fee"
placeholder="Consultation Fee"
required>




<select name="payment_method">

<option>Cash</option>
<option>Card</option>
<option>Online</option>

</select>



<textarea 
name="notes"
placeholder="Notes"></textarea>




<button name="save_bill">

Generate Bill

</button>


</form>


</div>







<div class="box">


<form method="get">


<input 
type="text"
name="search"
placeholder="Search invoice or patient"
value="<?php echo $search;?>">


<button>
Search
</button>


</form>


</div>







<div class="box">


<h2>Bill List</h2>


<table>


<tr>

<th>Invoice</th>
<th>Patient</th>
<th>Doctor</th>
<th>Amount</th>
<th>Status</th>
<th>Action</th>

</tr>



<?php


$result=mysqli_query($conn,


"SELECT

bills.*,

patients.name AS patient_name,

users.name AS doctor_name


FROM bills


LEFT JOIN patients

ON bills.patient_id=patients.patient_id


LEFT JOIN doctors

ON bills.doctor_id=doctors.doctor_id


LEFT JOIN users

ON doctors.user_id=users.id


WHERE 

bills.invoice_id LIKE '%$search%'

OR patients.name LIKE '%$search%'


ORDER BY bill_id DESC"

);



while($row=mysqli_fetch_assoc($result)){


?>


<tr>


<td>
<?php echo $row['invoice_id'];?>
</td>


<td>
<?php echo $row['patient_name'];?>
</td>


<td>
<?php echo $row['doctor_name'];?>
</td>


<td>
<?php echo $row['total_amount'];?>
</td>


<td>
<?php echo $row['payment_status'];?>
</td>



<td>


<?php if($row['payment_status']=="Pending"){ ?>


<a href="billing.php?paid=<?php echo $row['bill_id'];?>">

<button>
Mark Paid
</button>

</a>


<?php } else { echo "Completed"; } ?>


</td>


</tr>


<?php } ?>


</table>


</div>



</div>


</div>


</body>

</html>