<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Participate\ParticipateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::group([
    'middleware' => ['auth.web']
], function (){
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', ['page' => 'dashboard']);
    });
    Route::get('/activity', function () {
        return Inertia::render('ActivitiesList', ['page' => 'activities']);
    });
    Route::get('/participants', function () {
        return Inertia::render('Participants', ['page' => 'participants']);
    });
    Route::get('/organizations', function () {
        return Inertia::render('Organizations', ['page' => 'organizations']);
    });
});

Route::get('/dashboard/public', [ParticipateController::class, 'publicDashboard'])->name('public.dashboard');

Route::get('/participate/{activity_id}/add/tree', [ParticipateController::class, 'show'])->name('participate.form');
Route::get('/participate/view/tree/{tree_id}', [ParticipateController::class, 'viewTree'])->name('participate.view.tree');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
