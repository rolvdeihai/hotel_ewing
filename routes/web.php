<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\LogisticsController;
use App\Models\Bookings;
use App\Models\Logistics;
use App\Models\Transactions;

Route::get('/', function () {
    return view('ahotel');
});

Route::get('/', [RoomsController::class, 'availableRooms']);
// Route::get('ahotel', [BookingsController::class, 'totalRevenue']);

Route::get('/viewSlideLogistics', [ItemsController::class, 'viewSlideLogistics']);

Route::get('/viewSlideTransactions', [TransactionsController::class, 'viewSlideTransactions']);

// Route::get('/SearchBookings', [BookingsController::class, 'SearchBookings']);


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

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/signin', function () {
    return view('signin');
});

Route::get('/account-maintenance', function () {
    return view('account-maintenance');
});

Route::get('/addtransaction', function () {
    return view('addtransaction');
});

Route::post('/addTransaction', [KasController::class, 'addTransaction']);

Route::post('/additionalitem',
[RoomsController::class, 'additionalitem']);

Route::post('/booking',
[BookingsController::class, 'booking']);

Route::post('/deletebooking', [BookingsController::class, 'deleteBooking']);
Route::post('/deletetransaction', [TransactionsController::class, 'deleteTransactions']);

Route::post('/nota',
[TransactionsController::class, 'nota']);

Route::post('/editbooking',
[BookingsController::class, 'editbooking']);

Route::post('/edittransaction',
[TransactionsController::class, 'edittransaction']);

Route::post('/updatebooking',
[BookingsController::class, 'updatebooking']);

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

Route::post('/delete_kas',
[KasController::class, 'delete_kas']);

Route::post('/cancel_kas',
[KasController::class, 'cancel_kas']);

Route::get('/roomsettings', [RoomsController::class, 'roomsettings']);
Route::post('/update-room-settings', [RoomsController::class, 'update_room_settings']);

Route::get('/editusers', function () {
    return view('editusers');
});
