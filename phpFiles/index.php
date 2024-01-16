<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Library Webstite</title>
        <link rel="stylesheet" href="styles/globals.css" />
        <link rel="stylesheet" href="styles/styleguide.css" />
    </head>
    <body style="  background-color:  rgba(159, 231, 245, 1);">
        
        <?php
            // if logged in
            require_once "header.php";
            if (isset($_SESSION["username"])) 
            {
                require_once "backgroundLogo.php";
                require_once "searchBarContent.php";
                require_once "background.php";
                require_once "footer.php";
            }
            else
            {
                header("Location: login.php");
            }

        ?>
    </body>
</html>