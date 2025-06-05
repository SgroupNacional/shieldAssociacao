<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usersCount = User::count();
        $rolesCount = Role::count();
        $usersByRole = Role::withCount('users')->get();

        return view('dashboard', compact('usersCount', 'rolesCount', 'usersByRole'));
    }
}
