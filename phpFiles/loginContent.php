<head>
    <link rel="stylesheet" href="../styles/style-loginContent.css">
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
    
    // Check username and password entered
    if (isset($_POST["username"]) && isset($_POST["password"])) 
    {
        $username = $conn->real_escape_string($_POST["username"]);
        $password = $conn->real_escape_string($_POST["password"]);
        $errorMsg = "";

        // sql to find username and password entered
        $sql = "SELECT username, password FROM user WHERE username = '$username' AND password = '$password'";

        $result = $conn->query($sql);

        // if the query results 1 row, username and password exist, then store in SESSION
        if ($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $_SESSION["username"] = $row["username"];
            $_SESSION["password"] = $row["password"];
            header("Location: index.php");
        }
        else
        {
            $errorMsg = "Invalid username or password. Try again";
        }
    }

    $conn->close();
?>

<div class="main">
    <div class="content">
        <form method="post" class="log-in">
            <div class="loginText">LOG IN</div>
            <?php  
                // print  error message accordingly
                if (isset($errorMsg))
                {
                    echo '<p style="color: rgba(247, 173, 25, 1); font-size: 14px;">'. $errorMsg .'</p>';
                    unset($errorMsg);
                }
            ?>
            <input type="text" class="username" name="username" placeholder="Username" required/>
            <input type="password" class="username" name="password" placeholder="Password" required/>
            <button type="submit" method="post" name="login" value="login" class="log-in-wrapper"><div class="log-in-2">LOG IN</div></button>
            <div class="frame-2">
                <p class="have-not-registered">Have Not Registered An Account?</p>
                <a class="sign-up-here" href="signup.php">Sign Up Here</a>
            </div>
        </form>
        <div class="backgroundHome"><img src="../img/background.png" alt=""></div>
    </div>
</div>