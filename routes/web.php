<?php

use App\Models\User;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\AdminCategoryController;


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

// tinggal ganti aja return nya buat nampilin view berbeda
Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        "active" => "home"
    ]);
});

Route::get('/about', function () {
    return view('about', [
        // ini kirim data
        "active" => "about",
        "name" => "Abraham",
        "email" => "abraham@gmail.com",
        "image" => "abraham.jpg",
        "title" => "About"
    ]);
});


Route::get('/blog', [PostController::class, 'index']); // 'index' itu nama methodnya

// halaman single routes
Route::get('/post/{post:slug}', [PostController::class, 'show']); // 'show'
    // {post:slug} biar yang diambil slug, kalo post aja yg diambil idnya
    // wildcard untuk ambil post yg di url nya
    // /bebas itu url yang dikirim, ditangkep pake variabel bebas didalem function

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/users', function(){
    return view('users', [
        'title' => 'Users',
        'active' => 'users',
        'users' => User::all()
    ]);
});

// Login
// nanti kalau misalnya mau langsung akses dashboard, otomatis ke route dengan nama login karena di auth nya begitu defaultnya
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest'); // hanya bisa diakses oleh user yang belum terautentikasi, nama routes nya adalah login

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// Register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// dashboard
Route::get('/dashboard', function() {
    return view('dashboard.index');
})->middleware('auth');

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth'); // gabisa diakses, harus login dulu
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

// ->middleware('admin'), middleware ini udah update dari kernel.php, di kernel dinamain admin yang diambil dari middleware php artisan make:middleware IsAdmin
// gapake middleware juga gapapa karena udah pake gate, GATE JAUH LEBIH FLEKSIBEL
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin'); // pengecualian untuk categories.show nya
