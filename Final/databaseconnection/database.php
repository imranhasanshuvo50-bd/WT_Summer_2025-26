<!DOCTYPE html>
<html>
    <head>
        <title> PHP Validation</title>
    </head>
<body>
    This is the PHP validation part

<?php
$name="";
$age="";
$email="";
$phone="";
$error="";
$confirmation="";
include 'config.php';
if ($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $name=$_POST["name"]; 
        $age=$_POST["age"];
        $email=$_POST["email"];
        $phone=$_POST["phone"]; 
        $address=$_POST["address"];
        if(empty($_POST["name"])||empty($_POST["age"]))
            {
                $error="Please fill the form";
            }
        else
            {
                $sql="INSERT INTO student(name,age,email,phone,address) VALUES('$name','$age','$email','$phone','$address')"; 
                if(mysqli_query($conn,$sql))
                    {
                        $confirmation="Data inserted successfully";
                    }
                else
                    {
                        $error="Insert failed: " . mysqli_error($conn);
                    }

            }
 

 
    }
 
?>
 asdsad
 
<form method="post" action="">
   
 
    Name:
    <input type="text" name="name" value="">
  
    
    <br><br>
 
    Age:
    <input type="text" name="age" value=""><br><br>
    email:
    <input type="text" name="email" value="">
    Phone:
    <input type="text" name="phone" value=""><br><br>
    Address:
    <textarea name="address" value=""></textarea><br><br>
    search Student: <input type="text" name="search" value="">
    <button type="search" name="search">Search</button><br><br>
    <input type="submit" name="submit" value="Submit">
    <?php echo $error ;?>
 
</form>
 
<?php
if ($_SERVER["REQUEST_METHOD"]=="POST" && empty($error) && !empty($confirmation))
    {
        echo $confirmation;
echo"The input is <br>";
echo "The name :  $name <br>";
echo "The age is : $age <br>";
echo "The email is : $email <br>";
echo "The phone is : $phone <br>";
echo "The address is : $address <br>";


    }
 
?>
</body>

 
</html>