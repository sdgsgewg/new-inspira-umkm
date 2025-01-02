<?php

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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// ROUTE BUAT HOME DAN ABOUT PAGE

Route::get('/', [AppController::class, 'home'])->name('home');
Route::get('/about', [AppController::class, 'about'])->name('about');

// ROUTE BUAT LOCALIZATION

// SESSION
// Route::get('/change-language/{lang}', function ($lang) {
//     if (in_array($lang, ['en', 'id'])) {
//         Session::put('locale', $lang);
//         App::setLocale($lang);
//     }
//     return redirect()->back();
// })->name('changeLanguage');

// COOKIE
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
    Route::get('/checkout/{plan:slug}', [SubscriptionController::class, 'checkout'])
    ->middleware('CheckRole:buyer')
    ->name('checkout');
    
    // Payment Snap Page
    Route::get('/payment/snap/{subscription:id}', [SubscriptionController::class, 'payment'])
    ->middleware(['CheckRole:buyer', 'CheckSubscriptionPayment'])
    ->name('snap');

    // Cancel Payment
    Route::get('/payment/cancel/{subscription:id}', [SubscriptionController::class, 'cancelPayment'])
    ->middleware('CheckRole:buyer')
    ->name('cancel');

    // Payment Success Page
    Route::get('/payment/success/{subscription:id}', [SubscriptionController::class, 'success'])
    ->middleware('CheckRole:buyer')
    ->name('payment-success');

    Route::resource('/', SubscriptionController::class)->parameters(['' => 'subscriptions']);
});

// ROUTE FOR PROMOTIONS

Route::prefix('promotions')->as('promotions.')->group(function() {
    // Show Design Selection Based on Promotion
    Route::get('/designs/{promotion:id}', [PromotionController::class, 'showDesignSelection'])
    ->middleware('CheckRole:buyer')
    ->name('designs');

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
    Route::post('/sendFeedback', [DesignController::class, 'sendFeedback'])
    ->middleware('CheckRole:buyer')
    ->name('sendFeedback');
});

// ROUTE FOR CART

Route::middleware(['auth', 'IsBuyer'])->prefix('carts')->as('carts.')->group(function () {
    // Resource for cart
    Route::resource('/', CartController::class)->parameters(['' => 'cart'])->except(['create', 'edit']);

    // Update cart item checkbox
    Route::post('update-is-checked', [CartController::class, 'updateIsChecked'])->name('updateIsChecked');

    // Update cart item quantity
    Route::post('update-quantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
});

// ROUTE FOR CHECKOUT

Route::middleware(['auth', 'IsBuyer'])->prefix('checkouts')->as('checkouts.')->group(function () {
    // Checkout from cart
    Route::get('/checkout', [CheckoutController::class, 'checkout'])
    ->middleware('CheckRole:buyer')
    ->name('checkout');

    // Checkout from design detail page
    Route::post('/checkout-from-design', [CheckoutController::class, 'checkoutFromDesign'])
    ->middleware('CheckRole:buyer')
    ->name('checkoutFromDesign');

    // Checkout from promotion
    Route::post('/checkout-from-promo', [CheckoutController::class, 'checkoutFromPromotion'])
    ->middleware('CheckRole:buyer')
    ->name('checkoutFromPromo');
});

// ROUTE FOR TRANSACTION

Route::middleware('auth')->prefix('transactions')->as('transactions.')->group(function () {
    // Route for order request
    Route::get('/orderRequest', [TransactionController::class, 'orderRequest'])->name('orderRequest');

    // Route for update transaction status
    Route::post('/updateStatus/{transaction:order_number}', [TransactionController::class, 'updateStatus'])
    ->middleware('CheckRole:buyer')
    ->name('updateStatus');

    // Payment Summary Page
    Route::post('/payment', [PaymentController::class, 'payment'])
    ->middleware('CheckRole:buyer')
    ->name('payment');

    //Payment Promo Summary Page
    Route::post('/payment-promo', [PaymentController::class, 'paymentPromo'])
    ->middleware('CheckRole:buyer')
    ->name('paymentPromo');

    // Payment Snap Page
    Route::get('/payment/snap/{transaction:order_number}', [PaymentController::class, 'processPayment'])
    ->middleware(['CheckTransactionPayment', 'CheckRole:buyer'])
    ->name('snap');

    // Payment Success Page
    Route::get('/payment/success/{transaction:order_number}', [PaymentController::class, 'handlePaymentSuccess'])
    ->middleware(['CheckTransactionPayment', 'CheckRole:buyer'])
    ->name('payment-success');

    // Cancel payment
    Route::get('/payment/cancel/{transaction:order_number}', [TransactionController::class, 'cancelPayment'])
    ->middleware(['CheckTransactionPayment', 'CheckRole:buyer'])
    ->name('payment-cancel');

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