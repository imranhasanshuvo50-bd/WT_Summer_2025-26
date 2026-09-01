<?php

session_start();

session_unset();
session_destroy();

?>

<!DOCTYPE html>
<html>

<head>

    <title>
        logout
    </title>

</head>

<body>

    <div class="logoutContainer">

        <div id="heading">
            <label>You are logout</label>
        </div>

        <a href="Login.php">
            <br>
            <button id="loginBtn">
                Login Again
            </button>
        </a>

    </div>

</body>

<style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #cfedfa;
        font-family: Arial, sans-serif;
    }

    .logoutContainer {
        display: flex;
        flex-direction: column;
        padding: 100px 50px 100px 50px;
        margin: 20px;
        background-color: #ffffff;
        border: 2px solid #aeadad;
        border-radius: 8px;
        justify-content: center;
        align-items: center;
    }

    #heading {
        color: #333;
        font-size: 24px;
        margin-bottom: 20px;
    }

    #loginBtn {
        padding: 10px 20px;
        position: relative;
        font-size: 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #loginBtn:hover {
        background-color: #0056b3;
    }

</style>

</html>
