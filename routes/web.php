<?php
use App\Http\Controllers\AdminController;


// Trang chủ
Route::get('/', [ProductController::class,'products'])->name('home');
// Authentication routes
Route::get('/login', function () {
    // Nếu đã đăng nhập thì redirect về trang chủ
    if (session('user_id')) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login');

Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/logout', [GoogleAuthController::class, 'logout'])->name('logout');

//admin
Route::get('/trang-chu/login',[AdminController::class, 'login'])->name('admin.login');
Route::post('/trang-chu/login',[AdminController::class, 'handleLogin'])->name('admin.handleLogin');
Route::middleware(['admin.check'])->group(function () {
    Route::prefix('trang-chu')->group(function () {
        Route::get('/',[AdminController::class,'index'])->name('admin.home');
    });
});
