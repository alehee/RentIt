

// Slide category options
$(document).on('click', '.offer-header-category', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('_index','');
    $( '#'+target ).slideToggle();
});

// Slide subcategory options
$(document).on('click', '.offer-header-subcategory', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('_index','');
    $( '#'+target ).slideToggle();
});

// Open info for item
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

// Check availability of item
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
            console.log(data);
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
                orders.array.forEach(order => {
                    console.log(order['start']);
                    console.log(order['end']);
                    console.log(order['accept']);
                });
            }
            else{
                $( '#offer-list-datebox' ).append('<div>No orders for this date range!</div>');
            }
            $( '#offer-list-datebox' ).css("display", "block");

        }, "json");
    }
});

// Open modal with new order
$(document).on('click', '#offer-list-btn-order', function(clicked){
    var item = $( '#offer-list-title' ).text();
    var start = $( '#offer-list-date-start' ).val();
    var end = $( '#offer-list-date-end' ).val();

    $( '#offer-modal-item' ).append(item);
    $( '#offer-modal-start' ).append(start);
    $( '#offer-modal-end' ).append(end);
});

// Modal send new request
$(document).on('click', '#offer-modal-btn-send', function(clicked){
    var target = $( '#offer-list-title' ).attr('name');
    var start = $( '#offer-list-date-start' ).val();
    var end = $( '#offer-list-date-end' ).val();
    var name = $( '#offer-modal-name' ).val();
    var email = $( '#offer-modal-email' ).val();
    var phone = $( '#offer-modal-phone' ).val();

    /// Checking data if is ok
    console.log(target+", "+start+", "+end+", "+name+", "+email+", "+phone);
    if(!name || !email || !phone)
    {
        alert('Fill all the inputs!');
        return 0;
    }
    /// ==========

    /// Loading screen and waiting for check
    $( '#offer-modal-body' ).empty();
    $( '#offer-modal-body' ).append('Loading...');
    /// ==========

    /// Showing the result
    $( '#offer-modal-body' ).empty();
    $( '#offer-modal-body' ).append('Result progressed');
    $( '#offer-modal-btn-send' ).css('display', 'none');
    /// ==========
});