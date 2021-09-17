<?php
    // Attempting session
    session_start();

    // Request default php file
    require_once('def/def.php');

    // Request querys php file
    require_once('php/query.php');

    if($_SESSION["admin"] != true)
        header("location:login.php");
?>

<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <title>Admin panel - Rent It</title>

        <?php echo $def_Head ?>

        <link rel="stylesheet" type="text/css" href="css/admin.css?date=<?php echo $cssUpdateVariable; ?>" />
    
    </head>

    <body>
        <div class="content">

            <!-- Header --->
            <?php echo $def_Header ?>

            <!-- Logout button --->
            <form action="login.php" method="post">
                <div id="admin-logout">
                    <input type="text" name="logout" style="display:none">
                    <button id="admin-btn-logout" type="submit" class="btn btn-primary btn-rentit">Logout</button>
                </div>
            </form>
            <div style="clear:both"></div>

            <!-- Main information shortcut --->
            <h2 class="admin-title d-grid mx-auto pt-4">STATISTICS</h2>
            <div class="row text-center mx-auto">
                <?php query_GetAdminBasics(); ?>
            </div>

            <!-- Requests to accept --->
            <h2 class="admin-title d-grid mx-auto pt-4">ORDERS TO ACCEPT</h2>
            <table id="admin-accept-list" class="table table-striped">
                <thead>
                    <tr><th scope="col">Item</th><th scope="col">Start</th><th scope="col">End</th><th scope="col">Name</th><th scope="col">Email</th><th scope="col">Phone</th><th scope="col">Decision</th></tr>
                </thead>
                <tbody id="admin-accept-list-orders">
                    <?php query_GetOrdersToAccept(); ?>
                </tbody>
            </table>

            <!-- Next three days events (start/end of order) --->
            <h2 class="admin-title d-grid mx-auto pt-4">UPCOMING/ENDING ORDERS</h2>
            <table id="admin-upcoming-list" class="table table-striped">
                <thead>
                    <tr><th scope="col">Item</th><th scope="col">Start</th><th scope="col">End</th><th scope="col">Name</th><th scope="col">Email</th><th scope="col">Phone</th></tr>
                </thead>
                <tbody id="admin-accept-list-upcoming">
                    <?php query_GetOrdersUpcoming(); ?>
                </tbody>
            </table>

            <!-- Full list of orders --->
            <h2 class="admin-title d-grid mx-auto pt-4">HISTORY OF ORDERS</h2>
            <div id="admin-history-main">  
            </div>

            <!-- Add new item --->
            <h2 class="admin-title d-grid mx-auto pt-4">ADD CATEGORY/SUBCATEGORY/ITEM</h2>
            <div id="admin-addcategory-banner" class="d-grid mx-auto text-center rounded p-2 btn btn-primary btn-rentit admin-add-banner">ADD/DELETE CATEGORY</div>
            <div id="admin-addcategory" class="admin-add-div">
                <form action="php/edit.php" method="post" class="input-group">
                    <input type="text" name="add-cat" class="form-control" placeholder="Enter category name to add">
                    <button id="admin-btn-addcategory" type="submit" class="btn btn-primary btn-rentit btn-grn">Add category</button>
                </form>
                <hr/>
                <form action="php/edit.php" method="post" class="input-group">
                    <select class="form-select form-select" name="del-cat">
                        <option value="0" selected>Select category to delete</option>
                        <?php query_GetAdminInfo('getSelectCategories'); ?>
                    </select>
                    <div id="admin-btn-delcategory" class="btn btn-primary btn-rentit btn-red admin-btn-conf">Delete category</div><span id="admin-conf-cat"> Confirm <button type="submit" class="btn btn-primary btn-rentit btn-grn">Yes</button></span>
                </form>
            </div>
            <div id="admin-addsubcategory-banner" class="d-grid mx-auto text-center rounded p-2 btn btn-primary btn-rentit admin-add-banner">ADD/DELETE SUBCATEGORY</div>
            <div id="admin-addsubcategory" class="admin-add-div">
                <form action="php/edit.php" method="post" class="input-group">
                    <select class="form-select form-select" name="add-subcat-cat">
                        <option value="0" selected>Select category</option>
                        <?php query_GetAdminInfo('getSelectCategories'); ?>
                    </select>
                    <input type="text" name="add-subcat" class="form-control" placeholder="Enter subcategory name">
                    <button id="admin-btn-addsubcategory" type="submit" class="btn btn-primary btn-rentit btn-grn">Add subcategory</button>
                </form>
                <hr/>
                <form action="php/edit.php" method="post" class="input-group">
                    <select class="form-select form-select" name="del-subcat">
                        <option value="0" selected>Select subcategory to delete</option>
                        <?php query_GetAdminInfo('getSelectSubcategories'); ?>
                    </select>
                    <div id="admin-btn-delsubcategory" class="btn btn-primary btn-rentit btn-red admin-btn-conf">Delete subcategory</div><span id="admin-conf-subcat"> Confirm <button type="submit" class="btn btn-primary btn-rentit btn-grn">Yes</button></span>
                </form>
            </div>
            <div id="admin-additem-banner" class="d-grid mx-auto text-center rounded p-2 btn btn-primary btn-rentit admin-add-banner">ADD NEW ITEM</div>
            <div id="admin-additem" class="admin-add-div">
                <form action="php/edit.php" method="post" class="input-group" enctype="multipart/form-data">
                    <div class="input-group">
                        <select class="form-select form-select" name="add-item-subcat">
                            <option selected>Select subcategory for item</option>
                            <?php query_GetAdminInfo('getSelectSubcategories'); ?>
                        </select>
                        <input type="text" name="add-item-name" class="form-control" placeholder="Enter item name" required>
                        <input type="number" name="add-item-stock" class="form-control" placeholder="How many on stock" required>
                    </div>
                    <div class="input-group">
                        <textarea name="add-item-description" class="form-control" placeholder="(Optional) Enter description for item"></textarea>
                    </div>
                    <div class="input-group">
                        (Optional) Upload photo of the item
                    </div>
                    <div class="input-group">
                        <input id="add-item-file" name="add-item-file" class="form-control" type="file">
                    </div>
                    <button id="admin-btn-additem" type="submit" class="btn btn-primary btn-rentit btn-grn">Add item</button>
                </form>
            </div>

            <!-- Info about items with wrong category --->
            <div id="admin-itemswrong">
                
            </div>

            <!-- Edit item --->
            <h2 class="admin-title d-grid mx-auto pt-4">EDIT ITEM</h2>
            <div id="admin-edit-banner" class="d-grid mx-auto text-center rounded p-2 btn btn-primary btn-rentit admin-edit-toggle">EDIT ITEMS</div>
            <div id="admin-edit">
            </div>
        
        </div>

        <!-- Edit modal --->
        <div class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit item</h5>
                    </div>
                    <div class="modal-body">
                        <form action="php/edit.php" method="post" class="input-group" enctype="multipart/form-data">
                            <div class="input-group">
                                <select id="edit-item-subcat" class="form-select form-select" name="edit-item-subcat"></select>
                                <input id="edit-item-name" type="text" name="edit-item-name" class="form-control" placeholder="Enter item name" required>
                                <input id="edit-item-stock" type="number" name="edit-item-stock" class="form-control" placeholder="How many on stock" required>
                            </div>
                            <div class="input-group">
                                <textarea id="edit-item-description" name="edit-item-description" class="form-control" placeholder="Enter description for item"></textarea>
                            </div>
                            <div id="edit-item-file-info" class="input-group"></div>
                            <div class="input-group">
                                <input id="edit-item-file" name="edit-item-file" class="form-control" type="file">
                            </div>
                            <button type="submit" class="btn btn-primary btn-rentit btn-grn" style="margin-top:1%">Edit item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wait modal --->
        <?php echo $def_Modals ?>

        <!-- Footer --->
        <?php echo $def_Footer ?>
    
    </body>

    <!-- SCRIPT AREA --->
    <?php echo $def_AfterBody ?>
    <script src="def/script.js"></script>
    <script src="js/admin.js"></script>

</html>