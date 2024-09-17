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
if ( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['surname']) 
&& isset($_POST['addressline1']) && isset($_POST['addressline2']) && isset($_POST['city']) && isset($_POST['telephone']) && isset($_POST['mobile'])){
    $user = $conn -> real_escape_string($_POST['username']); 
    $pass = $conn -> real_escape_string($_POST['password']); 
    $name = $conn -> real_escape_string($_POST['firstname']);
    $sur = $conn -> real_escape_string($_POST['surname']);
    $a1 = $conn -> real_escape_string($_POST['addressline1']);
    $a2 = $conn -> real_escape_string($_POST['addressline2']);
    $city = $conn -> real_escape_string($_POST['city']);
    $tele = $conn -> real_escape_string($_POST['telephone']);
    $mobile = $conn -> real_escape_string($_POST['mobile']);

echo "<br>";

//insert form values into db
$sql = "INSERT INTO users(username, password, firstname, surname, addressline1, addressline2, city, telephone, mobile) VALUES ('$user', '$pass', '$name', '$sur', '$a1', '$a2', '$city', '$tele', '$mobile')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} 

else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
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
            <li><a href = "books.php"> Reserve a Book </a></li>
            <li><a href = "reserved.php"> My Books </a></li>
            <li><a class= "active" href = "login.php"> Log In </a></li>
            </ul>
        </div>
        <div style="clear:both"></div>

        <!-- register form -->
        <div class = "register">
        <h2>Please fill out your details: </h2>
        <br>
            <form method="post">
                <p>
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </p>
                <p>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </p>
                <p>
                    <label>Firstname:</label>
                    <input type="text" name="firstname" required>
                </p>
                <p>
                    <label>Surname:</label>
                    <input type="text" name="surname" required>
                </p>
                <p>
                    <label>Address Line 1:</label>
                    <input type="text" name="addressline1" required>
                </p>
                <p>
                    <label>Address Line 2:</label>
                    <input type="text" name="addressline2" required>
                </p>
                <p>
                    <label>City:</label>
                    <input type="text" name="city" required>
                </p>
                <p>
                    <label>Telephone:</label>
                    <input type="text" name="telephone" required>
                </p>
                <p>
                    <label>Mobile:</label>
                    <input type="text" name="mobile" required>
                </p>
                <p><button type="submit" value="register">Click here to register</button></p>
            </form>
        </div>
</body>
</html>