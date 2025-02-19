<?php
use App\Http\Controllers\Admin\RestaurentManagement\TableController;
use App\Http\Controllers\Admin\RestaurentManagement\MenuController;
use App\Http\Controllers\Admin\RestaurentManagement\OrderController;
use App\Http\Controllers\Admin\Sweets_and_confectionery\SweetMenuController;
use App\Http\Controllers\Admin\Sweets_and_confectionery\SweetOrderController;
use App\Http\Controllers\Admin\Sweets_and_confectionery\SweetTableController;
use Illuminate\Support\Facades\Route;
use App\Models\RestaurentManagement\Table;
use Illuminate\Support\Facades\Session;

Route::group(['middleware' => ['auth']], function () {
    
            // Resturant Part start


    Route::name('restaurentManagement.')->prefix('restaurentManagement')->group(function () {

        Route::name('table.')->prefix('table')->group(function () {
            Route::get('/view',         [TableController::class, 'index'])->name('view');
            Route::get('/getTable',    [TableController::class, 'getTable'])->name('getTable');
            Route::post('/store',       [TableController::class, 'store'])->name('store');
            Route::get('/edit',         [TableController::class, 'edit'])->name('edit');
            Route::post('/update',      [TableController::class, 'update'])->name('update');
            Route::post('/delete',      [TableController::class, 'delete'])->name('delete');
			Route::get('/asset/serialize/product', [TableController::class, 'assetSerializeProduct'])->name('assetSerializeProduct');
        });

        
        Route::name('menu.')->prefix('menu')->group(function () {
            Route::get('/view',         [MenuController::class, 'index'])->name('view');
            Route::get('/getMenu',      [MenuController::class, 'getMenu'])->name('getMenu');
            Route::get('/getmenucarddetails',      [MenuController::class, 'getmenucarddetails'])->name('getmenucarddetails');
            Route::get('/getMenu_itms_list',      [MenuController::class, 'getMenu_itms_list'])->name('getMenu_itms_list');
            Route::get('/addtocard',      [MenuController::class, 'addtocard'])->name('addtocard');
            Route::get('/fetch_menu_Cart_item',      [MenuController::class, 'fetch_menu_Cart_item'])->name('fetch_menu_Cart_item');
          
            Route::get('/create',       [MenuController::class, 'create'])->name('create');
            Route::post('/store',       [MenuController::class, 'store'])->name('store');
            Route::get('/edit',         [MenuController::class, 'edit'])->name('edit');
            Route::post('/removeCartmenuitem',[MenuController::class, 'removeCartmenuitem'])->name('removeCartmenuitem');
            Route::post('/updateCartmenuitem', [MenuController::class, 'updateCartmenuitem'])->name('updateCartmenuitem');
            Route::post('/menuImage',    [MenuController::class, 'menuImageDelete'])->name('image.delete');
            Route::post('/menuSpec',    [MenuController::class, 'menuSpecDelete'])->name('spec.delete');
            Route::post('/update',      [MenuController::class, 'update'])->name('update');
            Route::post('/delete',      [MenuController::class, 'delete'])->name('delete');
            
        });

        
        Route::name('order.')->prefix('order')->group(function () {
            Route::get('/view',                     [OrderController::class, 'index'])->name('view');
            Route::get('/list',                     [OrderController::class, 'orderlist'])->name('list');
            Route::get('/getlist/{filterByTypeDateParty}', [OrderController::class, 'getorderlist'])->name('getlist');
            Route::get('/editList',                 [OrderController::class, 'listedit'])->name('editList');
            Route::post('/deleteorder',             [OrderController::class, 'orderdelete'])->name('deleteorder');
            Route::get('/getTablePlanning',         [OrderController::class, 'getTablePlanning'])->name('getTablePlanning');
            Route::get('/getRunningOrders',         [OrderController::class, 'getRunningOrders'])->name('getRunningOrders');
            Route::post('/customerinfo',            [OrderController::class, 'customerinfo'])->name('customerinfo');
            Route::get('/addOrder',                 [OrderController::class, 'addOrder'])->name('addOrder');
            Route::get('/addOrderedit',                 [OrderController::class, 'editaddOrder'])->name('addOrderedit');
            Route::get('/addToCart',                [OrderController::class, 'addToCart'])->name('addToCart');
            Route::get('/fetch_menu_Cart',          [OrderController::class, 'fetch_menu_Cart'])->name('fetch_menu_Cart');
            Route::post('/update_menu_Cart',        [OrderController::class, 'update_menu_Cart'])->name('update_menu_Cart');
            Route::post('/removeCartitem',          [OrderController::class, 'removeCartitem'])->name('removeCartitem');
            Route::post('/checkout',                [OrderController::class, 'checkoutOrder'])->name('checkout');
            Route::get('/tablewiseorderdetails',                [OrderController::class, 'Orderdetailstablewise'])->name('tablewiseorderdetails');
            Route::get('/addEdititemToCart',                [OrderController::class, 'Edit_item_addToCart'])->name('addEdititemToCart');
            Route::get('/edit_fetch_menu_Cart',          [OrderController::class, 'fetch_menu_Cart_edit'])->name('edit_fetch_menu_Cart');
            Route::post('/details_update_menu_Cart',        [OrderController::class, 'update_menu_Cart_details'])->name('details_update_menu_Cart');
            Route::post('/removeEditCartitem',          [OrderController::class, 'EditremoveCartitem'])->name('removeEditCartitem');
            Route::post('/editcheckout',                [OrderController::class, 'EditcheckoutOrder'])->name('editcheckout');
            Route::get('/orderInvoice/{id}',     [OrderController::class, 'createPDF'])->name('orderInvoice');
            Route::get('/create',                   [OrderController::class, 'create'])->name('create');
            Route::post('/store',                   [OrderController::class, 'store'])->name('store');
            Route::get('/edit',                     [OrderController::class, 'edit'])->name('edit');;
            Route::post('/OrderImage',              [OrderController::class, 'OrderImageDelete'])->name('image.delete');
            Route::post('/OrderSpec',               [OrderController::class, 'OrderSpecDelete'])->name('spec.delete');
            Route::post('/update',                  [OrderController::class, 'update'])->name('update');
            Route::post('/delete',                  [OrderController::class, 'delete'])->name('delete');
        });
        
    });


                            // restaurant part end



                    //    Sweets and confectionery part  start




                    Route::name('sweetsconfectionary.')->prefix('sweetsconfectionary')->group(function () {

                        Route::name('table.')->prefix('table')->group(function () {
                            Route::get('/view',         [SweetTableController::class, 'index'])->name('view');
                            Route::get('/getTable',    [SweetTableController::class, 'getTable'])->name('getTable');
                            Route::post('/store',       [SweetTableController::class, 'store'])->name('store');
                            Route::get('/edit',         [SweetTableController::class, 'edit'])->name('edit');
                            Route::post('/update',      [SweetTableController::class, 'update'])->name('update');
                            Route::post('/delete',      [SweetTableController::class, 'delete'])->name('delete');
                            Route::get('/asset/serialize/product', [SweetTableController::class, 'assetSerializeProduct'])->name('assetSerializeProduct');
                        });
                
                        
                        Route::name('menu.')->prefix('menu')->group(function () {
                            Route::get('/view',         [SweetMenuController::class, 'index'])->name('view');
                            Route::get('/getMenu',      [SweetMenuController::class, 'getMenu'])->name('getMenu');
                            Route::get('/getmenucarddetails',      [SweetMenuController::class, 'getmenucarddetails'])->name('getmenucarddetails');
                            Route::get('/getMenu_itms_list',      [SweetMenuController::class, 'getMenu_itms_list'])->name('getMenu_itms_list');
                            Route::get('/addtocard',      [SweetMenuController::class, 'addtocard'])->name('addtocard');
                            Route::get('/fetch_menu_Cart_item',      [SweetMenuController::class, 'fetch_menu_Cart_item'])->name('fetch_menu_Cart_item');
                            Route::get('/fetch_menu_modal_Cart_item',      [SweetMenuController::class, 'fetch_menu_Cart_item_modaldata'])->name('fetch_menu_modal_Cart_item');
                            Route::post('/menucheckout',                [SweetMenuController::class, 'checkoutmenuOrder'])->name('menucheckout');
                            Route::GET('/menuinvoice/{id}',     [SweetMenuController::class, 'createmenuPDF'])->name('menuinvoice');
                            Route::get('/create',       [SweetMenuController::class, 'create'])->name('create');
                            Route::post('/store',       [SweetMenuController::class, 'store'])->name('store');
                            Route::get('/edit',         [SweetMenuController::class, 'edit'])->name('edit');
                            Route::post('/removeCartmenuitem',[SweetMenuController::class, 'removeCartmenuitem'])->name('removeCartmenuitem');
                            Route::post('/updateCartmenuitem', [SweetMenuController::class, 'updateCartmenuitem'])->name('updateCartmenuitem');
                            Route::post('/updateCartmenubreakitem', [SweetMenuController::class, 'updatebreakCartmenuitem'])->name('updateCartmenubreakitem');
                            Route::post('/clearCart', [SweetMenuController::class, 'clearCart'])->name('clearCart');
                            Route::post('/menuImage',    [SweetMenuController::class, 'menuImageDelete'])->name('image.delete');
                            Route::post('/menuSpec',    [SweetMenuController::class, 'menuSpecDelete'])->name('spec.delete');
                            Route::post('/update',      [SweetMenuController::class, 'update'])->name('update');
                            Route::post('/delete',      [SweetMenuController::class, 'delete'])->name('delete');
                            Route::get('/getRemainmenuquantity',      [SweetMenuController::class, 'getmenuRemainquantity'])->name('getRemainmenuquantity');
                        });
                
                        
                        Route::name('order.')->prefix('order')->group(function () {
                            Route::get('/view',                     [SweetOrderController::class, 'index'])->name('view');
                            Route::get('/list',                     [SweetOrderController::class, 'orderlist'])->name('list');
                            Route::get('/getlist/{filterByTypeDateParty}', [SweetOrderController::class, 'getorderlist'])->name('getlist');
                            Route::get('/editList',                 [SweetOrderController::class, 'listedit'])->name('editList');
                            Route::post('/deleteorder',             [SweetOrderController::class, 'orderdelete'])->name('deleteorder');
                            Route::get('/getTablePlanning',         [SweetOrderController::class, 'getTablePlanning'])->name('getTablePlanning');
                            Route::get('/getRunningOrders',         [SweetOrderController::class, 'getRunningOrders'])->name('getRunningOrders');
                            Route::post('/customerinfo',            [SweetOrderController::class, 'customerinfo'])->name('customerinfo');
                            Route::get('/addOrder',                 [SweetOrderController::class, 'addOrder'])->name('addOrder');
                            Route::get('/addOrderedit',                 [SweetOrderController::class, 'editaddOrder'])->name('addOrderedit');
                            Route::get('/addToCart',                [SweetOrderController::class, 'addToCart'])->name('addToCart');
                            Route::get('/fetch_menu_Cart',          [SweetOrderController::class, 'fetch_menu_Cart'])->name('fetch_menu_Cart');
                            Route::post('/update_menu_Cart',        [SweetOrderController::class, 'update_menu_Cart'])->name('update_menu_Cart');
                            Route::post('/removeCartitem',          [SweetOrderController::class, 'removeCartitem'])->name('removeCartitem');
                            Route::get('/tablewiseorderdetails',                [SweetOrderController::class, 'Orderdetailstablewise'])->name('tablewiseorderdetails');
                            Route::get('/addEdititemToCart',                [SweetOrderController::class, 'Edit_item_addToCart'])->name('addEdititemToCart');
                            Route::get('/edit_fetch_menu_Cart',          [SweetOrderController::class, 'fetch_menu_Cart_edit'])->name('edit_fetch_menu_Cart');
                            Route::post('/details_update_menu_Cart',        [SweetOrderController::class, 'update_menu_Cart_details'])->name('details_update_menu_Cart');
                            Route::post('/removeEditCartitem',          [SweetOrderController::class, 'EditremoveCartitem'])->name('removeEditCartitem');
                            Route::post('/editcheckout',                [SweetOrderController::class, 'EditcheckoutOrder'])->name('editcheckout');
                            Route::get('/orderInvoice/{id}',     [SweetOrderController::class, 'createPDF'])->name('orderInvoice');
                            Route::get('/create',                   [SweetOrderController::class, 'create'])->name('create');
                            Route::post('/store',                   [SweetOrderController::class, 'store'])->name('store');
                            Route::get('/edit',                     [SweetOrderController::class, 'edit'])->name('edit');;
                            Route::post('/OrderImage',              [SweetOrderController::class, 'OrderImageDelete'])->name('image.delete');
                            Route::post('/OrderSpec',               [SweetOrderController::class, 'OrderSpecDelete'])->name('spec.delete');
                            Route::post('/update',                  [SweetOrderController::class, 'update'])->name('update');
                            Route::post('/delete',                  [SweetOrderController::class, 'delete'])->name('delete');
                        });
                        
                    });



                    //    Sweets and confectionery part  end
  


 
















});
