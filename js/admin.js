// Get orders history
$(document).ready(function(){
    
    /// Get history array from post.php
    $.post( "php/post.php", { getHistory: true }, function( historyData ) {
        
        if(historyData.message==true){
            var months = {};

            historyData.history.forEach(element => {
                console.log(element);
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