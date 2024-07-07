<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Dashboard extends Controller
{
    
    public function __construct(protected Admin $admin) {
        $user = Auth::guard('admin')->user();
    }
    
    function index() {
    
        $registrant_group = DB::table('employees')
                                ->select('sub_districts.name AS sub_district_name', DB::raw('count(employees.sub_district) as count'))
                                ->join('sub_districts', 'sub_districts.id', '=', 'employees.sub_district')
                                ->groupBy('sub_districts.name')
                                ->get();

        $countEmployee = Employee::count();

        $cur_route = Route::current()->uri();
        $data = Auth::guard('admin')->user();
        return view('admin-page.dashboard', [
            'title' => 'Dashboard',
            'cur_page' => $cur_route,
            'auth_user' => $data,
            'pendaftarBaru' => DB::table('employees')->count(),
            'registrant_group' => $registrant_group,
            'countEmployee' => $countEmployee,
        ]);
    }
}
