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
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url(../images/topbook.jpeg);
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
            <li><a class ="active" href = "reserved.php"> My Books </a></li>
            <li><a href = "login.php"> Log In </a></li>
        </ul>
    </div>
    <div style="clear:both"></div>
    <?php
    if ( !isset($_SESSION["account"])) {
        ?> 
        <div class = "access">
            <p> Please <a href='login.php'> LOGIN </a> to view your reserved books </p>
        </div> <?php 
    } else { ?>
    <?php

    $acc = $_SESSION["account"];
    $sql = "SELECT reservations.ISBN, booktitle, author, edition, year, category, reservations.username, reservations.reservedate FROM books
    RIGHT JOIN reservations ON books.ISBN = reservations.ISBN
    WHERE reservations.username = '$acc'
    GROUP BY reservations.ISBN";
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();

    if ($result->num_rows > 0) {
            // output data of each row in table
            echo "<table border='1'>";
            echo <<< _END
            <tr>
                <th>Booktitle</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Delete</th>
            </tr>
            _END;
            do {
                echo "<td>";
                echo (htmlentities($row["booktitle"]));
                echo "</td><td>";
                echo (htmlentities($row["author"]));
                echo "</td><td>";
                echo (htmlentities($row["edition"]));
                echo "</td><td>";
                echo ('<a href= "delete.php?id='.htmlentities($row["ISBN"]).'">Delete Book</a> ');
                echo ("</td></tr>\n");
                } while($row = $result->fetch_assoc());
            }
            else {
                echo "0 results";
            } 
        }
        $conn->close();
    ?>
</body>
</html>