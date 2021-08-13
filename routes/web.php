<?php

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FilterController;

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

Route::get('/test', function (){
    return view('test');
});
Route::get('/showDetail', [TestController::class, 'showDetail'])->name('showDetail');
Route::get('/create', [TestController::class, 'index'])->name('index');
Route::get('/settings', [TestController::class, 'settings'])->name('settings');
Route::get('/request', [TestController::class, 'request'])->name('request');
Route::get('/components', [TestController::class, 'components'])->name('components');

Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/impressum', [PageController::class, 'impressum'])->name('impressum');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/what-we-do', [PageController::class, 'whatWeDo'])->name('what_we_do');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'contact_mail'])->name('contact.mail');
    Route::post('/purchase-advice', [ContactController::class, 'purchaseAdvice'])->name('purchase.advice');

    Route::get('/buy', [BikeController::class, 'buy'])->name('buy');
    Route::get('/sell', [BikeController::class, 'sell'])->name('sell');

    Route::get('/sell/select', [BikeController::class, 'select'])->name('sell.select');
    Route::post('/sell/{bike_id}/select', [BikeController::class, 'selectStore'])->name('sell.select.store');
    Route::get('/sell/{bike_id}/condition', [BikeController::class, 'condition'])->name('sell.condition');
    Route::post('/sell/{bike_id}/condition', [BikeController::class, 'conditionStore'])->name('sell.condition.store');
    Route::get('/sell/components/{bike_id}', [BikeController::class, 'components'])->name('sell.components');
    Route::post('/add_my_bike', [BikeController::class, 'add_my_bike'])->name('add_my_bike');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    Route::post('/compare', [ProfileController::class, 'compare'])->name('compare');
    Route::get('/compare', [BikeController::class, 'compaire'])->name('compaire.index');

    Route::group([
            'middleware' => ['auth']
        ], function () {

        Route::resource('/personal-information', ProfileController::class);
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        Route::get('/published-bicycles', [ProfileController::class, 'published_bicycles'])->name('published-bicycles');
        Route::get('/favorites', [ProfileController::class, 'favorites'])->name('favorites');

        Route::post('/compare/delete', [ProfileController::class, 'compare_delete'])->name('compare.delete');
        Route::get('/my-purchases', [ProfileController::class, 'my_purchases'])->name('my-purchases');
        Route::get('/change-password', [ProfileController::class, 'change_password'])->name('change-password');
        Route::post('/edit-bike', [ProfileController::class, 'edit_bike'])->name('edit-bike');

        Route::post('/pay/{id}', [\App\Http\Controllers\StripeController::class, 'pay'])->name('pay');
        Route::get('/pay/redirect/{session_id}', [\App\Http\Controllers\StripeController::class, 'redirect'])->name('pay.redirect');
        Route::get('/pay/result/{type}', [\App\Http\Controllers\StripeController::class, 'result'])->name('pay.result');
        Route::get('/pay/result/{type}', [\App\Http\Controllers\StripeController::class, 'result'])->name('pay.result');

        Route::get('/payout', [\App\Http\Controllers\PayoutController::class, 'index'])->name('payout.index');
        Route::post('/payout', [\App\Http\Controllers\PayoutController::class, 'payout'])->name('payout');
        Route::post('/account', [\App\Http\Controllers\AccountController::class, 'store'])->name('account.store');
        Route::post('/account/update', [\App\Http\Controllers\AccountController::class, 'update'])->name('account.update');
        Route::post('/account/file/{type}', [\App\Http\Controllers\AccountController::class, 'updateFile'])->name('account.file');


        Route::post('/comment', [ CommentController::class, 'comment'])->name('comment');
        Route::post('/reply-comment', [ CommentController::class, 'reply_comment'])->name('reply.comment');
        Route::post('/delete-parent-comment', [ CommentController::class, 'deleteParentComment'])->name('delete.parent_comment');
        Route::post('/delete-comment', [ CommentController::class, 'deleteComment'])->name('delete.comment');

        Route::get('/sell/images/{bike_id}', [BikeController::class, 'images'])->name('sell.images')->middleware('verified');
        Route::post('/sell/images/{bike_id}', [BikeController::class, 'imagesStore'])->name('sell.images.store');
        Route::get('/sell/information/{bike_id}', [BikeController::class, 'information'])->name('sell.information');
        Route::get('/sell/edit/information/{bike_id}', [BikeController::class, 'editInformation'])->name('sell.edit.information');
        Route::post('/sell/new-bike/{id}', [BikeController::class, 'new_bike'])->name('sell.new_bike');
        Route::post('/sell/edit-bike/{id}', [BikeController::class, 'edit_bike'])->name('sell.edit_bike');
        Route::get('/sell/address/{id}', [BikeController::class, 'address'])->name('sell.address');
        Route::post('/sell/address/{id}', [BikeController::class, 'addressStore'])->name('sell.address.store');

        Route::get('/cart', [ShippingController::class, 'cart'])->name('shipping.cart')->middleware('verified');

        Route::get('/shipping-address', [ShippingController::class, 'address'])->name('shipping.address');
        Route::post('/shipping-address', [ShippingController::class, 'shipping_address'])->name('shipping.shipping-address');

        Route::get('/cart/information', [ShippingController::class, 'cartPay'])->name('shipping.info');
        Route::post('/cart/information/{bike_id}', [ShippingController::class, 'storeOrder'])->name('shipping.info.store');

    });

    Route::delete('/publish-destroy/{id}', [ProfileController::class, 'publish_destroy'])->name('publish-destroy');
    Route::post('/eye-colaps', [ProfileController::class, 'eye_colaps'])->name('eye-colaps');
    Route::delete('/favorite-destroy/{id}', [ProfileController::class, 'favorites_destroy'])->name('favorite-destroy');
    Route::delete('/booking-destroy/{id}', [ProfileController::class, 'booking_destroy'])->name('booking-destroy');
    Route::post('/password-update', [ProfileController::class, 'password_update'])->name('password-update');
    Route::post('/profile-picture-update', [ProfileController::class, 'profile_picture_update'])->name('profile-picture-update');

    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/structured', [ShopController::class, 'structured'])->name('shop.structured');
    Route::get('/bike/{slug}', [ShopController::class, 'bike'])->name('shop.bike');
    Route::get('/get-buy/{id}', [ShopController::class, 'get_buy']);
    Route::post('/countery/{id}', [ShopController::class, 'countery_offer'])->name('countery-offer');
    Route::get('/countery', [ShopController::class, 'dicline_approve'])->name('dicline-approve');
    Route::post('/answer', [ShopController::class, 'shipping_answer'])->name('shop.answer');

    Route::delete('/notifications', [ProfileController::class, 'delete_notification'])->name('delete.notification');

    Route::get('/booking-action/{token}/{type}', [ShippingController::class, 'actions'])->name('booking.actions');
    Route::post('/booking-action/{id}', [ShippingController::class, 'actionsStore'])->name('booking.actions.store');
    Route::post('/booking-decline/{id}', [ShippingController::class, 'actionsDecline'])->name('booking.actions.decline');

    Auth::routes(['verify' => true]);
});

