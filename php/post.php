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

        unset($_POST["check"]);
        unset($_POST["checkStart"]);
        unset($_POST["checkEnd"]);

        $connection = getConnection();

        $sql = "SELECT `OnStock` FROM items WHERE `Id`='$itemId'";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $itemOnStock = $res["OnStock"];
        }

        $sql = "SELECT `OrderStart`, `OrderEnd`, `Accept` FROM orders WHERE `IdItem`='$itemId' AND ((`OrderStart` BETWEEN '$itemStart' AND '$itemEnd') OR (`OrderEnd` BETWEEN '$itemStart' AND '$itemEnd'))";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            array_push($itemOrders, ["start"=>$res["OrderStart"], "end"=>$res["OrderEnd"], "accept"=>$res["Accept"]]);
        }

        // Decision algoritm
        $decisionStart = new DateTime($itemStart);
        $decisionEnd = new DateTime($itemEnd);
        $decisionDateBuffer = $decisionStart;
        $itemDecision = true;

        while($decisionDateBuffer<=$decisionEnd && $itemDecision == true){
            $decisionStock = $itemOnStock;

            foreach($itemOrders as $order){
                if($decisionDateBuffer >= new DateTime($order["start"]) && $decisionDateBuffer <= new DateTime($order["end"]))
                    $decisionStock -= 1;
            }

            $decisionDateBuffer->modify('+1 day');

            if($decisionStock<1){
                $itemDecision = false;
            }
        }

        echo json_encode(array("available"=>$itemDecision, "orders"=>$itemOrders));
    }
    /// ==========

    /// POST: insert new order to table
    if(isset($_POST["newOrder"])){
        try{
            $order = $_POST["newOrder"];
            unset($_POST["newOrder"]);

            $orderItem = $order["item"];
            $orderName = $order["name"];
            $orderEmail = $order["email"];
            $orderStart = $order["start"];
            $orderEnd = $order["end"];
            $orderPhone = $order["phone"];

            $timestamp = new DateTime();
            $orderNumber = $orderItem."T".$timestamp->getTimestamp();

            //$message = $orderItem.", ".$orderName.", ".$orderEmail.", ".$orderStart.", ".$orderEnd.", ".$orderPhone;

            $connection = getConnection();

            $sql = "INSERT INTO orders (`Id`, `IdItem`, `OrderNumber`, `OrderName`, `OrderEmail`, `OrderPhone`, `OrderStart`, `OrderEnd`) VALUES (default, '$orderItem', '$orderNumber', '$orderName', '$orderEmail', '$orderPhone', '$orderStart', '$orderEnd')";
            $que = mysqli_query($connection, $sql);

            echo json_encode(array("message"=>true, "orderNumber"=>$orderNumber));
        }catch(Exception $e) {
            echo json_encode(array("message"=>false, "orderNumber"=>$e->getMessage()));
        }
    }
    /// ==========
?>