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
            <div class="col-lg-8 elevation-1 p-4">
                <form action="" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mt-2">
                                <label for="fullname" class="ml-1">Nama Karyawan</label>
                                <select class="select-fullname form-control" name="fullname" id="fullname">
                                    <option value="">Semua Karyawan</option>
                                    @foreach ($employee as $item)
                                        <option value="{{ $item->nik }}"> » &nbsp; {{ $item->nik .' - '. $item->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 mt-2">
                                <label for="gender" class="ml-1">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control form-select">
                                    <option value="">Semua Jenis Kelamin</option>
                                    <option value="M">Laki-laki</option>
                                    <option value="F">Perempuan</option>
                                </select>
                            </div>
                            {{-- <div class="col-lg-6 col-md-6">
                                <label class="font-weight-normal ml-1">Selesai</label>
                                <input type="date" class="form-control" name="end_date" value="{{ $item->end_date }}" readonly>
                            </div> --}}
                            <div class="col-lg-6 col-md-6 mt-2">
                                <label for="year" class="ml-1">Tahun</label>
                                <select name="year" id="year" class="form-control form-select"></select>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-warning ml-3" id="submitRpt" style="float: right;"> 
                        <i class="fas fa-search mr-1"></i> Submit
                    </button> 
                </form>
            </div>
        </div>
    </div>

</section> 
    
@endsection