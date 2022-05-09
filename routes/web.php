<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

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

Route::get('/'                  , [HomeController::class , 'index'])->name('home')->middleware('guest');
Route::get('/letter'            , [LetterController::class , 'index'])->name('letter')->middleware('guest');
Route::post('/addproductcart'   , [LetterController::class , 'addproductcart']);


Route::get('/cart'              , [CartController::class , 'index'])->name('cart')->middleware('guest');
Route::post('/getcart'          , [CartController::class , 'getcart'])->name('getcart');
Route::post('/remove_product'   , [CartController::class , 'remove_product'])->name('remove_product');
Route::post('/quantityproducts' , [CartController::class , 'quantityproducts'])->name('quantityproducts');
Route::post('/updatequantity'   , [CartController::class , 'updatequantity'])->name('updatequantity');
Route::post('/validname'        , [CartController::class , 'validname'])->name('validname');
Route::post('/sendorder'        , [CartController::class , 'sendorder'])->name('sendorder');
Route::post('/destroycart'      , [CartController::class , 'destroycart'])->name('destroycart');

Route::post('/validnamedeli'    , [CartController::class , 'validnamedeli'])->name('validnamedeli');
Route::post('/validardireccion' , [CartController::class , 'validardireccion'])->name('validardireccion');
Route::post('/sendorderdeli'    , [CartController::class , 'sendorderdeli'])->name('sendorderdeli');



Route::get('/login'             , [LoginController::class , 'index'])->name('login')->middleware('guest');
Route::post('/logueo'           , [LoginController::class , 'logueo'])->name('login.logueo');
Route::get('/logout'            , [LoginController::class , 'logout'])->name('login.logout');


Route::get('/home'              , [AdminController::class , 'index'])->name('admin.home')->middleware('auth');
Route::get('/getorders'         , [AdminController::class , 'getorders'])->name('admin.getorders');
Route::post('/modalstatus'      , [AdminController::class , 'modalstatus'])->name('admin.modalstatus');
Route::post('/updatestatus'     , [AdminController::class , 'updatestatus'])->name('admin.updatestatus');

Route::get('/products'          , [AdminController::class , 'products'])->name('admin.products')->middleware('auth');
Route::get('/getproducts'       , [AdminController::class , 'getproducts'])->name('admin.getproducts');
Route::get('/newproduct'        , [AdminController::class , 'newproduct'])->name('admin.newproduct')->middleware('auth');
Route::post('/addnewproduct'    , [AdminController::class , 'addnewproduct'])->name('admin.addnewproduct');
Route::get('/editproduct/{id}'  , [AdminController::class , 'editproduct'])->name('admin.editproduct')->middleware('auth');
Route::post('/storeproduct'     , [AdminController::class , 'storeproduct'])->name('admin.storeproduct');
Route::post('/updatecheck'      , [AdminController::class , 'updatecheck'])->name('admin.updatecheck');
Route::get('/settings'          , [AdminController::class , 'settings'])->name('admin.settings')->middleware('auth');
Route::post('/updatesett'       , [AdminController::class , 'updatesett'])->name('admin.updatesett');


Route::get('/ticket'            , [AdminController::class , 'ticket'])->name('admin.ticket');
Route::get('/pdf_ticket'        , [AdminController::class , 'pdf_ticket'])->name('admin.pdf_ticket');