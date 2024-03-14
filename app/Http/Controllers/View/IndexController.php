<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Banner;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Project;
use App\Models\ProjectCategories;
use App\Models\Service;
use App\Models\Settings;

class IndexController extends Controller
{
    public function index()
    {
        // $lang = ['az' => '/', 'en' => '/en/', 'ru' => '/ru/'];
        $lang = ['en' => '/', 'ru' => '/ru/'];
        $settings = Settings::findOrFail(1);
        $menues = Menu::where('destroy', 0)->orderBy('order')->get();
        $banners = Banner::where('destroy', 0)->orderBy('order')->get();
        $about = About::findOrFail(1);
        $services = Service::where('destroy', 0)->orderBy('order')->get();
        $projectcategories = ProjectCategories::where('destroy', 0)->orderBy('order')->get();
        $projects = Project::where('destroy', 0)->orderBy('order')->get();
        $customers = Customer::where('destroy', 0)->orderBy('order')->get();
        return view('site.pages.home', compact(['settings', 'lang', 'menues', 'banners', 'about', 'services', 'projectcategories', 'projects', 'customers']));
    }

    public function home()
    {
        return redirect()->route('index');
    }
}
