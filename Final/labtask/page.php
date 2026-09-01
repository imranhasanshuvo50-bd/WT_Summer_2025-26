
<?php

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_Email = $_POST["user-Email"];
    $pass = $_POST["password"];
    $remember = isset($_POST["remember"]);

    $sql = "SELECT * FROM USERS WHERE EMAIL = '$user_Email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);

        if ($user["pass"] == $pass) {

            $_SESSION["user-Email"] = $user_Email;

            if ($remember) {
                setcookie(
                    "user-Email",
                    $user_Email,
                    time() + (86400 * 30),
                    "/"
                );
            }

            if ($user["role"] == "Admin" && $user["status"] == "Active") {
                header("Location: dashbord.php");
                exit();
            }

        } else {
            $error = "Invalid user-Email or password";
        }

    } else {
        $error = "Invalid user-Email or password";
    }
}
?>
```


<!DOCTYPE html>
<html>
    <form method ="post">
    Name: <input type="text" name="name"><br>
    Registration No: <input type="number" name="registration_no"><br>
    Department  :<select name="department">
        <option value="Computer Science">Computer Science</option>
        <option value="Mathematics">Mathematics</option>
        <option value="Physics">Physics</option>
    </select><br>
    <input type="submit" value="add_user">
</form>
</html>