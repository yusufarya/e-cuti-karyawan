<?php

namespace App\Http\Controllers\FE;

use App\Models\Registrant;
use App\Models\Employee;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    function index() {
        return view('user-page/auth/register', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'fullname'      => 'required|max:90',
            'username'      => 'required|max:30|unique:employees',
            'gender'        => 'required',
            'no_telp'       => 'required|numeric',
            'email'         => 'required|email|unique:employees',
            'password'      => 'required|confirmed|min:6|max:255',
            'password_confirmation' => 'required|min:6|max:255'
        ]);

        $validatedData['fullname'] = ucwords($validatedData['fullname']);
        $validatedData['number'] = $this->getLasNumber();
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = $validatedData['username'];
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['is_active'] = "Y";
        $validatedData['employee'] = "Y";
        // dd($validatedData);
        $result = Employee::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/login');
        } else {
            $request->session()->flash('success', 'Proses gagal, Hubungi administrator');
            return redirect('/register');
        }
    }

    function login() {
        return view('user-page.auth.login', [
            'title' => 'Login'
        ]);
    }

    public function loginValidation(Request $request) {

        $credentials = $request->validate([
            'email'  => 'required',
            'password'  => 'required'
        ]);
        // dd($credentials);
        $resultUser = Employee::where('email', $credentials['email'])->count();

        if(!$resultUser) {
            $request->session()->flash('failed', 'Akun tidak terdaftar.');
            return redirect('/login');
        }
        // dd(auth('employee'));
        if (auth('employee')->attempt($credentials)) {

            $isActive = Auth::guard('employee')->user()->is_active == "Y";
            if ($isActive == true) {
                return redirect()->intended('/home');
            } else {
                Auth::guard('employee')->logout();
                $request->session()->flash('failed', 'Akun belum aktif, Hubungi Administrator.');
                return redirect('/login');
            }
        }

        return back()->with('failed', 'Username atau Password salah!');
    }

    function getLasNumber() {

        $lastNumber = Employee::max('number');

        if($lastNumber) {
            $lastNumber = substr($lastNumber, -4);
            $code_ = sprintf('%04d', $lastNumber+1);
            $numberFix = "EM".date('Ymd').$code_;
        } else {
            $numberFix = "EM".date('Ymd')."0001";
        }

        return $numberFix;
    }

    // USER PROFILE - PARTICIPANT (PESERTA) //

    function profile() {
        $filename = 'profile';
        $filename_script = getContentScript(false, $filename);

        if(!auth('employee')->user()) {
            return redirect('/login');
        }

        $employee = new Employee;
        $data = $employee->getUserProfile();

        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Profil Saya',
            'auth_user' => $data
        ]);
    }

    function updateProfile() {
        $filename = 'update_profile';
        $filename_script = getContentScript(false, $filename);

        $nik = Auth::guard('employee')->user()->nik;
        $data = Employee::where('nik', $nik)->first();

        // $subDistrict = SubDistrict::get();
        return view('user-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Profil Saya',
            'auth_user' => $data,
            // 'subDistrict' => $subDistrict
        ]);
    }

    function updateProfileData(Request $request, string $nik) {
        // dd($request);
        $validatedData = $request->validate([
            'fullname'    => 'required|max:100',
            'username'    => 'required|max:30',
            'email'    => 'required|email|max:100',
            'phone'    => 'required|max:15',
            'place_of_birth'    => 'required|max:30',
            'date_of_birth'    => 'required',
            'address'            => 'required|max:200',
            'religion'          => 'required|max:20',
            'material_status'    => 'required|max:30',
            // 'sub_district'    => 'required|max:100',
            // 'village'    => 'required|max:100',
            'image'     => 'image|file|max:1024',
        ]);

        if($request->nik != $request->nik1) {
            $validatedData = $request->validate([
                'nik'    => 'required|max:16|unique:employees',
            ]);
        }
        if($request->email != $request->email1) {
            $validatedData = $request->validate([
                'email'    => 'required|max:100|email|unique:employees',
            ]);
        }
        if($request->username != $request->username1) {
            $validatedData = $request->validate([
                'username'    => 'required|max:100|unique:employees',
            ]);
        }

        $getData = Employee::find($nik);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('profile-images');
            $is_valid_image = true;
        } else if ($getData->image) {
            $is_valid_image = true;
        } else {
            $is_valid_image = false;
            $request->session()->flash('image', 'Pas Foto belum di upload');
        }

        if(!$is_valid_image) {
            return redirect('/update-profile');
        }

        if($request->file('image')) {
            if($validatedData['image'] && $getData->image) {
                Storage::delete($getData->image);
            }
        }
        $validatedData['fullname'] = ucwords($request['fullname']);
        $validatedData['username'] = strtolower($request['username']);
        $validatedData['email'] = strtolower($request['email']);
        $validatedData['phone'] = $request['phone'];
        $validatedData['place_of_birth'] = ucwords($request['place_of_birth']);
        $validatedData['date_of_birth'] = $request['date_of_birth'];
        $validatedData['address'] = ucwords($request['address']);
        $validatedData['religion'] = $request['religion'];
        $validatedData['material_status'] = $request['material_status'];
        // $validatedData['sub_district'] = $request['sub_district'];
        // $validatedData['village'] = $request['village'];
        // dd($validatedData);
        $result = Employee::where(['nik'=> $nik])->update($validatedData);
        if($result) {
            $request->session()->flash('success', 'Data Berhasil diperbaharui');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/_profile');
    }

    // LOGOUT PARTICIPANT //
    function logout(Request $request) {
        Auth::guard('employee')->logout();

        $request->session()->flash('success', 'Anda berhasil logout');
        return redirect('/login');
    }
}
