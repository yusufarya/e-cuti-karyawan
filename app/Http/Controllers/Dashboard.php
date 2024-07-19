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
    
        $registrant_group = DB::table('emp_leaves')
                                ->select('emp_leaves.id', 'emp_leaves.leave_type','emp_leaves.created_at', 'employees.fullname' 
                                )
                                ->join('employees', 'employees.nik', '=', 'emp_leaves.emp_nik')
                                ->orderBy('emp_leaves.id', 'desc')
                                ->limit(3)
                                ->get();
        
        $countEmployee = Employee::count();

        $cur_route = Route::current()->uri();
        $data = Auth::guard('admin')->user();
        return view('admin-page.dashboard', [
            'title' => 'Dashboard',
            'cur_page' => $cur_route,
            'auth_user' => $data,
            'total_emp' => DB::table('employees')->count(),
            'total_cuti' => DB::table('emp_leaves')->where('leave_type', 'CUTI')->count(),
            'total_izin' => DB::table('emp_leaves')->where('leave_type', 'IZIN')->count(),
            'total_sakit' => DB::table('emp_leaves')->where('leave_type', 'SAKIT')->count(),
            'registrant_group' => $registrant_group,
            'countEmployee' => $countEmployee,
        ]);
    }
}
