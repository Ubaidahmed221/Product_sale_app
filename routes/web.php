<?php

use App\Http\Controllers\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentGatewayCOntroller;
use App\Http\Controllers\Admin\PriceFilterController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderCOntroller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController as websiteProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/test-mail', function () {
    try {
        // 👇 yahan apna receiving email address likho
        $toEmail = 'uneebahmed397@gmail.com';

        // 👇 Simple test message
        Mail::raw('This is a test email from Laravel SMTP setup.', function ($message) use ($toEmail) {
            $message->to($toEmail)
                    ->subject('✅ Laravel Email Test');
        });

        return "<h3 style='color:green;'>✅ Test email sent successfully to <b>{$toEmail}</b></h3>";
    } catch (\Exception $e) {
        return "<h3 style='color:red;'>❌ Failed to send email:</h3><pre>{$e->getMessage()}</pre>";
    }
});
Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');

    return "<h3 style='color:green;'>✅ Cache cleared and config re-cached successfully test test!</h3>";
});
Route::get('/',[MainController::class,'index'])->name('index');

Route::group(['middleware' => ['web','IsAuthenticated']], function(){

Route::get('/register',[AuthController::class,'registerView'])->name('registerView');
Route::post('/register/create',[AuthController::class,'register'])->name('register');

Route::get('/verify/{token}',[VerificationController::class,'verify'])->name('verify');

Route::get('/login',[AuthController::class,'loginView'])->name('loginView');
Route::post('/login',[AuthController::class,'login'])->name('login');

Route::get('/forget-Passsword',[AuthController::class,'forgetpasswordView'])->name('forgetpasswordView');
Route::post('/forget-Passsword',[AuthController::class,'forgetPasssword'])->name('forgetPasssword');

Route::get('/reset-password/{token}',[AuthController::class,'resetpasswordView'])->name('resetpasswordView');
Route::post('/reset-Passsword',[AuthController::class,'resetPasssword'])->name('resetPasssword');
Route::get('/Passsword-updated',[AuthController::class,'PassswordUpdated'])->name('PassswordUpdated');

Route::get('/mail-verification',[AuthController::class,'mailverificationView'])->name('mailverificationView');
Route::post('/mail-verification',[AuthController::class,'mailVerification'])->name('mailVerification');
});

Route::group(['middleware' => ['OnlyAuthenticated']], function(){
    Route::get('/dashboard',[UserController::class,'account'])->name('user.dashboard');
    Route::get('/dashboard/orders',[UserController::class,'orders'])->name('user.orders');
    Route::get('/dashboard/orders/{id}',[UserController::class,'orderInformation'])->name('user.orders.information');
    Route::get('/dashboard/orders/{order}/invoice',[UserController::class,'downloadInvoice'])->name('user.orders.invoice');
    Route::get('/dashboard/address',[UserController::class,'address'])->name('user.address');
    Route::post('/dashboard/address',[UserController::class,'Updateaddress'])->name('user.update.address');
    Route::get('/dashboard/change-password',[UserController::class,'changePassword'])->name('user.change-password');
    Route::put('/dashboard/change-password',[UserController::class,'updatePassword'])->name('user.update.password');
    Route::post('/dashboard/update',[UserController::class,'accountUpdate'])->name('user.account.update');

    // chat support route
    Route::get('/dashboard/chat-support',[ChatController::class,'index'])->name('user.chat.support');
    Route::post('/dashboard/chat/send',[ChatController::class,'sendMessage'])->name('user.chat.send');
    Route::get('/dashboard/chat/messages/{userId}',[ChatController::class,'fetchMessages'])->name('user.chat.messages');
    Route::post('/dashboard/chat/mark-read/{userId}',[ChatController::class,'markAsRead'])->name('user.messages.read');

    Route::post('/review',[ReviewController::class,'store'] )->name('review.store');
    Route::post('/logout',[AuthController::class,'logout'] )->name('logout');

    Route::post('/cart/store',[CartController::class,'store'] )->name('cart.store');
    Route::get('/cart',[CartController::class,'index'] )->name('cart');
    Route::delete('/cart',[CartController::class,'destory'] )->name('cart.destory');
    Route::put('/cart',[CartController::class,'update'] )->name('cart.update');
    Route::put('/currency-update',[AuthController::class,'CurrencyUpdate'] )->name('user.currency.update');
    Route::post('/apply-coupon',[CartController::class,'applyCoupon'] )->name('cart.apply.coupon');
    Route::delete('/apply-coupon',[CartController::class,'removeCoupon'] )->name('cart.remove.coupon');

    Route::get('/checkout',[CheckoutController::class,'index'] )->name('checkout');
    Route::post('/place-order',[OrderCOntroller::class,'store'] )->name('place.order');

    // payment method route
    Route::get('/payment/success/{order}',[PaymentController::class,'success'] )->name('payment.success');
    Route::get('/payment/cancel/{order}',[PaymentController::class,'cancel'] )->name('payment.cancel');
    
    Route::get('/payment/thank-you/{id}',[PaymentController::class,'thankYou'] )->name('thank-you');
    // wishlist rout
    Route::post('/wishlist/toggle',[WishlistController::class,'toggle'] )->name('wishlist.toggle');
    Route::get('/wishlist',[WishlistController::class,'index'] )->name('wishlist');
    Route::delete('/wishlist/remove',[WishlistController::class,'destory'] )->name('wishlist.destory');

    Route::post('/save-fcm_token',[NotificationController::class,'saveFcmToken'] )->name('save.token');

    // affiliate route
    Route::get('/affliate',[AffiliateController::class,'index'] )->name('user.affiliate');
});

