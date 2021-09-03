

// Set acceptation status and send query
$(document).on('click', '.admin-accept-btn', function(clicked){
    var decision = clicked.target.name;
    var target = $(this).closest('tr').attr('id').replace('admin_accept_', '');
    console.log(decision+", "+target);

    $.post( "php/post.php", { acceptOrder: {id: target, dec: decision} }, function( data ) {
        console.log(data.message);
        
    }, "json");
    
    /// Refresh admin panel
    $( '#admin-accept-list-orders' ).empty();
    $.post( "php/query.php", { function: "GetOrdersToAccept" }, function( data ) {
        $( '#admin-accept-list-orders' ).append(data);
    });

    $( '#admin-accept-list-upcoming' ).empty();
    $.post( "php/query.php", { function: "GetOrdersUpcoming" }, function( data ) {
        $( '#admin-accept-list-upcoming' ).append(data);
    });
    /// ==========
});