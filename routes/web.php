<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/* ---------------- Vitrin ---------------- */
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/magaza', [ShopController::class, 'index'])->name('shop');
Route::get('/urun/{product}', [ShopController::class, 'show'])->name('product');

Route::get('/hizmetler', [PageController::class, 'services'])->name('services');
Route::get('/hizmet/{service}', [PageController::class, 'serviceShow'])->name('service.show');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{post}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/hakkimizda', [PageController::class, 'about'])->name('about');
Route::get('/iletisim', [PageController::class, 'contact'])->name('contact');
Route::post('/iletisim', [PageController::class, 'contactStore'])->name('contact.store');
Route::post('/randevu', [PageController::class, 'appointment'])->name('appointment');

/* ---------------- Yasal sayfalar ---------------- */
Route::get('/sayfa/{slug}', [LegalController::class, 'show'])->name('legal');

/* ---------------- Sitemap ---------------- */
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/* ---------------- Sepet ---------------- */
Route::get('/sepet', [CartController::class, 'index'])->name('cart');
Route::post('/sepet/ekle/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/sepet/guncelle', [CartController::class, 'update'])->name('cart.update');
Route::post('/sepet/sil/{id}', [CartController::class, 'remove'])->name('cart.remove');

/* ---------------- Checkout ---------------- */
Route::get('/odeme', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/odeme', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/odeme/sonuc/{order:order_no}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::match(['get', 'post'], '/odeme/callback/{order:order_no}', [CheckoutController::class, 'callback'])->name('checkout.callback');

/* ---------------- Üyelik ---------------- */
Route::middleware('guest')->group(function () {
    Route::get('/giris', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/giris', [AuthController::class, 'login']);
    Route::get('/kayit', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/kayit', [AuthController::class, 'register']);

    // Şifremi unuttum / sıfırlama
    Route::get('/sifremi-unuttum', [PasswordResetController::class, 'showRequest'])->name('password.request');
    Route::post('/sifremi-unuttum', [PasswordResetController::class, 'sendLink'])->name('password.email');
    Route::get('/sifre-sifirla/{token}', [PasswordResetController::class, 'showReset'])->name('password.reset');
    Route::post('/sifre-sifirla', [PasswordResetController::class, 'reset'])->name('password.update');
});
Route::post('/cikis', [AuthController::class, 'logout'])->name('logout');

/* ---------------- Hesabım ---------------- */
Route::middleware('auth')->prefix('hesabim')->name('account')->group(function () {
    Route::get('/', [AccountController::class, 'index']);
    Route::get('/siparislerim', [AccountController::class, 'orders'])->name('.orders');
    Route::get('/siparis/{order:order_no}', [AccountController::class, 'orderShow'])->name('.order');
    Route::post('/guncelle', [AccountController::class, 'update'])->name('.update');
});

/* ---------------- Admin ---------------- */
Route::middleware(['auth', 'admin'])->prefix('yonetim')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', Admin\ProductController::class)->except('show');
    Route::resource('categories', Admin\CategoryController::class)->except('show');

    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');

    Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/appointments', [Admin\AppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}', [Admin\AppointmentController::class, 'update'])->name('appointments.update');

    Route::get('/messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}', [Admin\ContactMessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
});