Route::group(['middleware' => ['OnlyAuthenticated','OnlyAdmin']], function(){

    Route::get('/admin',function(){
        return redirect()->route('admin.dashboard');
    });

    Route::get('/admin/dashboard',[DashboardController::class,'index'] )->name('admin.dashboard');
    Route::get('/admin/site-setting',[AppController::class,'index'] )->name('admin.site-setting');
    Route::post('update-app-data',[AppController::class,'UpdateAppData'] )->name('UpdateAppData');

    // menu Route
    Route::get('/admin/menus',[MenuController::class,'index'] )->name('admin.menus');
    Route::post('/admin-menu-create',[MenuController::class,'store'] )->name('admin.menus.store');
    Route::delete('/admin-menu-destory',[MenuController::class,'destory'] )->name('admin.menus.destory');
    Route::put('/admin-menu-update',[MenuController::class,'update'] )->name('admin.menus.update');

    // category route
    Route::get('/admin/categories',[CategoryController::class,'index'] )->name('admin.categories');
    Route::post('/admin-category-create',[CategoryController::class,'store'] )->name('admin.category.store');
    Route::delete('/admin-category-destory',[CategoryController::class,'destory'] )->name('admin.category.destory');
    Route::post('/admin-Category-update',[CategoryController::class,'update'] )->name('admin.category.update');


    // Banners
    Route::get('/admin/banners',[BannerController::class,'index'] )->name('admin.banners');
    Route::post('/admin-banner-create',[BannerController::class,'store'] )->name('admin.banner.store');
    Route::delete('/admin-banner-destory',[BannerController::class,'destory'] )->name('admin.banner.destory');
    Route::post('/admin-banner-update',[BannerController::class,'update'] )->name('admin.banner.update');

    // variation & variation Value
    Route::get('/admin/variation',[VariationController::class,'index'] )->name('admin.variation');
    Route::post('/admin-variation-create',[VariationController::class,'store'] )->name('admin.variation.store');
    Route::post('/admin-variation-value-create',[VariationController::class,'variationValuestore'] )->name('admin.variation.value.store');
    Route::put('/admin-variation-update',[VariationController::class,'update'] )->name('admin.variation.update');
    Route::delete('/admin-variation-destory',[VariationController::class,'destory'] )->name('admin.variation.destory');
    Route::delete('/admin-variation-value-destory',[VariationController::class,'variationValuedestory'] )->name('admin.variation.value.destory');

    // Products
    Route::get('/admin/products',[ProductController::class,'index'] )->name('admin.products');
    Route::post('/admin-products-store',[ProductController::class,'store'] )->name('admin.products.store');
    Route::get('/admin-product-image',[ProductController::class,'productImages'] )->name('admin.products.productImages');
    Route::delete('/admin-product-image-remove',[ProductController::class,'productImagesRemove'] )->name('admin.products.productImagesRemove');
    Route::delete('/admin-product-destory',[ProductController::class,'destory'] )->name('admin.product.destory');
    Route::get('/admin-product-info',[ProductController::class,'productInfo'] )->name('admin.product.Info');
    Route::post('/admin-product-update',[ProductController::class,'update'] )->name('admin.product.update');
    Route::delete('/admin-product-variation-destory',[ProductController::class,'variationdestory'] )->name('admin.product.variation.destory');

     // Offer
     Route::get('/admin/offers',[OfferController::class,'index'] )->name('admin.offers');
     Route::post('/admin-offer-create',[OfferController::class,'store'] )->name('admin.offer.store');
     Route::post('/admin-offer-update',[OfferController::class,'update'] )->name('admin.offer.update');
     Route::delete('/admin-offer-destory',[OfferController::class,'destory'] )->name('admin.offer.destory');

      // shipping 
      Route::get('/admin/shipping',[ShippingController::class,'index'] )->name('admin.shipping');
      Route::post('/shipping',[ShippingController::class,'store'] )->name('admin.shipping.store');
      Route::put('/shipping',[ShippingController::class,'update'] )->name('admin.shipping.update');
      Route::delete('/shipping',[ShippingController::class,'destory'] )->name('admin.shipping.destory');
     
      // Coupon
      Route::get('/admin/coupon',[CouponController::class,'index'] )->name('admin.coupon');
      Route::post('/coupon',[CouponController::class,'store'] )->name('admin.coupon.store');
      Route::put('/coupon',[CouponController::class,'update'] )->name('admin.coupon.update');
      Route::delete('/coupon',[CouponController::class,'destroy'] )->name('admin.coupon.destroy');
    
    // Price Filter
    Route::get('/admin/price-filter',[PriceFilterController::class,'index'] )->name('admin.price.filter');
    Route::post('/price-filter',[PriceFilterController::class,'store'] )->name('admin.price.filter.store');
    Route::put('/price-filter',[PriceFilterController::class,'update'] )->name('admin.price.filter.update');
    Route::delete('/price-filter',[PriceFilterController::class,'destroy'] )->name('admin.price.filter.destroy');

     // Payment Gateway Route
     Route::get('/admin/payment-gateway',[PaymentGatewayCOntroller::class,'index'] )->name('admin.gateway');
     Route::post('/payment-gateway',[PaymentGatewayCOntroller::class,'store'] )->name('admin.gateway.store');
     Route::put('/payment-gateway',[PaymentGatewayCOntroller::class,'update'] )->name('admin.gateway.update');
     Route::delete('/payment-gateway',[PaymentGatewayCOntroller::class,'destroy'] )->name('admin.gateway.destroy');
 
     Route::get('/admin/orders',[AdminOrderController::class,'index'] )->name('admin.orders.index');
     Route::get('/admin/orders/{order}',[AdminOrderController::class,'show'] )->name('admin.orders.show');
     Route::get('/admin/orders/{order}/invoice',[AdminOrderController::class,'downloadInvoice'] )->name('admin.orders.invoice');
     Route::put('/admin/orders/{order}/status',[AdminOrderController::class,'updateStatus'] )->name('admin.orders.update.status');

     // users 
     Route::get('/admin/users',[AdminUserController::class,'index'] )->name('admin.users.index');
     Route::post('/admin/users/{user}/toggle-block',[AdminUserController::class,'toggleBlock'] )->name('admin.users.toggle-block');
     Route::delete('/admin/users/{user}',[AdminUserController::class,'destroy'] )->name('admin.users.destroy');
     Route::get('/admin/users/{user}/orders',[AdminUserController::class,'orders'] )->name('admin.users.orders');

    //  Contact
     Route::get('/admin/contact',[AdminContactController::class,'index'])->name('admin.contact.index');
     Route::get('/admin/contact/{contact}',[AdminContactController::class,'show'])->name('admin.contact.show');
     Route::put('/admin/contact/{contact}',[AdminContactController::class,'update'])->name('admin.contact.update');
     Route::delete('/admin/contact/{contact}',[AdminContactController::class,'destroy'])->name('admin.contact.distroy');

    //  Chat Route
    Route::get('/admin/chat',[AdminChatController::class,'index'])->name('admin.chat');
    Route::get('/admin/chat/users',[AdminChatController::class,'userwithMessages'])->name('admin.chat.users');
    Route::get('/admin/chat/messages/{userid}',[ChatController::class,'fetchMessages'])->name('admin.chat.message');
    Route::post('/admin/chat/send',[ChatController::class,'sendMessage'])->name('admin.chat.send.message');
  
    // setting
    Route::get('/admin/setting',[SettingController::class,'index'])->name('admin.setting');
    Route::put('/admin/setting/affiliate',[SettingController::class,'affiliateUpdate'])->name('admin.setting.affiliate.update');

    // affiliate 
    Route::get('/admin/affiliate/commission',[AdminAffiliateController::class,'index'])->name('admin.affiliate.commission');
    Route::get('/admin/affiliate-user/{id}',[AdminAffiliateController::class,'commissions'])->name('admin.affiliate.users');



});
Route::post('/subscribe',[SubscriberController::class,'store'] )->name('subscribe');
Route::get('/unsubscribe/{token}',[SubscriberController::class,'unsubscribe'] )->name('unsubscribe');
Route::get('/detail/{string}',[websiteProductController::class,'detail'] )->name('product.detail');
Route::post('/states',[Controller::class,'states'] )->name('states');
Route::get('/shop',[ShopController::class,'index'])->name('shop');
Route::get('/shop/filter',[ShopController::class,'filterProduct'])->name('shop.filter');
Route::get('/contact',[ContactController::class,'index'])->name('contact');
Route::post('/contact',[ContactController::class,'store'])->name('contact.submit');

