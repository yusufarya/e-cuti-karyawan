<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use App\Models\Registrant;
use App\Models\Participant;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use App\Models\ParticipantWork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    function index() {
        $nip = Auth::guard('admin')->user()->nip;

        $data = User::with('user_level')->where(['nip' => $nip])->first();  
        
        return view('admin-page.profile', [
            'title' => 'Profile',
            'auth_user' => $data
        ]);
    }
    
    function dataAdmin() {
        $filename = 'data_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();
        if($data->level_id == 1) {
            $admin = User::with('user_level')->get();  
        } else if($data->level_id == 2) {
            $admin = User::with('user_level')->where('level_id', 2)->get();  
        } 

        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Data User',
            'auth_user' => $data,
            'dataAdmin' => $admin
        ]);
    }

    function getDetailUser(Request $request) {
        $nip = $request->nip;
        $data = User::with('user_level')->find($nip)->first();

        $data->address = $data->address ? $data->address : " - ";
        $data->place_of_birth = $data->place_of_birth ? $data->place_of_birth : " - ";
        $data->date_of_birth = $data->date_of_birth ? date('d-m-Y', strtotime($data->date_of_birth)) : " - - -";
        $data->created_at = date('d-m-Y', strtotime($data->created_at));
        $data->gender = $data->gender == "M" ? "Laki-laki" : "Perempuan";
        $data->level = $data->user_level->name;
        echo json_encode($data);
    }

    function addFormAdmin() {
        $filename = 'add_new_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $admin = User::with('user_level')->get();  
        $user_level = UserLevel::get();  
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Tambah Data User',
            'auth_user' => $data,
            'level_id' => $user_level
        ]);
    }

    function storeAdmin(Request $request) {
        // dd($request);
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30|unique:users',
            'gender'        => 'required',
            'level_id'        => 'required',
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
        
        $validatedData['nip'] = getLasNumberAdmin($validatedData['level_id']);
        $validatedData['address'] = $request['address'];
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['created_by'] = Auth::guard('admin')->user()->username;
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['level_id'] = $validatedData['level_id'];
        $validatedData['is_active'] = $request['is_active'] ? "Y" : "N";
        // dd($validatedData);
        $result = User::create($validatedData);
        if($result) {
            $request->session()->flash('success', 'Akun berhasil dibuat');
            return redirect('/data-admin');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
            return redirect('/form-add-admin');
        }
        
    }

    function editFormAdmin($nip) {
        $filename = 'edit_new_admin';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();
        $data_admin = User::find($nip);
        $user_level = UserLevel::get();  
        return view('admin-page.'.$filename, [
            'script' => $filename_script,
            'title' => 'Edit Data User',
            'auth_user' => $data,
            'data_admin' => $data_admin,
            'level' => $user_level
        ]);
    }

    function updateAdmin(Request $request) {
        
        $validatedData = $request->validate([
            'fullname'      => 'required|max:50',
            'username'      => 'required|max:30',
            'gender'        => 'required',
            'level_id'        => 'required',
            'place_of_birth'    => 'required|max:40',
            'date_of_birth'     => 'required',
            'phone'       => 'required|max:15',
            'images'     => 'image|file|max:1024',
        ]);
        // dd($validatedData);
        $username_exist = false;
        if($request['username1'] != $request['username']) {
            $username_exist = User::where('username', $request['username'])->first();
        }
        
        if($request->file('images')) {
            $validatedData['images'] = $request->file('images')->store('profile-images');
        }

        $validatedData['nip'] = $request['nip'];
        $validatedData['address'] = $request['address'];
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_by'] = Auth::guard('admin')->user()->username;
        if($request['password']) {
            $validatedData['password'] = Hash::make($request['password']);
        }
        $validatedData['level_id'] = $validatedData['level_id'];
        $validatedData['is_active'] = $request['is_active'] ? "Y" : "N";
        
        if($username_exist === false) {
            $result = User::where(['nip' => $validatedData['nip']])->update($validatedData);
            
            if($result) {
                $request->session()->flash('success', 'Akun berhasil dibuat');
                return redirect('/data-admin');
            } else {
                $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
                return redirect('/form-edit-admin/'.$validatedData['nip']);
            }
        } else {
            $request->session()->flash('failed', 'Username sudah ada');
            return redirect('/form-edit-admin/'.$validatedData['nip']);
        }

    }

    function deleteUser(Request $request, string $nip) {

        if(auth()->guard('admin')->user()->nip == $nip) {
            $request->session()->flash('failed', 'Proses gagal, Anda tidak dapat menghapus akun anda sendiri');
            return redirect('/data-admin');
        }
        $data = User::find($nip);

        if($data->image) {
            Storage::delete($data->image);
        }

        $result = $data->delete();
        if($result) {
            $request->session()->flash('success', 'Data berhasil dihapus');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/data-admin');
    }

    function registrantData() {
        $filename = 'data_participant';
        $filename_script = getContentScript(true, $filename);

        $data = Auth::guard('admin')->user();  
        $dataParticipants = Participant::get();
        return view('admin-page.'.$filename, [
            'candidate' => '',
            'script' => $filename_script,
            'title' => 'Data Pendaftar Akun',
            'auth_user' => $data,
            'dataParticipants' => $dataParticipants
        ]);
    }

    function resetPassword(Request $request, string $nip) {
        
        $password = Hash::make($request->password);

        $result = Participant::where('nip', $nip)->update(['password'=>$password]);
        
        if($result) {
            $request->session()->flash('success', 'Password baru berhasil disimpan');
        } else {
            $request->session()->flash('failed', 'Proses gagal, Hubungi administrator');
        }
        return redirect('/detail-participant/'.$nip);
    }
    
}
