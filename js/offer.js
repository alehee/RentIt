$(document).on('click', '.offer-header-category', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('_index','');
    $( '#'+target ).slideToggle();
});

$(document).on('click', '.offer-header-subcategory', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('_index','');
    $( '#'+target ).slideToggle();
});

$(document).on('click', '.offer-header-item', function(clicked){
    var idName = clicked.target.id;
    var target = idName.replace('_index','');
    $( '#'+target ).slideToggle();
});