Route::post('/filtersave', [FilterController::class, 'save'])->name('filter.save');
Route::post('/filter/delete', [FilterController::class, 'delete'])->name('filter.delete');


Route::get('/get-sell-1/{id}', [BikeController::class, 'get_models'])->name('get_models');
Route::get('/get-sell-2/{year}', [BikeController::class, 'get_brands'])->name('get_brands');

Route::get('/login/{provider}', [LoginController::class, 'redirectToProvider'])->name('login.provider');
Route::get('/login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('login.callback');

Route::post('/favorite', [ShopController::class, 'favorite'])->name('toggleFavorite')->middleware('auth');

Route::get('/get-filters/{id}', [ShopController::class, 'getFilters'])->name('shop.getFilters');
Route::get('/filter', [ShopController::class, 'filter'])->name('shop.filter');

Route::get('/mobile/images/{token}', [BikeController::class, 'mobileImages'])->name('mobile.images');
Route::post('/mobile/images/{id}', [BikeController::class, 'mobileImagesUpload'])->name('mobile.images.upload');
Route::get('/mobile-images/{id}', [BikeController::class, 'mobileImagesGet'])->name('mobile.images.get');
Route::post('/mobile-images/destroy', [BikeController::class, 'mobileImagesDestroy'])->name('mobile.images.destroy');
