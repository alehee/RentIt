<?php
    // Attempting session
    session_start();

    // Request default php file
    require_once('def/def.php');

    if($_SESSION["admin"] != true)
        header("location:login.php");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <title>Rent It - Admin</title>

        <?php echo $def_Head ?>

        <link rel="stylesheet" type="text/css" href="css/admin.css?date=<?php echo $cssUpdateVariable; ?>" />
    
    </head>

    <body>

        <!-- Header --->
        <?php echo $def_Header ?>

        <!-- Logout button --->
        <form action="login.php" method="post">
            <div id="admin-logout">
                <input type="text" name="logout" style="display:none">
                <button id="admin-btn-logout" type="submit" class="btn btn-primary btn-rentit">Logout</button>
            </div>
        </form>
        <div style="clear:both"></div>

        <!-- Main information shortcut --->

        <!-- Requests to accept --->
        <div>

        </div>

        <!-- Add new item --->

        <!-- Edit item --->

        <!-- Footer --->
        <?php echo $def_Footer ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/admin.js"></script>

</html>