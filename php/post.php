<?php
    // Require connection file
    require_once('connection.php');

    /// POST: receive item full info
    if(isset($_POST["item"])){

        $itemId = $_POST["item"];
        $itemName = 0;
        $itemDescription = 0;
        $itemOnStock = 0;
        $itemPhoto = false;

        unset($_POST["item"]);

        $connection = getConnection();

        $sql = "SELECT `Name`, `Description`, `OnStock` FROM items WHERE `Id`='$itemId'";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $itemName = $res["Name"];
            $itemDescription = $res["Description"];
            $itemOnStock = $res["OnStock"];
        }

        foreach(glob("../photo/$itemId.*") as $filename) {
            $itemPhoto = pathinfo($filename)['basename'];
        }

        echo json_encode(array("name"=>$itemName, "description"=>$itemDescription, "onstock"=>$itemOnStock, "photo"=>$itemPhoto));
    }
    /// ==========

    /// POST: get other orders dates and decision
    if(isset($_POST["check"]) && isset($_POST["checkStart"]) && isset($_POST["checkEnd"])){

        $itemId = $_POST["check"];
        $itemStart = $_POST["checkStart"];
        $itemEnd = $_POST["checkEnd"];
        $itemOnStock = 0;
        $itemOrders = [];
        
        $itemDecision = true;

        unset($_POST["check"]);
        unset($_POST["checkStart"]);
        unset($_POST["checkEnd"]);

        $connection = getConnection();

        $sql = "SELECT `OnStock` FROM items WHERE `Id`='$itemId'";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $itemOnStock = $res["OnStock"];
        }

        $sql = "SELECT `OrderStart`, `OrderEnd`, `Accept` FROM orders WHERE `IdItem`='$itemId' AND `OrderStart`>='$itemStart' AND `OrderEnd`<='$itemEnd'";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            array_push($itemOrders, ["start"=>$res["OrderStart"], "end"=>$res["OrderEnd"], "accept"=>$res["Accept"]]);
        }

        echo json_encode(array("available"=>$itemDecision, "orders"=>$itemOnStock));
    }
    /// ==========
?>