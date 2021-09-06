// Set cancelation and send mails
$(document).on('click', '.cancel-box-btn', function(clicked){
    var decision = clicked.target.name;

    if(decision=='no'){
        window.location.replace("index.php");
        return 0;
    }
    decision = true;

    var target = $( '#cancel-order-id' ).attr('name');

    $( '#wait-modal' ).modal('show');

    /// Cancel the order and send mails
    $.post( "php/post.php", { cancelOrder: target }, function( cancelData ) {
        if(cancelData.message){
            $.post( "php/post.php", { getOrderInfo: target }, function( orderData ) {
                if(orderData.message){
                    orderData.order.case = 'cancelation';
                    $.post( "php/mail.php", { mail: orderData.order }, function( userMailData ) {
                        orderData.order.case = 'cancelation_admin';
                        $.post( "php/mail.php", { mail: orderData.order }, function( adminMailData ) {
    
                            $( '#wait-modal-title' ).empty();
                            $( '#wait-modal-title' ).append('ORDER CANCELED SUCCESSFULLY!');
                            $( '#wait-modal-title' ).css('color', '#79d279');

                            $( '#wait-modal-img' ).empty();
                            
                            $( '#wait-modal-information' ).empty();
                            $( '#wait-modal-information' ).append('<p>E-mail with confirmation will be sended to you.</p> <p><b>See you soon!</b></p>');

                            setTimeout(function() {
                                window.location.replace("index.php");
                            }, 3000);
                        }, "json");
                    }, "json");
                }
            }, "json");
        }
        else{
            alert('An error occured while canceling order. Try again later!');
            $( '#wait-modal' ).modal('hide');
        }
    }, "json");
    /// ==========

});