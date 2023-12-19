<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show']);

Route::prefix('/listings')
    ->as('listings.')
    ->group(function () {
        Route::get('/', [ListingController::class, 'index'])->name('index');

        Route::get('/{listing}', [ListingController::class, 'show'])->name('show');

        Route::post('/{listing}', [ListingOfferController::class, 'store'])->name('offers.store')->middleware('auth');
    });

Route::prefix('/notifications')
    ->as('notifications.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [ListingController::class, 'index'])->name('index');

        Route::get('/{notification}/seen', NotificationSeenController::class)->name('seen');
    });

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('listing.index')->with('success', 'Email was verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::resource('user-account', UserAccountController::class)->only(['create', 'store']);

Route::prefix('realtors')
    ->name('realtors.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::prefix('/listings')
            ->as('listings.')
            ->group(function () {
                Route::get('/', [RealtorListingController::class, 'index'])->name('index');

                Route::get('/create', [RealtorListingController::class, 'create'])->name('create');

                Route::post('/', [RealtorListingController::class, 'store'])->name('store');

                Route::get('/{listing}', [RealtorListingController::class, 'show'])->name('show');

                Route::get('/{listing}/edit', [RealtorListingController::class, 'edit'])->name('edit');

                Route::put('/{listing}', [RealtorListingController::class, 'update'])->name('update');

                Route::put('/{listing}/restore', [RealtorListingController::class, 'restore'])->name('listing.restore')->withTrashed();

                Route::delete('/{listing}', [RealtorListingController::class, 'destroy'])->name('destroy');

                Route::prefix('/{listing}/image')
                    ->as('image.')
                    ->group(function () {
                        Route::get('/create', [RealtorListingImageController::class, 'create'])->name('create');

                        Route::post('/', [RealtorListingImageController::class, 'store'])->name('store');

                        Route::delete('/{image}', [RealtorListingImageController::class, 'destroy'])->name('destroy');
                    });
            });

        Route::put('offers/{offer}/accept', RealtorListingAcceptOfferController::class)->name('offer.accept');
    });
