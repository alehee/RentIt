<?php

$VERSION = "0.0.1";
$cssUpdateVariable = "04082021";

/// jQuery, Bootstrap linked
$def_Head = '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="icon" href="favicon.ico"/>
';

$def_AfterBody = '
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
';
/// ==========

/// Set default header variable
$def_Header = '
<header class="text-center py-4">
    <h1 id="header-title">RENT IT!</h1>
</header>
';
/// ==========

/// Set default footer variable
$def_Footer = '
<footer class="pt-2 px-3">
    <p style="float:left;">Platform Version '.$VERSION.'</p>
    <p style="float:right;">Aleksander Heese 2021</p>
    <div style="clear:both;"></div>
</footer>
';

$def_Footer_Index = '
<footer class="pt-2 px-3">
    <span style="float:left;"><a href="login.php">Admin panel</a></span><br>
    <p style="float:left;">Platform Version '.$VERSION.'</p>
    <p style="float:right;">Aleksander Heese 2021</p>
    <div style="clear:both;"></div>
</footer>
';
/// ==========

?>