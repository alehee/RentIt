<?php
    // Request default php file
    require_once('def/def.php');
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

        <!-- Main information shortcut --->

        <!-- Requests to accept --->

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