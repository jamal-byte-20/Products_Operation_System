<?php

use App\Http\Controllers\AuthenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index']);

Route::get('/register', [AuthenController::class, 'register'])->name('register');
Route::post('/register', [AuthenController::class, 'storeRegister']);


Route::get('/login', [AuthenController::class, 'formlog'])->name('login');
Route::post('/login', [AuthenController::class, 'login']);


Route::post('/logout', [AuthenController::class, 'logout'])->middleware('auth')->name('logout');


Route::middleware(['auth','admin'])->prefix('dashboard')->group(function(){
    Route::get('/', function(){
        $users = User::count();
        $products = Product::count();
        $orders = Order::count();
        return view('dashboard', compact('users','products','orders'));
});
Route::resource('products',ProductController::class);
    
}
);

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');




