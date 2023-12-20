<?php
use App\Http\Controllers\SendController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Botble\Hotel\Http\Controllers\PublicController;


//Route::post('/send', [SendController::class, 'sendForm'])->name('send');


Route::prefix('rooms')->group(function () {
    Route::get('/', [RoomController::class, 'index']); // Получение всех номеров
    Route::get('/{id}', [RoomController::class, 'show']); // Получение данных конкретного номера
    Route::get('/test/rooms', [PublicController::class, 'getRooms']);
});

Route::prefix('restaurant')->group(function () {
    Route::get('/', [RestaurantController::class, 'index']); // Получение всех номеров
    Route::get('/{id}', [RestaurantController::class, 'show']); // Получение данных конкретного номера
    Route::get('/order', [RestaurantController::class, 'orderFood']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('bookings')->group(function () {
        Route::get('/my', [BookingController::class, 'index']); // Получение всех бронирований
        Route::post('/', [BookingController::class, 'createBooking']); // Создание нового бронирования
        Route::get('/{token}', [BookingController::class, 'getBookingAPI']);
        Route::post('/checkout', [BookingController::class, 'postCheckoutAPI']);
        Route::get('/checkout/success/{transactionId}', [BookingController::class, 'checkoutSuccessAPI']);
        Route::get('/{id}', [BookingController::class, 'show']); // Получение данных конкретного бронирования
        Route::put('/{id}', [BookingController::class, 'update']); // Обновление бронирования
        Route::delete('/{id}', [BookingController::class, 'destroy']); // Удаление бронирования
        Route::post('/post', [PublicController::class, 'postBooking']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/me', [UserController::class, 'index']);
        Route::put('/edit', [UserController::class, 'update']);
    });
});



Route::prefix('auth')->group(function () {
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::get('/login', [UserAuthController::class, 'login']);
    Route::post('/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/reset', [ResetPasswordController::class, 'reset']);
    Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum'); // Логаут с Sanctum
});
Route::prefix('slider')->group(function () {
    Route::get('/', [SliderController::class, 'index']);
});
