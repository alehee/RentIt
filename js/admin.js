// Set acceptation status and send query script
$(document).on('click', '.admin-accept-btn', function(clicked){
    var decision = clicked.target.name;
    var target = $(this).closest('tr').attr('id').replace('admin_accept_', '');

    $( '#wait-modal' ).modal('show');

    $.post( "php/post.php", { acceptOrder: {id: target, dec: decision} }, function( data ) {
        if(data.message!=true){
            alert("There's a problem with accepting order. Website will reload now.");
            
            setTimeout(function() {
                location.reload();
            }, 1000);
        }
        else{
            /// Get data about order and send mail with decision to customer
            $.post( "php/post.php", { getOrderInfo: target }, function( orderData ) {
                if(orderData.message){
                    orderData.order.case = 'acceptation';
                    $.post( "php/mail.php", { mail: orderData.order }, function( mailData ) {

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

                        $( '#wait-modal' ).modal('hide');
                    }, "json");
                }
            }, "json");
            /// ==========

        }
    }, "json");
});

// Open ADD smthg divs
$(document).on('click', '.admin-add-banner', function(clicked){
    var target = $(this).attr('id').replace('-banner', '');
    //alert(target);
    $( '#'+target ).slideToggle();
});

// Open CONFIRM DELETE divs
$(document).on('click', '.admin-btn-conf', function(clicked){
    var target = $(this).attr('id').replace('admin-btn-', '');
    //alert(target);
    switch(target){
        case 'delcategory':
            $( '#admin-conf-cat' ).slideToggle();
        break;
        case 'delsubcategory':
            $( '#admin-conf-subcat' ).slideToggle();
        break;
    }
});