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
        <div class="content">

            <!-- Header --->
            <?php echo $def_Header ?>

            <!-- Description --->
            <div id="index-description" class="d-grid mx-auto py-3">
                <img src="img/index.jpg" class="py-3"/>
                <p>There's some place for your rental office description.</p>
                <p>We're a small family rental office open for anyone who want to do sports without much cost.<br>
                Feel free to check our offer, we are here for you!</p>
            </div>

            <!-- How much equipment --->

            <!-- Navigation --->
            <div class="d-grid col-4 mx-auto py-3">
                <button id="index-btn-navi" type="button" class="btn btn-primary btn-rentit">Check full offer here</button>
            </div>

            <!-- Rankings --->

        </div>

        <!-- Footer --->
        <?php echo $def_Footer_Index ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/index.js"></script>

</html>