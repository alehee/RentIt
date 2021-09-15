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

            $connection = getConnection();

            $sql = "INSERT INTO orders (`Id`, `IdItem`, `OrderNumber`, `OrderName`, `OrderEmail`, `OrderPhone`, `OrderStart`, `OrderEnd`) VALUES (default, '$orderItem', '$orderNumber', '$orderName', '$orderEmail', '$orderPhone', '$orderStart', '$orderEnd')";
            $que = mysqli_query($connection, $sql);

            $orderItemName = '';
            $sql = "SELECT `Name` FROM items WHERE `Id`='$orderItem'";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                $orderItemName = $res["Name"];
            }

            echo json_encode(array("message"=>true, "orderNumber"=>$orderNumber, "orderItem"=>$orderItemName));
        }catch(Exception $e) {
            echo json_encode(array("message"=>false, "orderNumber"=>$e->getMessage(), "orderItem"=>false));
        }
    }
    /// ==========

    /// POST: accept order
    if(isset($_POST["acceptOrder"])){
        $order = $_POST["acceptOrder"];
        unset($_POST["acceptOrder"]);

        try{
            $connection = getConnection();

            $orderId = $order["id"];
            $decision = 0;
            if($order["dec"] == "yes")
                $decision = 1;

            $sql = "UPDATE orders SET `Accept`='$decision', `AcceptTimestamp`=CURRENT_TIMESTAMP WHERE `Id`='$orderId'";
            $que = mysqli_query($connection, $sql);

            echo json_encode(array("message"=>true));
        }catch(Exception $e) {
            echo json_encode(array("message"=>$e->getMessage()));
        }
    }
    /// ==========

    /// POST: get order info
    if(isset($_POST["getOrderInfo"])){
        $orderId = $_POST["getOrderInfo"];
        unset($_POST["getOrderInfo"]);

        try{
            $connection = getConnection();

            $returnOrder = [];

            $sql = "SELECT ITE.`Name`, ORD.`OrderNumber`, ORD.`OrderName`, ORD.`OrderEmail`, ORD.`OrderPhone`, ORD.`OrderStart`, ORD.`OrderEnd`, ORD.`Accept` FROM orders AS ORD LEFT JOIN items AS ITE ON ORD.`IdItem`=ITE.`Id` WHERE ORD.`Id`='$orderId'";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                $returnOrder = ['to'=>$res['OrderEmail'], 'case'=>'', 'order'=>['number'=>$res['OrderNumber'], 'item'=>$res['Name'], 'name'=>$res['OrderName'], 'email'=>$res['OrderEmail'], 'phone'=>$res['OrderPhone'], 'start'=>$res['OrderStart'], 'end'=>$res['OrderEnd'], 'accept'=>$res['Accept']]];
                
                if($returnOrder['order']['accept'] == '1')
                    $returnOrder['order']['accept'] = true;
                else if($returnOrder['order']['accept'] == '0')
                    $returnOrder['order']['accept'] = false;
            }

            echo json_encode(array("message"=>true, "order"=>$returnOrder));
        }catch(Exception $e) {
            echo json_encode(array("message"=>$e->getMessage(), "order"=>null));
        }
    }
    /// ==========

    /// POST: cancel order
    if(isset($_POST["cancelOrder"])){
        $orderId = $_POST["cancelOrder"];
        unset($_POST["cancelOrder"]);

        try{
            $connection = getConnection();

            $sql = "UPDATE orders SET `Accept`='0' WHERE `Id`='$orderId'";
            $que = mysqli_query($connection, $sql);

            $sql = "INSERT INTO cancellations (`Id`, `IdOrder`) VALUES (default, '$orderId')";
            $que = mysqli_query($connection, $sql);

            echo json_encode(array("message"=>true));
        }catch(Exception $e) {
            echo json_encode(array("message"=>$e->getMessage()));
        }
    }
    /// ==========

    /// POST: get history for admin.php
    if(isset($_POST["getHistory"])){
        unset($_POST["getHistory"]);

        try{
            $connection = getConnection();

            $returnHistory = [];

            $sql = "SELECT ITE.`Name`, ORD.`OrderNumber`, ORD.`OrderName`, ORD.`OrderEmail`, ORD.`OrderPhone`, ORD.`OrderStart`, ORD.`OrderEnd`, ORD.`OrderTimestamp`, ORD.`Accept` FROM orders AS ORD LEFT JOIN items AS ITE ON ORD.`IdItem`=ITE.`Id` ORDER BY ORD.`OrderStart` DESC";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                if($res["Accept"]=="1")
                    $orderAccept = 'Yes';
                else
                    $orderAccept = 'No';

                array_push($returnHistory, ['timestamp'=>$res['OrderTimestamp'], 'number'=>$res["OrderNumber"], 'item'=>$res["Name"], 'start'=>$res["OrderStart"], 'end'=>$res["OrderEnd"], 'name'=>$res["OrderName"], 'email'=>$res["OrderEmail"], 'phone'=>$res["OrderPhone"], 'accept'=>$orderAccept]);
            }

            echo json_encode(array("message"=>true, "history"=>$returnHistory));
        }catch(Exception $e) {
            echo json_encode(array("message"=>$e->getMessage(), "history"=>null));
        }
    }
    /// ==========

    /// POST: get items edit module for admin.php
    if(isset($_POST["getItemsEdit"])){
        unset($_POST["getItemsEdit"]);

        try{
            $connection = getConnection();

            $returnCategories = [];
            $returnSubcategories = [];
            $returnItems = [];

            $sql = "SELECT `Id`, `Name` FROM categories ORDER BY `Id` ASC";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                array_push($returnCategories, ['id'=>$res['Id'], 'name'=>$res['Name']]);
            }

            $sql = "SELECT `Id`, `IdCategory`, `Name` FROM subcategories ORDER BY `Id` ASC";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                array_push($returnSubcategories, ['id'=>$res['Id'], 'idCategory'=>$res['IdCategory'], 'name'=>$res['Name']]);
            }

            $sql = "SELECT `Id`, `IdSubcategory`, `Name`, `Description`, `OnStock` FROM items ORDER BY `Id` ASC";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                array_push($returnItems, ['id'=>$res['Id'], 'idSubcategory'=>$res['IdSubcategory'], 'name'=>$res['Name'], 'description'=>$res['Description'], 'stock'=>$res['OnStock']]);
            }

            echo json_encode(array("message"=>true, "categories"=>$returnCategories, "subcategories"=>$returnSubcategories, "items"=>$returnItems));
        }catch(Exception $e) {
            echo json_encode(array("message"=>$e->getMessage(), "categories"=>null, "subcategories"=>null, "items"=>null));
        }
    }
    /// ==========
?>