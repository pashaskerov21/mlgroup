<?php

use App\Http\Controllers\AdminPanel\AboutController;
use App\Http\Controllers\AdminPanel\AltMenuController;
use App\Http\Controllers\AdminPanel\ApplicationController;
use App\Http\Controllers\AdminPanel\BannerController;
use App\Http\Controllers\AdminPanel\CustomerController;
use App\Http\Controllers\AdminPanel\DashboardController;
use App\Http\Controllers\AdminPanel\MenuController;
use App\Http\Controllers\AdminPanel\MessageController;
use App\Http\Controllers\AdminPanel\ProjectCategoryController;
use App\Http\Controllers\AdminPanel\ProjectController;
use App\Http\Controllers\AdminPanel\ServiceAltContentController;
use App\Http\Controllers\AdminPanel\ServiceController;
use App\Http\Controllers\AdminPanel\SettingController;
use App\Http\Controllers\AdminPanel\VacancyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\View\AboutController as ViewAboutController;
use App\Http\Controllers\View\CareerController;
use App\Http\Controllers\View\ContactController;
use App\Http\Controllers\View\IndexController;
use App\Http\Controllers\View\NotFoundPageController;
use App\Http\Controllers\View\ProjectController as ViewProjectController;
use App\Http\Controllers\View\ServiceController as ViewServiceController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/admin', 'as' => 'admin.'], function () {

    Route::group(['middleware' => 'isLogin'], function () {
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });
    Route::group(['middleware' => 'notLogin'], function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::resource('account', AuthController::class);
        Route::resource('users', UserController::class);

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::resource('menu', MenuController::class);
        Route::get('/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.delete');
        Route::post('/menu/sort', [MenuController::class, 'sort'])->name('menu.sort');

        Route::resource('banner', BannerController::class);
        Route::get('/banner/delete/{id}', [BannerController::class, 'destroy'])->name('banner.delete');
        Route::post('/banner/sort', [BannerController::class, 'sort'])->name('banner.sort');

        Route::get('/about', [AboutController::class, 'index'])->name('about');
        Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');

        Route::resource('services', ServiceController::class);
        Route::post('/update-service-homestatus', [ServiceController::class, 'updateHomeStatus'])->name('services.update-home-status');
        Route::get('/services/delete/{id}', [ServiceController::class, 'destroy'])->name('services.delete');
        Route::post('/services/sort', [ServiceController::class, 'sort'])->name('services.sort');

        Route::resource('service-contents', ServiceAltContentController::class);
        Route::get('/service-contents/delete/{id}', [ServiceAltContentController::class, 'destroy'])->name('service-contents.delete');
        Route::post('/service-contents/sort', [ServiceAltContentController::class, 'sort'])->name('service-contents.sort');

        Route::resource('project-categories', ProjectCategoryController::class);
        Route::get('/project-categories/delete/{id}', [ProjectCategoryController::class, 'destroy'])->name('project-categories.delete');
        Route::post('/project-categories/sort', [ProjectCategoryController::class, 'sort'])->name('project-categories.sort');

        Route::resource('projects', ProjectController::class);
        Route::post('/update-project-homestatus', [ProjectController::class, 'updateHomeStatus'])->name('projects.update-home-status');
        Route::get('/projects/delete/{id}', [ProjectController::class, 'destroy'])->name('projects.delete');
        Route::post('/projects/sort', [ProjectController::class, 'sort'])->name('projects.sort');

        Route::resource('customers', CustomerController::class);
        Route::get('/customers/delete/{id}', [CustomerController::class, 'destroy'])->name('customers.delete');
        Route::post('/customers/sort', [CustomerController::class, 'sort'])->name('customers.sort');

        Route::resource('messages', MessageController::class);

        Route::resource('vacancy', VacancyController::class);
        Route::get('/vacancy/delete/{id}', [VacancyController::class, 'destroy'])->name('vacancy.delete');
        Route::post('/vacancy/sort', [VacancyController::class, 'sort'])->name('vacancy.sort');

        Route::resource('applications', ApplicationController::class);
    });
});






$locale = Request::segment(1);

// if (in_array($locale, ['en', 'ru'])) {
//     $locale = Request::segment(1);
// } else {
//     $locale = '';
// }
if (in_array($locale, ['ru'])) {
    $locale = Request::segment(1);
} else {
    $locale = '';
}

