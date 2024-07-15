@extends('admin-page.layouts.main_layout')

@section('content-pages')

<div class="content-header">
  <div class="container-fluid">
    <div class="row my-2">
      <div class="col-sm-6">
        <h3 class="m-0 ml-2">{{ $title}}</h3>
      </div><!-- /.col --> 
    </div><!-- /.row -->
    <hr style="margin-bottom: 0">
  </div><!-- /.container-fluid -->
</div>

<input type="hidden" id="valid" value="<?= session()->has('success') ?>">
<input type="hidden" id="invalid" value="<?= session()->has('failed') ?>">

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mx-2">
          @if (session()->has('failed'))
            <div class="alert alert-danger py-1">
              <?= session()->get('failed') ?>
            </div>
          @endif
          <div class="row justify-content-end mb-2 w-100" {{ $auth_user->level_id != 1 ? 'hidden' : '' }}>
            <a href="/form-add-karyawan" class="btn float-right btn-add "><i class="fas fa-plus-square"></i> &nbsp; Data</a>
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 13%">Nomor</th>
                      <th>Nama</th>
                      <th style="width: 11%">Jenis Kelamin</th>
                      <th style="width: 12%">No. Telp</th>
                      <th>Email</th>
                      <th style="width: 10%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($dataEmployee as $row)
                  <tr>
                      <td>{{ $row->nik }}</td>
                      <td>{{ $row->fullname }}</td>
                      <td>{{ $row->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                      <td>{{ $row->phone }}</td>
                      <td>{{ $row->email }}</td>
                      <td style=" text-align: center;" >
                        @if ($auth_user->level_id != 1)
                            <div class="text-danger"> <i class="fas fa-minus"></i> </div>
                        @else
                          <a href="/form-edit-karyawan/{{$row->nik}}" class="text-warning"><i class="fas fa-edit"></i></a>
                          &nbsp;
                          <a href="#" onclick="delete_data(`{{$row->nik}}`, `{{$row->name}}`)" class="text-danger"><i class="fas fa-trash-alt"></i></a>
                        @endif
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" id="notif-success">
        <div class="toast" style="position: absolute; top: 0; right: 0;">
          <div class="toast-header">
            <strong class="me-auto text-white">Berhasil</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            {{ session('success') }}
          </div>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" id="notif-failed">
        <div class="toast" style="position: absolute; top: 0; right: 0;">
          <div class="toast-header">
            <strong class="me-auto text-white">Proses Gagal</strong> 
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            {{ session('failed') }}
          </div>
        </div>
    </div>

</section> 

<div class="modal fade" id="modal-detail" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-3 font-weight-bold">Detail Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3">
        <div class="row">
          <div class="col-lg-3 px-1" style="max-width: 28%;">
            <img src="" class="imgProfile" alt="imgProfile" style="height: 210px;">
            <div id="since" class="text-center text-sm w-100"></div>
          </div>
          <div class="col-lg-8">
            <table class="table table-striped" id="tb-detail"></table>
          </div> 
        </div>
      </div> 
    </div>
  </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ml-2 font-weight-bold">Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-body p-3">
          <div class="row" id="content-delete">
            
          </div>
        </div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-primary">Ya</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection