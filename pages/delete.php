<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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

//if delete is clicked, and get id from url
if ( isset($_POST['delete']) && isset($_GET['id'])) {
    $id = $conn -> real_escape_string($_GET['id']);
    $sql = "DELETE FROM reservations WHERE ISBN = '$id'";
    if ($conn->query($sql) === TRUE) {

        //aligning the books reserved field if book is present in reservations table 
        $sql = "UPDATE books SET reserved = 'N' WHERE ISBN = '$id'";
        $conn->query($sql);
        echo"<pre>\n$sql\n</pre>\n";
        echo 'Success - <a href="./reserved.php"> Continue...</a>';
    }
    
    return;
}
    $id = $conn -> real_escape_string($_GET['id']);
    $sql = "SELECT ISBN, username, reservedate FROM reservations where ISBN = '$id'";
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();

    echo"<p>Confirm: Deleting ".$row["ISBN"]."</p>\n";
    echo('<form method="post"><input type="hidden" ');
    echo('name="id" value="'.htmlentities($row["ISBN"]).'">'."\n");
    echo('<input type="submit" value="Delete" name="delete"> ');
    echo('<a href="./reserved.php">Cancel</a>');
    echo("\n</form>\n");

    $conn->close();
?>
</body>
</html>