<?php session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

unset($_SESSION["account"]);
if ( isset($_POST["account"]) && isset($_POST["password"])) {
    $user = $conn -> real_escape_string($_POST['account']); 
    $pass = $conn -> real_escape_string($_POST['password']); 
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result == true && $result->num_rows > 0) {
        $_SESSION["account"] = $_POST["account"];
        $_SESSION["success"] = "You have logged in successfully";
        header('Location: index.php');
        return;
    } else {
        $_SESSION["error"] = "Incorrect password";
        header('Location: login.php');
        return; 
    } 
} else if (count($_POST) > 0) {
    $_SESSION["error"] = "Missing required information";
    header('Location: login.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <style>
        <?php include '../css/style.css'; ?>
        body {
            width: 100%;
            height: 100vh;
            background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url(../images/topbook.jpeg);
            background-size: cover;
            background-position: center;
        }
    </style>
    <title>Book Reservation</title>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href = "index.php"> Home </a></li>
            <li><a href = "books.php"> Reserve a Book </a></li>
            <li><a href = "reserved.php"> My Books </a></li>
            <li><a class ="active" href = "login.php"> Log In </a></li>
        </ul>
    </div>
    <div style="clear:both"></div>

    <div class="login">

    <h1>Log In</h1>
    <form method="post">
        <p>Username </p>
        <input type="text" name="account" placeholder="Username" value="" required>

        <p>Password </p>
        <input type="password" name="password" placeholder="Password" value="" required>
        <button type="submit" value="Log In">Login</button>
    </form>

    <?php
    if ( isset($_SESSION["error"])) {
        echo('<p style="color:red">ERROR:'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
    ?>
        Don't have an account? <a href="register.php"> Click here </a> to register
    </div>


</body>
</html>
