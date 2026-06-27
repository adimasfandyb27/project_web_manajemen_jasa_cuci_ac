<?php

use App\Http\Controllers\AcBrandController;
use App\Http\Controllers\AcCapacityController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AcTypeController;
use App\Http\Controllers\Customer\CustomerAcUnitController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerInvoiceController;
use App\Http\Controllers\Customer\CustomerNotificationController;
use App\Http\Controllers\Customer\CustomerPaymentController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchedulerController;
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
        'title' => 'Service Center | Company Profile',
    ]);
})->name('home');

Route::middleware(['auth', 'role:Owner|Admin|Teknisi'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Scheduler
        Route::prefix('scheduler')
            ->name('scheduler.')
            ->group(function () {
                Route::get('/', [SchedulerController::class, 'index'])->name('index');
                Route::get('/events', [SchedulerController::class, 'events'])->name('events');
                Route::get('/technician/{technician}', [SchedulerController::class, 'technicianSchedule'])
                    ->name('technician');
            });

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Master Data
        Route::resource('customers', CustomerController::class);
        Route::resource('technicians', TechnicianController::class);
        Route::resource('services', ServiceController::class);

        // AC Brands
        Route::resource('ac-brands', AcBrandController::class);

        // AC Types
        Route::resource('ac-types', AcTypeController::class);

        // AC Capacities
        Route::resource('ac-capacities', AcCapacityController::class);

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

        // payments
        Route::get(
            '/payments/export-pdf',
            [PaymentController::class, 'exportPdf']
        )->name('payments.export.pdf');

        Route::get('/payments/data', [PaymentController::class, 'data'])
            ->name('payments.data');

        Route::resource('payments', PaymentController::class)
            ->only(['index', 'show']);

        Route::patch(
            '/payments/{payment}/verify',
            [PaymentController::class, 'verify']
        )->name('payments.verify');

        Route::patch(
            '/payments/{payment}/reject',
            [PaymentController::class, 'reject']
        )->name('payments.reject');

        Route::get('/payments/{payment}/export', [PaymentController::class, 'export'])
            ->name('payments.export');

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

// customer
Route::middleware(['auth', 'role:Customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/orders', [App\Http\Controllers\Customer\ServiceOrderController::class, 'index'])
            ->name('orders');

        Route::get('/orders/create', [App\Http\Controllers\Customer\ServiceOrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [App\Http\Controllers\Customer\ServiceOrderController::class, 'store'])
            ->name('orders.store');

        Route::get('/orders/{id}', [App\Http\Controllers\Customer\ServiceOrderController::class, 'show'])
            ->name('orders.show');

        Route::get('/orders/{id}/edit', [App\Http\Controllers\Customer\ServiceOrderController::class, 'edit'])
            ->name('orders.edit');

        Route::put('/orders/{id}', [App\Http\Controllers\Customer\ServiceOrderController::class, 'update'])
            ->name('orders.update');

        Route::patch(
            '/orders/{id}/cancel',
            [App\Http\Controllers\Customer\ServiceOrderController::class, 'cancel']
        )->name('orders.cancel');

        // AC UNITS
        Route::get('/ac-units', [CustomerAcUnitController::class, 'index'])
            ->name('ac-units.index');

        Route::get('/ac-units/create', [CustomerAcUnitController::class, 'create'])
            ->name('ac-units.create');

        Route::post('/ac-units', [CustomerAcUnitController::class, 'store'])
            ->name('ac-units.store');

        Route::get('/ac-units/{id}/edit', [CustomerAcUnitController::class, 'edit'])
            ->name('ac-units.edit');

        Route::put('/ac-units/{id}', [CustomerAcUnitController::class, 'update'])
            ->name('ac-units.update');

        Route::delete('/ac-units/{id}', [CustomerAcUnitController::class, 'destroy'])
            ->name('ac-units.destroy');

        Route::get('/profile', [CustomerProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [CustomerProfileController::class, 'update'])
            ->name('profile.update');

        // INVOICE
        Route::get('/invoices', [CustomerInvoiceController::class, 'index'])
            ->name('invoices');

        Route::get('/invoices/{id}', [CustomerInvoiceController::class, 'show'])
            ->name('invoices.show');

        // Route::get('/invoices/{id}/print', [CustomerInvoiceController::class, 'print'])
        //     ->name('invoices.print');

        Route::post(
            '/payments',
            [CustomerPaymentController::class, 'store']
        )->name('payments.store');

        Route::get(
            '/invoices/{invoice}/payments',
            [CustomerPaymentController::class, 'history']
        )->name('payments.history');

        // NOTIFICATIONS
        Route::get('/notifications/unread', [CustomerNotificationController::class, 'unread'])
            ->name('notifications.unread');

        Route::post('/notifications/{notification}/read', [CustomerNotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        Route::post('/notifications/read-all', [CustomerNotificationController::class, 'markAllAsRead'])
            ->name('notifications.read-all');
    });
require __DIR__.'/auth.php';
