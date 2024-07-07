
@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4 mx-3">
  
  <div class="heading text-center ">
    <div class="mt-3">
      <span style="font-size: 26px; font-weight: 600">{{$title}}</span>
    </div>
  </div>

  @if (count($histories) > 0)
  
    @foreach ($histories as $key => $data)
    
      <div class="row shadow bg-white rounded-3 p-3 mt-3 px-5 mx-4" >
        
        <div class="col-md-12">
            <small>
              @if ($data->updated_at)
                <i>Diperbaharui pada </i>{{ date('d M Y', strtotime($data->updated_at)) }}
              @else
                <i>Diajukan pada </i> {{ date('d M Y', strtotime($data->created_at)) }}
              @endif
            </small>
              &emsp; || &emsp;
            <small>
              @php
                  if($data->approved1 == 'X') {
                    $status1 = 'Menunggu Persetujuan';
                    $color = "text-success";
                  } else if($data->approved1 == 'Y') {
                    $status1 = 'Pengajuan Disetujui';
                    $color = "text-primary";
                    if ($data->approved2 == 'X') {
                      $status1 = 'Menunggu Persetujuan ke 2';
                      $color = "text-success";
                    } else
                    if ($data->approved2 == 'Y') {
                      $status1 = 'Pengajuan Disetujui';
                      $color = "text-success";
                    } else
                    if ($data->approved2 == 'N') {
                      $status1 = 'Pengajuan Ditolak Persetujuan ke 2';
                      $color = "text-danger";
                    }
                  } else if($data->approved1 == 'N') {
                    $status1 = 'Pengajuan Ditolak';
                    $color = "text-danger";
                  }
              @endphp
              <b>Status Pengajuan : </b> <span class={{ $color }} > {{ $status1 }} </span>

            </small>
        </div>
        
        <div class="col-md-12" style="border-right: 1px solid #acacac !important;">
          <div class="row mt-3">
            <div class="col-md-3 shadow p-2 m-2">
              <div class="h4 ps-2">{{ $data->employee->fullname }}</div>
            </div>
            <div class="col-md-2 shadow p-2 m-2">
              <div class="ps-2 mt-2">Pengajuan {{$data->leave_type}}</div>
            </div>
            <div class="col shadow p-2 m-2">
              <div class="ps-2 mt-2">Tanggal {{$data->start_date}} sampai {{$data->end_date}}</div>
            </div>
          </div>
          <p></p>
          <a href="/detail-pengajuan/{{ $data->id }}" class="text-decoration-none">
            Selengkapnya ...
          </a>
        </div>

      </div>

    @endforeach

  @else
      <div class="row">
        <span class="alert alert-danger text-center h4 my-5">
          Belum ada pengajuan saat ini.
        </span>
      </div>
  @endif
  
</div>

@endsection

<script>
  function downloadImg(url, filename, element) {
    fetch(url)
      .then(response => response.blob())
      .then(blob => {
          // Create a download link
          const downloadLink = document.createElement('a');
          downloadLink.href = URL.createObjectURL(blob);
          downloadLink.download = filename;

          // Append the link to the document and trigger a click on the link to start the download
          document.body.appendChild(downloadLink);
          downloadLink.click();

          // Remove the link from the document
          document.body.removeChild(downloadLink);

      })
      .catch(error => console.error('Error downloading file:', error));
  }
</script>