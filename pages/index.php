<?php session_start();
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
    </style>
    <title>Book Reservation</title>
</head>
<body>
    <div class="banner">
        <div class="navbar">
            <ul>
            <li><a class ="active" href = "index.php"> Home </a></li>
            <li><a href = "books.php"> Reserve a Book </a></li>
            <li><a href = "reserved.php"> My Books </a></li>
            <li><a href = "login.php"> Log In </a></li>
            </ul>
        </div>
        <div class="content">
            <h1>Polina's Bookstore</h1>
            <p>Book Reservation<br/> Reserve a book with us!</p>

    <?php
    // Retrieve data from the session to view
    if ( isset($_SESSION["account"])) {
        if ( isset($_SESSION["error"])) {
            echo('<p style="color:red">ERROR:'.$_SESSION["error"]."</p>\n");
            unset($_SESSION["error"]);
        }
        if ( isset($_SESSION["success"])) {
                echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
                unset($_SESSION["success"]);
        }
    ?>
    <?php }
    ?>
            </div>
        </div>
    <div style="clear:both"></div>

</body>
</html>