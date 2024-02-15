<head>
    <link rel="stylesheet" href="../styles/myAccountResult.css">
</head>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "librarydb";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $pageNum = 0;
    
    if (isset($_GET["pageNum"]))
    {
        $pgNum = $conn->real_escape_string($_GET["pageNum"]); // current page number for the result
        
        $sql = 'SELECT * FROM book 
                JOIN reservedBook ON book.ISBN = reservedBook.ISBN 
                JOIN category ON book.categoryID = category.categoryID
                WHERE reservedBook.username ="' . $_SESSION["username"] . '"';

        $result = $conn->query($sql);

        $rowPerPage = 5; // rows per page limit
        $rowCount = $result->num_rows; // number of total rows produced in query
        $dataPages = ceil($rowCount / $rowPerPage); // number of pages query

        //limiting pgNum so that user cannot go further than expected result
        if ($pgNum > $dataPages && $dataPages != 0)
        {
          $pgNum = $dataPages;
        }
        else if ($pgNum < 1)
        {
          $pgNum = 1;
        }

        $pageNum = $pgNum;

        $currentPage = ($pgNum-1) * $rowPerPage; //POST from url, OFFSET number
       
        $sql = $sql . " LIMIT $rowPerPage OFFSET $currentPage;";

        $result = $conn->query($sql);

    }
    else
    {
        header("Location: index.php"); // if pageNum not set from GET
    }

    //Reservation function
    if (isset($_POST["reserveStatus"]) && isset( $_POST["ISBN"]) && isset( $_SESSION["username"]))
    {
        $usernameReserve = $_SESSION["username"];
        $ISBN = $_POST["ISBN"];
        $reserveStatus = $_POST["reserveStatus"];
        $reservedBook = "reservedBook";
        $sqlReserve="";

        if ($reserveStatus == "ToUnreserve") // unreserves book
        {
            $sqlReserve = "DELETE FROM $reservedBook WHERE ISBN = $ISBN AND username = '$usernameReserve'";
            $resultReserve = $conn->query($sqlReserve);
            $string = "Location: myAccount.php?pageNum=" . $pageNum;
            header($string); // redirect user to current page, refresh to show updated
        }
        else if ($reserveStatus == "ToReserve") // reserves book
        {
            $sqlReserve = "INSERT INTO $reservedBook (ISBN, username) VALUES ($ISBN, '$usernameReserve')";
            $resultReserve = $conn->query($sqlReserve);
            $string = "Location: searchResult.php?pageNum=" . $pageNum;
            header($string); // redirect user to current page, refresh to show updated
        }
    } 
    $conn->close();
?>


<div class="div-2">
    <div class="full-table">
        <div class="search-text"><p class="showing-results">Showing Results <?php echo ($currentPage + 1) . " - " . ($currentPage + $rowPerPage); ?> Of <?php echo $rowCount; ?></p></div><!-- php-->
        <div class="div-3">
            <?php
                if ($result->num_rows > 0) 
                {
                    // Display the all books reserved by the user
                    while ($row = $result->fetch_assoc())
                    {
                        echo '<div class="table-row">';
                            echo '<div class="frame-2">';
                                echo '<div class="book-title">' . $row["title"]  . '</div>';
                                echo '<div class="text-wrapper-2">' . $row["author"] . ' ' . $row["pubYear"] . ' EDITION: ' . $row["edition"] . '</div>';
                                echo '<div class="category-wrapper"><div class=text-wrapper-2>' . $row["categoryTitle"]  . '</div></div>';
                            echo '</div>';
                            echo '<form method="post" action="myAccount.php?pageNum=' . $pgNum . '">
                                        <input type="text" name="ISBN" value="' . $row["ISBN"] .'" readonly hidden>
                                        <input type="text" name="reserveStatus" value="ToUnreserve" readonly hidden>
                                        <button type="submit" class="reserve-button"><div class="unreserve">UNRESERVE</div></button>
                                      </form>';  
                        echo '</div>';
                    }
                }
            ?>
            
        </div>
            <div class="buttons">
                
                <div class="next-and-previous">
                    <?php
                        // move data page to previous or next page
                        echo '<a href="myAccount.php?pageNum=' . ($pgNum -1) . '"><img class="img-2" src="../img/previous-button-2.png"/></a>';
                        echo '<div class="div-wrapper"><div class="text-wrapper-5">' . $pgNum . '</div></div>';
                        echo '<a  href="myAccount.php?pageNum=' . ($pgNum +1) . '" ><img class="img-2" src="../img/next-button-2.png"/></a>';
                     ?>
                </div>
        </div>
    </div>
    <div class="backgroundHome"><img src="../img/background.png" alt=""></div>
</div>
