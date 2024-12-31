<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController, LoginController, DesignController, ProductController,
    CategoryController, RegisterController, AdminProductController,
    AdminCategoryController, AdminOptionController, AdminOptionValueController, AppController, CartController, ChatController, CheckoutController, CommentController, DashboardDesignController,
    PaymentController,
    PromotionController,
    ReplyController,
    SubscriptionController,
    TransactionController
};
use App\Http\Middleware\LocalizationMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// Route::middleware([LocalizationMiddleware::class])->group(function () {

// ROUTE BUAT HOME DAN ABOUT PAGE

// Route::get('/test-env', function () {
//     dd(env('PUSHER_APP_KEY'), env('PUSHER_APP_CLUSTER'));
// });

Route::get('/', [AppController::class, 'home'])->name('home');
Route::get('/about', [AppController::class, 'about'])->name('about');

// ROUTE BUAT LOCALIZATION

// Route::get('/change-language/{lang}', function ($lang) {
//     if (in_array($lang, ['en', 'id'])) {
//         Session::put('locale', $lang);
//         App::setLocale($lang);
//     }
//     return redirect()->back();
// })->name('changeLanguage');

Route::get('/change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'id'])) {
        return redirect()->back()->withCookie(cookie()->forever('locale', $lang))->with('status', 'Language changed');
    }
    return redirect()->back();
})->name('changeLanguage');

// ROUTE BUAT RESOURCE

Route::resources([
    'designs' => DesignController::class,
    'categories' => CategoryController::class,
    'products' => ProductController::class
]);

// ROUTE BUAT TAMBAHAN VIEW DESIGNS

// Filter design feature
Route::get('/filtered-designs', [DesignController::class, 'filter'])->name('designs.filter');

Route::prefix('designs')->as('designs.')->group(function() {
    // Show Designs by Product
    Route::get('/product/{product:slug}', [DesignController::class, 'showDesignProduct'])->name('product');

    // Show Designs by Category
    Route::get('/category/{category:slug}', [DesignController::class, 'showDesignCategory'])->name('category');

    // Show Seller Designs
    Route::get('/seller/{seller:username}', [DesignController::class, 'showSeller'])->name('seller')->middleware('auth');
});

Route::get('design/categories/{productSlug}', [DesignController::class, 'getCategoriesByProduct'])->name('designFilter.getCategoriesByProduct');

// ROUTE BUAT GUEST USER

Route::middleware('guest')->group(function () {
    // Login Page
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    // Authentication
    Route::post('/login', [LoginController::class, 'authenticate']);
    // Register Page
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    // Store New User
    Route::post('/register', [RegisterController::class, 'store']);
});
// Logout
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');

// ROUTE BUAT PROFILE PAGE

Route::middleware('auth')->prefix('users')->as('users.')->group(function() {
    // Manage Profile Page
    Route::resource('/', UserController::class)->parameters(['' => 'user']);
});

// ROUTE FOR SUBSCRIPTIONS

Route::middleware('auth')->prefix('subscriptions')->as('subscriptions.')->group(function() {
    // User subscription packages page
    Route::get('/pricing', [SubscriptionController::class, 'pricing'])->name('pricing');

    // Checkout Page
    Route::get('/checkout/{plan:slug}', [SubscriptionController::class, 'checkout'])->name('checkout');
    
    // Payment Snap Page
    Route::get('/snap/{subscription:id}', [SubscriptionController::class, 'payment'])->name('snap');

    Route::get('/cancel/{subscription:id}', [SubscriptionController::class, 'cancelPayment'])->name('cancel');

    // Payment Success Page
    Route::get('/payment/success/{subscription:id}', [SubscriptionController::class, 'success'])->name('success');

    Route::resource('/', SubscriptionController::class)->parameters(['' => 'subscriptions']);
});

// ROUTE FOR PROMOTIONS

Route::prefix('promotions')->as('promotions.')->group(function() {
    // Show Design Selection Based on Promotion
    Route::get('/designs/{promotion:id}', [PromotionController::class, 'showDesignSelection'])->name('designs');

    Route::resource('/', PromotionController::class)->parameters(['' => 'promotions']);
});

// ROUTE FOR COMMUNICATION

