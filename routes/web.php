<?php
use App\Http\Controllers\AdminController;


// Trang chủ
Route::get('/', [ProductController::class,'products'])->name('home');

//admin
Route::get('/trang-chu/login',[AdminController::class, 'login'])->name('admin.login');
Route::post('/trang-chu/login',[AdminController::class, 'handleLogin'])->name('admin.handleLogin');
Route::middleware(['admin.check'])->group(function () {
    Route::prefix('trang-chu')->group(function () {
        Route::get('/',[AdminController::class,'index'])->name('admin.home');
    });
});


//admin
Route::get('/trang-chu/login',[AdminController::class, 'login'])->name('admin.login');
Route::post('/trang-chu/login',[AdminController::class, 'handleLogin'])->name('admin.handleLogin');
Route::middleware(['admin.check'])->group(function () {
    Route::prefix('trang-chu')->group(function () {
        Route::get('/',[AdminController::class,'index'])->name('admin.home');
        Route::get('/logout',[AdminController::class, 'logout'])->name('admin.logout');

        //quản lý sản phẩm
        Route::get('/product-management',[AdminController::class, 'productManagement'])->name('admin.product');
        Route::get('/product/create', [AdminController::class, 'createProduct'])->name('admin.product.create');
        Route::post('/product/store', [AdminController::class, 'storeProduct'])->name('admin.product.store');
        Route::get('/product/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.product.edit');
        Route::post('/product/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
        Route::get('/product/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
        Route::get('/product/toggle-status/{id}', [AdminController::class, 'toggleProductStatus'])->name('admin.product.toggle');
        //quản lý đợn hàng
        Route::get('/order-management',[AdminController::class, 'orderManagement'])->name('admin.order');

        //quản lý đơn hàng
        Route::get('/order-management/{trangThai?}',[AdminController::class, 'orderManagement'])->name('admin.order');
        Route::get('/order-management/detail/{idDonHang?}',[AdminController::class, 'detail'])->name('admin.detail');

        Route::post('/order-management',[AdminController::class, 'orderConfirm'])->name('admin.confirm');
        Route::put('/order-management',[AdminController::class, 'confirmStep2'])->name('admin.confirmStep2');
        Route::post('/order-management/cancel-order',[AdminController::class, 'huyDonByAdmin'])->name('admin.huyDonByAdmin');

        Route::post('/order-management/2',[AdminController::class, 'detailOrder'])->name('admin.detail-order');
        Route::put('/order-management/2',[AdminController::class, 'delivery'])->name('admin.confirm-delivery');

        Route::post('/order-management/3',[AdminController::class, 'confirmFinish'])->name('admin.finish-order');
    });
});