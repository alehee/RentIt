<?php
require_once('def/def.php') //ŁĄCZYMY SIĘ Z BAZĄ PODSTAWOWYCH KOMPONENTÓW
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Rent It</title>

        <?php echo $headContent ?>

        <link rel="stylesheet" type="text/css" href="strona-glowna.css?date=<?php echo $cssUpdateVariable; ?>" />

        <script src="def/script.js"></script>
        <script src="strona-glowna.js"></script>
    </head>
    <body>
        <p style="text-align:center; margin:10px;">Rent It!</p>
    </body>
</html>