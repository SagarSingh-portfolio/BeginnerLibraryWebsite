
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

    $result = 0;   
    $ST = "";
    $Sort = "";
    $SearchBy = "";
    $Category = "";
    
    //initialize from POST
    if (isset($_POST["searchText"]) && isset($_POST["sortBy"]) && isset($_POST["searchBy"]) && isset($_POST["category"]))
    {
        $ST = strtolower($conn->real_escape_string($_POST["searchText"]));// what if search text is not a single word?
        $Sort = $_POST["sortBy"]; // author, title, pubYear
        $SearchBy = $_POST["searchBy"]; // title, author or both. how to do both?
        $Category = $_POST["category"]; // from a list, can be also null

        
        $_SESSION["searchText"] = $ST;
        $_SESSION["sortBy"] = $Sort;
        $_SESSION["searchBy"] = $SearchBy;
        $_SESSION["category"] = $Category;
    }

    // initiliaze from session variables
    if (isset($_SESSION["searchText"]) && isset($_SESSION["sortBy"]) && isset($_SESSION["searchBy"]) && isset($_SESSION["category"]))
    {
        $ST = $_SESSION["searchText"];
        $Sort = $_SESSION["sortBy"];
        $SearchBy = $_SESSION["searchBy"];
        $Category = $_SESSION["category"];
    }

    $pageNum = 0;
    $reserved = 0;

    //query the search function
    if (isset($_GET["pageNum"]) && isset($_SESSION["searchText"]) && isset($_SESSION["sortBy"]) && isset($_SESSION["searchBy"]) && isset($_SESSION["category"]))
    {
        $pgNum = $conn->real_escape_string($_GET["pageNum"]); // current page number for the result 

        $sql ="";

        if($SearchBy == 'both') // if search text has both title and author
        {
            $sql = "SELECT * FROM book join category ON book.categoryID = category.categoryID 
                    WHERE 
                    ((LOWER(title) LIKE '%$ST%' 
                    OR  '$ST' LIKE CONCAT('%', LOWER(title), '%')) 
                    AND 
                    (LOWER(author) LIKE '%$ST%' 
                    OR  '$ST' LIKE CONCAT('%', LOWER(author), '%')))";
        }
        else
        {
            $sql = "SELECT * FROM book join category ON book.categoryID = category.categoryID 
                    WHERE 
                    (LOWER($SearchBy) LIKE '%$ST%' 
                    OR  '$ST' LIKE CONCAT('%', LOWER($SearchBy), '%'))";
        }
        
        // adding category filter to search
        if($Category != '.')
        {
            $sql = $sql . " AND categoryTitle = '$Category' ";
        }

        $result = $conn->query($sql);


        $rowPerPage = 5; // rows per page LIMIT
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

        $currentPage = ($pgNum-1) * $rowPerPage; //GET from url, OFFSET number

        $sql = $sql . " ORDER BY $Sort LIMIT $rowPerPage OFFSET $currentPage;";

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

        if ($reserveStatus == "ToUnreserve")
        {
            $sqlReserve = "DELETE FROM $reservedBook WHERE ISBN = $ISBN AND username = '$usernameReserve'";
            $resultReserve = $conn->query($sqlReserve);
            $string = "Location: myAccount.php?pageNum=" . $pageNum;
            header($string);  // redirect user to current page, refresh to show updated
        }
        else if ($reserveStatus == "ToReserve")
        {
            $sqlReserve = "INSERT INTO $reservedBook (ISBN, username, date) VALUES ($ISBN, '$usernameReserve', NOW())";
            $resultReserve = $conn->query($sqlReserve);
            $string = "Location: searchResult.php?pageNum=" . $pageNum;
            header($string);  // redirect user to current page, refresh to show updated
        }
    }
    $conn->close();
?>

<div class="main">
        <div class="content">
          <img class="background-pattern" src="img/background.png" />
          <div class="div">
            <div class="div">
              <div class="full-table">
                <div class="search-text">
                  <div class="text-wrapper-2">Sorted By 
                    <?php
                        if ($Sort == 'pubYear')
                        {
                          echo "Pulication Year";
                        }
                        else
                        {
                          echo $Sort;
                        }
                    ?>
                  </div>
                  <p class="showing-results">Showing Results <?php echo ($currentPage + 1) . " - " . ($currentPage + $rowPerPage); ?> Of <?php echo $rowCount; ?> For “<?php echo htmlentities($ST);?>”</p>
                </div>
                <div class="div-2">
                        <?php
                          if ($result->num_rows > 0) 
                          {
                             // Display the all books found from search
                            while ($row = $result->fetch_assoc())
                            {
                              echo '<div class="table-row">';
                                echo '<div class="frame-4">';
                                  echo '<div class="book-title">' . $row["title"] . '</div>';
                                  echo '<div class="author-publish-year">' . $row["author"] . ' ' . $row["pubYear"] . ' EDITION: ' . $row["edition"] . '</div>';
                                  echo '<div class="category-wrapper"><div class="text-wrapper-3">' . $row["categoryTitle"] . '</div></div>';
                              echo '</div>';
                              
                              if ($row['reserveStatus'] == '1') // if book reserved
                              {
                                echo '<div class="unavailable-wrapper"><div class="text-wrapper-3">UNAVAILABLE</div></div>';
                              }
                              else // if book not reserved
                              {
                                echo '<form method="post" action="searchResult.php?pageNum=' . $pgNum . '">
                                        <input type="text" name="ISBN" value="' . $row["ISBN"] .'" readonly hidden>
                                        <input type="text" name="reserveStatus" value="ToReserve" readonly hidden>
                                        <button type="submit" class="reserve-button"><div class="reserve">RESERVE</div></button>
                                      </form>';                                
                              }

                              echo '</div>';
                            }
                          }
                        ?>
                
                </div>
                <div class="buttons">
                  <div class="div-3">
                     <?php
                        // move data page to previous or next page
                        echo '<a href="searchResult.php?pageNum=' . ($pgNum -1) . '"><img class="img-2" src="img/previous-button-2.png"/></a>';
                        echo '<div class="div-wrapper"><div class="text-wrapper-4">' . $pgNum . '</div></div>';
                        echo '<a href="searchResult.php?pageNum=' . ($pgNum +1) . '" ><img class="img-2" src="img/next-button-2.png" /></a>';
                     ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="next-and-previous"></div>
          </div>
        </div>
      </div>