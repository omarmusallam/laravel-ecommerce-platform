<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthentcationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ImagesController;
use App\Http\Controllers\Front\ListProductsController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\UserProfileController;
use App\Http\Controllers\SendSms;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StripeWebhooksController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
], function () {

    Route::get('user-profile', [UserProfileController::class, 'edit'])->name('user-profile.edit');
    Route::patch('user-profile', [UserProfileController::class, 'update'])->name('user-profile.update');

    Route::get('user/register', [UserProfileController::class, 'create'])->name('user.register');
    Route::post('user/register', [UserProfileController::class, 'store'])->name('user.register');

    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/products', [ProductsController::class, 'index'])
        ->name('products.index');

    Route::get('/products/{product:slug}', [ProductsController::class, 'show'])
        ->name('products.show');

    Route::resource('cart', CartController::class);

    Route::get('checkout', [CheckoutController::class, 'create'])
        ->name('checkout')->middleware('auth');

    Route::post('checkout', [CheckoutController::class, 'store']);

    Route::get('auth/user/2fa', [TwoFactorAuthentcationController::class, 'index'])
        ->name('front.2fa');

    Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');

    Route::get('about-us', function () {
        return view('front.about');
    })->name('about-us');

    Route::get('contact-us', [ContactController::class, 'index'])->name('contact-us');
    Route::post('contact-us', [ContactController::class, 'sendEmail'])->name('contact.send');

    Route::get('faq', function () {
        return view('front.faq');
    })->name('faq');

    Route::resource('list-products', ListProductsController::class);
});

// Login with facebook and google
Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.socialite.callback');
Route::get('verify-email', EmailVerificationPromptController::class)
    ->middleware('auth')
    ->name('verification.notice.compat');
Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth');
Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

// Payment
Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
    ->middleware('auth')
    ->name('orders.payments.create');
Route::post('orders/{order}/stripe/payment-intent', [PaymentsController::class, 'createStripePaymentIntent'])
    ->middleware('auth')
    ->name('stripe.paymentIntent.create');
Route::post('orders/{order}/stripe/paymeny-intent', [PaymentsController::class, 'createStripePaymentIntent'])
    ->middleware('auth');
Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
    ->middleware('auth')
    ->name('stripe.return');
// Stripe webhook
Route::any('stripe/webhook', [StripeWebhooksController::class, 'handle']);

// Test delivery 
Route::get('/orders/{order}', [OrdersController::class, 'show'])
    ->name('orders.show');

// sms messages
Route::get('send-sms', [SendSms::class, 'send']);

// Working with images
Route::get('images/{disk}/{width}x{height}/{image}', [ImagesController::class, 'index'])
    ->name('image')
    ->where('image', '.*');

require __DIR__ . '/dashboard.php';

// copy storage folder to public folder
Route::get('/storage/{file}', function ($file) {
    $filepath = storage_path('app/public/' . $file);
    if (!is_file($filepath)) {
        abort(404);
    }
    return response()->file($filepath);
})->where('file', '.*');
