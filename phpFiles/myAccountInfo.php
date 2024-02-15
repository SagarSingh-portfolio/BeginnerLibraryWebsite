<head>
    <link rel="stylesheet" href="../styles/myAccountInfo.css">
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
    
    // select all information of user
    $sql = 'SELECT * FROM USER WHERE username = "' . $_SESSION["username"] . '"'; 

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
?>


<div class="account-details">
    <div class="account-information">ACCOUNT INFORMATION</div>
    <div class="account-info">
        <div class="account-field-names">
            <div class="text-wrapper-2">USERNAME:</div>
            <div class="text-wrapper-2">PASSWORD:</div>
            <div class="text-wrapper-2">FIRST NAME:</div>
            <div class="text-wrapper-2">LAST NAME:</div>
            <div class="text-wrapper-2">TELEPHONE NUMBER:</div>
            <div class="text-wrapper-2">MOBILE PHONE NUMBER:</div>
            <div class="text-wrapper-2">ADDRESS:</div>
        </div>
        <div class="account-field-data"> <!-- php-->
            <div class="text-wrapper-4"><?php echo htmlentities($row["username"]);?></div>
            <div class="text-wrapper-4"><?php echo htmlentities($row["password"]);?></div>
            <div class="text-wrapper-4"><?php echo htmlentities($row["firstName"]);?></div>
            <div class="text-wrapper-4"><?php echo htmlentities($row["lastName"]);?></div>
            <div class="text-wrapper-4"><?php echo htmlentities($row["telephone"]);?></div>
            <div class="text-wrapper-4"><?php echo htmlentities($row["mobile"]);?></div>
            <div class="text-wrapper-4"><?php echo htmlentities($row["addLineSt"]) . ', ' . htmlentities($row["addLineDis"]) . ', ' . htmlentities($row["city"]);?></div>
        </div>
    </div>
</div>