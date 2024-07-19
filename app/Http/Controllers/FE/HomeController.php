<?php

namespace App\Http\Controllers\FE;

use App\Models\EmpLeave;
use Illuminate\Http\Request;
use App\Models\CalculateEmpLeave;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function index() {
        return view('user-page/index', [
            'title' => 'Home',
            // 'category' => $category,
            'brand_name' => 'E-CUTI'
        ]);
    }

    function submission() {
        // $submission = Post::with('picturePost')->orderBy('id', 'DESC')->get();
        $dataCuti = CalculateEmpLeave::where('emp_nik', auth()->guard('employee')->user()->nik)->first();
        
        return view('user-page/submissions', [
            'title' => 'Pengajuan',
            'submissions' => [],
            'dataCuti' => $dataCuti,
            'brand_name' => 'E-CUTI'
        ]);
    }

    function storeSubmission(Request $request) {
        
        $validatedData = $request->validate([
            'emp_nik'      => 'required|max:20',
            'start_date'        => 'required',
            'end_date'        => 'required',
            'leave_type'      => 'required',
            'reason'       => 'required|max:200',
            'file'     => 'image|file|max:1024',
        ]);

        if($request->file('attachment')) {
            $validatedData['file'] = $request->file('attachment')->store('attachment');
        }
        
        // dd($validatedData);
        $result = EmpLeave::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/riwayat');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/pengajuan');
        }
    }

    function detailSubmission(int $id) {
        $resultData = EmpLeave::with('employee')->where('id', $id)->first();

        return view('user-page/detail_submission', [
            'title' => 'Detail Pengajuan',
            'resultData' => $resultData,
            'brand_name' => 'E-CUTI'
        ]);
    }

    function histories() {
        $emp_nik = Auth::guard('employee')->user()->nik;
        $submission = EmpLeave::with('employee')->where('emp_nik', $emp_nik)->orderBy('id', 'DESC')->get();
        
        return view('user-page/histories', [
            'title' => 'Riwayat Pengajuan',
            'histories' => $submission,
            'brand_name' => 'E-CUTI'
        ]);
    }
}
