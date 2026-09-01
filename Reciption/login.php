<?php

session_start();

include "config.php";


$error = "";



if($_SERVER["REQUEST_METHOD"] == "POST"){


    $email = $_POST['user-Email'];

    $password = $_POST['password'];



    // check user

    $sql = "SELECT *

            FROM users

            WHERE email='$email'

            AND pass='$password'

            AND status='active'";



    $result = mysqli_query($conn,$sql);



    if(!$result){

        die("SQL Error : ".mysqli_error($conn));

    }



    $user = mysqli_fetch_assoc($result);




    if($user){



        // create session


        $_SESSION['user_id'] = $user['id'];

        $_SESSION['name'] = $user['name'];

        $_SESSION['email'] = $user['email'];

        $_SESSION['role'] = $user['role'];






        // role wise redirect


        if($user['role']=="Admin"){


            header("Location: admin_dashboard.php");

            exit();


        }



        elseif($user['role']=="Doctor"){


            header("Location: doctor_dashboard.php");

            exit();


        }



        elseif($user['role']=="receptionist"){


            header("Location: dashboard_reciption.php");

            exit();


        }



        elseif($user['role']=="Patient"){


            header("Location: patient_dashboard.php");

            exit();


        }



        else{


            $error="Invalid User Role";


        }



    }



    else{


        $error="Invalid Email or Password";


    }



}


?>





<!DOCTYPE html>

<html lang="en">


<head>


<title>MediCare Login</title>



<style>


*{

box-sizing:border-box;

margin:0;

padding:0;

font-family:Arial,sans-serif;

}



body{

background:#e0f2fe;

min-height:100vh;

display:flex;

justify-content:center;

align-items:center;

}



#login{


background:white;

padding:40px 30px;

width:420px;

border-radius:12px;

border:1px solid #cbd5e1;


}



.header{

text-align:center;

margin-bottom:25px;

}



#header{


font-size:32px;

font-weight:bold;

color:#0284c7;

display:block;

}



#subheader{


font-size:15px;

color:#64748b;

display:block;

margin-top:5px;


}



label{


font-size:14px;

font-weight:600;

color:#334155;

display:block;

margin-bottom:6px;

}



input{


width:100%;

padding:12px;

border:1px solid #cbd5e1;

border-radius:8px;

margin-bottom:15px;

font-size:15px;

}



.passwordSection{

position:relative;

}



#showPasswordBtn{


position:absolute;

right:10px;

top:10px;

border:none;

background:none;

cursor:pointer;

color:#64748b;


}



.checkbox-wrapper{


display:flex;

gap:8px;

align-items:center;

margin-bottom:20px;


}



.checkbox-wrapper input{

width:16px;

margin:0;

}



.checkbox-wrapper label{

font-weight:normal;

margin:0;

}



#loginBtn{


width:100%;

padding:12px;

background:#0284c7;

color:white;

border:none;

border-radius:8px;

font-size:16px;

font-weight:bold;

cursor:pointer;


}



#loginBtn:hover{


background:#0369a1;


}



.error-message{


background:#fee2e2;

color:#dc2626;

padding:10px;

border-radius:8px;

margin-bottom:15px;

text-align:center;


}


</style>



</head>



<body>




<form method="post" id="login">



<div class="header">


<label id="header">

MediCare

</label>


<label id="subheader">

Login to your portal

</label>


</div>





<?php if($error!=""){ ?>


<div class="error-message">

<?php echo $error; ?>

</div>


<?php } ?>







<label>

Email

</label>


<input

type="email"

name="user-Email"

placeholder="Enter Email"

required>






<label>

Password

</label>



<div class="passwordSection">


<input

type="password"

id="password"

name="password"

placeholder="Enter Password"

required>



<button

type="button"

id="showPasswordBtn"

onclick="viewPassword()">

Show

</button>


</div>






<div class="checkbox-wrapper">


<input

type="checkbox"

name="remember">



<label>

Remember me

</label>


</div>






<input

type="submit"

name="login"

id="loginBtn"

value="Login">



</form>







<script>


function viewPassword(){


let pass=document.getElementById("password");

let btn=document.getElementById("showPasswordBtn");



if(pass.type==="password"){


pass.type="text";

btn.innerHTML="Hide";


}

else{


pass.type="password";

btn.innerHTML="Show";


}


}


</script>



</body>

</html>