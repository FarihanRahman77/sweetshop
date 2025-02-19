<?php

use App\Http\Controllers\Admin\hotelManagement\RoomController;
use App\Http\Controllers\Admin\hotelManagement\AssetAssignController;
use App\Http\Controllers\Admin\hotelManagement\FloorController;
use App\Http\Controllers\Admin\hotelManagement\FacilityController;
use App\Http\Controllers\Admin\hotelManagement\BuildingController;
use App\Http\Controllers\Admin\hotelManagement\BookingController;
use App\Http\Controllers\Admin\hotelManagement\CallRemainderController;
use App\Http\Controllers\Admin\hotelManagement\BoyAssignController;
use App\Http\Controllers\Admin\hotelManagement\BoyController;
use Illuminate\Support\Facades\Route;
use App\Models\hotelManagement\Floor;
use Illuminate\Support\Facades\Session;

Route::group(['middleware' => ['auth']], function () {
    
    Route::name('hotelManagement.')->prefix('hotelManagement')->group(function () {

        Route::name('floor.')->prefix('floor')->group(function () {
            Route::get('/view',         [FloorController::class, 'index'])->name('view');
            Route::get('/getFloors/{filterByBuilding}',    [FloorController::class, 'getFloors'])->name('getFloors');
            Route::get('/getFloorView', [FloorController::class, 'getFloorView'])->name('getFloorView');
            Route::post('/store',       [FloorController::class, 'store'])->name('store');
            Route::get('/edit',         [FloorController::class, 'edit'])->name('edit');;
            Route::post('/update',      [FloorController::class, 'update'])->name('update');
            Route::post('/delete',      [FloorController::class, 'delete'])->name('delete');
        });

        Route::name('room.')->prefix('room')->group(function () {
            Route::get('/view',                 [RoomController::class, 'index'])->name('view');
            Route::get('/getFloor',             [RoomController::class, 'getFloor'])->name('getFloor');
            Route::get('/getRooms',             [RoomController::class, 'getRooms'])->name('getRooms');
            Route::get('/getRoomslist',             [RoomController::class, 'getRoomslistview'])->name('getRoomslist');
            Route::get('/viewgetRooms',             [RoomController::class, 'viewgetRooms'])->name('viewgetRooms');
            Route::get('/categoryWiseFacility', [RoomController::class, 'categoryWiseFacility'])->name('categoryWiseFacility');
            Route::post('/assignFacility',      [RoomController::class, 'assignFacility'])->name('assignFacility');
            Route::post('/store',               [RoomController::class, 'store'])->name('store');
            Route::get('/edit',                 [RoomController::class, 'edit'])->name('edit');
            Route::post('/update',              [RoomController::class, 'update'])->name('update');
            Route::post('/delete',              [RoomController::class, 'delete'])->name('delete');
            Route::get('/roomAndFloorView',     [RoomController::class, 'roomAndFloorView'])->name('roomAndFloorView');
            Route::get('/getRoomAvailability',  [RoomController::class, 'getRoomAvailability'])->name('getRoomAvailability');
            Route::get('/getSisterConcernFromFloor', [RoomController::class, 'getSisterConcernFromFloor'])->name('getSisterConcernFromFloor');
            Route::get('/roomDetails', [RoomController::class, 'roomDetails'])->name('roomDetails');
        });

        Route::name('facilities.')->prefix('facilities')->group(function () {
            Route::get('/view',          [FacilityController::class, 'index'])->name('view');
            Route::get('/getFacilities', [FacilityController::class, 'getFacilities'])->name('getFacilities');
            Route::post('/store',        [FacilityController::class, 'store'])->name('store');
            Route::get('/edit',          [FacilityController::class, 'edit'])->name('edit');;
            Route::post('/update',       [FacilityController::class, 'update'])->name('update');
            Route::post('/delete',       [FacilityController::class, 'delete'])->name('delete');
        });

        Route::name('building.')->prefix('building')->group(function () {
            Route::get('/view',        [BuildingController::class, 'index'])->name('view');
            Route::get('/getBuildings',[BuildingController::class, 'getBuildings'])->name('getBuildings');
            Route::post('/store',      [BuildingController::class, 'store'])->name('store');
            Route::get('/edit',        [BuildingController::class, 'edit'])->name('edit');;
            Route::post('/update',     [BuildingController::class, 'update'])->name('update');
            Route::post('/delete',     [BuildingController::class, 'delete'])->name('delete');
            Route::post('/getFloors',     [BuildingController::class, 'getFloors'])->name('getFloors');
            Route::get('/getRoomsFromBuilding',     [BuildingController::class, 'getRoomsFromBuilding'])->name('getRoomsFromBuilding');
        });

        Route::name('bookings.')->prefix('bookings')->group(function () {
            Route::get('/view/{id}',               [BookingController::class, 'index'])->name('view');
            Route::get('/date_wise',               [CallRemainderController::class, 'date_wisebooking_view'])->name('date_wise');
            // Route::get('/getBookings/{booking_id}',[BookingController::class, 'getBookings'])->name('getBookings');
            Route::get('/getBookings/{booking_id}', [BookingController::class, 'getBookings'])->name('getBookings');
            Route::get('/searchCustomer',          [BookingController::class, 'searchCustomer'])->name('searchCustomer');
            Route::get('/searchCustomerAndBooking',[BookingController::class, 'searchCustomerAndBooking'])->name('searchCustomerAndBooking');
            Route::get('/addbooking/{ids}',        [BookingController::class, 'addbooking'])->name('addbooking');
            Route::get('/bookingDetails',          [BookingController::class, 'bookingDetails'])->name('bookingDetails');
            Route::get('/resetbookingstatus',          [BookingController::class, 'resetbookingstatus'])->name('resetbookingstatus');
            Route::POST('/update_bookinghstatus_Time', [BookingController::class, 'update_bookinghstatus_Time'])->name('update_bookinghstatus_Time');
            Route::POST('/saveExtendedRooms',      [BookingController::class, 'saveExtendedRooms'])->name('saveExtendedRooms');
            Route::get('/getBookingData',          [BookingController::class, 'getBookingData'])->name('getBookingData');
            Route::get('/setRowValue',             [BookingController::class, 'setRowValue'])->name('setRowValue');
            Route::POST('/changeBookingStatus',    [BookingController::class, 'changeBookingStatus'])->name('changeBookingStatus');
            Route::get('/fetchRooms',              [BookingController::class, 'fetchRooms'])->name('fetchRooms');
            Route::GET('/getBuildingWiseRoom',     [BookingController::class, 'getBuildingWiseRoom'])->name('getBuildingWiseRoom');
            Route::post('/booking',                [BookingController::class, 'booking'])->name('booking');
            Route::GET('/bookingInvoice/{id}',     [BookingController::class, 'createPDF'])->name('invoice');
            Route::GET('/billData',                [BookingController::class, 'billData'])->name('billData');
            Route::post('/billAdjust',             [BookingController::class, 'billAdjust'])->name('billAdjust');
            Route::get('/edit',                    [BookingController::class, 'edit'])->name('edit');
            Route::post('/update',                 [BookingController::class, 'update'])->name('update');
            Route::post('/delete',                 [BookingController::class, 'delete'])->name('delete');
            Route::get('/paymentReceive',          [BookingController::class, 'paymentReceive'])->name('paymentReceive');
        });
        Route::name('boy.')->prefix('boy')->group(function () {
            Route::get('/addBoy',          [BoyController::class, 'addBoy'])->name('addBoy');
            Route::get('/view',          [BoyController::class, 'index'])->name('view');
            Route::get('/getboys',          [BoyController::class, 'getboys'])->name('getboys');
            Route::post('/store',        [BoyController::class, 'store'])->name('store');
            Route::get('/edit',          [BoyController::class, 'edit'])->name('edit');;
            Route::post('/update',       [BoyController::class, 'update'])->name('update');
            Route::post('/delete',       [BoyController::class, 'delete'])->name('delete');
        });
        Route::name('boyAssign.')->prefix('boyAssign')->group(function () {
            Route::get('/addBoyAssign',          [BoyAssignController::class, 'addBoyAssign'])->name('addBoyAssign');
            Route::get('/view',          [BoyAssignController::class, 'index'])->name('view');
            Route::get('/getAssignedEmployee/{filterByRoom}/{filterByEmployee}/{filterByBuilding}',[BoyAssignController::class, 'getAssignedEmployee'])->name('getAssignedEmployee');
            Route::post('/store',        [BoyAssignController::class, 'store'])->name('store');
            Route::get('/edit',          [BoyAssignController::class, 'edit'])->name('edit');;
            Route::post('/update',       [BoyAssignController::class, 'update'])->name('update');
            Route::post('/delete',       [BoyAssignController::class, 'delete'])->name('delete');
        });

        Route::name('assetAssign.')->prefix('assetAssign')->group(function (){
            Route::get('/view',            [AssetAssignController::class, 'index'])->name('view');
            Route::get('/getAssignedAsset',[AssetAssignController::class, 'getAssignedAsset'])->name('getAssignedAsset');
            Route::get('/getRooms',        [AssetAssignController::class, 'getRooms'])->name('getRooms');
            Route::post('/store',          [AssetAssignController::class, 'store'])->name('store');
            Route::get('/edit',            [AssetAssignController::class, 'edit'])->name('edit');;
            Route::post('/update',         [AssetAssignController::class, 'update'])->name('update');
            Route::post('/delete',         [AssetAssignController::class, 'delete'])->name('delete');
            Route::post('/shiftAsset',     [AssetAssignController::class, 'shiftAsset'])->name('shiftAsset');
            Route::get('/getShiftedAsset', [AssetAssignController::class, 'getShiftedAsset'])->name('getShiftedAsset');
            Route::get('/getBuildingForShift',      [AssetAssignController::class, 'getBuildingForShift'])->name('getBuildingForShift');
            Route::get('/getRoomsForShift',         [AssetAssignController::class, 'getRoomsForShift'])->name('getRoomsForShift');
            Route::get('/getAssignedAssetForShift', [AssetAssignController::class, 'getAssignedAssetForShift'])->name('getAssignedAssetForShift');
        });
    });
});
