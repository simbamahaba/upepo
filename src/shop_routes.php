<?php
use Illuminate\Support\Facades\Route;
use Simbamahaba\Upepo\Controllers\CustomerController as FrontCustomerController;
use Simbamahaba\Upepo\Controllers\CartController;
use Simbamahaba\Upepo\Controllers\Admin\CustomerController;
use Simbamahaba\Upepo\Controllers\Admin\OrdersController;
use Simbamahaba\Upepo\Controllers\Admin\StatusController;
use Simbamahaba\Upepo\Controllers\Admin\TransportController;
use Simbamahaba\Upepo\Controllers\Admin\InvoiceController;
use Simbamahaba\Upepo\Controllers\ProformaController;

# Customers Front End
Route::put('customer/profile/{customer}',[FrontCustomerController::class, 'update'])->name('customer.update');
Route::get('customer/profile',[FrontCustomerController::class,'profile'])->name('customer.profile');
Route::get('customer/myOrders',[FrontCustomerController::class,'myOrders'])->name('customer.myOrders');
Route::get('customer/newPassword',[FrontCustomerController::class,'newPassword'])->name('customer.newPassword');
Route::post('customer/updatePassword/{customer}',[FrontCustomerController::class, 'updatePassword'])->name('customer.updatePassword');

# Cart
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

# Transport
Route::get('admin/shop/transport',[TransportController::class,'index'])->name('transport.index');
Route::get('admin/shop/transport/create',[TransportController::class, 'create'])->name('transport.create');
Route::post('admin/shop/transport',[TransportController::class,'store'])->name('transport.store');
Route::post('admin/shop/transport/updateOrder',[TransportController::class,'updateOrder'])->name('transport.update.order');
Route::get('admin/shop/transport/{id}/edit',[TransportController::class,'edit'])->name('transport.edit');
Route::put('admin/shop/transport/{id}',[TransportController::class,'update'])->name('transport.update');
Route::get('admin/shop/transport/{id}/delete',[TransportController::class,'destroy'])->name('transport.destroy');

# Customers
Route::get('admin/shop/customers',[CustomerController::class,'index'])->name('customer.index.backend');
Route::post('admin/shop/customers',[CustomerController::class, 'store'])->name('customer.store.backend');
Route::post('admin/shop/customers/updateLimit',[CustomerController::class,'updateLimit'])->name('customer.limit.backend');
Route::get('admin/shop/customers/create',[CustomerController::class, 'create'])->name('customer.create.backend');
Route::get('admin/shop/customers/{customer}/edit',[CustomerController::class,'edit'])->name('customer.edit.backend');
Route::put('admin/shop/customers/{customer}',[CustomerController::class, 'update'])->name('customer.update.backend');
Route::delete('admin/shop/customers/{customer}',[CustomerController::class,'destroy'])->name('customer.destroy.backend');
Route::post('admin/shop/customers/deleteMultiple',[CustomerController::class, 'deleteMultiple'])->name('customer.delete.multiple.backend');

# Invoices
Route::get('admin/shop/invoice',[InvoiceController::class,'index'])->name('invoice.index');
Route::get('cart/vizualizareProforma/{id}/{code}',[ProformaController::class, 'index'])->name('proforma');
Route::put('admin/shop/invoice/{id}',[InvoiceController::class,'update'])->name('invoice.update');

# Statuses
Route::get('admin/shop/statuses',[StatusController::class,'index'])->name('status.index');
Route::get('admin/shop/statuses/{id}/edit',[StatusController::class,'edit'])->name('status.edit');
Route::put('admin/shop/statuses/{id}',[StatusController::class,'update'])->name('status.order.update');

# Orders
Route::resource('admin/shop/orders', OrdersController::class)->except(['create', 'store', 'show', 'destroy']);
Route::delete('admin/shop/orders/{order}',[OrdersController::class,'destroy'])->name('order.destroy');
Route::put('admin/shop/orders/{id}/updateStatus/',[OrdersController::class,'updateStatus'])->name('order.update.status');
Route::post('admin/shop/orders/{id}/updateQuantity/',[OrdersController::class,'updateQuantity'])->name('order.update.quantity');
Route::put('admin/shop/orders/{id}/updateTransportPrice/',[OrdersController::class,'updateTransportPrice'])->name('order.transport.price');
Route::get('admin/shop/orders/{order}/item/{orderedItem}/delete/',[OrdersController::class,'destroyItem'])->name('order.deleteItem');
Route::post('admin/shop/ordersByStatus',[OrdersController::class,'ordersByStatus'])->name('orders.filter.status');
Route::post('admin/shop/orders/updateLimit',[OrdersController::class,'updateLimit'])->name('orders.update.limit');
Route::post('admin/shop/orders/deleteMultiple',[OrdersController::class,'deleteMultiple'])->name('orders.delete.multiple');