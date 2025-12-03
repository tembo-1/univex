<?php

use App\Livewire\AboutPage;
use App\Livewire\CatalogPage;
use App\Livewire\HomePage;
use App\Livewire\ManufacturersPage;
use App\Livewire\PostPage;
use App\Livewire\PostsPage;
use Illuminate\Support\Facades\Route;

Route::get('/',                     HomePage::class)->name('home');
Route::get('/posts',                PostsPage::class)->name('posts');
Route::get('/posts/{slug}',         PostPage::class)->name('post');
Route::get('/manufacturers',        ManufacturersPage::class)->name('manufacturers');
Route::get('/catalog',              CatalogPage::class)->name('catalog');
Route::get('/about',                AboutPage::class)->name('about');

Route::get('/test-livewire', function () {
    return view('test-livewire');
});

