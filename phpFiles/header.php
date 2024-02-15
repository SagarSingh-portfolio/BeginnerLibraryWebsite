<head>
    <link rel="stylesheet" href="../styles/globals.css" />
    <link rel="stylesheet" href="../styles/styleguide.css" />
    <link rel="stylesheet" href="../styles/style-header.css" />
</head>

<?php
//session starting
session_start();

// if user clicks log out button
if (isset($_POST["logout"]))
{
  $logout = $_POST["logout"];
  
  if ($logout == "logout")
  {
    $logout="";
    $_SESSION= array();
    session_destroy();
    header("Location: login.php");
  }

}

?>

<header class="header">
    <div class="navbar">
      <!--if logged in-->
      <?php if (isset($_SESSION["username"])) {?>
        <div class="navbarBtn" onclick="location.href='index.php'">
          <div><img class="navbarIcon" src="../img/icon-home.png" /></div>
          <div class="navbarText">HOME</div>
        </div>

        <div class="navbarBtn" onclick="location.href='index.php#searchBar'">
          <div><img class="navbarIcon" src="../img/icon-search.png" /></div>
          <div class="navbarText">SEARCH</div>
        </div>
        <!--logout button-->
        <form method="post">
          <button type="submit" class="navbarBtn">
            <div><img class="navbarIcon" src="../img/icon-logout.png" /></div>
            <div class="navbarText">LOG OUT</div>
        </button>
          <input type="text" name="logout" value="logout" hidden readonly>
        </form>

        <div class="navbarBtn" onclick="location.href='myAccount.php?pageNum=1'">
          <div><img class="navbarIcon" src="../img/icon-account.png" /></div>
          <div class="navbarText">MY ACCOUNT</div>
        </div>
      <!--else-->
      <?php }else{ ?>
        <div class="navbarBtn">
          <img class="navbarIcon" src="../img/icon-warning.png" />
          <p class="navbarText" style="color:rgba(247, 173, 25, 1);" >LOG IN TO ACCESS ALL FEATURES</p>
        </div>
      <?php }?>
    </div>
</header>