<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProduitController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::get('/', function () {
    return view('pages.index');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/service', function () {
    return view('pages.service');
})->name('service');

Route::get('/price', function () {
    return view('pages.price');
})->name('price');

Route::get('/feature', function () {
    return view('pages.feature');
})->name('feature');

Route::get('/quote', function () {
    return view('pages.quote');
})->name('quote');

Route::get('/team', function () {
    return view('pages.team');
})->name('team');

Route::get('/testimonial', function () {
    return view('pages.testimonial');
})->name('testimonial');

Route::get('/404', function () {
    return view('pages.404');
})->name('404');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');


Route::resource('membres', App\Http\Controllers\MembreController::class);

Route::resource('membres', App\Http\Controllers\MembreController::class);

Route::resource('contacts', App\Http\Controllers\ContactController::class);

Route::resource('services', App\Http\Controllers\ServiceController::class);

Route::resource('produits', App\Http\Controllers\ProduitController::class);
Route::resource('annonces', App\Http\Controllers\AnnonceController::class);
Route::POST('annonces/{annonce}/toggle-active', [App\Http\Controllers\AnnonceController::class, 'toggleActive'])->name('annonces.toggle-active');

Route::delete('contacts/destroy-multiple', [ContactController::class, 'destroyMultiple'])->name('contacts.destroy-multiple');
Route::get('contacts/export', [ContactController::class, 'export'])->name('contacts.export');