<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\CalculateEmpLeave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller {

    // function getVillages(Request $request) {
    //     $data = Village::where(['sub_district_id' => $request->sub_district_id])->get();
    //     echo json_encode($data);
    // }

    function getTrainings(Request $request) {
        $data = Training::where(['category_id' => $request->category_id])->get();
        echo json_encode($data);
    }

    function getRegistrant(Request $request) {
        $result = Registrant::where(['training_id' => $request->training_id])->get();
        echo json_encode($result);
    }

    function manage_leave_emp() {
        $filename = 'manage_emp_leave';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();
        if($data->level_id == 1) {
            $admin = User::with('user_level')->get();
        } else if($data->level_id == 2) {
            $admin = User::with('user_level')->where('level_id', 2)->get();
        }

        $count = CalculateEmpLeave::where('year', date('Y'))->get()->count();
        $getEmp = Employee::get();
        foreach ($getEmp as $emp) {
            $countLeave = CalculateEmpLeave::where(['year' => date('Y'), 'emp_nik' => $emp->nik])->get()->count();

            if($count == 0 OR $countLeave == 0) {
                $data = new CalculateEmpLeave;
                $data->emp_nik = $emp->nik;
                $data->total = 12;
                $data->used = 0;
                $data->over = 0;
                $data->year = date('Y');
                $data->created_at = date('Y-m-d');

                $data->save();
            }
        }

        $getData = CalculateEmpLeave::with('employee')->where('year', date('Y'))->get();

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Cuti Karyawan',
            'auth_user' => $data,
            'resultData' => $getData
        ]);
    }

    function update_manage_leave(Request $request, $nik) {
        $data = CalculateEmpLeave::where('emp_nik', $nik)->first();

        if ($data) {
            $data->total = $request->total;
            $data->used = $request->used;
            $data->over = $request->total - $request->used;
            $data->updated_at = now();

            $data->save();
        } else {
            return redirect('/manage-leave-emp')->withErrors('Record not found.');
        }

        return redirect('/manage-leave-emp');
    }

    function submissionReport() {
        $filename = 'report_employee';
        $filename_script = getContentScript(true, $filename);

        $admin = Auth::guard('admin')->user();
        $employee = Employee::get();

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Laporan Pengajuan',
            'auth_user' => $admin,
            'employee' => $employee,
        ]);
    }

    // PENGAJUAN (REPORT SUBMISSION)
    function submissionRpt(Request $request) {

        if($request->fullname) {
            if($request->session()->get('fullname') != $request->fullname) {
                session()->forget('fullname');
            }
            $request->session()->push('fullname', $request->fullname);
        } else {
            session()->forget('fullname');
        }

        if($request->gender) {
            if($request->session()->get('gender') != $request->gender) {
                session()->forget('gender');
            }
            $request->session()->push('gender', $request->gender);
        } else {
            session()->forget('gender');
        }

        if($request->sub_district) {
            if($request->session()->get('sub_district') != $request->sub_district) {
                session()->forget('sub_district');
            }
            $request->session()->push('sub_district', $request->sub_district);
        } else {
            session()->forget('sub_district');
        }

        if($request->year) {
            if($request->session()->get('year') != $request->year) {
                session()->forget('year');
            }
            $request->session()->push('year', $request->year);
        } else {
            session()->forget('year');
        }

        echo json_encode('{}');
    }

    function openSubmissionRpt(Request $request) {
        $where = ['employees.is_active' => 'Y'];

        if($request->session()->get('fullname')) {
            $where['employees.nik'] = $request->session()->get('fullname')[0];
        }
        if($request->session()->get('gender')) {
            $where['employees.gender'] = $request->session()->get('gender')[0];
        }
        if($request->session()->get('year')) {
            $year = $request->session()->get('year')[0];
        } else {
            $year = '';
        }

        // dd($where);

        $data = DB::table('employees')
            ->select('employees.*', 'emp_leaves.start_date', 'emp_leaves.end_date', 'emp_leaves.leave_type', 'emp_leaves.approved1', 'emp_leaves.approved1_by', 'emp_leaves.approved2', 'emp_leaves.approved2_by')
            ->join('emp_leaves', 'employees.nik', '=', 'emp_leaves.emp_nik')
            ->where($where)
            ->where('employees.created_at', 'LIKE', '%' . $year . '%')
            ->get();
        $count = DB::table('employees')
            ->select('employees.*', 'emp_leaves.start_date', 'emp_leaves.end_date', 'emp_leaves.leave_type', 'emp_leaves.approved1', 'emp_leaves.approved1_by', 'emp_leaves.approved2', 'emp_leaves.approved2_by')
            ->join('emp_leaves', 'employees.nik', '=', 'emp_leaves.emp_nik')
            ->where($where)
            ->where('employees.created_at', 'LIKE', '%' . $year . '%')
            ->count();

        return view('admin-page.report.submission_rpt', [
            'title' => 'Laporan Pengajuan',
            'data' => $data,
            'count' => $count,
        ]);
    }

}
