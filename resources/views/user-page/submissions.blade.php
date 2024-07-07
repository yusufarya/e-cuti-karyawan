
@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4 px-3">
  
  <form action="/submission" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row shadow py-4 px-5">
      
      <div class="heading text-center ">
        <div class="mt-2">
          <span style="font-size: 26px; font-weight: 600">{{$title}}</span>
        </div>
      </div>
  
      <div class="col-lg-6 col-md-6 my-2">
        <label for="name">Nama Lengkap</label>
        <input type="text" readonly name="name" id="name" class="form-control" value="{{ auth()->guard('employee')->user()->fullname }}">
        <input type="hidden" name="emp_nik" id="emp_nik" class="form-control" value="{{ auth()->guard('employee')->user()->nik }}">
      </div>
      <div class="col-lg-6 col-md-6 my-2">
        <label for="name">Tipe</label>
        <select name="leave_type" id="leave_type" class="form-select @error('leave_type')is-invalid @enderror">
          <option value="">Pilih tipe</option>
          <option value="IZIN" {{ old('leave_type') == 'IZIN' ? 'selected' : '' }}>Izin</option>
          <option value="SAKIT" {{ old('leave_type') == 'SAKIT' ? 'selected' : '' }}>Sakit</option>
          <option value="CUTI" {{ old('leave_type') == 'CUTI' ? 'selected' : '' }}>Cuti</option>
        </select>
        @error('leave_type')
        <small class="invalid-feedback">
            Tipe {{ $message }}
        </small>
        @enderror
        
      </div>
  
      <div class="col-lg-6 col-md-6 my-2">
        <label for="start_date">Tanggal</label>
        <input type="date" name="start_date" id="start_date" class="form-control @error('start_date')is-invalid @enderror" value="{{ old('start_date') }}">
        @error('start_date')
        <small class="invalid-feedback">
            Tanggal {{ $message }}
        </small>
        @enderror
      </div>
      <div class="col-lg-6 col-md-6 my-2">
        <label for="end_date">S/D</label>
        <input type="date" name="end_date" id="end_date" class="form-control @error('end_date')is-invalid @enderror" value="{{ old('end_date') }}">
        @error('end_date')
        <small class="invalid-feedback">
            Tanggal S/D {{ $message }}
        </small>
        @enderror
      </div>
  
      <div class="col-lg-6 col-md-6 my-2">
        <label for="reason">Alasan</label>
        <textarea class="form-control @error('reason')is-invalid @enderror" name="reason" id="reason">{{ old('reason') }}</textarea>
        @error('reason')
        <small class="invalid-feedback">
            Alasan {{ $message }}
        </small>
        @enderror
      </div>

      <div class="col-lg-6 col-md-6 my-2">
        <label for="attachment">Lapiran</label>
        <input type="file" class="form-control @error('dile')is-invalid @enderror" name="attachment" id="attachment">
        @error('dile')
        <small class="invalid-feedback">
            Tipe {{ $message }}
        </small>
        @enderror
      </div>
  
      <div class="col-lg-12 col-md-12 my-2">
        <button type="submit" class="btn btn-success">Submit</button>
      </div>

    </div>
      
  </form>
  
</div>

@endsection