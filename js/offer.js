// Slide category options script
$(document).on('click', '.offer-header-category', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('_index','');
    $( '#'+target ).slideToggle();
});

// Slide subcategory options script
$(document).on('click', '.offer-header-subcategory', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('_index','');
    $( '#'+target ).slideToggle();
});

// Open info for item script
$(document).on('click', '.offer-header-item', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('item_','');
    $.post( "php/post.php", { item: target }, function( data ) {
        $( '#offer-list-title' ).text(data.name);
        $( '#offer-list-title' ).attr('name', target);
        $( '#offer-list-description' ).text(data.description);
        $( '#offer-list-onstock-indicator' ).text(data.onstock);

        var photo = data.photo;
        if(photo != false)
            $( '#offer-list-image' ).attr('src', 'photo/'+photo);
        else
            $( '#offer-list-image' ).attr('src', 'img/no-image.png');
    }, "json");

    $( '#offer-list-show' ).css("display", "block");
    $( '.offer-list-dates' ).css("display", "none");
});

// Check availability of item script
$(document).on('click', '#offer-list-btn-date', function(clicked){
    var target = $( '#offer-list-title' ).attr('name');
    var start = $( '#offer-list-date-start' ).val();
    var end = $( '#offer-list-date-end' ).val();

    if(!start || !end)
        alert('Enter valid dates');

    else{
        $( '#offer-list-datebox' ).css("display", "none");
        $( '#offer-list-order-not' ).css("display", "none");
        $( '#offer-list-btn-order' ).css("display", "none");

        $.post( "php/post.php", { check: target, checkStart: start, checkEnd: end }, function( data ) {
            var available = data.available;
            var orders = data.orders;

            if(available){
                $( '#offer-list-btn-order' ).css("display", "block");
            }
            else{
                $( '#offer-list-order-not' ).css("display", "block");
            }

            $( '#offer-list-datebox' ).empty();
            if(orders.length > 0){
                var inputed = 0;
                for(var i=0; i<orders.length; i++){
                    inputed++;
                    $( '#offer-list-datebox' ).append('<div>No. '+inputed+': From <b>'+orders[i].start+'</b> to <b>'+orders[i].end+'</b></div>');
                }
            }
            else{
                $( '#offer-list-datebox' ).append('<div>No orders for this date range!</div>');
            }
            $( '#offer-list-datebox' ).css("display", "block");

        }, "json");
    }
});

// Open modal with new order script
$(document).on('click', '#offer-list-btn-order', function(clicked){
    $( '#offer-modal-item' ).text('');
    $( '#offer-modal-start' ).text('');
    $( '#offer-modal-end' ).text('');
    
    var item = $( '#offer-list-title' ).text();
    var start = $( '#offer-list-date-start' ).val();
    var end = $( '#offer-list-date-end' ).val();

    $( '#offer-modal-item' ).append(item);
    $( '#offer-modal-start' ).append(start);
    $( '#offer-modal-end' ).append(end);
});

// Modal send new request script
$(document).on('click', '#offer-modal-btn-send', function(clicked){
    var target = $( '#offer-list-title' ).attr('name');
    var start = $( '#offer-list-date-start' ).val();
    var end = $( '#offer-list-date-end' ).val();
    var name = $( '#offer-modal-name' ).val();
    var email = $( '#offer-modal-email' ).val();
    var phone = $( '#offer-modal-phone' ).val();

    /// Checking data if is ok
    if(!name || !email || !phone)
    {
        alert('Fill all the inputs!');
        return 0;
    }
    /// ==========

    /// Loading screen and waiting for check
    $( '#offer-modal-body' ).empty();
    $( '#offer-modal-body' ).append('Your order is being processing...');

    $.post( "php/post.php", { newOrder: { item: target, start: start, end: end, name: name, email: email, phone: phone } }, function( data ) {
        var message = data.message;
        var orderNumber = data.orderNumber;
        var orderItem = data.orderItem;

        /// Showing the result
        $( '#offer-modal-btn-send' ).css('display', 'none');
        $( '#offer-modal-btn-close' ).css('display', 'none');

        $( '#offer-modal-body' ).empty();
        if(message == true){
            $( '#offer-modal-body' ).append('Order completed!<br>Number of this transaction is <b>'+orderNumber+'</b>.<br>Acceptation of the order will be sended in mail soon.<br>Wait for page reload!');

            // Confirmation for user
            $.post( "php/mail.php", { mail: {to: email, case: 'confirmation', order: {number: orderNumber, item: orderItem, name: name, email: email, phone: phone, start: start, end: end, accept: null } } }, function( data ) {
                //console.log(data.message);
            }, "json");

            // Confirmation for admin
            $.post( "php/mail.php", { mail: {to: email, case: 'confirmation_admin', order: {number: orderNumber, item: orderItem, name: name, email: email, phone: phone, start: start, end: end, accept: null } } }, function( data ) {
                //console.log(data.message);
            }, "json");

            setTimeout(function() {
                location.reload();
            }, 8000);
        }
        else{
            $( '#offer-modal-body' ).append('Error occured while seting order. Try again later!');
        }
        /// ========== 

    }, "json");
    /// ==========
});