<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('employees/export/', [EmployeesController::class, 'export']);

Route::get('dashboard', DashboardController::class);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('users', UsersController::class)->except('store');
    Route::resource('employees', EmployeesController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::get('salaries/month', [SalariesController::class, 'getSalariesByMonth']);
    Route::resource('salaries', SalariesController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('carts', CartController::class);
    
    Route::get('stock/{product}', [StockController::class, 'show']);
    Route::put('stock/{product}', [StockController::class, 'update']);

    Route::get('sales/get_invoice_no', [SalesController::class, 'generateInvoiceNo']);
    Route::resource('sales', SalesController::class);
});

