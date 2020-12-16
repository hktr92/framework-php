<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;
use App\Http\Model\Auth;

class DashboardController extends Controller
{
    public function dashboardView(): void
    {
        Template::view('dashboard.html');
    }
}
