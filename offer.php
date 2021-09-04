<?php
    // Request default php file
    require_once('def/def.php');

    // Request querys php file
    require_once('php/query.php');
?>

<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <title>Rent It - Offer</title>

        <?php echo $def_Head ?>

        <link rel="stylesheet" type="text/css" href="css/offer.css?date=<?php echo $cssUpdateVariable; ?>" />
    
    </head>

    <body>
        <div class="content">

            <!-- Header --->
            <?php echo $def_Header ?>

            <!-- Nutshell of the items information --->

            <!-- Items list with categories etc --->
            <h2 id="offer-h2-title" class="d-grid mx-auto pt-4">THAT'S OUR GEAR!</h2>
            <div id="offer-list" class="d-grid mx-auto py-3 p-1 rounded container">
                <div class="row">
                    <div class="col">
                        <?php query_GetOffer(); ?>
                    </div>
                    <div class="col-9">
                        <div id="offer-list-show" style="display:none;">
                            <div class="row">
                                <div class="col">
                                    <img id="offer-list-image" src="img/no-image.png" class="d-grid mx-auto p-2 img-fluid"/>
                                </div>
                                <div id="offer-list-info" class="col-7 d-flex">
                                    <div class="my-auto mx-auto">
                                        <h2 id="offer-list-title">Pick item you want to order!</h2>
                                        <p id="offer-list-onstock">On stock: <span id="offer-list-onstock-indicator"></span></p>
                                        <p id="offer-list-description" class="pt-3">-</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5 d-flex">
                                    <div id="offer-list-datebox" class="offer-list-dates my-auto mx-auto rounded">
                                        <div>No orders for this date range!</div>
                                    </div>
                                </div>
                                <div class="col d-flex">
                                    <div id="offer-list-date" class="my-auto mx-auto">
                                        <div>From <input type="date" id="offer-list-date-start" /></div>
                                        <div> to <input type="date" id="offer-list-date-end" /></div>
                                        <div id="offer-list-btn-date" class="btn btn-primary m-2">Check availability</div>
                                        <div id="offer-list-order-not" class="offer-list-dates text-center">There's empty stock for this date range. Try in other time.</div>
                                        <div id="offer-list-btn-order" class="btn btn-primary btn-rentit offer-list-dates" data-bs-toggle="modal" data-bs-target="#orderModal">Order now</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New order creation modal -->
            <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create new order</h5>
                            <button type="button" id="offer-modal-btn-close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div id="offer-modal-body" class="modal-body">
                            <div class="offer-modal-title">REQUESTED ITEM</div>
                            <div id="offer-modal-item" class="offer-modal-result"></div>
                            <div class="offer-modal-title">START DATE</div>
                            <div id="offer-modal-start" class="offer-modal-result"></div>
                            <div class="offer-modal-title">END DATE</div>
                            <div id="offer-modal-end" class="offer-modal-result"></div>
                            <div class="offer-modal-title">YOUR NAME</div>
                            <div class="input-group mb-3">
                                <input type="text" id="offer-modal-name" class="form-control" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="offer-modal-title">YOUR E-M@IL</div>
                            <div class="input-group mb-3">
                                <input type="email" pattern=".+@+." id="offer-modal-email" class="form-control" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="offer-modal-title">YOUR PHONE NUMBER</div>
                            <div class="input-group mb-3">
                                <input type="tel" pattern="[0-9]{9}" id="offer-modal-phone" class="form-control" aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="offer-modal-btn-send" class="btn btn-primary offer-modal-btn">Send request</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer --->
        <?php echo $def_Footer ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/offer.js"></script>

</html>