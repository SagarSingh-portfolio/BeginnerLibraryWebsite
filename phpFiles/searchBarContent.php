<head>
    <link rel="stylesheet" href="styles/globals.css" />
    <link rel="stylesheet" href="styles/styleguide.css" />
    <link rel="stylesheet" href="styles/style-searchBarContent.css" />
</head>
<div class="search-bar" id="searchBar">
    <p class="search-for-any-book">SEARCH FOR ANY BOOK OR AUTHOR</p>
    <form class="searchMain" method="post" action="searchResult.php?pageNum=1">
      <div class="searchMainBtn">
        <input name="searchText" type="text" class="search-books" id="input-1" placeholder="Search for books"/>
        <button type="submit" class="searchMainEnter">
          <img class="icon-search" src="img/icon-search-2.png" />
          <label class="search" for="input-1">SEARCH</label>
        </button>
      </div>
      <div class="searchOther">
        <div class="drop-down-menu">
            <select required class="searchbtns" name="sortBy">
                <option hidden selected value="title"  class="search-by">Sort By</option>
                <option value="title">Title</option>
                <option value="author">Author</option>
                <option value="pubYear">Year</option>
            </select>
        </div>
        <div class="drop-down-menu">
            <select required class="searchbtns" name="searchBy">
                <option hidden selected value="title"  class="search-by">Search By</option>
                <option value="title">Title</option>
                <option value="author">Author</option>
                <option value="both">both</option>
            </select>
        </div>
        <div class="drop-down-menu">
            <select required class="searchbtns" name="category">
                <option hidden selected value="."  class="search-by">Category</option>
                <option value=".">None</option>
                <!--generate rows of categories available here-->
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
                  
                  $sql = "SELECT categoryTitle FROM category;";
                  $result = $conn->query($sql);

                  //display all categories in select list
                  if ($result->num_rows > 0) 
                  {
                    while ($row = $result->fetch_assoc())
                    {
                      echo "<option value='" . $row["categoryTitle"] . "'>" . $row["categoryTitle"] . "</option>";
                    }
                  }
                  
                  $conn->close();
                ?>  
          </select>
        </div>
      </div>
    </form>
  </div>
