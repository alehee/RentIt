<?php
    // Request default php file
    require_once('def/def.php');

    // Request querys php file
    require_once('php/query.php');
?>

<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <title>Rent It - Offer</title>

        <?php echo $def_Head ?>

        <link rel="stylesheet" type="text/css" href="css/offer.css?date=<?php echo $cssUpdateVariable; ?>" />
    
    </head>

    <body>

        <!-- Header --->
        <?php echo $def_Header ?>

        <!-- Nutshell of the items information --->

        <!-- Items list with categories etc --->
        <h2 id="offer-h2-title" class="d-grid mx-auto pt-4">THAT'S OUR GEAR!</h2>
        <div id="offer-list" class="d-grid mx-auto py-3 p-1 rounded container">
            <div class="row">
                <div class="col">
                    <?php query_GetOffer(); ?>
                </div>
                <div class="col-9">
                    <p>Select the gear you want to check!</p>
                </div>
            </div>
        </div>

        <!-- Footer --->
        <?php echo $def_Footer ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/offer.js"></script>

</html>