// Get orders history and items edit
$(document).ready(function(){
    
    /// Get history array from post.php
    $.post( "php/post.php", { getHistory: true }, function( historyData ) {
        if(historyData.message==true){
            var months = {};

            historyData.history.forEach(element => {
                var month = element.start.substring(0,7);
                if(!(month in months)){
                    months[month] = [];
                }
                months[month].push('<tr><td>'+element.number+'</td><td>'+element.item+'</td><td>'+element.start+'</td><td>'+element.end+'</td><td>'+element.name+'</td><td>'+element.email+'</td><td>'+element.phone+'</td><td>'+element.accept+'</td><td>'+element.timestamp+'</td></tr>');
            });

            for(let month in months){
                var html = '';
                html+='<div id="admin-history-banner-'+month+'" class="btn btn-primary btn-rentit admin-history-month-banner text-center p-2 mt-2 rounded">'+month+'</div>';
                html+='<table id="admin-history-table-'+month+'" class="table table-striped">';
                html+='<thead><tr><th scope="col">Number</th><th scope="col">Item</th><th scope="col">Start</th><th scope="col">End</th><th scope="col">Name</th><th scope="col">E-mail</th><th scope="col">Phone</th><th scope="col">Accept</th><th scope="col">Created on</th></tr></thead>';
                html+='<tbody>';
                months[month].forEach(line => {
                    html+=line;
                });
                html+='</tbody>';
                html+='</table>';

                $( '#admin-history-main' ).append(html);
            }
        }
    }, "json");
    /// ==========

    /// Get items-edit array from post.php
    $.post( "php/post.php", { getItemsEdit: true }, function( itemsData ) {
        if(itemsData.message==true){
            var html = '';
            var cats = itemsData.items;
            for(let catId in cats){
                var subcats = cats[catId]['subcategories'];

                html += '<div id="admin-edit-category-'+catId+'" class="d-grid mx-auto text-center rounded p-2 btn btn-primary btn-rentit admin-edit-category admin-edit-toggle">'+cats[catId]['name']+'</div>';
                html += '<div id="admin-edit-category-'+catId+'-body" class="admin-edit-category-body">';

                for(let subcatId in subcats){
                    var items = subcats[subcatId]['items'];

                    html += '<div id="admin-edit-subcategory-'+subcatId+'" class="d-grid mx-auto text-center rounded p-2 btn btn-primary btn-rentit admin-edit-subcategory admin-edit-toggle">'+subcats[subcatId]['name']+'</div>';
                    html += '<div id="admin-edit-subcategory-'+subcatId+'-body" class="admin-edit-subcategory-body">';

                    for(let itemId in items){

                        html += '<div id="admin-edit-item-'+itemId+'" class="d-grid mx-auto text-center rounded p-2 btn btn-primary btn-rentit admin-edit-item admin-edit-toggle">'+items[itemId]['name']+'</div>';
                        html += '<div id="admin-edit-item-'+itemId+'-body" class="admin-edit-item-body rounded">';
                        html += '<div class="d-flex justify-content-center p-2"><div name="'+itemId+'" class="btn btn-primary btn-rentit btn-grn admin-edit-btn-edit" style="margin-right:1%;">Edit item</div><div name="'+itemId+'" class="btn btn-primary btn-rentit btn-red admin-edit-btn-remove" style="margin-right:1%;">Delete item</div><span id="admin-edit-remove-conf-span-'+itemId+'"> Confirm item removing <div name="'+itemId+'" class="btn btn-primary btn-rentit btn-red admin-edit-btn-remove-conf">Remove</div></span></div>';
                        html += '</div>';
                    }
                    html += '</div>';
                }
                html += '</div>';
            }
            $( '#admin-edit' ).append(html);
        }
    }, "json");
    /// ==========
    
    /// Get items with wrong subcategories
    $.post( "php/post.php", { getItemSubcatProblems: true }, function( data ) {
        if(data.message==true && data.problem==true){
            
            for(var i=0; i<data.items.length; i++){
                $( '#admin-itemswrong-ul' ).append('<li>'+data.items[i]+'</li>');
            }

            $( '#admin-itemswrong' ).css('display','block');
        }
    }, "json");
    /// ==========
    
});

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

// Open history tables for months
$(document).on('click', '.admin-history-month-banner', function(clicked){
    var target = $(this).attr('id').replace('banner', 'table');
    $( '#'+target ).toggle();
});

// Open edit divs
$(document).on('click', '.admin-edit-toggle', function(clicked){
    var target = $(this).attr('id');

    if(target == 'admin-edit-banner')
        target = 'admin-edit';

    else if(target.startsWith('admin-edit-category') || target.startsWith('admin-edit-subcategory') || target.startsWith('admin-edit-item'))
        target += '-body';

    $( '#'+target ).toggle();

    // Scrolling to element
    if($( '#'+target ).is(":visible")){
        $([document.documentElement, document.body]).animate({
            scrollTop: $( '#'+target ).offset().top
        }, 100);
    }
});

// Run edit script
$(document).on('click', '.admin-edit-btn-edit', function(clicked){
    var target = $(this).attr('name');

    $.post( "php/post.php", { editItemData: target }, function( data ) {
        $( '#edit-item-id' ).val(target);
        $( '#edit-item-name' ).val(data.name);
        $( '#edit-item-description' ).text(data.description);
        $( '#edit-item-stock' ).val(data.onstock);
        $( '#edit-item-subcat' ).append(data.selectHtml);
            
        if(data.photo == false)
            $( '#edit-item-file-info' ).text('<span style="background-color:red;">There\'s no photo uploaded. Upload below if you want to.</span>');
        else
            $( '#edit-item-file-info' ).text('Photo for this item already uploaded. If you want to change it upload new below.');

        $( '#edit-modal' ).modal('show');
    }, "json");
});

// Open remove confirmation span
$(document).on('click', '.admin-edit-btn-remove', function(clicked){
    var target = $(this).attr('name');
    $( '#admin-edit-remove-conf-span-'+target ).toggle();
});

// Run remove script
$(document).on('click', '.admin-edit-btn-remove-conf', function(clicked){
    var target = $(this).attr('name');

    $( '#wait-modal' ).modal('show');

    $.post( "php/edit.php", { delItem: target }, function( data ) {
        location.reload();
    }, "json");
});

// Open ADD smthg divs
$(document).on('click', '.admin-add-banner', function(clicked){
    var target = $(this).attr('id').replace('-banner', '');
    $( '#'+target ).slideToggle();
});

// Open CONFIRM DELETE divs
$(document).on('click', '.admin-btn-conf', function(clicked){
    var target = $(this).attr('id').replace('admin-btn-', '');
    switch(target){
        case 'delcategory':
            $( '#admin-conf-cat' ).slideToggle();
        break;
        case 'delsubcategory':
            $( '#admin-conf-subcat' ).slideToggle();
        break;
    }
});