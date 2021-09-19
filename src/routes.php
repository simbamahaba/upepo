<?php
use Illuminate\Support\Facades\Route;
//  1. Customers - Front End
//use Decoweb\Panelpack\Controllers\CustomerAuth\LoginController;
//use Decoweb\Panelpack\Controllers\CustomerAuth\RegisterController;
//use Decoweb\Panelpack\Controllers\CustomerAuth\PostRegisterController;
//use Decoweb\Panelpack\Controllers\CustomerAuth\ResetPasswordController;
//use Decoweb\Panelpack\Controllers\CustomerAuth\ForgotPasswordController;
use Simbamahaba\Upepo\Controllers\CustomerAuth\FbauthController;
use Simbamahaba\Upepo\Controllers\CustomerController as FrontCustomerController;
//  2. Cart - Front End
use Simbamahaba\Upepo\Controllers\CartController;
//  3. Admin
//use Decoweb\Panelpack\Controllers\Auth\LoginController as AdminLoginController;
use Simbamahaba\Upepo\Controllers\Admin\Auth\AuthenticatedSessionController;
use Simbamahaba\Upepo\Controllers\Admin\HomeController as AdminHomeController;
use Simbamahaba\Upepo\Controllers\Admin\HelpController as AdminHelpController;

use Simbamahaba\Upepo\Controllers\Admin\TablesController;
use Simbamahaba\Upepo\Controllers\Admin\RecordsController;

use Simbamahaba\Upepo\Controllers\Admin\ImagesController;
use Simbamahaba\Upepo\Controllers\Admin\FilesController;

use Simbamahaba\Upepo\Controllers\Admin\CustomerController;
use Simbamahaba\Upepo\Controllers\Admin\OrdersController;
use Simbamahaba\Upepo\Controllers\Admin\StatusController;
use Simbamahaba\Upepo\Controllers\Admin\TransportController;
use Simbamahaba\Upepo\Controllers\Admin\InvoiceController;
use Simbamahaba\Upepo\Controllers\ProformaController;

use Simbamahaba\Upepo\Controllers\Admin\MapsController;
use Simbamahaba\Upepo\Controllers\Admin\SettingsController;
use Simbamahaba\Upepo\Controllers\Admin\SitemapController;

use UniSharp\LaravelFilemanager\Lfm;
/*
 * Starter Kit
 */
use Simbamahaba\Upepo\Models\Admin;
use Illuminate\Support\Facades\Hash;


Route::get('/start', function () {
    return view('upepo::start');
});
Route::post('/kit',function(){
    if( !empty($_POST['email']) && !empty($_POST['password']) ){
        $admin = new Admin();
        $admin->name = 'Andrei';
        $admin->email = $_POST['email'];
        $admin->password = Hash::make($_POST['password']);
        $admin->save();
        return redirect('/start');
    }
    return redirect('/start');
});

// 1. Customers Front End
//Route::get('customer/login/{cart?}',[LoginController::class, 'showLoginForm'])->name('customer.showLoginForm');
//Route::post('customer/login',[LoginController::class, 'login'])->name('customer.login');
//Route::get('customer/logout',[LoginController::class, 'logout'])->name('customer.logout');
Route::put('customer/profile/{customer}',[FrontCustomerController::class, 'update'])->name('customer.update');
Route::get('customer/profile',[FrontCustomerController::class,'profile'])->name('customer.profile');
Route::get('customer/myOrders',[FrontCustomerController::class,'myOrders'])->name('customer.myOrders');
Route::get('customer/newPassword',[FrontCustomerController::class,'newPassword'])->name('customer.newPassword');
Route::post('customer/updatePassword/{customer}',[FrontCustomerController::class, 'updatePassword'])->name('customer.updatePassword');

// Customers - Register, PasswordReset, PasswordForgotten
//Route::get('customer/confirmemail/{token}', [PostRegisterController::class, 'confirmEmail'])->name('customer.confirmEmail');
//Route::get('customer/register', [RegisterController::class,'showRegistrationForm'])->name('customer.showRegistrationForm');
//Route::post('customer/register', [RegisterController::class, 'register'])->name('customer.register');
//Route::get('customer/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('customer.showResetForm');
//Route::post('customer/password/reset', [ResetPasswordController::class, 'reset'])->name('customer.reset');
//Route::get('customer/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('customer.showLinkRequestForm');
//Route::post('customer/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer.sendResetLinkEmail');

// Customers - Facebook Auth
Route::get('auth/facebook', [FbauthController::class, 'redirectToProvider'])->name('fb.redirectToProvider');
Route::get('auth/facebook/callback', [FbauthController::class, 'handleProviderCallback'])->name('fb.handleProviderCallback');

