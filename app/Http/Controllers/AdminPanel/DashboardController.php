<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $banners = Banner::where('destroy', 0)->orderBy('order')->get();
        $services = Service::where('destroy', 0)->orderBy('order')->get();
        $projects = Project::where('destroy', 0)->orderBy('order')->get();
        $customers = Customer::where('destroy', 0)->orderBy('order')->get();
        return view('admin-panel.dashboard.index', compact(['banners','services', 'projects','customers']));
    }
}
