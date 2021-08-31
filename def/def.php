<?php

$VERSION = "0.0.1";
$cssUpdateVariable = "04082021";

/// jQuery, Bootstrap linked
$def_Head = '
<link href="framework/bootstrap-css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="favicon.ico"/>
';

$def_AfterBody = '
<script src="framework/bootstrap-js/bootstrap.bundle.min.js"></script>
<script src="framework/jquery-3.6.0.js"></script>
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
<div style="clear:both;"></div>
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