Route::group([
    'prefix' => $locale, function ($locale = null) {
        return $locale;
    }, 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => 'setLocale'
], function () {
    

    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::get('/esas-sehife', [IndexController::class, 'home'])->name('home_az');
    Route::get('/home', [IndexController::class, 'home'])->name('home_en');
    Route::get('/glavnaia', [IndexController::class, 'home'])->name('home_ru');

    Route::get('/haqqimizda', [ViewAboutController::class, 'index'])->name('about_az');
    Route::get('/about-us', [ViewAboutController::class, 'index'])->name('about_en');
    Route::get('/o-nas', [ViewAboutController::class, 'index'])->name('about_ru');

    Route::get('/xidmetler', [ViewServiceController::class, 'index'])->name('services_az');
    Route::get('/services', [ViewServiceController::class, 'index'])->name('services_en');
    Route::get('/servis', [ViewServiceController::class, 'index'])->name('services_ru');

    Route::get('/xidmetler/{slug}', [ViewServiceController::class, 'details'])->name('service_inner_az');
    Route::get('/services/{slug}', [ViewServiceController::class, 'details'])->name('service_inner_en');
    Route::get('/servis/{slug}', [ViewServiceController::class, 'details'])->name('service_inner_ru');

    Route::get('/mehsullar', [ViewProjectController::class, 'index'])->name('projects_az');
    Route::get('/products', [ViewProjectController::class, 'index'])->name('projects_en');
    Route::get('/tovary', [ViewProjectController::class, 'index'])->name('projects_ru');

    Route::get('/mehsullar/{categorySlug}', [ViewProjectController::class, 'category'])->name('project_category_az');
    Route::get('/products/{categorySlug}', [ViewProjectController::class, 'category'])->name('project_category_en');
    Route::get('/tovary/{categorySlug}', [ViewProjectController::class, 'category'])->name('project_category_ru');

    Route::get('/mehsullar/{categorySlug}/{projectSlug}', [ViewProjectController::class, 'details'])->name('project_inner_az');
    Route::get('/products/{categorySlug}/{projectSlug}', [ViewProjectController::class, 'details'])->name('project_inner_en');
    Route::get('/tovary/{categorySlug}/{projectSlug}', [ViewProjectController::class, 'details'])->name('project_inner_ru');

    Route::get('/bizimle-elaqe', [ContactController::class, 'index'])->name('contact_az');
    Route::get('/contact-us', [ContactController::class, 'index'])->name('contact_en');
    Route::get('/kontakt', [ContactController::class, 'index'])->name('contact_ru');

    Route::post('/bizimle-elaqe/send-message', [ContactController::class, 'send'])->name('contact_send_message_az');
    Route::post('/contact-us/send-message', [ContactController::class, 'send'])->name('contact_send_message_en');
    Route::post('/kontakt/send-message', [ContactController::class, 'send'])->name('contact_send_message_ru');


    Route::get('/insan-resurslari', [CareerController::class, 'career'])->name('career_az');
    Route::get('/human-resources', [CareerController::class, 'career'])->name('career_en');
    Route::get('/celoveceskie-resursy', [CareerController::class, 'career'])->name('career_ru');


    Route::get('/insan-resurslari/vakansiyalar', [CareerController::class, 'index'])->name('vacancies_az');
    Route::get('/human-resources/vacancies', [CareerController::class, 'index'])->name('vacancies_en');
    Route::get('/celoveceskie-resursy/vakansii', [CareerController::class, 'index'])->name('vacancies_ru');

    Route::get('/insan-resurslari/is-ucun-muraciet', [CareerController::class, 'applypage'])->name('apply_page_az');
    Route::get('/human-resources/apply-for-a-job', [CareerController::class, 'applypage'])->name('apply_page_en');
    Route::get('/celoveceskie-resursy/zaiavka-na-rabotu', [CareerController::class, 'applypage'])->name('apply_page_ru');

    Route::get('/insan-resurslari/is-ucun-muraciet/{slug}', [CareerController::class, 'selectvacancy'])->name('select_vacancy_az');
    Route::get('/human-resources/apply-for-a-job/{slug}', [CareerController::class, 'selectvacancy'])->name('select_vacancy_en');
    Route::get('/celoveceskie-resursy/zaiavka-na-rabotu/{slug}', [CareerController::class, 'selectvacancy'])->name('select_vacancy_ru');

    Route::post('/insan-resurslari/is-ucun-muraciet', [CareerController::class, 'submit'])->name('vacancy_form_submit_az');
    Route::post('/human-resources/apply-for-a-job', [CareerController::class, 'submit'])->name('vacancy_form_submit_en');
    Route::post('/celoveceskie-resursy/zaiavka-na-rabotu', [CareerController::class, 'submit'])->name('vacancy_form_submit_ru');


    Route::get('/404', [NotFoundPageController::class, 'index'])->name('not_found');

});
