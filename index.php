<?php
    // Request default php file
    require_once('def/def.php');
?>

<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <title>Rent It</title>

        <?php echo $def_Head ?>

        <link rel="stylesheet" type="text/css" href="css/index.css?date=<?php echo $cssUpdateVariable; ?>" />
    
    </head>

    <body>

        <!-- Header --->
        <?php echo $def_Header ?>

        <!-- How much equipment --->

        <!-- Navigation --->
        <div class="d-grid col-4 mx-auto py-3">
            <button id="index-navi-button" type="button" class="btn btn-primary btn-rentit">Check full offer here</button>
        </div>

        <!-- Rankings --->

        <!-- Footer --->
        <?php echo $def_Footer_Index ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/index.js"></script>

</html>