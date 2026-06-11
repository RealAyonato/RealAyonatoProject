<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/portfolio', function () {
    return view('portfolio');
});

Route::get('/feedback', function () {
    return view('feedback');
});

Route::get('/service', function () {
    return view('service');
});

Route::get('/faq', function () {
    return view('faq');
});

Route::get('/contact', function () {
    return view('contact');
});