

// Set acceptation status and send query
$(document).on('click', '.admin-accept-btn', function(clicked){
    var decision = clicked.target.name;
    var target = $(this).closest('tr').attr('id').replace('admin_accept_', '');
    //console.log(decision+", "+target);

    $( '#wait-modal' ).modal('show');

    $.post( "php/post.php", { acceptOrder: {id: target, dec: decision} }, function( data ) {
        //console.log(data.message);
        if(data.message!=true){
            alert("There's a problem with accepting order. Website will reload soon.");
            
            setTimeout(function() {
                location.reload();
            }, 1000);
        }
        else{
            /// Get data about order and send mail with decision to customer
            $.post( "php/post.php", { getOrderInfo: target }, function( da ) {
                //console.log("here "+da.message);
                
                if(da.message){
                    da.order.case = 'acceptation';
                    $.post( "php/mail.php", { mail: da.order }, function( d ) {
                        //console.log(d.message);

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