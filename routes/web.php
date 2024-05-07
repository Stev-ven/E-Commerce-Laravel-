<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;

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

// Admin Authentication routes
Route::get('/admin.signup', function () {
    return view('adminAuth.adminSignup');
});

Route::post('/admin.signup', [AdminController::class, 'registerAdmin'])->name('admin.save');

Route::get('/admin.login', function () {
    return view('adminAuth.adminLogin');
})->name('admin.login');

Route::post('/admin.login', [AdminController::class, 'loginAdmin'])->name('admin.login');

Route::get('/admin.dashboard', function () {
    return view('adminHome.adminDashboard');
});
Route::group(['middleware' => ['admin']], function(){
    Route::get('/admin.dashboard', 'AdminController@adminHome.adminDashboard')->name('admin.dashboard');
}); 


Route::get('/admin.password.recovery', function(){
    return view('adminAuth.adminPassRecovery');
})->name('admin.password.recovery'); 

//user authentication routes
Route::get('/user.signup', function () {
    return view('userAuth.userSignup');
})->name('user.signup');

Route::post('/user.signup', [ClientController::class,  'registerClient'])->name('client.save');

Route::get('/user.login', function () {
    return view('userAuth.userLogin');
})->name('user.login');

Route::post('/user.login', [ClientController::class, 'loginClient'])->name('login.client');

Route::get('/user.home', function(){
    return view('userHome.userHome');
});


Route::get('/user.password.recovery', function(){
    return view('userAuth.userPassRecovery');
})->name('user.password.recovery'); 