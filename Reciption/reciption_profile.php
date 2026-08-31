<?php

session_start();

include "config.php";

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'LIMIT 1");
$user = mysqli_fetch_assoc($result);

if(!$user){

    die("User profile not found");

}


if(isset($_POST['update'])){

    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];

    mysqli_query($conn,"UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$user_id'");

    $_SESSION['name']=$name;

    header("Location: reciption_profile.php");

    exit();
}
?>

<!DOCTYPE html>
<html>

  <head>
    <title>Receptionist Profile</title>
  <style>

  *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
   }

   body{
        background:#f5f9ff;
        color:#17375e;
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

 .menu a:hover,.menu .active{
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
    font-weight:bold;
   }

 .content{
    padding:30px;
  }

   .profile-box{
    background:white;
    padding:30px;
    width:600px;
    border-radius:10px;
    border:1px solid #dbeafe;
   }

 .avatar{
    width:80px;
    height:80px;
    border-radius:50%;
    background:#0b3d91;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    font-weight:bold;
    margin-bottom:20px;
  }

  h1{
    margin-bottom:20px;
    color:#0b3d91;
   }

 label{
    display:block;
    margin-top:15px;
    margin-bottom:5px;
    font-weight:bold;
  }

 input{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:5px;
 }

 button{
    margin-top:20px;
    padding:12px 25px;
    background:#2878c8;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
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
            <a href="reciption_appointments.php">Appointments</a>
            <a href="reciption_patients.php">Patients</a>
            <a href="billing.php">Billing</a>
            <a href="reciption_queue.php">Queue</a>
            <a href="reciption_profile.php" class="active">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="main">
        <div class="topbar">
            <a class="profile" href="reciption_profile.php">
                <?php echo $user['name']; ?> | Receptionist
            </a>
        </div>
        
        <div class="content">
            <h1>My Profile</h1>
            <div class="profile-box">

                <div class="avatar">
                    <?php echo strtoupper(substr($user['name'],0,1)); ?>
                </div>
                
                <form method="post">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $user['name']; ?>">
                    
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>">
                    
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $user['phone']; ?>">

                    <label>Role</label>
                    <input type="text" value="<?php echo $user['role']; ?>"readonly>

                    <button name="update">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>