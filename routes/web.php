<?php

use App\Http\Controllers\BushController;
use App\Http\Controllers\CharacteristicController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MetalController;
use App\Http\Controllers\PaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\SteelController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [UserController::class, 'welcome'])->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('/bushes')->group(function () {
        Route::get('/', [BushController::class, 'index'])->name('index.bush');
        Route::post('/', [BushController::class, 'store'])->name('store.bush');
        Route::get('/{bush}', [BushController::class, 'show'])->name('show.bush');
        Route::get('all/{bush}', [BushController::class, 'all'])->name('all.bush');
        Route::delete('/{bush}', [BushController::class, 'destroy'])->name('destroy.bush');
        Route::get('/export/{bush}', [BushController::class, 'export'])->name('export.bush');
    });
    Route::prefix('/projects')->group(function () {
        Route::post('/', [ProjectController::class, 'store'])->name('store.project');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update.project');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy.project');
    });
    Route::prefix('/materials')->group(function () {
        Route::get('/', [MaterialController::class, 'showAll'])->name('all');
        Route::get('/{project}', [MaterialController::class, 'index'])->name('index.material');
        Route::post('/', [MaterialController::class, 'store'])->name('store.material');
        Route::put('/{material}', [MaterialController::class, 'update'])->name('update.material');
        Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('destroy.material');
        Route::get('/export/{project}', [MaterialController::class, 'export'])->name('export.project');
    });
    Route::prefix('/elements')->group(function () {
        Route::get('/', [ElementController::class, 'index'])->name('index.elements');
        Route::post('/', [ElementController::class, 'store'])->name('store.element');
        Route::put('/{element}', [ElementController::class, 'update'])->name('update.element');
        Route::delete('/{element}', [ElementController::class, 'delete'])->name('destroy.element');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('index.users');
    Route::prefix('/paint')->group(function () {
        Route::get('/', [PaintController::class, 'index'])->name('paint.index');
        Route::post('/', [PaintController::class, 'store'])->name('store.paint');
        Route::put('/{paint}', [PaintController::class, 'update'])->name('update.paint');
        Route::delete('/{paint}', [PaintController::class, 'destroy'])->name('destroy.paint');
    });
    Route::prefix('/metal')->group(function () {
        Route::get('/', [MetalController::class, 'index'])->name('index.metal');
        Route::post('/', [MetalController::class, 'store'])->name('store.metal');
        Route::get('/{metal}', [MetalController::class, 'show'])->name('show.metal');
        Route::put('/{metal}', [MetalController::class, 'update'])->name('update.metal');
        Route::delete('/{metal}', [MetalController::class, 'destroy'])->name('destroy.metal');
    });
    Route::prefix('/characteristic')->group(function () {
        Route::post('/', [CharacteristicController::class, 'store'])->name('store.characteristic');
        Route::put('/{characteristic}', [CharacteristicController::class, 'update'])->name('update.characteristic');
        Route::delete('/{characteristic}', [CharacteristicController::class, 'destroy'])->name('destroy.characteristic');
    });
    Route::prefix('/standard')->group(function () {
        Route::get('/', [StandardController::class, 'index'])->name('standard.index');
        Route::post('/', [StandardController::class, 'store'])->name('store.standard');
        Route::put('/{standard}', [StandardController::class, 'update'])->name('update.standard');
        Route::delete('/{standard}', [StandardController::class, 'destroy'])->name('destroy.standard');
    });
    Route::prefix('/steel')->group(function () {
        Route::get('/', [SteelController::class, 'index'])->name('steel.index');
        Route::post('/', [SteelController::class, 'store'])->name('store.steel');
        Route::put('/{steel}', [SteelController::class, 'update'])->name('update.steel');
        Route::delete('/{steel}', [SteelController::class, 'destroy'])->name('destroy.steel');
    });
});

require __DIR__ . '/auth.php';
