<?php session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(../images/bookstack2.jpg);
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
            <li><a class ="active" href = "books.php"> Reserve a Book </a></li>
            <li><a href = "reserved.php"> My Books </a></li>
            <li><a href = "login.php"> Log In </a></li>
        </ul>
    </div>
    <div style="clear:both"></div>
    <?php
    //if user isnt logged in
    if ( !isset($_SESSION["account"])) {
        ?> 
        <div class = "access">
            <p> Please <a href='login.php'> LOGIN </a> to reserve a book </p>
        </div> <?php 
    
    //if user is logged in
    } else { 

        if (isset($_GET['id'])){
            $id = $conn -> real_escape_string($_GET['id']); //ISBN from GET id from url
            $n = $_SESSION["account"]; //username from current session
            $d = date("Y-m-d"); //current date in year-month-date format

            //insert values into reservations db
            $sql = "INSERT INTO reservations(ISBN, username, reservedate) VALUES ('$id', '$n', '$d')";
            if ($conn->query($sql) === TRUE) {

                //aligning the books reserved field if book is present in reservations table 
                $sql = "UPDATE books SET reserved = 'Y' WHERE ISBN = '$id'";
                $conn->query($sql);
                echo '<div class = "access">';
                echo "<p>Book reserved successfully</p>";
                echo '<p>View your reserved books <a href="reserved.php"> HERE </a></p>';
            }
            else {
                echo "<p>Error: " . $sql . "</p><br>" . $conn->error;
                echo '</div>';
            }
        }
        $conn->close();
    }
?>
</body>
</html>