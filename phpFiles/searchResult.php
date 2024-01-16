<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Library Webstite</title>
        <link rel="stylesheet" href="styles/globals.css" />
        <link rel="stylesheet" href="styles/styleguide.css" />
        <link rel="stylesheet" href="styles/style-searchBarResult.css" />
    </head>
    <body style="  background-color:  rgba(159, 231, 245, 1);">
        
        <?php
            require_once "header.php";
            // if not logged in
            if (!isset($_SESSION['username']) || !isset($_GET["pageNum"])) 
            {
                header("Location: login.php");
            }

            require_once "searchBarResult.php";
            require_once "footer.php";
        ?>
    </body>
</html>