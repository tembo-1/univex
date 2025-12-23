<?php

use App\Livewire\Auth\LoginModal;
use App\Livewire\Pages\Multi\Cart\CartPage;
use App\Livewire\Pages\Multi\Catalog\CatalogPage;
use App\Livewire\Pages\Multi\Catalog\ManufacturersPage;
use App\Livewire\Pages\Multi\Catalog\ProductPage;
use App\Livewire\Pages\Multi\Notepad\NotepadItemsPage;
use App\Livewire\Pages\Multi\Notepad\NotepadPage;
use App\Livewire\Pages\Multi\Order\OrderItemsPage;
use App\Livewire\Pages\Multi\Order\OrdersPage;
use App\Livewire\Pages\Multi\Order\UpdateOrderPage;
use App\Livewire\Pages\Multi\Post\PostPage;
use App\Livewire\Pages\Multi\Post\PostsPage;
use App\Livewire\Pages\Multi\Profile\CabinetPage;
use App\Livewire\Pages\Multi\Refund\CreateRefundPage;
use App\Livewire\Pages\Multi\Refund\RefundPage;
use App\Livewire\Pages\Multi\Refund\RefundsPage;
use App\Livewire\Pages\Single\AboutPage;
use App\Livewire\Pages\Single\BasePage;
use App\Livewire\Pages\Single\ContactPage;
use App\Livewire\Pages\Single\HomePage;
use App\Livewire\Pages\Single\NotFoundPage;
use App\Livewire\Pages\Single\PdfCatalogsPage;
use App\Livewire\Pages\Single\RequisitesPage;
use App\Livewire\Pages\Single\VacancyPage;
use App\Livewire\Popups\CallbackPopup;
use App\Livewire\Popups\Forgot;
use App\Livewire\Popups\NotepadComment;
use App\Livewire\Popups\NotepadPopup;
use App\Livewire\Popups\Register;
use App\Livewire\Popups\ResumePopup;
use Illuminate\Support\Facades\Route;

// РОУТЫ ТОЛЬКО ДЛЯ НЕАВТОРИЗОВАННЫХ ПОЛЬЗОВАТЕЛЕЙ
Route::middleware(['web', 'guest'])->prefix('popup')->group(function () {
    Route::get('/login', LoginModal::class)->name('popup.login');
    Route::get('/register', Register::class)->name('popup.register');
    Route::get('/forgot', Forgot::class)->name('popup.forgot');
});

// РОУТЫ ТОЛЬКО ДЛЯ АВТОРИЗОВАННЫХ КЛИЕНТОВ
Route::middleware(['web', 'auth'])->group(function () {
    // Личный кабинет
    Route::get('/cabinet', CabinetPage::class)->name('cabinet');
    Route::get('/basket', CartPage::class)->name('basket');

    // Заказы
    Route::get('/orders', OrdersPage::class)->name('orders');
    Route::get('/orders/{id}', OrderItemsPage::class)->name('orders.show');
    Route::get('/orders/{id}/update', UpdateOrderPage::class)->name('orders.edit');

    // Возвраты
    Route::prefix('refunds')->group(function () {
        Route::get('/', RefundsPage::class)->name('refunds');
        Route::get('/create', CreateRefundPage::class)->name('refunds.create');
        Route::get('/{id}', RefundPage::class)->name('refunds.show');
    });

    // Блокнот
    Route::prefix('notepad')->group(function () {
        Route::get('/', NotepadPage::class)->name('notepad');
        Route::get('/{id}', NotepadItemsPage::class)->name('notepad.items');
    });

    // Попапы для авторизованных
    Route::prefix('popup')->group(function () {
        Route::get('/notepad', NotepadPopup::class)->name('popup.notepad');
        Route::get('/notepad-comment/{id}', NotepadComment::class)->name('popup.notepadComment');
    });
});

// ПУБЛИЧНЫЕ РОУТЫ (доступны всем)
Route::middleware(['web'])->group(function () {
    // Главная
    Route::get('/', HomePage::class)->name('home');

    // Блог
    Route::get('/posts', PostsPage::class)->name('posts');
    Route::get('/posts/{slug}', PostPage::class)->name('post');

    // Каталог
    Route::get('/manufacturers', ManufacturersPage::class)->name('manufacturers');
    Route::get('/catalog', CatalogPage::class)->name('catalog');
    Route::get('/catalog/{slug}', ProductPage::class)->name('product.show');

    // Информационные страницы
    Route::get('/pdf-catalogs', PdfCatalogsPage::class)->name('pdfCatalogs');
    Route::get('/about', AboutPage::class)->name('about');
    Route::get('/requisites', RequisitesPage::class)->name('requisites');
    Route::get('/vacancies', VacancyPage::class)->name('vacancies');
    Route::get('/contacts', ContactPage::class)->name('contacts');

    // Ошибки
    Route::get('/404', NotFoundPage::class)->name('404');

    // Попапы (доступны всем) - с group но без name()
    Route::prefix('popup')->group(function () {
        Route::get('/resume', ResumePopup::class)->name('popup.resume');
        Route::get('/callback', CallbackPopup::class)->name('popup.callback');
    });

    // Динамические страницы (должен быть последним!)
    Route::get('/{slug}', BasePage::class)->name('page');
});
