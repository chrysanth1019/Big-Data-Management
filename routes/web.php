<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SimpleSearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

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

// Welcome page
Route::get('/', function () {
    return view('dashboard');
})->name('welcome');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/proxy-detected', function () {
    $ip = session('ip_address');
    $user_agent = session('user_agent');
    return view('proxy', [
        'ip' => $ip,
        'user_agent' => $user_agent
    ]);
})->name('proxy');


Route::get('/restricted-ip', function () {
    $ip = session('ip_address');
    return view('restricted', [
        'ip' => $ip,
    ]);
})->name('restricted');

Route::middleware([\App\http\Middleware\CheckProxy::class])->group(function () {
    // Authentication routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Protected routes (require authentication)
Route::middleware(['auth', \App\http\Middleware\CheckIP::class])->group(function () {
    // Search functionality
    Route::get('/search_', [SearchController::class, 'index'])->name('search.index');
    Route::get('/advanced_search', [SearchController::class, 'advanced_search'])->name('advanced_search');
    Route::get('/search/results', [SearchController::class, 'search'])->name('search.results');
    Route::get('/search', [SimpleSearchController::class, 'index'])->name('simple-search.index');    
});
Route::get('/my-ip', [SimpleSearchController::class, 'myip'])->name('myip');

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Admin routes
Route::middleware(['auth', \App\http\Middleware\AdminAuth::class, \App\http\Middleware\CheckIP::class])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User management
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/password', [UserController::class, 'editPassword'])->name('admin.users.edit-password');
    Route::patch('/users/{user}/password', [UserController::class, 'updatePassword'])->name('admin.users.update-password');    
    Route::patch('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('admin.users.toggle-block');
    Route::patch('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/users/{user}/allowed-ips', [UserController::class, 'editAllowedIps'])->name('admin.users.edit-allowed-ips');
    Route::patch('/users/{user}/allowed-ips', [UserController::class, 'updateAllowedIps'])->name('admin.users.update-allowed-ips');
    
    // Activity logs
    Route::get('/activities', [AdminController::class, 'activities'])->name('admin.activities');
});