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
        $sql = "SELECT ORD.`Id`, ITE.`Name`, ORD.`OrderName`, ORD.`OrderEmail`, ORD.`OrderPhone`, ORD.`OrderStart`, ORD.`OrderEnd` FROM orders AS ORD LEFT JOIN items AS ITE ON ORD.`IdItem`=ITE.`Id` WHERE ORD.`Accept` IS NULL ORDER BY ORD.`OrderStart` ASC";
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

        $connection = getConnection();
        
        
    }
    /// ==========
?>