<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AnnonceController;

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

    Route::prefix('annonces')->group(function () {
        Route::get('/', [AnnonceController::class, 'index']);
        Route::post('/', [AnnonceController::class, 'store']);
    });