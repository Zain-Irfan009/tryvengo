<?php

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

Route::get('/trackorder', [App\Http\Controllers\OrderController::class, 'TrackOrder']);

Route::group(['middleware' => ['verify.shopify']], function () {
    Route::get('/', [App\Http\Controllers\OrderController::class, 'allOrders'])->name('home');
    Route::get('sync-order', [App\Http\Controllers\OrderController::class, 'shopifyOrders'])->name('sync.orders');
    Route::get('send-order-delivery/{id}', [App\Http\Controllers\OrderController::class, 'SendOrderDelivery'])->name('send.order.delivery');
    Route::post('orders-filter', [App\Http\Controllers\OrderController::class, 'OrdersFilter'])->name('orders.filter');
    Route::post('push-selected-orders', [App\Http\Controllers\OrderController::class, 'PushSelectedOrders'])->name('push.selected.orders');


    Route::get('settings', [App\Http\Controllers\SettingController::class, 'Settings'])->name('settings');
    Route::post('save-settings', [App\Http\Controllers\SettingController::class, 'SettingsSave'])->name('settings.save');

});


Route::get('/testing1', function() {

    $shop = \Illuminate\Support\Facades\Auth::user();
    $shop=\App\Models\User::where('name','mubkhar-fragrances.myshopify.com')->first();
//$shop=\App\Models\User::where('name','prod-awake-water.myshopify.com')->first();
    $response = $shop->api()->rest('GET', '/admin/webhooks.json');

//    $response = $shop->api()->rest('delete', '/admin/api/webhooks/1418449715478.json');
    dd($response);
    $orders = $shop->api()->rest('POST', '/admin/webhooks.json', [

        "webhook" => array(
            "topic" => "orders/create",
            "format" => "json",
            "address" => env('APP_URL')."/webhook/order-create"
        )
    ]);
    dd($orders);
    dd($response);
})->name('getwebbhook');
