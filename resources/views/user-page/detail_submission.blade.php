
@extends('user-page.layouts.user_main')

@section('content-pages')

<div class="explain-product my-4 mx-3">
  
  <div class="heading text-center ">
    <div class="mt-3">
      <span style="font-size: 26px; font-weight: 600">{{$title}}</span>
    </div>
  </div>

  @if ($resultData)
    <div class="row shadow bg-white rounded-3 p-3 mt-3">
    
    <div class="col-md-12">
        <small>
        @if ($resultData->updated_at)
            <i>updated at </i>{{ date('d M Y', strtotime($resultData->updated_at)) }}
        @else
            <i>created at </i> {{ date('d M Y', strtotime($resultData->created_at)) }}
        @endif
        </small>
    </div>
    
    <div class="col-md-7" style="border-right: 1px solid #acacac !important;">

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 40%;">Nama</th>
                    <td>{{ $resultData->employee->fullname }}</td>
                </tr>
                <tr>
                    <th style="width: 40%;">Tipe Pengajuan</th>
                    <td>{{ $resultData->leave_type }}</td>
                </tr>
                <tr>
                    <th style="width: 40%;">Dari Tanggal</th>
                    <td>{{ date('d-m-Y', strtotime($resultData->start_date)) }}</td>
                </tr>
                <tr>
                    <th style="width: 40%;">Sampai Tanggal</th>
                    <td>{{ date('d-m-Y', strtotime($resultData->end_date)) }}</td>
                </tr>
                <tr>
                    <th style="width: 40%;">Alasan</th>
                    <td>{{ $resultData->reason }}</td>
                </tr>
            </thead>
        </table>

    </div>

    <div class="col-md-5" style="border-right: 1px solid #acacac !important;">

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 40%;">Status Persetujuan 1</th>
                    @php
                        if($resultData->approved1 == 'X') {
                            $status1 = 'Menunggu Persetujuan';
                        } else if($resultData->approved1 == 'Y') {
                            $status1 = 'Pengajuan Disetujui';
                        } else if($resultData->approved1 == 'N') {
                            $status1 = 'Pengajuan Ditolak';
                        }
                    @endphp
                    <td>{{$status1}}</td>
                </tr>
                <tr>
                    <th style="width: 40%;">Disetujui Oleh</th>
                    <td>{{ $resultData->approved1_by }}</td>
                </tr>
                <tr>
                    <th style="width: 40%;">Status Persetujuan 2</th>
                    @php
                        if($resultData->approved2 == 'X') {
                            $status2 = 'Menunggu Persetujuan';
                        } else if($resultData->approved2 == 'Y') {
                            $status2 = 'Pengajuan Disetujui';
                        } else if($resultData->approved2 == 'N') {
                            $status2 = 'Pengajuan Ditolak';
                        }
                    @endphp
                    <td>{{ $status2 }}</td>
                </tr>
                <tr>
                    <th style="width: 40%;">Disetujui Oleh</th>
                    <td>{{ $resultData->approved2_by }}</td>
                </tr>
            </thead>
        </table>

    </div>

    </div>
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