<?php
    // Request default php file
    require_once('def/def.php');

    // Request querys php file
    require_once('php/query.php');

    /// Checking if cancellation is available
    if(!isset($_GET["order"]))
        header('location: index.php');

    require_once('php/connection.php');

    $orderNumber = $_GET['order'];

    $connection = getConnection();

    $times = 0;

    $sql = "SELECT `Id` FROM orders WHERE `OrderNumber`='$orderNumber' AND (`Accept`='1' OR `Accept` IS NULL)";
    $que = mysqli_query($connection, $sql);
    while($res = mysqli_fetch_array($que)){
        $times = $times + 1;
    }

    if($times==0)
        header('location: index.php');
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
            <div id="cancel-panel">
                <h2 id="cancel-panel-h2" class="py-4 text-center">YOU'RE <span style="color:red;">CANCELING</span> ORDER <?php echo $orderNumber; ?></h2>
                <h4 id="cancel-panel-h4" class="py-2 text-center">ORDER DATA:</h4>
                <?php query_GetCancelInfo($orderNumber); ?>
                <div id="cancel-box" class="my-4 rounded">
                    <h5 id="cancel-panel-h5" class="py-2 text-center">ARE YOU SURE YOU WANT TO CANCEL THIS ORDER?</h5>
                    <div id="cancel-box-btn-box" class="py-2"><button class="btn btn-primary btn-rentit cancel-box-btn" name="yes">Cancel order</button><button class="btn btn-primary btn-cancel cancel-box-btn" name="no">Keep my order</button></div>
                </div>
            </div>

            
        </div>

        <?php echo $def_Modals ?>

        <!-- Footer --->
        <?php echo $def_Footer ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/cancel.js"></script>

</html>