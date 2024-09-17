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
    $sql = "SELECT ISBN, booktitle, author, edition, year, category, reserved FROM books";
    $result = $conn->query($sql);
    $row = $result -> fetch_assoc();
    
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
        <li><a href="index.php"> Home </a></li>
        <li><a class="active" href="books.php"> Reserve a Book </a></li>
        <li><a href="reserved.php"> My Books </a></li>
        <li><a href="login.php"> Log In </a></li>
    </ul>
</div>
<div style="clear:both"></div>

<?php
// if user isnt logged in
if (!isset($_SESSION["account"])) {
    ?>
    <div class="access">
        <p> Please <a href='login.php'> LOGIN </a> to reserve a book </p>
    </div>
    <?php

//if user is logged in
} else {
    ?>

    <!-- search for book title and author -->
    <div class="search">
        <form method="post">
            <p>Please search for a Book or Author: </p>
            <input type="text" name="search" placeholder="Book Title / Author Name" value="">
            <button type="submit" value="submit">Search</button>
        </form>
    </div>


    <!-- dropdown menu for category search -->
    <div class="dropdown">
        <?php
        $sql = "SELECT * FROM category ORDER BY categoryName";
        $all_categories = $conn->query($sql);
        echo "<p>Please select a category: </p>";
        echo '<form method="post">';
        echo "<select name='category' value=''>Category</option>";
        echo "<option value=''>None</option>";
        foreach ($conn->query($sql) as $row) {
            echo "<option value='{$row['categoryID']}'>{$row['categoryName']}</option>";
        }
        echo "</select>";
        ?>
        <button type="submit" value="submit">Filter by Category</button>
        </form>
    </div>

    <?php

    if (isset($_POST["search"]) || isset($_GET["search"]) || isset($_POST["category"]) )
    {
        //pagination
        $num_per_page = 5;
        
        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }
        else {
            $page = 1;
        }
        
        $start_from = ($page - 1) * 5;


        // Retrieveing search value for POST and GET for current page and pagination
        if(isset($_GET["search"])){
            $search = $_GET["search"];
        }

        if(isset($_POST["search"])){
            $search = $_POST["search"];
        }

        // Search for booktitle and author
        if(isset($_POST["search"]) || isset($_GET["search"])){
            $sql = "SELECT ISBN, booktitle, author, edition, year, category, reserved FROM books WHERE booktitle LIKE '%$search%' OR author LIKE '%$search%'";
            $result = $conn->query($sql);
            $total_records = $result->num_rows;
            $sql = "SELECT ISBN, booktitle, author, edition, year, category, reserved FROM books WHERE booktitle LIKE '%$search%' OR author LIKE '%$search%' limit $start_from, $num_per_page";
        }

        // Category search
        if(isset($_POST["category"])){
             if($_POST["category"] != ''){
                echo $_POST["category"];
                $category = $_POST["category"]; 
                $sql = "SELECT ISBN, booktitle, author, edition, year, category, reserved FROM books WHERE category = $category";
                $result = $conn->query($sql);
                $total_records = $result->num_rows;
                $sql = "SELECT ISBN, booktitle, author, edition, year, category, reserved FROM books WHERE category = $category limit $start_from, $num_per_page";
            }
        }

        //pagination
        $total_pages = ceil($total_records/$num_per_page);
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
                <th>Reserved(y/n)</th>
                <th>Reserve</th>
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
                echo (htmlentities($row["reserved"]));
                echo "</td><td>";
                if ($row["reserved"] == "N"){  // if book isnt reserved, allow user to reserve with link
                    echo ('<a href= "reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve Book</a> ');
                    echo ("</td></tr>\n");
                } else { // if book is already reserved
                    echo ('<p>Book reserved</p> ');
                    echo ("</td></tr>\n");
                }
                } while($row = $result->fetch_assoc());
            }
            else {
                echo "0 results";
            } 
            echo "</table>";
            echo <<< _END
            <div class="page">
            <p>
            _END;

            //pagination
            $prev = $page-1;
            $next = $page+1;
            //previous page
            if ($prev > 0){
                echo "<a href='books.php?page=".$prev."&search=".$search."'>< Previous</a>";
            }

            //numbering of each page
            for ($i=1; $i<=$total_pages; $i++){
                if ($i == $page){
                    echo "<b><a href='books.php?page=".$i."&search=".$search."'>".$i."</a></b>";
                } else{
                    echo "<a href='books.php?page=".$i."&search=".$search."'>".$i."</a>";
                }
            }
            //next page
            if ($next < ($total_pages + 1)){
                echo "<a href='books.php?page=".$next."&search=".$search."'>Next ></a>";
            }
        } 
        echo <<< _END
        </p>
        </div>
        _END;
    }
    $conn->close();
    ?>
</body>
</html>