<?php

namespace App\Http\Controllers;

use App\Models\EmpLeave;
use Illuminate\Http\Request;
use App\Models\CalculateEmpLeave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubmissionDataController extends Controller
{
    // CUTI
    function e_cuti() {
        $filename = 'e_submission';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $resultData = EmpLeave::with('employee')->where('leave_type', 'CUTI')->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pengajuan Cuti',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }
    
    // IZIN
    function e_izin() {
        $filename = 'e_submission';
        $filename_script = getContentScript(true, $filename);
        
        $data = Auth::guard('admin')->user();  
        $resultData = EmpLeave::with('employee')->where('leave_type', 'IZIN')->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pengajuan Izin',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }
    
    // SAKIT
    function e_sakit() {
        $filename = 'e_submission';
        $filename_script = getContentScript(true, $filename);
        
        $data = Auth::guard('admin')->user();
        $resultData = EmpLeave::with('employee')->where('leave_type', 'SAKIT')->get();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pengajuan Sakit',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function detail_submission($id) {

        $filename = 'e_submission_detail';
        $filename_script = getContentScript(true, $filename);
        
        // Fetch the updated record
        $resultData = EmpLeave::with('employee')->where('id', $id)->first();

        $data = Auth::guard('admin')->user();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pengajuan Sakit',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function detail_submission_nik($nik) {

        $filename = 'e_submission_detail';
        $filename_script = getContentScript(true, $filename);
        
        // Fetch the updated record
        $resultData = EmpLeave::with('employee')->where('emp_nik', $nik)->first();

        $data = Auth::guard('admin')->user();
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Pengajuan Sakit',
            'auth_user' => $data,
            'resultData' => $resultData
        ]);
    }

    function acc_submission(Request $request) {
        $id = $request->id;
        $user = Auth::guard('admin')->user();
        if($user->level_id == 1) {
            $params = [
                'approved1' => 'Y',
                'approved1_by' => $user->username
            ];
        } else if($user->level_id == 2) {
            $params = [
                'approved2' => 'Y',
                'approved2_by' => $user->username
            ];
        }
        // Update the record
        DB::table('emp_leaves')
        ->where('id', $id)
        ->update($params);

        // Fetch the updated record
        $updatedData = DB::table('emp_leaves')
        ->where('id', $id)
        ->first();
        
        if($updatedData->leave_type == 'CUTI') {
            $path = 'e-cuti';
        } else if($updatedData->leave_type == 'IZIN') {
            $path = 'e-izin';
        } else if($updatedData->leave_type == 'SAKIT') {
            $path = 'e-sakit';
        }

        if($user->level_id == 2) {
            $data = CalculateEmpLeave::where('emp_nik', $updatedData->emp_nik)->first();

            if ($data) {
                $data->used = $data->used+1;
                $data->over = $data->total - $data->used;
                $data->updated_at = now();

                $data->save();
            }

        }
        
        return redirect($path);

    }

    function reject_submission(Request $request) {
        $id = $request->id;
        $user = Auth::guard('admin')->user();

        // Update the record
        DB::table('emp_leaves')
        ->where('id', $id)
        ->update([
            'approved1' => 'N',
            'approved1_by' => $user->username
        ]);

        // Fetch the updated record
        $updatedData = DB::table('emp_leaves')
        ->where('id', $id)
        ->first();
        
        if($updatedData->leave_type == 'IZIN') {
            $path = 'e-cuti';
        } else if($updatedData->leave_type == 'IZIN') {
            $path = 'e-izin';
        } else if($updatedData->leave_type == 'SAKIT') {
            $path = 'e-sakit';
        }
        
        return redirect($path);

    }
}
