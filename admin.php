<?php
    // Attempting session
    session_start();

    // Request default php file
    require_once('def/def.php');

    // Request querys php file
    require_once('php/query.php');

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
        <h2 class="admin-accept-title d-grid mx-auto pt-4">ORDERS TO ACCEPT</h2>
        <table id="admin-accept-list" class="table table-striped">
            <thead>
                <tr><th scope="col">Item</th><th scope="col">Start</th><th scope="col">End</th><th scope="col">Name</th><th scope="col">Email</th><th scope="col">Phone</th><th scope="col">Decision</th></tr>
            </thead>
            <tbody id="admin-accept-list-orders">
                <?php query_GetOrdersToAccept(); ?>
            </tbody>
        </table>

        <!-- Next three days events (start/end of order) --->
        <h2 class="admin-accept-title d-grid mx-auto pt-4">UPCOMING ORDERS</h2>
        <table id="admin-upcoming-list" class="table table-striped">

            <tbody id="admin-accept-list-upcoming">
                <?php query_GetOrdersUpcoming(); ?>
            </tbody>
        </table>

        <!-- Full list of items and orders --->

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