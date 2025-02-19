<?php

use App\Http\Controllers\Admin\Assets\AssetProductController;
// use App\Http\Controllers\Admin\Assets\AssetCategoryController;
// use App\Http\Controllers\Admin\Assets\AssetBrandController;
use App\Http\Controllers\Admin\Assets\AssetPurchaseController;
use App\Http\Controllers\Admin\Assets\AssetSaleController;
use App\Http\Controllers\Admin\Assets\AssetController;
use App\Http\Controllers\Admin\Setup\AccountSettingController;


use Illuminate\Support\Facades\Route;

use App\Models\Asstes\asset;
use Illuminate\Support\Facades\Session;

Route::group(['middleware' => ['auth']], function () {


	
	Route::name('assets.')->prefix('assets')->group(function () {

				Route::get('/View',[AssetController::class,'index'])->name('view');
				Route::get('/getAssets',[AssetController::class,'getAssets'])->name('getAssets');
				Route::get('/generate/asset/pdf',[AssetController::class,'generateAssetPdf'])->name('generateAssetPdf');
				//Products Routes
				Route::name('products.')->prefix('products')->group(function () {
					Route::get('/view', [AssetProductController::class, 'index'])->name('view');
					Route::get('/getproduct', [AssetProductController::class, 'getproducts'])->name('getproducts');
					Route::get('/editProduct', [AssetProductController::class, 'editProduct'])->name('editProduct');
					Route::POST('/store', [AssetProductController::class, 'store'])->name('store');
					Route::POST('/update', [AssetProductController::class, 'update'])->name('update');
					Route::POST('/delete', [AssetProductController::class, 'delete'])->name('delete');
					Route::get('/depriciation/products/list', [AssetProductController::class, 'depriciationProducts'])->name('depriciationProducts');
					Route::get('getDepreciationAssets', [AssetProductController::class, 'getDepreciationAssets'])->name('getDepreciationAssets');
					Route::get('/generate/Depreciation/Assets/Pdf', [AssetProductController::class, 'depreciationAssetsPdf'])->name('depreciationAssetsPdf');
					Route::get('/get/depreciation/tenure', [AssetProductController::class, 'getDepreciationTenure'])->name('getDepreciationTenure');
					Route::get('/close/depreciation/tenure', [AssetProductController::class, 'cloaseDepreciation'])->name('cloaseDepreciation');
					Route::get('/get/Depreciation/Products/Yearwise', [AssetProductController::class, 'getDepreciationProductsYearwise'])->name('getDepreciationProductsYearwise');
					Route::get('/save/depreciation/tenure', [AssetProductController::class, 'saveDepriciationTenure'])->name('saveDepriciationTenure');
				});

				//Category Routes
				Route::name('categories.')->prefix('categories')->group(function () {
					Route::get('/view', [AssetCategoryController::class, 'index'])->name('view');
					Route::get('/edit', [AssetCategoryController::class, 'edit'])->name('edit');
					Route::POST('/store', [AssetCategoryController::class, 'store'])->name('store');
					Route::POST('/update', [AssetCategoryController::class, 'update'])->name('update');
					Route::POST('/delete', [AssetCategoryController::class, 'delete'])->name('delete');
				});

				//Brands Routes
				Route::name('brands.')->prefix('brands')->group(function () {
					Route::get('/view', [AccountSettingController::class, 'index'])->name('view');
					Route::get('/get/asset/brand', [AccountSettingController::class, 'getAssetBrand'])->name('getAssetBrand');
					Route::get('/edit/brand', [AccountSettingController::class, 'editBrand'])->name('edit');
					Route::POST('/store', [AccountSettingController::class, 'storeBrand'])->name('store');
					Route::POST('/update', [AccountSettingController::class, 'updateBrand'])->name('update');
					Route::POST('/delete', [AccountSettingController::class, 'deleteBrand'])->name('delete');
		     	});

				//Purchase Routes
				Route::name('purchase.')->prefix('purchase')->group(function () {
					Route::get('/', [AssetPurchaseController::class, 'index'])->name('index');
					Route::get('/purchaseView/{days}', [AssetPurchaseController::class, 'getPurchase'])->name('purchaseView');
					Route::get('/add', [AssetPurchaseController::class, 'add'])->name('add');
					Route::post('/addProduct', [AssetPurchaseController::class, 'addToCart'])->name('addToCart');
					Route::get('/fetchCart', [AssetPurchaseController::class, 'fetchCart'])->name('fetchCart');
					Route::post('/clearCart', [AssetPurchaseController::class, 'clearCart'])->name('clearCart');
					Route::post('/removeProduct',  [AssetPurchaseController::class, 'removeProduct'])->name('removeProduct');
					Route::post('/updateCart', [AssetPurchaseController::class, 'updateCart'])->name('updateCart');
					Route::post('/checkOutCart', [AssetPurchaseController::class, 'checkOutCart'])->name('checkOutCart');
					Route::post('/delete', [AssetPurchaseController::class, 'delete'])->name('delete');
					Route::get('/supplierDue', [AssetPurchaseController::class, 'supplierDue'])->name('supplierDue');
					Route::post('/showSerializTable', [AssetPurchaseController::class, 'showSerializTable'])->name('showSerializTable');
					Route::get('/invoice/{id}', [AssetPurchaseController::class, 'invoice'])->name('invoice');
		     	});

				//Sales Routes
				Route::name('sales.')->prefix('sales')->group(function () {
					Route::get('/view', [AssetSaleController::class, 'index'])->name('view');
					Route::get('/add', [AssetSaleController::class, 'create'])->name('add');
					Route::get('/edit', [AssetSaleController::class, 'edit'])->name('edit');
					Route::POST('/store', [AssetSaleController::class, 'store'])->name('store');
					Route::POST('/update', [AssetSaleController::class, 'update'])->name('update');
					Route::POST('/delete', [AssetSaleController::class, 'delete'])->name('delete');
					Route::get('/loadSearialProduct/{ProductId}', [AssetSaleController::class, 'loadSearialProduct'])->name('loadSearialProduct');
					Route::get('/get/serialize/product', [AssetSaleController::class, 'getSerializeProduct'])->name('getSerializeProduct');
					Route::post('/addProduct', [AssetSaleController::class, 'addToCart'])->name('addToCart');
					Route::get('/fetchCart', [AssetSaleController::class, 'fetchCart'])->name('fetchCart');
					Route::post('/clearCart', [AssetSaleController::class, 'clearCart'])->name('clearCart');
					Route::post('/updateCart', [AssetSaleController::class, 'updateCart'])->name('updateCart');
					Route::post('/removeProduct',  [AssetSaleController::class, 'removeProduct'])->name('removeProduct');
					Route::post('/checkOutCart', [AssetSaleController::class, 'checkOutCart'])->name('checkOutCart');
					Route::get('/getAssetSales', [AssetSaleController::class, 'getAssetSales'])->name('getAssetSales');
					Route::get('/invoice/{id}', [AssetSaleController::class, 'invoice'])->name('invoice');
				});
	});



				Route::get('account/asset/setting', [AccountSettingController::class, 'assetCategory'])->name('assetCategory');
				Route::post('asset/category/store', [AccountSettingController::class, 'assetCategoryStore'])->name('asset.category.store');
				Route::get('get/asset/category', [AccountSettingController::class, 'getassetCategory'])->name('assetCategory.getassetCategory');
				Route::get('asset/category/edit', [AccountSettingController::class, 'assetCategoryEdit'])->name('asset.category.edit');
				Route::post('asset/category/update', [AccountSettingController::class, 'assetCategoryUpdate'])->name('asset.category.update');
				Route::post('asset/category/delete', [AccountSettingController::class, 'assetCategoryDelete'])->name('asset.category.delete');
				
				Route::get('account/asset/brand', [AccountSettingController::class, 'assetBrand'])->name('assetBrand');
				Route::post('asset/Brand/store', [AccountSettingController::class, 'assetBrandStore'])->name('asset.Brand.store');
				Route::get('get/asset/Brand', [AccountSettingController::class, 'getassetBrand'])->name('assetBrand.getassetBrand');
				Route::get('asset/Brand/edit', [AccountSettingController::class, 'assetBrandEdit'])->name('asset.Brand.edit');
				Route::post('asset/Brand/update', [AccountSettingController::class, 'assetBrandUpdate'])->name('asset.Brand.update');
				Route::post('asset/Brand/delete', [AccountSettingController::class, 'assetBrandDelete'])->name('asset.Brand.delete');


});