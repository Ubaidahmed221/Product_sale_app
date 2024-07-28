<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('/admin/dashboard',function(){
        return 'Admin Dashboard';
    })->name('admin.dashboard');

});
