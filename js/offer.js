

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
    }, "json");

    $( '#offer-list-show' ).css("display", "block");
    $( '.offer-list-dates' ).css("display", "none");
});

// Check availability of item
$(document).on('click', '#offer-list-btn-date', function(clicked){
    var target = $( '#offer-list-title' ).attr('name');
    alert(target);
});