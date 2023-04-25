<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    //  PROVINCES ROUTES
    Route::get('all-provinces', [ProvinceController::class, 'index'])->name('provinces.index');
    Route::get('province/{province}', [ProvinceController::class, 'showProvince'])->name('provinces.show');
    Route::post('add-province', [ProvinceController::class, 'postProvince'])->name('provinces.add');
    Route::put('edit-province/{province}', [ProvinceController::class, 'putProvince'])->name('provinces.edit');
    Route::delete('delete-province/{province}', [ProvinceController::class, 'deleteProvince'])->name('provinces.delete');
    Route::put('provinces/{province}/status', [ProvinceController::class, 'toggleStatus'])->name('provinces.toggle-status');

    //  WARDS ROUTES
    Route::get('all-wards', [WardController::class, 'index'])->name('wards.index');
    Route::get('ward/{ward}', [WardController::class, 'showWard'])->name('wards.show');
    Route::post('add-ward', [WardController::class, 'postWard'])->name('wards.add');
    Route::put('edit-ward/{ward}', [WardController::class, 'putWard'])->name('wards.edit');
    Route::delete('delete-ward/{ward}', [WardController::class, 'deleteWard'])->name('wards.delete');
    Route::put('wards/{ward}/status', [WardController::class, 'toggleStatus'])->name('wards.toggle-status');
    Route::get('get-wards', [WardController::class, 'getWards'])->name('wards.get-wards');

    //  SUB-WARDS ROUTES
    Route::get('all-sub-wards', [SubWardController::class, 'index'])->name('sub_wards.index');
    Route::get('sub-ward/{subWard}', [SubWardController::class, 'showSubWard'])->name('sub_wards.show');
    Route::post('add-sub-ward', [SubWardController::class, 'postSubWard'])->name('sub_wards.add');
    Route::put('edit-sub-ward/{subWard}', [SubWardController::class, 'putSubWard'])->name('sub_wards.edit');
    Route::delete('delete-sub-ward/{subWard}', [SubWardController::class, 'deleteSubWard'])->name('sub_wards.delete');
    Route::put('sub-wards/{subWard}/status', [SubWardController::class, 'toggleStatus'])->name('sub_wards.toggle-status');
    Route::get('get-sub-wards', [SubWardController::class, 'getSubWards'])->name('wards.get-sub-wards');

    //  STREETS ROUTES
    Route::get('all-streets', [StreetController::class, 'index'])->name('streets.index');
    Route::get('street/{street}', [StreetController::class, 'showStreet'])->name('streets.show');
    Route::post('add-street', [StreetController::class, 'postStreet'])->name('streets.add');
    Route::put('edit-street/{street}', [StreetController::class, 'putStreet'])->name('streets.edit');
    Route::delete('delete-street/{street}', [StreetController::class, 'deleteStreet'])->name('streets.delete');
    Route::put('streets/{street}/status', [StreetController::class, 'toggleStatus'])->name('streets.toggle-status');
    Route::get('get-streets', [StreetController::class, 'getStreets'])->name('wards.get-streets');

    //  VEHICLES ROUTES
    Route::get('all-vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('vehicle', [VehicleController::class, 'showVehicle'])->name('vehicles.show');
    Route::post('add-vehicle', [VehicleController::class, 'postVehicle'])->name('vehicles.add');
    Route::get('add-vehicle-form', [VehicleController::class, 'showAddVehicleForm'])->name('vehicles.show_add_form');
    Route::put('edit-vehicle/{vehicle}', [VehicleController::class, 'putVehicle'])->name('vehicles.edit');
    Route::put('change_tin/{vehicle}', [VehicleController::class, 'changeTin'])->name('vehicles.change_tin');
    Route::delete('delete-vehicle/{vehicle}', [VehicleController::class, 'deleteVehicle'])->name('vehicles.delete');
    Route::put('vehicles/{vehicle}/status', [VehicleController::class, 'toggleStatus'])->name('vehicles.toggle-status');
    Route::get('suggestions', [VehicleController::class, 'getSuggestions'])->name('suggestions');

    //  STICKERS ROUTES
    Route::get('all-stickers', [StickerController::class, 'index'])->name('stickers.index');
    Route::get('sticker/{sticker}', [StickerController::class, 'showSticker'])->name('stickers.show');
    Route::post('add-sticker', [StickerController::class, 'postSticker'])->name('stickers.add');
    Route::put('edit-sticker/{sticker}', [StickerController::class, 'putSticker'])->name('stickers.edit');
    Route::delete('delete-sticker/{sticker}', [StickerController::class, 'deleteSticker'])->name('stickers.delete');
    Route::put('stickers/{sticker}/status', [StickerController::class, 'toggleStatus'])->name('stickers.toggle-status');
    Route::get('update-expired-sticker-status', [StickerController::class, 'sendReminderBeforeMonth'])->name('stickers.update-expired-sticker-status');

    //  PARKINGS ROUTES
    Route::get('/parkings', [ParkingController::class, 'index'])->name('parkings.index');
    Route::get('all-parkings', [ParkingController::class, 'index'])->name('parkings.index');
    Route::get('parking/{parking}', [ParkingController::class, 'showSticker'])->name('parkings.show');
    Route::post('add-parking', [ParkingController::class, 'postSticker'])->name('parkings.add');
    Route::put('edit-parking/{parking}', [ParkingController::class, 'putSticker'])->name('parkings.edit');
    Route::delete('delete-parking/{parking}', [ParkingController::class, 'deleteSticker'])->name('parkings.delete');
    Route::put('parkings/{parking}/status', [ParkingController::class, 'toggleStatus'])->name('parkings.toggle-status');
    Route::get('update-expired-parking-status', [ParkingController::class, 'sendReminderBeforeMonth'])->name('parkings.update-expired-sticker-status');

    //  PAYMENTS ROUTES
    Route::get('all-payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payment/{payment}', [PaymentController::class, 'showPayment'])->name('payments.show');
    Route::post('add-payment', [PaymentController::class, 'postPayment'])->name('payments.add');
    Route::put('edit-payment/{payment}', [PaymentController::class, 'putPayment'])->name('payments.edit');
    Route::delete('delete-payment/{payment}', [PaymentController::class, 'deletePayment'])->name('payments.delete');
    Route::put('payments/{payment}/status', [PaymentController::class, 'toggleStatus'])->name('payments.toggle-status');

    //  PROFILES ROUTES
    Route::get('all-profiles', [ProfileController::class, 'index'])->name('profiles.index');

    //  ALERTS ROUTES
    Route::get('all-alerts', [AlertController::class, 'index'])->name('alerts.index');

    //  E-MAILS ROUTES
    Route::post('send-email', [VehicleController::class, 'sendEmail'])->name('send-email');

    //  MESSAGES ROUTES
    Route::post('send-message', [VehicleController::class, 'sendMessage'])->name('send-message');

    //  ROLES ROUTES
    Route::get('all-roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('role/{role}', [RoleController::class, 'showRole'])->name('roles.show');
    Route::post('add-role', [RoleController::class, 'postRole'])->name('roles.add');
    Route::put('edit-role/{role}', [RoleController::class, 'putRole'])->name('roles.edit');
    Route::delete('delete-role/{role}', [RoleController::class, 'deleteRole'])->name('roles.delete');
    Route::put('roles/{role}/status', [RoleController::class, 'toggleStatus'])->name('roles.toggle-status');

    //  OWNERS ROUTES
    Route::get('all-owners', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('owner/{owner}', [OwnerController::class, 'showOwner'])->name('owners.show');
    Route::post('add-owner', [OwnerController::class, 'postOwner'])->name('owners.add');
    Route::put('edit-owner/{owner}', [OwnerController::class, 'putOwner'])->name('owners.edit');
    Route::delete('delete-owner/{owner}', [OwnerController::class, 'deleteOwner'])->name('owners.delete');
    Route::put('owners/{owner}/status', [OwnerController::class, 'toggleStatus'])->name('owners.toggle-status');

    //  DRIVERS ROUTES
    Route::get('all-drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('driver/{driver}', [DriverController::class, 'showDriver'])->name('drivers.show');
    Route::post('add-driver', [DriverController::class, 'postDriver'])->name('drivers.add');
    Route::put('edit-driver/{driver}', [DriverController::class, 'putDriver'])->name('drivers.edit');
    Route::delete('delete-driver/{driver}', [DriverController::class, 'deleteDriver'])->name('drivers.delete');
    Route::put('drivers/{driver}/status', [DriverController::class, 'toggleStatus'])->name('drivers.toggle-status');

    //  USERS ROUTES
    Route::get('all-users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/{user}', [UserController::class, 'showUser'])->name('users.show');
    Route::post('add-user', [UserController::class, 'postUser'])->name('users.add');
    Route::put('edit-user/{user}', [UserController::class, 'putUser'])->name('users.edit');
    Route::delete('delete-user/{user}', [UserController::class, 'deleteUser'])->name('users.delete');
    Route::put('users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    //  USERS ROUTES
    Route::get('all-users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/{user}', [UserController::class, 'showUser'])->name('users.show');
    Route::post('add-user', [UserController::class, 'postUser'])->name('users.add');
    Route::put('edit-user/{user}', [UserController::class, 'putUser'])->name('users.edit');
    Route::delete('delete-user/{user}', [UserController::class, 'deleteUser'])->name('users.delete');
    Route::put('users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // LOG ACTIVITY ROUTES
    Route::get('log-activities', [LogActivityController::class, 'index'])->name('logs.index');

    //  SETTINGS ROUTES
    Route::get('all-settings', [SettingController::class, 'index'])->name('settings.index');

    // REPORTS ROUTES
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/vehicle-report', [ReportController::class, 'vehicleReport'])->name('reports.vehicle');
    Route::get('/sales-report', [WatercomReportController::class, 'salesReport'])->name('watercom.reports.sales');
    Route::get('/stocks-report', [WatercomReportController::class, 'stocksReport'])->name('watercom.reports.stocks');
    Route::get('/customers-report', [WatercomReportController::class, 'customersReport'])->name('watercom.reports.customers');
});
