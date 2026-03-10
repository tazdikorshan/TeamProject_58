<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PastOrderController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});


Route::get('/Feedback', [FeedbackController::class, 'show'])->name('Feedback');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('product.review');
Route::get('/Basket', [BasketController::class, 'listProducts'])->name('Basket');
Route::post('updateQuantity/{bid}', [BasketController::class, 'updateQuantity'])->name('updateQuantity.updateQuantity');
Route::post('addProduct/{pid}', [BasketController::class, 'addProduct'])->name('addProduct.addProduct');
Route::post('removeProduct/{bid}', [BasketController::class, 'removeProduct'])->name('removeProduct.removeProduct');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{id}', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/{id}', [CheckoutController::class, 'submitDetails'])->name('checkout.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register-submit');
Route::get('/pastOrders', [PastOrderController::class, 'index'])->name('pastOrders.index');



Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/force-password-change', [AuthController::class, 'showForcePasswordChange'])
    ->middleware('auth');

Route::post('/force-password-change', [AuthController::class, 'forcePasswordChange'])
    ->middleware('auth');

Route::get('/admin/create', [AuthController::class, 'showCreateAdmin'])
    ->middleware(['auth']);

Route::post('/admin/create', [AuthController::class, 'createAdmin'])
    ->middleware(['auth']);

Route::get('/admin/change-password', [AuthController::class, 'showAdminChangePassword'])
    ->middleware(['auth'])
    ->name('admin.change-password');

Route::post('/admin/change-password', [AuthController::class, 'adminChangePassword'])
    ->middleware(['auth'])
    ->name('admin.change-password.post');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');

Route::post('/admin/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');

Route::post('/admin/products/{id}/update', [AdminProductController::class, 'update'])->name('admin.products.update');

Route::post('/admin/products/{id}/delete', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');

Route::post('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');

Route::post('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

Route::get('/customer/change-password', [AuthController::class, 'showCustomerChangePassword'])
    ->middleware(['auth'])
    ->name('customer.change-password');

Route::post('/customer/change-password', [AuthController::class, 'customerChangePassword'])
    ->middleware(['auth'])
    ->name('customer.change-password.post');


Route::get('/About-Us', function () {
    return view('About-Us');
})->name('About-Us');

Route::get('/Contact-us', function () {
    return view('Contact-us');
})->name('Contact-us');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/FAQs', function () {
    return view('FAQs');
})->name('FAQs');

Route::get('/Delivery-information', function () {
    return view('Delivery-information');
})->name('Delivery-information');

Route::get('/Shipping-options', function () {
    return view('Shipping-options');
})->name('Shipping-options');

Route::get('/Track-order', function () {
    return view('Track-order');
})->name('Track-order');
Route::post('/submit-review', [FeedbackController::class, 'store']);
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/filter', [FilterController::class, 'filter'])->name('filter');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/customers', [AdminController::class, 'customersIndex']);
    Route::post('/admin/customers', [AdminController::class, 'customersStore']);
    Route::post('/admin/customers/{id}/update', [AdminController::class, 'customersUpdate']);
    Route::post('/admin/customers/{id}/delete', [AdminController::class, 'customersDelete']);
});
