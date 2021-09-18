<?php
    // Require connection file
    require_once('connection.php');

    /// POST: get history for admin.php
    if(isset($_POST["download-start"]) && isset($_POST["download-end"])){
        try{
            $connection = getConnection();
    
            $filename = "rentit_history";
    
            $columns = ["Id", "Order Number", "Item Name", "Order Start", "Order End", "Orderer Name", "Orderer Email", "Orderer Phone", "Order Created On", "Accepted"];
            $colIter = 0;

            // ORDER BY ORD.`OrderStart` DESC
            $sql = "SELECT ORD.`Id`, ORD.`OrderNumber`, ITE.`Name`, ORD.`OrderStart`, ORD.`OrderEnd`, ORD.`OrderName`, ORD.`OrderEmail`, ORD.`OrderPhone`, ORD.`OrderTimestamp`, ORD.`Accept` FROM orders AS ORD LEFT JOIN items AS ITE ON ORD.`IdItem`=ITE.`Id` ";
            if($_POST["download-start"]!="" && $_POST["download-end"]!="")
                $sql .= "WHERE ORD.`OrderStart`>='".$_POST["download-start"]."' AND ORD.`OrderStart`<='".$_POST["download-end"]."'";
            else if($_POST["download-start"]!="")
                $sql .= "WHERE ORD.`OrderStart`>='".$_POST["download-start"]."'";
            else if($_POST["download-end"]!="")
                $sql .= "WHERE ORD.`OrderStart`<='".$_POST["download-end"]."'";
            $sql .= " ORDER BY ORD.`OrderStart` ASC";
    
            $result = mysqli_query($connection, $sql);
            
            if($_POST["download-start"]!="")
                $filename .= "_start".str_replace("-", "", $_POST["download-start"]);
            if($_POST["download-end"]!="")
                $filename .= "_end".str_replace("-", "", $_POST["download-end"]);

            $filename .= "_gen".date('Ymd');

            $file_ending = "xls";
    
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=$filename.xls");
            header("Pragma: no-cache"); 
            header("Expires: 0");
           
            $sep = "\t";
            
            foreach($columns as $col){
                echo $col."\t";
            }
            print("\n");    
    
            while($row = mysqli_fetch_row($result))
            {
                $schema_insert = "";
                for($j=0; $j<mysqli_num_fields($result);$j++)
                {
                    if(!isset($row[$j]))
                        $schema_insert .= "NULL".$sep;
                    elseif ($row[$j] != "")
                        $schema_insert .= "$row[$j]".$sep;
                    else
                        $schema_insert .= "".$sep;
                }
                $schema_insert = str_replace($sep."$", "", $schema_insert);
                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                $schema_insert .= "\t";
                print(trim($schema_insert));
                print "\n";
            }

            unset($_POST["download-start"]);
            unset($_POST["download-end"]);
        }catch(Exception $e) {
            echo "An error occured while downloading: \n".$e->getMessage();
        }
    }
    /// ==========
?>