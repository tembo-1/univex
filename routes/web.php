<?php

use App\Livewire\Auth\LoginModal;
use App\Livewire\BasketPage;
use App\Livewire\OrdersPage;
use App\Livewire\Page\BasePage;
use App\Livewire\Page\CabinetPage;
use App\Livewire\Pages\AboutPage;
use App\Livewire\Pages\CatalogPage;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\ManufacturersPage;
use App\Livewire\Pages\NotFoundPage;
use App\Livewire\Pages\PdfCatalogsPage;
use App\Livewire\Pages\PostPage;
use App\Livewire\Pages\PostsPage;
use App\Livewire\Pages\ProductPage;
use App\Livewire\Pages\RefundPage;
use App\Livewire\Pages\RequisitesPage;
use App\Livewire\Popups\ResumePopup;
use App\Livewire\ProfilePage;
use App\Livewire\VacancyPage;
use Illuminate\Support\Facades\Route;

Route::get('/',                     HomePage::class)->name('home');
Route::get('/posts',                PostsPage::class)->name('posts');
Route::get('/posts/{slug}',         PostPage::class)->name('post');
Route::get('/manufacturers',        ManufacturersPage::class)->name('manufacturers');
Route::get('/catalog',              CatalogPage::class)->name('catalog');
Route::get('/catalog/{slug}',       ProductPage::class)->name('product.show');
Route::get('/pdf-catalogs',         PdfCatalogsPage::class)->name('pdfCatalogs');
Route::get('/about',                AboutPage::class)->name('about');
Route::get('/requisites',           RequisitesPage::class)->name('requisites');
Route::get('/vacancies',            VacancyPage::class)->name('vacancies');

Route::get('/refund',               RefundPage::class)->name('refund');

// С авторизацией клиента
Route::get('/cabinet',              CabinetPage::class)->name('cabinet');
Route::get('/basket',               BasketPage::class)->name('basket');
Route::get('/orders',               OrdersPage::class)->name('orders');
Route::get('/profile',              ProfilePage::class)->name('profile');

//Route::fallback(                        NotFoundPage::class);
Route::get('/404',                  NotFoundPage::class)->name('404');

Route::get('/popup/login',          LoginModal::class)->name('popup.login');
Route::get('/popup/resume',         ResumePopup::class)->name('popup.resume');

Route::get('/{slug}',               BasePage::class)->name('page');
