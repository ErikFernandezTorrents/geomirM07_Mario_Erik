<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\VisibilityController;
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

Route::get('mail/test', [MailController::class, 'test']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    return view('auth/login');
});

Route::resource('files', FileController::class)
    ->middleware(['auth', 'permission:files']);
    
Route::resource('posts', PostController::class)
    ->middleware(['auth', 'permission:posts']);

Route::resource('places', PlaceController::class)
    ->middleware(['auth', 'permission:places']);
    
Route::resource('visibilities', VisibilityController::class)
    ->middleware(['auth', 'permission:visibilities']);

Route::get('/language/{locale}', [LanguageController::class, 'language']);

Route::post('/places/{place}/favourites', [App\Http\Controllers\PlaceController::class, 'favourites'])->name('places.favourites');