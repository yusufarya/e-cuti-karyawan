<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    function dataEmployee() {
        $filename = 'data_employee';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $dataEmployee = Employee::orderBy('created_at', 'desc')->get(); 
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data Employee',
            'auth_user' => $data,
            'dataEmployee' => $dataEmployee
        ]);
    }

    function addFormEmployee() {
        $filename = 'add_new_karyawan';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $user = User::with('user_level')->get();  
        $user_level = UserLevel::get();  
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Data Employee',
            'auth_user' => $data,
            'level_id' => $user_level
        ]);
    }

    function storeEmployee(Request $request) {
        // dd($request);
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30|unique:users',
            'gender'        => 'required',
            // 'level_id'        => 'required',
            'place_of_birth'    => 'required|max:40',
            'date_of_birth'     => 'required',
            'phone'       => 'required|max:15',
            'email'         => 'required|max:100|email|unique:users',
            'password'      => 'required|min:6|max:255',
            'images'     => 'image|file|max:1024',
        ]);

        if($request->file('images')) {
            $validatedData['images'] = $request->file('images')->store('profile-images');
        }
        
        $validatedData['nik'] = getLasNumberEmp();
        $validatedData['address'] = $request['address'];
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = Auth::guard('admin')->user()->username;
        $validatedData['password'] = Hash::make($validatedData['password']);
        // $validatedData['level_id'] = $validatedData['level_id'];
        $validatedData['is_active'] = $request['is_active'] ? "Y" : "N";
        // dd($validatedData);
        $result = Employee::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/data-karyawan');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/form-add-karyawan');
        }
        
    }

    function editFormEmployee($nik) {
        $filename = 'edit_new_karyawan';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();
        $data_employee = Employee::find($nik);
        $user_level = UserLevel::get();  
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Edit Data Employee',
            'auth_user' => $data,
            'data_employee' => $data_employee,
            'level' => $user_level
        ]);
    }

    function updateEmployee(Request $request) {
        // dd($request);
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30',
            'gender'        => 'required',
            // 'level_id'        => 'required',
            'place_of_birth'    => 'required|max:40',
            'date_of_birth'     => 'required',
            'phone'       => 'required|max:15',
            'images'     => 'image|file|max:1024',
        ]);
        
        $username_exist = false;
        if($request['username1'] != $request['username']) {
            $username_exist = User::where('username', $request['username'])->first();
        }
        
        if($request->file('images')) {
            $validatedData['images'] = $request->file('images')->store('profile-images');
        }

        $validatedData['nik'] = $request['nik'];
        $validatedData['address'] = $request['address'];
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_by'] = Auth::guard('admin')->user()->username;
        if($request['password']) {
            $validatedData['password'] = Hash::make($request['password']);
        }
        // $validatedData['level_id'] = $validatedData['level_id'];
        $validatedData['is_active'] = $request['is_active'] ? "Y" : "N";
        
        if($username_exist === false) {
            $result = Employee::where(['nik' => $validatedData['nik']])->update($validatedData);
            
            if($result) {
                $request->session()->flash('success', 'Akun berhasil dibuat');
                return redirect('/data-karyawan');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
                return redirect('/form-edit-karyawan/'.$validatedData['nik']);
            }
        } else {
            $request->session()->flash('failed', 'Username sudah ada');
            return redirect('/form-edit-karyawan/'.$validatedData['nik']);
        }

    }

    function deleteEmployee(Request $request, string $nik) {

        if(auth()->guard('admin')->user()->nik == $nik) {
            $request->session()->flash('failed', 'Proses gagal, Anda tidak dapat menghapus akun anda sendiri');
            return redirect('/data-karyawan');
        }
        $data = User::find($nik);

        if($data->image) {
            Storage::delete($data->image);
        }

        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-karyawan');
    }
}
