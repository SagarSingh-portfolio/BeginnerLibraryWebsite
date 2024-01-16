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
            require_once "header.php";
            // if logged in
            if (isset($_SESSION['username'])) 
            {
                header("Location: index.php");
            }
            
            require_once "loginContent.php";
            require_once "footer.php"
        ?>
    </body>
</html>