$( "#login-btn-enter" ).click(function() {
    var input = $( "#login-btn-enter" ).val();
    
    $.post( "admin.php", { password: input });
});