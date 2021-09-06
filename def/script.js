

// Set loading modal attributes
$(document).ready(function(){
    $( '#wait-modal' ).modal({
        backdrop: 'static',
        keyboard: false
    });
});

// Header script
$( '#header-title' ).click(function(){
    window.location.href='index.php';
});