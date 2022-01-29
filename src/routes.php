<?php
use Illuminate\Support\Facades\Route;
use Simbamahaba\Upepo\Controllers\Admin\Auth\AuthenticatedSessionController;
use Simbamahaba\Upepo\Controllers\Admin\HomeController as AdminHomeController;
use Simbamahaba\Upepo\Controllers\Admin\HelpController as AdminHelpController;

use Simbamahaba\Upepo\Controllers\Admin\TablesController;
use Simbamahaba\Upepo\Controllers\Admin\RecordsController;

use Simbamahaba\Upepo\Controllers\Admin\ImagesController;
use Simbamahaba\Upepo\Controllers\Admin\FilesController;

use Simbamahaba\Upepo\Controllers\Admin\MapsController;
use Simbamahaba\Upepo\Controllers\Admin\SettingsController;
use Simbamahaba\Upepo\Controllers\Admin\SitemapController;
use UniSharp\LaravelFilemanager\Lfm;

use Simbamahaba\Upepo\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'admin.only']], function () {
    Lfm::routes();
});
