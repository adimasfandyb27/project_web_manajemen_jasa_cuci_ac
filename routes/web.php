<?php


use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerInvoiceController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome', [
        'title' => 'Service Center | Company Profile'
    ]);
})->name('home');

Route::middleware(['auth', 'role:Owner|Admin|Teknisi'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Master Data
        Route::resource('customers', CustomerController::class);
        Route::resource('technicians', TechnicianController::class);
        Route::resource('services', ServiceController::class);

        // Service Orders
        Route::get(
            '/service-orders/export-pdf',
            [ServiceOrderController::class, 'exportPdf']
        )->name('service-orders.export.pdf');
        Route::resource('service-orders', ServiceOrderController::class);

        // Users
        Route::resource('users', UserController::class);

        // Invoices
        Route::get('/invoices/data', [InvoiceController::class, 'data'])
            ->name('invoices.data');

        Route::get(
            '/invoices/export-pdf',
            [InvoiceController::class, 'exportPdf']
        )->name('invoices.export.pdf');

        Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])
            ->name('invoices.print');

        Route::patch('/invoices/{invoice}/paid', [InvoiceController::class, 'markAsPaid'])
            ->name('invoices.paid');

        Route::post('/invoices/{invoice}/paid-proof', [InvoiceController::class, 'markAsPaidWithProof'])
            ->name('invoices.paid.proof');

        Route::get('/invoices/{invoice}/export', [InvoiceController::class, 'export'])
            ->name('invoices.export');

        Route::resource('invoices', InvoiceController::class);

        // Roles
        Route::resource('roles', RoleController::class);

        // Activity Logs
        Route::prefix('activity-logs')
            ->name('activity-logs.')
            ->group(function () {

                Route::get('/', [ActivityLogController::class, 'index'])
                    ->name('index');

                Route::get('/{activityLog}', [ActivityLogController::class, 'show'])
                    ->name('show');
            });

        // Reports
        Route::prefix('reports')
            ->name('reports.')
            ->group(function () {

                Route::get('/service-orders', [ReportController::class, 'serviceOrders'])
                    ->name('service-orders');

                Route::get('/service-orders/data', [ReportController::class, 'serviceOrdersData'])
                    ->name('service-orders.data');

                Route::get('/service-orders/pdf', [ReportController::class, 'exportPdf'])
                    ->name('service-orders.pdf');

                Route::get('/revenue', [ReportController::class, 'revenue'])
                    ->name('revenue');

                Route::get('/revenue/data', [ReportController::class, 'revenueData'])
                    ->name('revenue.data');

                Route::get('/revenue/pdf', [ReportController::class, 'RevenueExportPdf'])
                    ->name('revenue.pdf');

                Route::get('/customers', [ReportController::class, 'customers'])
                    ->name('customers');

                Route::get('/customers/data', [ReportController::class, 'customersData'])
                    ->name('customers.data');

                Route::get('/customers/pdf', [ReportController::class, 'exportCustomerPdf'])
                    ->name('customers.pdf');
            });
    });

//customer
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/orders', [\App\Http\Controllers\Customer\ServiceOrderController::class, 'index'])
            ->name('orders');

        Route::get('/orders/create', [\App\Http\Controllers\Customer\ServiceOrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [\App\Http\Controllers\Customer\ServiceOrderController::class, 'store'])
            ->name('orders.store');

        Route::get('/orders/{id}', [\App\Http\Controllers\Customer\ServiceOrderController::class, 'show'])
            ->name('orders.show');

        Route::get('/orders/{id}/edit', [\App\Http\Controllers\Customer\ServiceOrderController::class, 'edit'])
            ->name('orders.edit');

        Route::put('/orders/{id}', [\App\Http\Controllers\Customer\ServiceOrderController::class, 'update'])
            ->name('orders.update');

        Route::patch(
            '/orders/{id}/cancel',
            [\App\Http\Controllers\Customer\ServiceOrderController::class, 'cancel']
        )->name('orders.cancel');

        Route::get('/profile', [CustomerProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [CustomerProfileController::class, 'update'])
            ->name('profile.update');

        // INVOICE
        Route::get('/invoices', [CustomerInvoiceController::class, 'index'])
            ->name('invoices');

        Route::get('/invoices/{id}', [CustomerInvoiceController::class, 'show'])
            ->name('invoices.show');

        Route::get('/invoices/{id}/print', [CustomerInvoiceController::class, 'print'])
            ->name('invoices.print');
    });
require __DIR__ . '/auth.php';
