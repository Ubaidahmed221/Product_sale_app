<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\SubscriberController;

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

Route::get('/',[MainController::class,'index'])->name('index');

Route::group(['middleware' => ['IsAuthenticated']], function(){

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
    Route::get('/dashboard',function(){
        return 'User Dashboard';
    })->name('user.dashboard');

});

Route::group(['middleware' => ['OnlyAuthenticated','OnlyAdmin']], function(){
    Route::get('/admin/dashboard',[AppController::class,'index'] )->name('admin.dashboard');
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
 

});
Route::post('/subscribe',[SubscriberController::class,'store'] )->name('subscribe');

