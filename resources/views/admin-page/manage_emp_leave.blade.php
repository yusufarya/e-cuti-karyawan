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


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mx-2">
          <div class="row justify-content-end mb-2 w-100">
            
          </div>
          
          <table class="table table-bordered table-sm">
              <thead>
                  <tr class="my-bg-primary text-white">
                      <th style="width: 11%">Nik</th>
                      <th>Nama</th>
                      <th style="width: 11%">Total</th>
                      <th style="width: 11%">Digunakan</th>
                      <th style="width: 11%">Tersisa</th>
                      <th>Periode </th>
                      <th style="width: 8%; text-align: center;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($resultData as $row)
                  <tr>
                      <td>
                        <a href="/detail-participant-appr/{{ $row->emp_nik }}/{{$row->id}}" class="text-info">
                          {{$row->emp_nik}}
                        </a>
                      </td>
                      <td>{{ $row->employee->fullname }}</td>
                      <td>{{ $row->total }}</td>
                      <td>{{ $row->used }}</td>
                      <td>{{ $row->total - $row->used }}</td>
                      <td>{{ $row->year }}</td>
                      <td style=" text-align: center;">
                        <a href="#" onclick="approve(`{{$row->id}}`, `{{$row->emp_nik}}`, `{{$row->employee->fullname}}`, `{{$row->total}}`, `{{$row->used}}`)" class="text-warning">
                            <i class="fas fa-user-edit"></i>
                          </a>
                      </td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
    </div>
</section> 

<div class="modal fade" id="modal-edit" tabindex="-1">
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
        <div class="modal-body p-3">
          <div class="row" id="content-edit">
            
            <div class="col-md-12">
                <label for="total">Total Cuti</label>
                <input type="text" name="total" id="total" class="form-control">
            </div>
            <div class="col-md-12">
                <label for="used">Digunakan</label>
                <input type="text" name="used" id="used" class="form-control">
            </div>
            <div class="col-md-12">
                <label for="over">Tersisa</label>
                <input type="text" name="over" id="over" class="form-control">
            </div>
          </div>
        </div> 
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-success">Ya</button>
        </div>
      </form>
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