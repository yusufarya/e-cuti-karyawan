
@extends('user-page.layouts.user_main')

@section('content-pages')
<?php 
// dd($auth_user->date_of_birth);
$date_of_birth = $auth_user->date_of_birth ? date('d, M Y', strtotime($auth_user->date_of_birth)) : '-- / -- / ----';
?>
<hr>
<div class="rounded-2 shadow p-5">
    <div class="row justify-content-center w-100 p-3">
        <h3 class="text-center mb-4"><b> {{ $auth_user->fullname }} </b></h3>
        <div class="col-lg-3">
            <div style=" width: 300px; height: 290px; overflow: hidden;">
                @if(!$auth_user->image)
                    <img src="{{ asset('img/userDefault.png') }}" class="shadow mb-2" style="width : 100%; height:100%; object-fit: cover; background-position: center; background-size: cover;" alt="User Image">
                @else
                    <img src="{{ asset('/storage').'/'.$auth_user->image }}" class="shadow mb-2" style="width : 100%; height:100%; object-fit: cover; background-position: center; background-size: cover;" alt="User Image">
                @endif
            </div>
            <span class="text-left"><small class="pt-2">Bergabung sejak, {{ date('d, M Y', strtotime($auth_user->created_at)) }}</small></span>
        </div>
        <div class="col-1"></div>
        <div class="col-lg-8">
            
            <table class="table table-info">
                <tr>
                    <th style="width: 30%;">Nomor Peserta</th>
                    <td><b> : &nbsp; {{ $auth_user->nik }}</b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">Username</th>
                    <td><b> : &nbsp; {{ $auth_user->username }}</b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">Jenis Kelamin</th>
                    <td><b> : &nbsp; {{ $auth_user->gender == "M" ? "Laki-laki" : "Perempuan" }}</b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">No. Telp</th>
                    <td><b> : &nbsp; {{ $auth_user->phone }}</b></td>
                </tr>
                
                <tr>
                    <th style="width: 30%;">Tempat Tanggal Lahir</th>
                    <td>
                        <b> : &nbsp; 
                        {{ $auth_user->place_of_birth.', '. $date_of_birth }}
                        </b>
                    </td>
                </tr>
                <tr>
                    <th style="width: 30%;">Email</th>
                    <td><b> : &nbsp; {{ $auth_user->email }}</b></td>
                </tr>
            </table>
            <div class="mx-0">
                <button type="button" class="btn btn-outline-primary py-1" id="see-more">Tampilkan lebih banyak <i class="fas fa-chevron-down ms-2"></i></button>
                <button type="button" class="btn btn-outline-secondary py-1" id="see-less">Tutup<i class="fas fa-chevron-up ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="p-3 rounded-2 shadow mt-0 w-100" id="additional-data">
    <div class="row">
        <div class="col">
            <label class="my-3 py-1 alert alert-danger" ><b>Data lainnya</b></label>
            <hr class="p-0 m-0">
            <table class="table">
                <tr>
                    <th style="width: 30%;">Agama</th>
                    <td><b> : &nbsp; {{ $auth_user->religion }} </b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">Status Pernikahan</th>
                    <td><b> : &nbsp; {{ $auth_user->material_status }} </b></td>
                </tr>
                <tr>
                    <th style="width: 30%;">Alamat Lengkap</th>
                    <td><b> : &nbsp; {{ $auth_user->address }} </b></td>
                </tr>
            </table>
        </div>
    </div>

    <span>Untuk dapat melakukan pendaftaran pelatihan silahkan lengkapi data di atas. <a href="/update-profile">Lengkapi data.</a></span>
</div>

@endsection
