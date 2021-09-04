<?php
    // Request default php file
    require_once('def/def.php');

    /// Checking if cancellation is available

    /// ==========
?>

<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <title>Rent It - Cancellation</title>

        <?php echo $def_Head ?>

        <link rel="stylesheet" type="text/css" href="css/cancel.css?date=<?php echo $cssUpdateVariable; ?>" />
    
    </head>

    <body>
        <div class="content">

            <!-- Header --->
            <?php echo $def_Header ?>

            <!-- Order info and cancellation button --->

        </div>

        <!-- Footer --->
        <?php echo $def_Footer ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/cancel.js"></script>

</html>