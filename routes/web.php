<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;

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
    Route::put('/admin-Category-update',[CategoryController::class,'update'] )->name('admin.category.update');


    // Banners
    Route::get('/admin/banners',[BannerController::class,'index'] )->name('admin.banners');
    Route::post('/admin-banner-create',[BannerController::class,'store'] )->name('admin.banner.store');



});
