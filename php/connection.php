<?php
    function getConnection(){
        $HOST = "localhost";
        $USER = "root";
        $PASSWORD = "root";
        $DATABASE = "rentit";

        return mysqli_connect($HOST, $USER, $PASSWORD, $DATABASE);
    }
?>