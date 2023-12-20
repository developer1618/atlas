<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\RoomController;

Route::post('/send', [SendController::class, 'sendForm'])->name('send');



//***********************************ГЛАВНЫЙ ЭКРАН****************************************
//Route::get('/mobile/slider', [MobileController::class, 'slider'])->name('public.slider');
//Route::get('/mobile/rooms', [RoomController::class, 'index']);
//Route::get('/mobile/restaurant', [MobileController::class, 'restaurant'])->name('public.restaurant');
//Route::get('/mobile/booking', [MobileController::class, 'booking'])->name('public.booking');
////****************************************************************************************
//
////**********************************ЭКРАН ВХОДА*******************************************
//Route::get('/mobile/register', [MobileController::class, 'register'])->name('public.register');
//Route::get('/mobile/login', [MobileController::class, 'login'])->name('public.login');
//Route::get('/mobile/forgotPassword', [MobileController::class, 'forgotPassword'])->name('public.forgotPassword');
////****************************************************************************************
//
////**********************************ИСТОРИЯ*******************************************
//Route::get('/mobile/booking-history/', [MobileController::class, 'booking-history'])->name('public.booking-history');
//Route::get('/mobile/booking-history/active', [MobileController::class, 'bhActive'])->name('public.bhActive');
////****************************************************************************************
//
////**********************************РЕСТОРАН*******************************************
//Route::get('/mobile/restaurant/list', [MobileController::class, 'rList'])->name('public.rList');
//Route::get('/mobile/restaurant/send', [MobileController::class, 'rSend'])->name('public.rSend');
////****************************************************************************************
//
////**********************************НОМЕРА*******************************************
//Route::get('/mobile/rooms/list', [MobileController::class, 'roomsList'])->name('public.roomsList');
//Route::get('/mobile/rooms/{roomdId}', [MobileController::class, '']);
////****************************************************************************************
//
////**********************************ПРОФИЛЬ*******************************************
//Route::get('/mobile/profile', [MobileController::class, 'profile'])->name('public.profile');
////****************************************************************************************