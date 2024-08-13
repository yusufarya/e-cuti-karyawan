@extends('user-page.layouts.user_main')

@php
  if($dataCuti) {
    $total_cuti = $dataCuti->total;
    $cuti_digunakan = $dataCuti->used;
    $tersisa = $total_cuti - $cuti_digunakan;
    $persentase_digunakan = ($cuti_digunakan / $total_cuti) * 100;
  } else {
    $total_cuti = 0;
    $cuti_digunakan = 0;
    $tersisa = $total_cuti - $cuti_digunakan;
    $persentase_digunakan = 0;
  }
@endphp

@section('content-pages')

<div class="explain-product my-4 px-3">

  <form action="/submission" method="POST" enctype="multipart/form-data" id="leave-form">
    @csrf
    <div class="row shadow py-4 px-5">

      <div class="heading">
        <div class="row">
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$persentase_digunakan}}%" aria-valuenow="{{$persentase_digunakan}}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p class="pt-2 text-left">Total cuti : {{ $total_cuti }}, digunakan : {{ $cuti_digunakan }} dan tersisa : {{ $tersisa }}</p>
        </div>
        <div class="mt-2 text-center">
          <span style="font-size: 26px; font-weight: 600">{{$title}}</span>
        </div>
      </div>

      @if ($tersisa <= 0)
      @endif

      @if ($dataCuti == null)
      <div class="mt-2">
        <div class="alert alert-danger py-2 text-center">Anda tidak dapat membuat pengajuan, karna belum memiliki jatah cuti</div>
      </div>
      @elseif($tersisa <= 0)
      <div class="mt-2">
        <div class="alert alert-danger py-2 text-center">Anda tidak dapat membuat pengajuan, karna sisa cuti anda telah habis</div>
      </div>
      @endif

      <div class="col-lg-6 col-md-6 my-2">
        <label for="name">Nama Lengkap</label>
        <input type="text" readonly name="name" id="name" class="form-control" value="{{ auth()->guard('employee')->user()->fullname }}" {{ $tersisa <= 0 ? 'disabled' : ''}} >
        <input type="hidden" name="emp_nik" id="emp_nik" class="form-control" value="{{ auth()->guard('employee')->user()->nik }}">
      </div>
      <div class="col-lg-6 col-md-6 my-2">
        <label for="name">Tipe</label>
        <select name="leave_type" id="leave_type" class="form-select @error('leave_type')is-invalid @enderror" {{ $tersisa <= 0 ? 'disabled' : ''}}>
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
        <input type="date" name="start_date" id="start_date" class="form-control @error('start_date')is-invalid @enderror" value="{{ old('start_date') }}" {{ $tersisa <= 0 ? 'disabled' : ''}}>
        @error('start_date')
        <small class="invalid-feedback">
            Tanggal {{ $message }}
        </small>
        @enderror
      </div>
      <div class="col-lg-6 col-md-6 my-2">
        <label for="end_date">S/D</label>
        <input type="date" name="end_date" id="end_date" class="form-control @error('end_date')is-invalid @enderror" value="{{ old('end_date') }}" {{ $tersisa <= 0 ? 'disabled' : ''}}>
        @error('end_date')
        <small class="invalid-feedback">
            Tanggal S/D {{ $message }}
        </small>
        @enderror
      </div>

      <div class="col-lg-6 col-md-6 my-2">
        <label for="reason">Alasan</label>
        <textarea class="form-control @error('reason')is-invalid @enderror" name="reason" id="reason" {{ $tersisa <= 0 ? 'disabled' : ''}}>{{ old('reason') }}</textarea>
        @error('reason')
        <small class="invalid-feedback">
            Alasan {{ $message }}
        </small>
        @enderror
      </div>

      <div class="col-lg-6 col-md-6 my-2">
        <label for="attachment">Lampiran</label>
        <input type="file" class="form-control @error('dile')is-invalid @enderror" name="attachment" id="attachment" {{ $tersisa <= 0 ? 'disabled' : ''}}>
        @error('dile')
        <small class="invalid-feedback">
            Tipe {{ $message }}
        </small>
        @enderror
      </div>

      <div class="col-lg-12 col-md-12 my-2">
        <button type="submit" class="btn btn-success" {{ $tersisa <= 0 ? 'disabled' : ''}}>Submit</button>
      </div>

    </div>

  </form>

</div>

<script>
    var overLeave = `<?= json_encode($tersisa) ?>`;

    document.getElementById('start_date').addEventListener('change', function() {
        const startDate = new Date(this.value);
        const today = new Date();

        // Set time of today to 00:00:00 to compare only dates
        today.setHours(0, 0, 0, 0);

        // Check if the selected start date is earlier than today
        if (startDate < today) {
            alert('Tanggal mulai tidak boleh kurang dari hari ini.');
            this.value = ''; // Reset the input field
        }
    });

    document.getElementById('end_date').addEventListener('change', function() {
        const endDate = new Date(this.value);
        const today = new Date();

        // Set time of today to 00:00:00 to compare only dates
        today.setHours(0, 0, 0, 0);

        // Check if the selected start date is earlier than today
        if (endDate < today) {
            alert('Tanggal mulai tidak boleh kurang dari hari ini.');
            this.value = ''; // Reset the input field
        }
    });


    document.getElementById('leave-form').addEventListener('submit', function(event) {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        const leave_type = document.getElementById('leave_type').value

        if(leave_type != "SAKIT") {
            // Calculate the difference in time (in milliseconds)
            const timeDifference = new Date(endDate) - new Date(startDate);
            // Convert time difference from milliseconds to days
            const dayDifference = timeDifference / (1000 * 60 * 60 * 24);

            if((overLeave - dayDifference) >= 0) {
                console.log(`Difference in days: ${dayDifference}`);
            } else {
                alert('Sisa cuti anda tidak mencukupi')
                event.preventDefault(); // Prevent form submission
                return;
            }

        }

        if (new Date(endDate) < new Date(startDate)) {
        event.preventDefault(); // Prevent form submission
        alert('Tanggal akhir tidak boleh lebih awal dari tanggal mulai.');
        }
    });
</script>

@endsection
