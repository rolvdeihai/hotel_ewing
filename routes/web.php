<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\AccountsController;
use App\Models\Bookings;
use App\Models\Logistics;
use App\Models\Transactions;

Route::middleware(['web'])->group(function () {
    Route::get('/', [RoomsController::class, 'availableRooms']);
    Route::get('/viewSlideLogistics', [ItemsController::class, 'viewSlideLogistics']);
    Route::get('/viewSlideTransactions', [TransactionsController::class, 'viewSlideTransactions']);

    Route::post('/signin', [AccountsController::class, 'login']);
    Route::post('/logout', [AccountsController::class, 'logout']);

    Route::get('/rooms', [RoomsController::class, 'index']);
    Route::get('/additem', [ItemsController::class, 'index']);
    Route::post('/additem', [ItemsController::class, 'add']);

    Route::post('/add_xitem', [BookingsController::class, 'add_xitem']);

    Route::get('/additemsell', [ItemsController::class, 'indexsell']);
    Route::post('/additemsell', [ItemsController::class, 'addsell']);

    Route::get('/checkin', [RoomsController::class, 'viewCheckIn']);
    Route::post('/checkIn', [RoomsController::class, 'CheckIn']);
    Route::post('/checkout', [RoomsController::class, 'CheckOut']);

    Route::get('/viewItems', [ItemsController::class, 'viewItems']);
    Route::get('/price_list', [ItemsController::class, 'viewItemsSell']);

    Route::get('/viewKas', [KasController::class, 'viewKas']);
    Route::get('/viewSlide', [KasController::class, 'viewSlide']);

    Route::get('/transactions', [TransactionsController::class, 'index']);

    // Route::get('/profile', function () {
    //     return view('profile');
    // });

    Route::get('/profile', [AccountsController::class, 'profile']);

    Route::get('/signin', function () {
        return view('signin');
    })->name('signin');

    // Route::get('/account-maintenance', [AccountsController::class, 'accountMaintenance'])->middleware('role');

    // Route::get('/account-maintenance', function () {
    //     return view('account-maintenance');
    // })->middleware('auth');

    Route::get('/addtransaction', function () {
        return view('addtransaction');
    });

    Route::post('/addTransaction', [KasController::class, 'addTransaction']);

    Route::post('/additionalitem',
    [RoomsController::class, 'additionalitem']);

    Route::post('/booking',
    [BookingsController::class, 'booking']);

    // Route::post('/deletebooking', [BookingsController::class, 'deleteBooking']);
    // Route::post('/deletetransaction', [TransactionsController::class, 'deleteTransactions']);

    Route::post('/nota',
    [TransactionsController::class, 'nota']);

    Route::post('/editlogistics',
    [LogisticsController::class, 'editlogistics']);

    Route::post('/updatelogistics',
    [ItemsController::class, 'updatelogistic']);

    Route::post('/edit_pricelist',
    [ItemsController::class, 'editpricelist']);

    Route::post('/update_pricelist',
    [ItemsController::class, 'update_pricelist']);

    Route::post('/delete_pricelist',
    [ItemsController::class, 'delete_pricelist']);

    Route::post('/delete_logistic',
    [LogisticsController::class, 'delete_logistic']);

});

Route::middleware(['web', 'role'])->group(function () {
    Route::get('/account-maintenance', [AccountsController::class, 'accountMaintenance']);
    Route::post('/deletebooking', [BookingsController::class, 'deleteBooking']);
    Route::post('/deletetransaction', [TransactionsController::class, 'deleteTransactions']);
    Route::post('/delete_kas',
    [KasController::class, 'delete_kas']);

    Route::post('/cancel_kas',
    [KasController::class, 'cancel_kas']);

    Route::post('/editbooking',
    [BookingsController::class, 'editbooking']);
    Route::post('/updatebooking',
    [BookingsController::class, 'updatebooking']);

    Route::post('/edittransaction',
    [TransactionsController::class, 'edittransaction']);

    Route::get('/roomsettings', [RoomsController::class, 'roomsettings']);
    Route::post('/update-room-settings', [RoomsController::class, 'update_room_settings']);
    Route::post('/editAccount', [AccountsController::class, 'editAccount']);
    Route::post('/updateProfile', [AccountsController::class, 'updateProfile']);

});


// Route::get('/rooms', [RoomsController::class, 'index']);
// Route::get('/additem', [ItemsController::class, 'index']);
// Route::post('/additem', [ItemsController::class, 'add']);

// Route::post('/add_xitem', [BookingsController::class, 'add_xitem']);

// Route::get('/additemsell', [ItemsController::class, 'indexsell']);
// Route::post('/additemsell', [ItemsController::class, 'addsell']);

// Route::get('/checkin', [RoomsController::class, 'viewCheckIn']);
// Route::post('/checkIn', [RoomsController::class, 'CheckIn']);
// Route::post('/checkout', [RoomsController::class, 'CheckOut']);

// Route::get('/viewItems', [ItemsController::class, 'viewItems']);
// Route::get('/price_list', [ItemsController::class, 'viewItemsSell']);

// Route::get('/viewKas', [KasController::class, 'viewKas']);
// Route::get('/viewSlide', [KasController::class, 'viewSlide']);

// Route::get('/transactions', [TransactionsController::class, 'index']);

// Route::get('/profile', function () {
//     return view('profile');
// });

// Route::get('/signin', function () {
//     return view('signin');
// })->name('signin');

// Route::get('/account-maintenance', [AccountsController::class, 'accountMaintenance'])->middleware('auth');

// // Route::get('/account-maintenance', function () {
// //     return view('account-maintenance');
// // })->middleware('auth');

// Route::get('/addtransaction', function () {
//     return view('addtransaction');
// });

// Route::post('/addTransaction', [KasController::class, 'addTransaction']);

// Route::post('/additionalitem',
// [RoomsController::class, 'additionalitem']);

// Route::post('/booking',
// [BookingsController::class, 'booking']);

// Route::post('/deletebooking', [BookingsController::class, 'deleteBooking']);
// Route::post('/deletetransaction', [TransactionsController::class, 'deleteTransactions']);

// Route::post('/nota',
// [TransactionsController::class, 'nota']);

// Route::post('/editbooking',
// [BookingsController::class, 'editbooking']);

// Route::post('/edittransaction',
// [TransactionsController::class, 'edittransaction']);

// Route::post('/updatebooking',
// [BookingsController::class, 'updatebooking']);

// Route::post('/editlogistics',
// [LogisticsController::class, 'editlogistics']);

// Route::post('/updatelogistics',
// [ItemsController::class, 'updatelogistic']);

// Route::post('/edit_pricelist',
// [ItemsController::class, 'editpricelist']);

// Route::post('/update_pricelist',
// [ItemsController::class, 'update_pricelist']);

// Route::post('/delete_pricelist',
// [ItemsController::class, 'delete_pricelist']);

// Route::post('/delete_logistic',
// [LogisticsController::class, 'delete_logistic']);

// Route::post('/delete_kas',
// [KasController::class, 'delete_kas']);

// Route::post('/cancel_kas',
// [KasController::class, 'cancel_kas']);

// Route::get('/roomsettings', [RoomsController::class, 'roomsettings']);
// Route::post('/update-room-settings', [RoomsController::class, 'update_room_settings']);
