<?php
    // Require connection file
    require_once('connection.php');

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
?>