Route::middleware('auth')->prefix('chats')->as('chats.')->group(function () {
    //  Single chat page
    Route::get('/{chatId}/messages', [ChatController::class, 'fetchMessages']);
    // Resource for chat
    Route::resource('/', ChatController::class)->parameters(['' => 'chats']);
});

Route::middleware('auth')->group(function () {
    // Comments
    Route::resource('/comments', CommentController::class);
    // Replies
    Route::resource('/replies', ReplyController::class);
    // Send Feedback
    Route::post('/sendFeedback', [DesignController::class, 'sendFeedback'])->name('sendFeedback');
});

// ROUTE FOR CART

Route::middleware('auth')->prefix('carts')->as('carts.')->group(function () {
    // Resource for cart
    Route::resource('/', CartController::class)->parameters(['' => 'cart'])->except(['create', 'edit']);

    // Store design to cart
    Route::post('store/{design:slug}', [CartController::class, 'store'])->name('store');

    // Update cart item checkbox
    Route::post('update-is-checked', [CartController::class, 'updateIsChecked'])->name('updateIsChecked');

    // Update cart item quantity
    Route::post('update-quantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
});

// ROUTE FOR CHECKOUT

Route::middleware('auth')->prefix('checkouts')->as('checkouts.')->group(function () {
    // Checkout from cart
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

    // Checkout from design detail page
    Route::post('/checkout-from-design', [CheckoutController::class, 'checkoutFromDesign'])->name('checkoutFromDesign');

    // Checkout from promotion
    Route::post('/checkout-from-promo', [CheckoutController::class, 'checkoutFromPromotion'])->name('checkoutFromPromo');
});

// ROUTE FOR PAYMENT

Route::middleware('auth')->prefix('payments')->as('payments.')->group(function () {
    // Payment Summary Page
    Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');

    //Payment Promo Summary Page
    Route::post('/payment-promo', [PaymentController::class, 'paymentPromo'])->name('paymentPromo');

    // Payment Snap Page
    Route::get('/snap/{transaction:order_number}', [PaymentController::class, 'processPayment'])->middleware('CheckPayment')->name('snap');

    // Payment Success Page
    Route::get('/payment/success/{transaction:order_number}', [PaymentController::class, 'handlePaymentSuccess'])->name('payment-success');
});

// ROUTE FOR TRANSACTION

Route::middleware('auth')->prefix('transactions')->as('transactions.')->group(function () {
    // Route for order request
    Route::get('/orderRequest', [TransactionController::class, 'orderRequest'])->name('orderRequest');

    // Route for update transaction status
    Route::post('/updateStatus/{transaction:order_number}', [TransactionController::class, 'updateStatus'])->name('updateStatus');

    // Route for cancel payment
    Route::get('/cancel/{transaction:order_number}', [TransactionController::class, 'cancelPayment'])->name('cancel');

    // Resource Route
    Route::resource('/', TransactionController::class)->parameters(['' => 'transaction']);
});

// ROUTE FOR ADMIN

Route::middleware('auth', 'IsAdmin')->prefix('dashboard')->as('admin.')->group(function () {
    // Dashboard Page
    Route::get('/', fn() => view('dashboard.index'))->name('dashboard');

    // Manage Designs
    Route::resource('designs', DashboardDesignController::class);
    Route::get('design/checkSlug', [DashboardDesignController::class, 'checkSlug']);
    Route::get('design/categories/{productId}', [DashboardDesignController::class, 'getCategoriesByProduct'])->name('designs.getCategoriesByProduct');

    // Manage Products
    Route::get('products/checkSlug', [AdminProductController::class, 'checkSlug']);
    Route::resource('products', AdminProductController::class)->except('show');

    // Manage Categories
    Route::get('categories/checkSlug', [AdminCategoryController::class, 'checkSlug']);
    Route::resource('categories', AdminCategoryController::class)->except('show');

    // Manage Options
    Route::get('options/checkSlug', [AdminOptionController::class, 'checkSlug']);
    Route::resource('options', AdminOptionController::class);

    // Manage Option Values
    Route::get('option-values/checkSlug', [AdminOptionValueController::class, 'checkSlug']);
    Route::resource('option-values', AdminOptionValueController::class);

    // Manage Subscription Plan
    // Manage Promotion
});

// });