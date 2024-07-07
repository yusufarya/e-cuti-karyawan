@extends('admin-page.layouts.main_layout')

@section('content-pages')

<div class="content-header">
  <div class="container-fluid">
    <div class="row my-2">
      <div class="col-sm-6">
        <h3 class="m-0 ml-2">Detail Pengajuan {{ ucwords($resultData->leave_type) }}</h3>
      </div><!-- /.col --> 
    </div><!-- /.row -->
    <hr style="margin-bottom: 0">
  </div><!-- /.container-fluid -->
</div>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mx-2">
          
            <div class="col-lg-7">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Nik</th>
                        <td>{{ $resultData->employee->nik }} </td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $resultData->employee->fullname }} </td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $resultData->employee->gender == 'M' ? 'Laki-laki' : 'Perempuan' }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">No. Telp</th>
                        <td> {{ $resultData->employee->phone }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">Dari Tanggal</th>
                        <td> {{ date('d-m-Y', strtotime($resultData->start_date)) }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">Sampai Tanggal</th>
                        <td> {{ date('d-m-Y', strtotime($resultData->end_date)) }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">Jenis Pengajuan</th>
                        <td> {{ $resultData->leave_type }} </td>
                    </tr>
                    <tr>
                        <th style="width: 30%;">Alasan</th>
                        <td> {{ $resultData->reason }} </td>
                    </tr>
                    
                    <tr>
                        <th style="width: 30%;">Lampiran</th>
                        @if ($resultData->file)
                            <td><b> : &nbsp; <a href="{{asset('/storage/'.$resultData->file)}}" target="_blank">Lihat file</a> </b></td>
                        @else
                            <td> : &nbsp; - </td>
                        @endif
                    </tr>
                </table>
            </div>

            <div class="col-lg-5">
                <table class="table table-bordered table-sm">

                    <th style="width: 40%;">Status Persetujuan 1</th>
                    <td style="text-align: left;">
                    @php
                        if($resultData->approved1 == 'X') {
                            $status1 = 'Menunggu Persetujuan';
                            $color = "text-success";
                        } else if($resultData->approved1 == 'Y') {
                            $status1 = 'Pengajuan Disetujui';
                            $color = "text-primary";
                        } else if($resultData->approved1 == 'N') {
                            $status1 = 'Pengajuan Ditolak';
                            $color = "text-danger";
                        }
                    @endphp
                    <span class={{ $color }} > {{ $status1 }} </span>
                    <tr>
                        <th style="width: 40%;">Oleh</th>
                        <td>{{ $resultData->approved1_by }}</td>
                    </tr>
                    <th style="width: 40%;">Status Persetujuan 2</th>
                    <td style="text-align: left;">
                    @php
                        if ($resultData->approved2 == 'X') {
                            $status2 = 'Menunggu Persetujuan ke 2';
                            $color = "text-success";
                        } else
                        if ($resultData->approved2 == 'Y') {
                            $status2 = 'Pengajuan Disetujui';
                            $color = "text-success";
                        } else
                        if ($resultData->approved2 == 'N') {
                            $status2 = 'Pengajuan Ditolak Persetujuan ke 2';
                            $color = "text-danger";
                        }
                    @endphp
                    <span class={{ $color }} > {{ $status2 }} </span>
                    <tr>
                        <th style="width: 40%;">Oleh</th>
                        <td>{{ $resultData->approved2_by }}</td>
                    </tr>

                    @php
                        if($resultData->leave_type == 'CUTI') {
                            $path = 'e-cuti';
                        } else if($resultData->leave_type == 'IZIN') {
                            $path = 'e-izin';
                        } else if($resultData->leave_type == 'SAKIT') {
                            $path = 'e-sakit';
                        }
                    @endphp
                    <tr>
                        <td colspan="2"><a href="/{{$path}}" class="btn btn-outline-info py-1 float-right w-full">Keluar <i class="fas fa-share-square"></i> </a></td>
                    </tr>
                    

                </table>
            </div>

        </div>
    </div>
</section> 

<div class="modal fade" id="modal-reset-password" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title ml-2 font-weight-bold">Reset Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="/reset-password/{{ $resultData->number }}">
          @csrf
          @method('PUT')
          <div class="modal-body mx-3 px-3">
            <div class="row">
              <label for="label">Kata Sandi Baru</label>
              <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi baru" required>
            </div>
          </div> 
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
