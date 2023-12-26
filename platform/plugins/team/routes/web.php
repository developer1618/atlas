<?php

use Botble\Base\Facades\BaseHelper;
use Botble\Team\Http\Controllers\PublicController;
use Botble\Team\Models\Team;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Team\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'teams', 'as' => 'team.'], function () {
            Route::resource('', 'TeamController')->parameters(['' => 'team']);
        });
    });

    Route::get(sprintf('%s/{slug}', SlugHelper::getPrefix(Team::class, 'teams')), [PublicController::class, 'getTeam'])
        ->name('public.team');
});
