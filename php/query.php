<?php
    // Require connection file
    require_once('connection.php');

    /// Handler for POST
    if(isset($_POST["function"])){
        $func = $_POST["function"];
        unset($_POST["function"]);
        
        switch($func){
            case 'GetOrdersToAccept':
                query_GetOrdersToAccept();
                break;
            case 'GetOrdersUpcoming':
                query_GetOrdersUpcoming();
                break;
        }
    }
    /// ==========

    /// Query: get list of offers
    function query_GetOffer(){

        $categories = [];
        $subToCat = [];

        $connection = getConnection();

        // Add categories to array
        $sql = "SELECT `Id`, `Name` FROM categories ORDER BY `Name` ASC";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $catId = $res["Id"];
            $catName = $res["Name"];

            $categories[$catId] = [$catName, []];
        }

        // Add subcategories to array
        $sql = "SELECT `Id`, `IdCategory`, `Name` FROM subcategories ORDER BY `Name` ASC";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $subId = $res["Id"];
            $subIdCategory = $res["IdCategory"];
            $subName = $res["Name"];

            $subToCat[$subId] = $subIdCategory;

            if(array_key_exists($subIdCategory, $categories)){
                $categories[$subIdCategory][1][$subId] = [$subName, []];
            }
        }

        // Add items to array
        $sql = "SELECT `Id`, `IdSubcategory`, `Name`, `Description` FROM items ORDER BY `Name` ASC";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $itemId = $res["Id"];
            $itemIdSubcategory = $res["IdSubcategory"];
            $itemName = $res["Name"];
            $itemDescription = $res["Description"];

            $categories[$subToCat[$itemIdSubcategory]][1][$itemIdSubcategory][1][$itemId] = [$itemName, $itemDescription];
        }

        // Display offers
        foreach($categories as $catId=>$cat){
            echo '<div id="cat_'.$catId.'_index" class="mt-1 p-1 rounded offer-header-category">'.$cat[0].'</div>';
            echo '<div id="cat_'.$catId.'" class="offer-box-subcategory">';
            foreach($cat[1] as $subId=>$sub){
                echo '<div id="sub_'.$subId.'_index" class="mt-1 p-1 rounded offer-header-subcategory">'.$sub[0].'</div>';
                echo '<div id="sub_'.$subId.'" class="offer-box-item">';
                foreach($sub[1] as $itemId=>$item){
                    echo '<div id="item_'.$itemId.'" class="mt-1 p-1 rounded offer-header-item">'.$item[0].'</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
    }
    /// ==========

    /// Query: get list of orders to accept
    function query_GetOrdersToAccept(){

        $toAccept = [];

        $connection = getConnection();

        // Add orders to array
        $sql = "SELECT ORD.`Id`, ITE.`Name`, ORD.`OrderName`, ORD.`OrderEmail`, ORD.`OrderPhone`, ORD.`OrderStart`, ORD.`OrderEnd` FROM orders AS ORD LEFT JOIN items AS ITE ON ORD.`IdItem`=ITE.`Id` WHERE ORD.`Accept` IS NULL AND ORD.`OrderEnd`>=CURDATE() ORDER BY ORD.`OrderStart` ASC";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            array_push($toAccept, ["id"=>$res["Id"], "item"=>$res["Name"], "name"=>$res["OrderName"], "email"=>$res["OrderEmail"], "phone"=>$res["OrderPhone"], "start"=>$res["OrderStart"], "end"=>$res["OrderEnd"]]);
        }

        // Display orders
        foreach($toAccept as $order){
            echo "<tr id='admin_accept_".$order['id']."'>";
            echo "<td>".$order['item']."</td>";
            echo "<td>".$order['start']."</td>";
            echo "<td>".$order['end']."</td>";
            echo "<td>".$order['name']."</td>";
            echo "<td>".$order['email']."</td>";
            echo "<td>".$order['phone']."</td>";
            echo "<td><button class='btn btn-primary btn-rentit admin-accept-btn admin-accept-btn-yes' name='yes'>Accept</button> <button class='btn btn-primary btn-rentit admin-accept-btn admin-accept-btn-no' name='no'>Cancel</button></td>";
            echo "</tr>";
        }
    }
    /// ==========

    /// Query: get list of orders upcoming and ending in next 3 days
    function query_GetOrdersUpcoming(){

        $orders = [];

        $connection = getConnection();
        
        // Add orders to array
        $sql = "SELECT ITE.`Name`, ORD.`OrderName`, ORD.`OrderEmail`, ORD.`OrderPhone`, ORD.`OrderStart`, ORD.`OrderEnd` FROM orders AS ORD LEFT JOIN items AS ITE ON ORD.`IdItem`=ITE.`Id` WHERE ORD.`Accept`='1' AND ((ORD.`OrderStart`>=CURDATE() AND ORD.`OrderStart`<=CURDATE() + INTERVAL 2 DAY) OR (ORD.`OrderEnd`>=CURDATE() AND ORD.`OrderEnd`<=CURDATE() + INTERVAL 2 DAY)) ORDER BY CASE WHEN CURDATE()<=ORD.`OrderStart` THEN ORD.`OrderStart` ELSE ORD.`OrderEnd` END";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            array_push($orders, ["item"=>$res["Name"], "name"=>$res["OrderName"], "email"=>$res["OrderEmail"], "phone"=>$res["OrderPhone"], "start"=>$res["OrderStart"], "end"=>$res["OrderEnd"]]);
        }

        // Display orders
        foreach($orders as $order){
            echo "<tr>";
            echo "<td>".$order['item']."</td>";
            echo "<td>".$order['start']."</td>";
            echo "<td>".$order['end']."</td>";
            echo "<td>".$order['name']."</td>";
            echo "<td>".$order['email']."</td>";
            echo "<td>".$order['phone']."</td>";
            echo "</tr>";
        }
    }
    /// ==========

    /// Query: get all info to cancel
    function query_GetCancelInfo($orderNumber){

        $connection = getConnection();

        echo '<div class="row w-75" style="margin: 0 auto;">';

        // Display order info
        $sql = "SELECT ORD.`Id`, ITE.`Name`, ORD.`OrderName`, ORD.`OrderStart`, ORD.`OrderEnd` FROM orders AS ORD LEFT JOIN items AS ITE ON ORD.`IdItem`=ITE.`Id` WHERE ORD.`OrderNumber`='$orderNumber'";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            echo '<div class="col">';
            echo '<div id="cancel-order-id" class="cancel-panel-info-title text-center pt-2" name="'.$res['Id'].'">ITEM</div>';
            echo '<div class="cancel-panel-info-result text-center">'.$res['Name'].'</div>';
            echo '<div class="cancel-panel-info-title text-center pt-2">START DATE</div>';
            echo '<div class="cancel-panel-info-result text-center">'.$res['OrderStart'].'</div>';
            echo '</div>';

            echo '<div class="col">';
            echo '<div class="cancel-panel-info-title text-center pt-2">NAME</div>';
            echo '<div class="cancel-panel-info-result text-center">'.$res['OrderName'].'</div>';
            echo '<div class="cancel-panel-info-title text-center pt-2">END DATE</div>';
            echo '<div class="cancel-panel-info-result text-center">'.$res['OrderEnd'].'</div>';
            echo '</div>';
        }

        echo '</div>';

    }
    /// ==========

    /// Query: get info for index.php page
    function query_GetIndexInfo($function){

        $connection = getConnection();

        switch($function){
            case 'basics':
                $sql = "SELECT (SELECT COUNT(`Id`) FROM subcategories) AS Genres, (SELECT COUNT(`Id`) FROM items) AS Items, (SELECT COUNT(`Id`) FROM orders) AS Orders, (SELECT COUNT(`Id`) FROM orders WHERE `Accept`='1' OR `Accept` IS NULL) AS Completed;";
                $que = mysqli_query($connection, $sql);
                while($res = mysqli_fetch_array($que)){
                    echo '<div class="col">';
                    echo '<div class="index-basics-title">ITEM GENRES: <span class="index-basics-count">'.$res["Genres"].'</span></div>';
                    echo '<div class="index-basics-title">ITEMS ON STOCK: <span class="index-basics-count">'.$res["Items"].'</span></div>';
                    echo '</div>';
                    echo '<div class="col">';
                    echo '<div class="index-basics-title">ORDERS IN SYSTEM: <span class="index-basics-count">'.$res["Orders"].'</span></div>';
                    echo '<div class="index-basics-title">ORDERS IN PROGRESS: <span class="index-basics-count">'.$res["Completed"].'</span></div>';
                    echo '</div>';
                }
            break;
            case 'rankings':
                $popular = '-';
                $newest = '-';
                $latest = '-';

                $sql = "SELECT (SELECT I.`Name` FROM (SELECT `IdItem`, COUNT(*) AS Times FROM orders GROUP BY `IdItem` ORDER BY `Times` DESC) AS M LEFT JOIN items AS I ON M.`IdItem`=I.`Id` LIMIT 1) AS Popular, (SELECT `Name` FROM items ORDER BY `Timestamp` DESC LIMIT 1) AS Newest, (SELECT I.`Name` FROM orders AS O LEFT JOIN items AS I ON O.`IdItem`=I.`Id` ORDER BY O.`OrderTimestamp` DESC LIMIT 1) AS Latest";
                $que = mysqli_query($connection, $sql);
                while($res = mysqli_fetch_array($que)){
                    $popular = $res["Popular"];
                    $newest = $res["Newest"];
                    $latest = $res["Latest"];
                }

                echo '<div class="col">';
                echo '<div class="index-rankings-title">MOST POPULAR ITEM</div>';
                echo '<div class="index-rankings-result">'.$popular.'</div>';
                echo '</div>';
                echo '<div class="col">';
                echo '<div class="index-rankings-title">NEWEST ITEM</div>';
                echo '<div class="index-rankings-result">'.$newest.'</div>';
                echo '</div>';
                echo '<div class="col">';
                echo '<div class="index-rankings-title">LAST ORDERED ITEM</div>';
                echo '<div class="index-rankings-result">'.$latest.'</div>';
                echo '</div>';
            break;
        }

    }
    /// ==========

    /// Query: get basic info for admin.php page
    function query_GetAdminBasics(){
        $connection = getConnection();

        $sql = "SELECT (SELECT COUNT(`Id`) FROM orders) AS Orders, (SELECT COUNT(`Id`) FROM orders WHERE `Accept`='1' AND `OrderEnd`<=CURDATE()) AS Completed, (SELECT COUNT(`Id`) FROM orders WHERE `Accept` IS NULL AND `OrderEnd`>=CURDATE()) AS Waiting";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            echo '<div class="col">';
            echo '<div class="admin-basics-title">TOTAL ORDERS IN SYSTEM: <span class="admin-basics-count">'.$res["Orders"].'</span></div>';
            echo '<div class="admin-basics-title">ORDERS IN PROGRESS: <span class="admin-basics-count">'.$res["Completed"].'</span></div>';
            echo '</div>';
            echo '<div class="col">';
            echo '<div class="admin-basics-title">WAITING FOR ACCEPT: <span class="admin-basics-count">'.$res["Waiting"].'</span></div>';
            echo '</div>';
        }
    }
    /// ==========

    /// Query: get direct info about database for admin.php page
    function query_GetAdminInfo($info){
        $connection = getConnection();

        switch($info){
            case 'getSelectCategories':
                $sql = "SELECT `Id`, `Name` FROM categories ORDER BY `Id` ASC";
                $que = mysqli_query($connection, $sql);
                while($res = mysqli_fetch_array($que)){
                    echo '<option value="'.$res["Id"].'">'.$res["Name"].'</option>';
                }
            break;

            case 'getSelectSubcategories':
                $sql = "SELECT `Id`, `Name` FROM subcategories ORDER BY `Id` ASC";
                $que = mysqli_query($connection, $sql);
                while($res = mysqli_fetch_array($que)){
                    echo '<option value="'.$res["Id"].'">'.$res["Name"].'</option>';
                }
            break;
        }

    }
    /// ==========
?>