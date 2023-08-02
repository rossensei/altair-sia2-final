<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\TaskController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/workspaces', [WorkspaceController::class, 'index'])->name('workspaces');
    Route::get('/workspaces/create', [WorkspaceController::class, 'create']);
    Route::post('/workspaces', [WorkspaceController::class, 'store']);
    Route::put('/workspaces/update-bg-photo/{workspace}', [WorkspaceController::class, 'updateBackgroundPhoto']);
    Route::delete('/workspaces/remove/{workspace}', [WorkspaceController::class, 'destroy']);
    Route::get('/workspaces/view-tasks/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
    Route::get('/workspaces/view-tasks/{workspace}/search/{searchKey}', [TaskController::class, 'search'])->name('workspaces.show');
    Route::post('/workspaces/view-tasks/{workspace}', [TaskController::class, 'store']);
    Route::post('/workspaces/view-tasks/{workspace}/toggle-finish/{task}', [TaskController::class, 'toggleFinish']);
    Route::delete('/workspaces/view-tasks/{workspace}/delete/{task}', [TaskController::class, 'destroy']);
    Route::get('/workspaces/view-tasks/{workspace}/edit/{task}', [TaskController::class, 'edit']);
    Route::patch('/workspaces/view-tasks/{workspace}/{task}', [TaskController::class, 'update']);
    Route::get('/workspaces/{workspace}/add-new-task', [TaskController::class, 'create']);
});
