<!DOCTYPE html>
<html>
    <head>
        <title> PHP Validation</title>
    </head>
<body>
    This is the PHP validation part

 
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
   
    <input type="submit" name="submit" value="Submit">
    <?php echo $error ;?><br><br>
     search Student: <input type="text" name="search" value="">
    <button type="submit" name="search_submit" >Search</button><button type="submit" name="delete">Delete</button><br><br>
    <input type="checkbox" name="checkbox">order by age<br><br>
 
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
        
        if(empty($_POST["name"])||empty($_POST["age"])||empty($_POST["email"])||empty($_POST["phone"])||empty($_POST["address"]))
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

             if (isset($_POST["search_submit"])) {

                    $searchTerm = $_POST["search"];

                    if (empty($searchTerm)) {

                        $searchResult = "Please enter a search term.";

        } 
        else {
            if (isset($_POST["checkbox"])) {
                $sql = "SELECT * FROM student WHERE name='$searchTerm' ORDER BY age DESC";
            } else {
                $sql = "SELECT * FROM student WHERE name='$searchTerm'";
            }
            
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows ($result) > 0) {
            
            for ($i = 0; $i < mysqli_num_rows ($result); $i++) {
                $row = mysqli_fetch_assoc($result);
                echo "Name: " . $row["name"] . "<br>";
                echo "Age: " . $row["age"] . "<br>";
                echo "Email: " . $row["email"] . "<br>";
                echo "Phone: " . $row["phone"] . "<br>";
                echo "Address: " . $row["address"] . "<br><br>";
            }
        } else {
            echo "No results found.";
        }
        }
 
     }

     if(isset($_POST["delete"])) {
        $searchTerm = $_POST["search"];
        if (empty($searchTerm)) {
            echo "Please enter a term to delete.";
        } else {
            $sql = "DELETE FROM student WHERE name='$searchTerm'";
            if (mysqli_query($conn, $sql)) {
                echo "Record deleted successfully.";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
        }

 
    }
    }
?>



</body>

 
</html>