<?php
    // Require connection file
    require_once('connection.php');

    /// POST: create category
    if(isset($_POST["add-cat"])){
        $catName = $_POST["add-cat"];
        unset($_POST["add-cat"]);

        if($catName!=""){
            $connection = getConnection();

            $sql = "INSERT INTO categories (`Id`, `Name`) VALUES (default, '$catName')";
            $que = mysqli_query($connection, $sql);
        }

        header("Refresh:0; url=../admin.php");
    }
    /// ==========

    /// POST: delete category
    if(isset($_POST["del-cat"])){
        $catId = $_POST["del-cat"];
        unset($_POST["del-cat"]);

        if($catId!="0"){
            $connection = getConnection();

            $sql = "SELECT `Id` FROM subcategories WHERE `IdCategory`='$catId'";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                $sql = "UPDATE items SET `IdSubcategory`='0' WHERE `IdSubcategory`='".$res["Id"]."'";
                $que = mysqli_query($connection, $sql);
            }

            $sql = "DELETE FROM subcategories WHERE `IdCategory`='$catId'";
            $que = mysqli_query($connection, $sql);

            $sql = "DELETE FROM categories WHERE `Id`='$catId'";
            $que = mysqli_query($connection, $sql);
        }

        header("Refresh:0; url=../admin.php");
    }
    /// ==========

    /// POST: create subcategory
    if(isset($_POST["add-subcat"])){
        $catId = $_POST["add-subcat-cat"];
        $subcatName = $_POST["add-subcat"];
        unset($_POST["add-subcat"]);
        unset($_POST["add-subcat-cat"]);

        if($subcatName!="" && $catId!="0"){
            $connection = getConnection();

            $sql = "INSERT INTO subcategories (`Id`, `IdCategory`, `Name`) VALUES (default, '$catId', '$subcatName')";
            $que = mysqli_query($connection, $sql);
        }

        header("Refresh:0; url=../admin.php");
    }
    /// ==========

    /// POST: delete subcategory
    if(isset($_POST["del-subcat"])){
        $subcatId = $_POST["del-subcat"];
        unset($_POST["del-subcat"]);

        if($subcatId!="0"){
            $connection = getConnection();

            $sql = "UPDATE items SET `IdSubcategory`='0' WHERE `IdSubcategory`='$subcatId'";
            $que = mysqli_query($connection, $sql);

            $sql = "DELETE FROM subcategories WHERE `Id`='$subcatId'";
            $que = mysqli_query($connection, $sql);
        }

        header("Refresh:0; url=../admin.php");
    }
    /// ==========

    /// POST: create item
    if(isset($_POST["add-item-name"])){
        $itemSubcatId = $_POST["add-item-subcat"];
        $itemName = $_POST["add-item-name"];
        $itemStock = intval($_POST["add-item-stock"]);
        $itemDescription = $_POST["add-item-description"];
        unset($_POST["add-item-subcat"]);
        unset($_POST["add-item-name"]);
        unset($_POST["add-item-stock"]);
        unset($_POST["add-item-description"]);

        if($itemName!="" && $itemSubcatId!="0" && $itemStock>0){
            $connection = getConnection();

            $sql = "INSERT INTO items (`Id`, `IdSubcategory`, `Name`, `Description`, `OnStock`) VALUES (default, '$itemSubcatId', '$itemName', '$itemDescription', '$itemStock')";
            $que = mysqli_query($connection, $sql);

            $itemId = 0;
            $sql = "SELECT `Id` FROM items WHERE `Name`='$itemName' ORDER BY `Id` DESC LIMIT 1";
            $que = mysqli_query($connection, $sql);
            while($res = mysqli_fetch_array($que)){
                $itemId = $res["Id"];
            }

            try{
                $target_dir = "../photo/";
                $target_file = $target_dir.$itemId.".".end((explode(".", $_FILES["add-item-file"]["name"])));
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                move_uploaded_file($_FILES["add-item-file"]["tmp_name"], $target_file);
            }catch(Exception $e) {
                //echo $e->getMessage();
            }
        }

        header("Refresh:0; url=../admin.php");
    }
    /// ==========

    /// POST: delete item
    if(isset($_POST["delItem"])){
        $itemId = $_POST["delItem"];
        unset($_POST["delItem"]);

        $connection = getConnection();

        $itemName = '';
        $sql = "SELECT `Name` FROM items WHERE `Id`='$itemId' LIMIT 1";
        $que = mysqli_query($connection, $sql);
        while($res = mysqli_fetch_array($que)){
            $itemName = $res["Name"];
        }

        $sql = "INSERT INTO deleteditems (`Id`, `IdItem`, `Name`) VALUES (default, '$itemId', '$itemName')";
        $que = mysqli_query($connection, $sql);

        $sql = "DELETE FROM items WHERE `Id`='$itemId'";
        $que = mysqli_query($connection, $sql);

        echo json_encode(array("message"=>true));
    }
    /// ==========

    /// POST: edit item
    if(isset($_POST["edit-item-name"])){
        $itemId = $_POST["edit-item-id"];
        $itemSubcatId = $_POST["edit-item-subcat"];
        $itemName = $_POST["edit-item-name"];
        $itemStock = intval($_POST["edit-item-stock"]);
        $itemDescription = $_POST["edit-item-description"];
        unset($_POST["edit-item-id"]);
        unset($_POST["edit-item-subcat"]);
        unset($_POST["edit-item-name"]);
        unset($_POST["edit-item-stock"]);
        unset($_POST["edit-item-description"]);

        echo $itemId.", ".$itemSubcatId.", ".$itemName.", ".$itemStock.", ".$itemDescription;

        if($itemName!="" && $itemSubcatId!="0"){
            $connection = getConnection();

            $sql = "UPDATE items SET `IdSubcategory`='$itemSubcatId', `Name`='$itemName', `Description`='$itemDescription', `OnStock`='$itemStock' WHERE `Id`='$itemId'";
            $que = mysqli_query($connection, $sql);

            try{
                $target_dir = "../photo/";
                $target_file = $target_dir.$itemId.".".end((explode(".", $_FILES["edit-item-file"]["name"])));
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                move_uploaded_file($_FILES["edit-item-file"]["tmp_name"], $target_file);
            }catch(Exception $e) {
                //echo $e->getMessage();
            }
        }

        header("Refresh:0; url=../admin.php");
    }
    /// ==========
?>