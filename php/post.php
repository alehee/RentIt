<?php
    // Require connection file
    require_once('connection.php');

    /// POST: receive item full info
    if(isset($_POST["item"])){

        $itemId = $_POST["item"];
        $itemName = 0;
        $itemDescription = 0;
        $itemOnStock = 0;

        $connection = getConnection();

        $sql = "SELECT `Name`, `Description`, `OnStock` FROM items WHERE `Id`='$itemId'";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $itemName = $res["Name"];
            $itemDescription = $res["Description"];
            $itemOnStock = $res["OnStock"];
        }

        echo json_encode(array("name"=>$itemName, "description"=>$itemDescription, "onstock"=>$itemOnStock));
    }
    /// ==========
?>