@extends('admin-page.layouts.main_layout')

@section('content-pages')

<div class="content-header">
  <div class="container-fluid">
    <div class="row my-2">
      <div class="col-sm-6">
        <h3 class="m-0 ml-2">{{ $title }} </h3>
      </div><!-- /.col --> 
    </div><!-- /.row -->
    <hr style="margin-bottom: 0">
  </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mx-2">
          <div class="row justify-content-end mb-2 w-100">
            {{-- <a href="/add-data-admin" class="btn float-right btn-add "><i class="fas fa-plus-square"></i> &nbsp; Data</a> --}}
            @if (session()->has('success'))
              <div class="alert alert-success py-1" id="success">
                <?= session()->get('success') ?>
              </div>
            @endif
            @if (session()->has('message'))
              <div class="alert alert-warning py-1" id="message">
                <?= session()->get('message') ?>
              </div>
            @endif
          </div>
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 12.5%">Nik</th>
                      <th>Nama Lengkap</th>
                      <th>Dari Tanggal</th>
                      <th>Sampai Tanggal</th>
                      <th style="width: 15%; text-align: center;">Status</th>
                      <th style="width: 7%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($resultData as $row)
                  <tr>
                      <td>{{ $row->employee->nik }}</td>
                      <td>{{ $row->employee->fullname }}</td>
                      <td>{{ date('d-m-Y', strtotime($row->start_date)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($row->end_date)) }}</td>
                      <td style="text-align: center;">
                        @php
                            if($row->approved1 == 'X') {
                                $status1 = 'Menunggu Persetujuan';
                                $color = "text-success";
                            } else if($row->approved1 == 'Y') {
                                $status1 = 'Pengajuan Disetujui';
                                $color = "text-primary";
                                if ($row->approved2 == 'X') {
                                    $status1 = 'Menunggu Persetujuan ke 2';
                                    $color = "text-success";
                                } else
                                if ($row->approved2 == 'Y') {
                                    $status1 = 'Pengajuan Disetujui';
                                    $color = "text-success";
                                } else
                                if ($row->approved2 == 'N') {
                                    $status1 = 'Pengajuan Ditolak Persetujuan ke 2';
                                    $color = "text-danger";
                                }
                            } else if($row->approved1 == 'N') {
                                $status1 = 'Pengajuan Ditolak';
                                $color = "text-danger";
                            }
                        @endphp
                        <span class={{ $color }} > {{ $status1 }} </span>
                      </td>
                      <td style=" text-align: center;">
                        <div class="row justify-content-center">
                          <div class="dropdown">
                            <a href="#" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              Detail
                              {{-- <i class="fas fa-edit"></i> --}}
                            </a>
                            <div class="dropdown-menu px-2" style="min-width: 90px;">
                              <a href="/detail-submission/{{ $row->id }}" class="text-info"> 
                                <i class="fas fa-info-circle"></i>
                                Detail 
                              </a><br>
                              @if ($row->approved1 == 'N')
                                <span class="badge bg-danger">
                                  <i class="fas fa-times">&nbsp; Ditolak</i>
                                </span>
                              @elseif ($auth_user->level_id == 1 && $row->approved1 == 'Y')
                                <span class="badge bg-success">
                                  <i class="fas fa-check">&nbsp; Approved</i>
                                </span>
                              @elseif ($auth_user->level_id == 2 && $row->approved2 == 'Y')
                                <span class="badge bg-success">
                                  <i class="fas fa-check">&nbsp; Approved</i>
                                </span>
                              @else
                                <a href="#" onclick="acc_data(`{{ $row->id }}`, `{{ $row->employee->fullname }}`, `{{ $row->leave_type }}`,)" class="text-success"> 
                                  <i class="fas fa-check"></i>
                                  Terima 
                                </a><br>
                                <a href="#" onclick="delete_data(`{{ $row->id }}`, `{{ $row->employee->fullname }}`, `{{ $row->leave_type }}`,)" class="text-danger"> 
                                  <i class="fas fa-times-circle"></i>
                                  Tolak 
                                </a><br>
                              @endif
                            </div>
                          </div>
                        </div>
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>
</section> 

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
        @method('POST')
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

<div class="modal fade" id="modal-acc" tabindex="-1">
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
        @method('POST')
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