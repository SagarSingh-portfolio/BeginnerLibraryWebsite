<head>
    <link rel="stylesheet" href="styles/style-signupContent.css">
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

    // check if form submitted
    if (isset($_POST["usernameSU"]) && 
        isset($_POST["passwordSU"]) &&
        isset($_POST["passwordTest"]) &&
        isset($_POST["firstName"]) &&
        isset($_POST["lastName"]) &&
        isset($_POST["addLineSt"]) &&
        isset($_POST["addLineDis"]) &&
        isset($_POST["city"]) &&
        isset($_POST["telephone"]) &&
        isset($_POST["mobile"])) 
        {
            $username = $conn->real_escape_string($_POST["usernameSU"]);
            $password = $conn->real_escape_string($_POST["passwordSU"]);
            $passwordTest = $conn->real_escape_string($_POST["passwordTest"]);
            $firstName = $conn->real_escape_string($_POST["firstName"]);
            $lastName = $conn->real_escape_string($_POST["lastName"]);
            $addLineSt = $conn->real_escape_string($_POST["addLineSt"]);
            $addLineDis = $conn->real_escape_string($_POST["addLineDis"]);
            $city = $conn->real_escape_string($_POST["city"]);
            $telephone = $conn->real_escape_string($_POST["telephone"]);
            $mobile =  $conn->real_escape_string($_POST["mobile"]);

            $errorMsg = "";
            $errorStatus = 0;

            // Validation for username to be unique
            $sql = "SELECT * FROM user WHERE username = '$username'";
            $result = $conn->query($sql);
            if($result->num_rows != 0)
            {
                $errorMsg = $errorMsg . " Username already taken.<br>";
                $errorStatus += 1;
            }

            // Validation for password to be only 6 characters long
            if(strlen($password) != 6)
            {
                $errorMsg = $errorMsg . " Password must be 6 characters long.<br>";
                $errorStatus += 1;
            }

            // Validation for second password is identical to entered password
            if($password != $passwordTest)
            {
                $errorMsg = $errorMsg . " Password does not match.<br>";
                $errorStatus += 1;
            }

            // Validation for phone numbers to be only 10 digits long
            if (strlen($telephone) != 10 or strlen($mobile) != 10)
            {
                $errorMsg = $errorMsg . " Telephone and mobile phone numbers MUST be 10 digits long.<br>";
                $errorStatus += 1;
            }
            else
            {
                // Validation for phone numbers to be numbers
                $phoneList = str_split($telephone . $mobile);
                $numbers = array('0','1','2','3','4','5','6','7','8','9');
                $countNum =0;
                for ($i = 0; $i < count($phoneList); $i++)
                {
                    for ( $j = 0; $j < count($numbers); $j++)
                    {
                        if ($phoneList[$i] == $numbers[$j])
                        {
                            $countNum +=1;
                        }
                    }

                    if ( $countNum !=1)
                    {
                        $errorMsg = $errorMsg . ' Only numbers for phone numbers.<br>';
                        $errorStatus += 1;
                        break;
                    }

                    $countNum = 0;
                }
            }

            // Validation for correct size in database for INSERT INTO
            if (!(  strlen($username) <= 20 && 
                    strlen($firstName) <=20 && 
                    strlen($lastName) <= 20 && 
                    strlen($addLineSt) <= 25 && 
                    strlen($city) <= 25 && 
                    strlen($addLineDis) <= 25))
                {
                    $errorMsg = $errorMsg . ' Field inputs cannot exceed 20 characters <br> for names and 25 characters for address.<br>';
                    $errorStatus += 1;
                }

            // If no errors, execute sql insert into from sign up form data
            if ($errorStatus == 0)
            {
                $sql = "INSERT INTO user (username, password, firstName, lastName, addLineSt, addLineDis, city, telephone, mobile) 
                        VALUES ('$username', '$password', '$firstName', '$lastName', '$addLineSt', '$addLineDis', '$city', '$telephone', '$mobile');";
                $success = $conn->query($sql); 
                header("Location: login.php");
            }
        } 
    $conn->close();
?>


<div class="main">
    <div class="content">
        <img class="background-pattern" src="img/background.png" />
        <form class="div-2" method="post">
            <div class="text-wrapper1">SIGN UP</div>
            <div class="all-fields-required">
                <?php  
                    // print error message if inputs are invalid
                    if (isset($errorMsg))
                    {
                        if ($errorMsg != "")
                        {
                            echo '<br';
                            echo '<p style="color: rgba(247, 173, 25, 1); font-size: 14px;">'. $errorMsg .'</p>';
                            echo '<br>';
                            $errorMsg = "";
                            $errorStatus = 0;
                        }
                        else
                        {
                            echo "All Fields Required*";
                        }
                            
                    }
                    else
                    {
                        echo "All Fields Required*";
                    }
                ?>
            </div>
            <div class="form">
                <div class="field-names">
                <div class="div-wrapper"><div class="text-wrapper-21">Username:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">Password:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">Confirm Password:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">First Name:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">Last Name:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">Address Line 1 Street:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">Address Line 2 District:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">City:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">Telephone:</div></div>
                <div class="div-wrapper"><div class="text-wrapper-21">Mobile:</div></div>
                </div>
                <div class="input-boxes">
                    <input class="book"  required type="text" name="usernameSU" placeholder="Must Be Unique"/>
                    <input class="book"  required type="password" name="passwordSU" placeholder="6 Characters In Length"/>
                    <input class="book"  required type="password" name="passwordTest" placeholder="Re-enter Password"/>
                    <input class="book"  required type="text" name="firstName" placeholder=""/>
                    <input class="book"  required type="text" name="lastName" placeholder=""/>
                    <input class="book"  required type="text" name="addLineSt" placeholder=""/>
                    <input class="book"  required type="text" name="addLineDis" placeholder=""/>
                    <input class="book"  required type="text" name="city" placeholder=""/>
                    <input class="book"  required type="text" name="telephone" placeholder="Only 10 Digits"/>
                    <input class="book"  required type="text" name="mobile" placeholder="Only 10 Digits"/>
                </div>
            </div>
            <button class="sign-up-button-wrapper" type="submit">
                <div class="sign-up-button"><div class="text-wrapper31">SIGN UP</div></div>
            </button>
            <div class="log-in-link">
                <div class="already-have-an">Already Have An Account?</div>
                <a href="login.php" class="log-in-here">Log In Here</a>
            </div>
        </form>
    </div>
</div>