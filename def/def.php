<?php

/// Edit this with new versions
$VERSION = "0.1.0";
$cssUpdateVariable = "06092021";
/// ==========

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

/// Set default header
$def_Header = '
<header class="text-center py-4">
    <h1 id="header-title">RENT IT!</h1>
</header>
';
/// ==========

/// Set wait modal
$def_Modals = '
<div class="modal fade" id="wait-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div id="wait-modal-title">WAIT FOR THE SYSTEM TO PROCESS</div>
                <div id="wait-modal-img"><img src="img/loading.gif"/></div>
                <div id="wait-modal-information" class="text-center"></div>
            </div>
        </div>
    </div>
</div>
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