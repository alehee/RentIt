<?php
    // Attempting session
    session_start();

    // Request default php file
    require_once('def/def.php');

    // Check login data
    $LOGGED = false;
    $GOOD_PASSWORD = "123"; // Change here the password!

    if(isset($_SESSION["admin"]) || isset($_POST["password"])){
        if(isset($_SESSION["admin"]))
            $LOGGED = $_SESSION["admin"];
        else if(!isset($_SESSION["admin"]) && isset($_POST["password"]) && $_POST["password"] == $GOOD_PASSWORD){
            $LOGGED = true;
        }

        if($LOGGED == false){
            if(session_status() == PHP_SESSION_ACTIVE)
                session_destroy();
            echo "<script>alert('Wrong password, try again!')</script>";
        }
        else{
            $_SESSION["admin"] = true;
            header("location:admin.php");
        } 
    }

    // Logout data
    if(isset($_POST["logout"])){
        $_SESSION["admin"] = false;
        unset($_POST["logout"]);
        if(session_status() == PHP_SESSION_ACTIVE)
            session_destroy();
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <title>Login - Rent It</title>

        <?php echo $def_Head ?>

        <link rel="stylesheet" type="text/css" href="css/login.css?date=<?php echo $cssUpdateVariable; ?>" />
    
    </head>

    <body>
        <div class="content">

            <!-- Header --->
            <?php echo $def_Header ?>

            <!-- Login panel --->
            <form action="login.php" method="post">
                <div class="text-center">
                    <p class="pt-5">Enter administrator code:</p>
                </div>
                <div class="input-group mb-3 w-25 mx-auto">
                    <input id="login-input-enter" type="password" class="form-control" name="password">
                </div>

                <div class="d-grid col-2 mx-auto">
                    <button id="login-btn-enter" type="submit" class="btn btn-primary btn-rentit">Log in!</button>
                </div>
            </form>

        </div>

        <!-- Footer --->
        <?php echo $def_Footer ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/login.js"></script>

</html>