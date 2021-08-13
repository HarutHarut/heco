<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\BikeController;
use App\Http\Controllers\Dashboard\DBBikeController;
use App\Http\Controllers\Dashboard\DetailController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\ModelController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\BookingController;
use App\Http\Controllers\Dashboard\ArticleController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\ChangePasswordController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\NewBikeRequestController;
use App\Http\Controllers\Dashboard\PageController;


Route::group([
        'prefix' => LaravelLocalization::setLocale() . '/dashboard',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('purchase', [BookingController::class, 'purchase'])->name('purchase');
    Route::post('purchase-export', [BookingController::class, 'export'])->name('purchase.export');

    Route::resource('users', UserController::class);
    Route::post('users-export', [UserController::class, 'export'])->name('users.export');

    Route::resource('bikes', BikeController::class);
    Route::post('bikes-import', [BikeController::class, 'import'])->name('bikes.import');
    Route::post('bikes-export', [BikeController::class, 'export'])->name('bikes.export');
    Route::resource('DBbikes', DBBikeController::class);
    Route::resource('bike/details', DetailController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('brand/models', ModelController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('change', ChangePasswordController::class);
    Route::resource('notifications', NotificationController::class);
    Route::resource('newbike', NewBikeRequestController::class);
    Route::resource('pages', PageController::class);

    Route::get('/brand-models', [BikeController::class, 'brandModels'])->name('brand-models');

    Route::post('/confirm/{id}', [\App\Http\Controllers\StripeController::class, 'confirm'])->name('pay.conmfirm');

});


Route::get('/translations', [Barryvdh\TranslationManager\Controller::class, 'getIndex'])->name('translation_manager');
Route::get('/translations/view/{group?}', [Barryvdh\TranslationManager\Controller::class, 'getView'])->name('translation_group');
