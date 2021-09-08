<?php
    // Request default php file
    require_once('def/def.php');

    // Request query php file
    require_once('php/query.php');
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
            <div id="index-description" class="d-grid mx-auto pt-3 pb-2">
                <img src="img/index.jpg" class="py-3"/>
                <p>There's some place for your rental office description.</p>
                <p>We're a small family rental office open for anyone who want to do sports without much cost.<br>
                Feel free to check our offer, we are here for you!</p>
            </div>

            <!-- How much equipment --->
            <div id="index-basics" class="py-3">
                <div id="index-basics-head" class="text-center">THERE'S SOME STATISTICS</div>
                <div class="row w-75 text-center mx-auto">
                    <?php query_GetIndexInfo('basics'); ?>
                </div>
            </div>

            <!-- Rankings --->
            <div id="index-ranking" class="pt-2 pb-3">
                <div class="row text-center mx-auto">
                    <?php query_GetIndexInfo('rankings'); ?>
                </div>
            </div>

            <!-- Navigation --->
            <div class="d-grid col-5 mx-auto py-4">
                <button id="index-btn-navi" type="button" class="btn btn-primary btn-rentit p-3">Check full offer here</button>
            </div>

        </div>

        <!-- Footer --->
        <?php echo $def_Footer_Index ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/index.js"></script>

</html>