// 2. Cart
Route::post('addCart',[CartController::class, 'addCart'])->name('addCart');
Route::get('cart',[CartController::class, 'index'])->name('cart.index');
Route::get('cart/destroy',[CartController::class, 'cartDestroy'])->name('cart.destroy');
Route::get('cart/deleteItem/{rowId}',[CartController::class, 'deleteItem'])->name('cart.deleteItem');
Route::get('cart/checkout2',[CartController::class, 'checkout2'])->name('cart.checkout2');
Route::get('cart/checkout3',[CartController::class, 'checkout3'])->name('cart.checkout3');
Route::get('cart/checkout4',[CartController::class, 'checkout4'])->name('cart.checkout4');
Route::post('cart/storeOrder/',[CartController::class, 'storeOrder'])->name('cart.storeOrder');
Route::post('cart/modalInfo',[CartController::class, 'modalInfo'])->name('cart.modalInfo');
Route::post('cart/update',[CartController::class, 'update'])->name('cart.update');

/***************************
 *
 * ADMIN ROUTES
 *
 ***************************/
Route::get('/admin/login/{cart?}', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['web','not.for.admin'])
    ->name('admin.showLoginForm');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['web','not.for.admin'])
    ->name('admin.login');

Route::post('admin/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['web','admin.only'])
    ->name('admin.logout');
//Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.showLoginForm');
//Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
//Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::get('admin/home', [AdminHomeController::class, 'index'])->name('admin.home');
Route::get('admin/home/account', [AdminHomeController::class, 'account'])->name('admin.account');
Route::put('admin/home/account/update/{user}',[AdminHomeController::class, 'updatePassword'])->name('admin.update.password');
Route::get('admin/help', AdminHelpController::class)->name('admin.help');
/**
 * TABLES
 */
Route::get('admin/table-settings',[TablesController::class, 'index'])->name('tables.index');
Route::get('admin/table-settings/create',[TablesController::class, 'create'])->name('tables.create');
Route::delete('admin/table-settings/{table}',[TablesController::class, 'destroy'])->name('tables.destroy');
Route::post('admin/table-settings/table',[TablesController::class, 'store'])->name('tables.store');
Route::post('admin/table-settings/tablesOrder',[TablesController::class, 'updateOrder'])->name('tables.order');
Route::get('admin/table-settings/{table}/edit',[TablesController::class, 'edit'])->name('tables.edit');
Route::put('admin/table-settings/{table}',[TablesController::class, 'update'])->name('tables.update');

/**
 * RECORDS
 */
Route::match(['get','post'],'admin/core/{tableName}/id/{id}',[RecordsController::class,'index'])->name('records.index');
Route::get('admin/core/{tableName}/create',[RecordsController::class,'create'])->name('record.create');
Route::post('admin/core/{tableName}/store',[RecordsController::class, 'store'])->name('record.store');
Route::get('admin/core/{tableName}/edit/{recordId}',[RecordsController::class, 'edit'])->name('record.edit');
Route::put('admin/core/{tableName}/update/{recordId}',[RecordsController::class, 'update'])->name('record.update');
Route::post('admin/core/{tableName}/updateOrder',[RecordsController::class,'updateOrder'])->name('records.update.order');
Route::post('admin/core/{tableName}/{id}/deleteMany',[RecordsController::class,'deleteMany'])->name('records.delete.many');
Route::get('admin/core/{tableName}/delete/{recordId}',[RecordsController::class, 'delete'])->name('record.delete');
Route::get('admin/core/{tableName}/resetFilters', [RecordsController::class, 'resetFilters'])->name('records.filters');
Route::post('admin/core/{tableName}/limit/perPage', [RecordsController::class, 'limit'])->name('records.limit');

/**
 * IMAGES
 */
Route::get('admin/core/{tabela}/addPic/{recordId}', [ImagesController::class, 'create'])->name('create.pic');
Route::post('admin/core/{tabela}/storePic/{id}', [ImagesController::class, 'store'])->name('store.pic');
Route::get('admin/core/deletePic/{idPic}', [ImagesController::class, 'delete'])->name('delete.pic');
Route::post('admin/core/updatePicsOrder/{tableId}/{recordId}',  [ImagesController::class, 'update'])->name('update.picsOrder');

/**
 * FILES
 */
Route::get('admin/core/{tabela}/addFile/{recordId}', [FilesController::class, 'create'])->name('create.file');
Route::post('admin/core/{tabela}/storeFile/{id}',[FilesController::class, 'store'])->name('store.file');
Route::get('admin/core/deleteFile/{file}',[FilesController::class, 'delete'])->name('delete.file');
Route::post('admin/core/updateFilesOrder/{tableId}/{recordId}',[FilesController::class, 'update'])->name('update.filesOrder');

/**
 * TRANSPORT
 */
Route::get('admin/shop/transport',[TransportController::class,'index'])->name('transport.index');
Route::get('admin/shop/transport/create',[TransportController::class, 'create'])->name('transport.create');
Route::post('admin/shop/transport',[TransportController::class,'store'])->name('transport.store');
Route::post('admin/shop/transport/updateOrder',[TransportController::class,'updateOrder'])->name('transport.update.order');
Route::get('admin/shop/transport/{id}/edit',[TransportController::class,'edit'])->name('transport.edit');
Route::put('admin/shop/transport/{id}',[TransportController::class,'update'])->name('transport.update');
Route::get('admin/shop/transport/{id}/delete',[TransportController::class,'destroy'])->name('transport.destroy');
/**
 * CUSTOMERS
 */
Route::get('admin/shop/customers',[CustomerController::class,'index'])->name('customer.index.backend');
Route::post('admin/shop/customers',[CustomerController::class, 'store'])->name('customer.store.backend');
Route::post('admin/shop/customers/updateLimit',[CustomerController::class,'updateLimit'])->name('customer.limit.backend');
Route::get('admin/shop/customers/create',[CustomerController::class, 'create'])->name('customer.create.backend');
Route::get('admin/shop/customers/{customer}/edit',[CustomerController::class,'edit'])->name('customer.edit.backend');
Route::put('admin/shop/customers/{customer}',[CustomerController::class, 'update'])->name('customer.update.backend');
Route::delete('admin/shop/customers/{customer}',[CustomerController::class,'destroy'])->name('customer.destroy.backend');
Route::post('admin/shop/customers/deleteMultiple',[CustomerController::class, 'deleteMultiple'])->name('customer.delete.multiple.backend');
/**
 * INVOICES
 */
Route::get('admin/shop/invoice',[InvoiceController::class,'index'])->name('invoice.index');
Route::get('cart/vizualizareProforma/{id}/{code}',[ProformaController::class, 'index'])->name('proforma');
Route::put('admin/shop/invoice/{id}',[InvoiceController::class,'update'])->name('invoice.update');
/**
 * STATUSES
 */
Route::get('admin/shop/statuses',[StatusController::class,'index'])->name('status.index');
Route::get('admin/shop/statuses/{id}/edit',[StatusController::class,'edit'])->name('status.edit');
Route::put('admin/shop/statuses/{id}',[StatusController::class,'update'])->name('status.order.update');
/**
 * ORDERS
 */
Route::resource('admin/shop/orders', OrdersController::class)->except(['create', 'store', 'show', 'destroy']);
Route::delete('admin/shop/orders/{order}',[OrdersController::class,'destroy'])->name('order.destroy');
Route::put('admin/shop/orders/{id}/updateStatus/',[OrdersController::class,'updateStatus'])->name('order.update.status');
Route::post('admin/shop/orders/{id}/updateQuantity/',[OrdersController::class,'updateQuantity'])->name('order.update.quantity');
Route::put('admin/shop/orders/{id}/updateTransportPrice/',[OrdersController::class,'updateTransportPrice'])->name('order.transport.price');
Route::get('admin/shop/orders/{order}/item/{orderedItem}/delete/',[OrdersController::class,'destroyItem'])->name('order.deleteItem');
Route::post('admin/shop/ordersByStatus',[OrdersController::class,'ordersByStatus'])->name('orders.filter.status');
Route::post('admin/shop/orders/updateLimit',[OrdersController::class,'updateLimit'])->name('orders.update.limit');
Route::post('admin/shop/orders/deleteMultiple',[OrdersController::class,'deleteMultiple'])->name('orders.delete.multiple');
/**
 * MAP
 */
Route::get('admin/maps', [MapsController::class, 'index'])->name('map.index');
Route::post('admin/maps/update',[MapsController::class, 'update'])->name('map.update');
/**
 * SETTINGS
 */
Route::get('admin/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('admin/settings/social',[SettingsController::class, 'social'])->name('settings.social');
Route::post('admin/settings/update',[SettingsController::class, 'update'])->name('settings.update');
Route::post('admin/settings/social/update',[SettingsController::class, 'updateSocial'])->name('social.update');
/**
 * SITEMAP
 */
Route::get('admin/sitemap', [SitemapController::class, 'index'])->name('sitemap');
Route::post('admin/sitemap/regenerate',[SitemapController::class, 'regenerate'])->name('sitemap.regenerate');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});
