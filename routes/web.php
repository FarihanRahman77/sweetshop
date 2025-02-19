<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagement\User\UserController;
use App\Http\Controllers\Admin\SetupManagement\CompanySettingController;
use App\Http\Controllers\Admin\SetupManagement\SisterConcernController;
use App\Http\Controllers\Admin\UserManagement\RolePermission\RoleController;
use App\Http\Controllers\Admin\UserManagement\RolePermission\PermissionController;
use App\Http\Controllers\Admin\UserManagement\RolePermission\PermissionToRoleController;
use App\Http\Controllers\Admin\UserManagement\DashboardController;




Route::get('/', function () {
	return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    /*  Company Settings Routes */
	Route::name('company.')->prefix('company')->group(function () {
		Route::get('/settings/view', [CompanySettingController::class, 'index'])->name('settings.view');
		Route::get('/settings/edit', [CompanySettingController::class, 'edit'])->name('settings.edit');
		Route::post('/settings/update', [CompanySettingController::class, 'update'])->name('settings.update');
	});
	
	//sister concern
	Route::get('/sister/concern/view', [SisterConcernController::class, 'index'])->name('sisterConcern.view');
	Route::get('/sister/concern/getSisterConcern', [SisterConcernController::class, 'getSisterConcern'])->name('getSisterConcern');
	Route::post('/sister/concern/store', [SisterConcernController::class, 'store'])->name('sisterConcern.store');
	Route::get('/sister/concern/edit', [SisterConcernController::class, 'edit'])->name('sisterConcern.edit');
	Route::post('/sister/concern/update', [SisterConcernController::class, 'update'])->name('sisterConcern.update');
	Route::post('/sister/concern/delete', [SisterConcernController::class, 'delete'])->name('sisterConcern.delete');
	
	

	/*  Users Routes */
	Route::name('users.')->prefix('users')->group(function () {
		Route::get('/view', [UserController::class, 'index'])->name('');
		Route::get('/viewTypes', [UserController::class, 'getUsers'])->name('view');
		//Route::get('/data',  [UserController::class, 'add']);
		Route::post('/store', [UserController::class,'store'])->name('store');
		Route::get('/edit', [UserController::class, 'edit'])->name('edit');
		Route::post('/update', [UserController::class, 'update'])->name('update');
		Route::post('/delete', [UserController::class, 'delete'])->name('delete');
		Route::get('/edit_user_password',  [UserController::class, 'edit_user_password'])->name('edit_user_password');
		Route::post('/password_update',  [UserController::class, 'password_update'])->name('password_update');
	});



	Route::post('changePassword', [UserController::class, 'changePassword'])->name('changePassword');

	/* Roles */
	Route::get('role/view', [RoleController::class, 'index'])->name('rolesView');
	Route::post('roles/store', [RoleController::class, 'store'])->name('roleStore');
	Route::get('roles/delete/{id}', [RoleController::class, 'delete'])->name('roleDelete');
	/* Permissions */
	Route::get('permission/view', [PermissionController::class, 'index'])->name('permissionView');
	Route::post('permission/store', [PermissionController::class, 'store'])->name('permissionStore');
	Route::get('permission/edit', [PermissionController::class, 'edit'])->name('editPermission');
	Route::post('permission/update', [PermissionController::class, 'update'])->name('permissionUpdate');
	Route::get('permissions/delete/{id}', [PermissionController::class, 'delete'])->name('permissionDelete');

	/* Permission to role */
	Route::get('permission/to/role/view', [PermissionToRoleController::class, 'index'])->name('permissionToRoleList');
	//Route::get('/give/permission', [PermissionToRoleController::class, 'givePermission'])->name('givePermission')->middleware('permission:user.view');
	Route::get('/get/permission', [PermissionToRoleController::class, 'getPermission'])->name('getPermissions');
	Route::post('/give/permission/store', [PermissionToRoleController::class, 'store'])->name('roleToPermissionStore');
});

require __DIR__.'/auth.php';
