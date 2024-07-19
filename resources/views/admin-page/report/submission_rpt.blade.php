<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <style>
        * {
            box-sizing: border-box;
        }
        @font-face {
            font-family: Nutino;
            src: url(../font/Nunito/Nunito-VariableFont_wght.ttf);
        }
        h1 {
            font-family: "Nutino";
            padding: 0;
            margin: 0;
        }
        table, td, th {
            border: 1px solid black;
            padding: 2px 5px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13.5px;
        }

        .table {
            border-collapse: collapse;
        }

        h1 {
            padding: 0;
        }
        .wrapper {
            padding: 0 10px;
        }

        .icon-export {
            float: right; 
            padding: 0px;
        }

        .row-export::after {
            content: "";
            clear: both;
            display: table;
        }
        .bg-success {
            background-color: rgb(23, 157, 41);
            border-radius: 3px;
        }
        .bg-primary {
            background-color: rgb(1, 19, 188);
            border-radius: 3px;
        }
        .bg-danger {
            background-color: rgb(189, 0, 0);
            border-radius: 3px;
        }
        
    </style>
</head>

<body>

    <div class="wrapper">
        <h1> {{ $title }} </h1>
        <div class="row-export">
            <div class="icon-export">
                <a href="/export_submission">
                    <img src="{{ asset('img/excel.png') }}" alt="excel" style="height: 40px;">
                    <label for="print" style="display : block; font-size: 12px; margin-left: 4px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">export</label>
                    <br>
                </a>
            </div> 
        </div>
        <div style=" background: black; width:100% height:100px;">
            <div style="float: right; right:0;font-family: 'Nutino';">
                <small><b>Total Pengajuan : {{$count}}</b></small>
            </div>
        </div> 

        <div style="display: flex; width: 100%;">
            <table class="table" style="width: 100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                <tr>
                    <th style="text-align: left;">NIK Karyawan</th>
                    <th style="text-align: left;">Nama Lengkap</th>
                    <th style="text-align: left; max-width: 80px;">Jenis Kelamin</th>
                    <th style="text-align: center; width:9%;">Jenis Pengajuan</th>
                    <th style="text-align: left;">Tanggal Mulai</th>
                    <th style="text-align: left;">Sampai Tanggal</th>
                    <th style="text-align: left;">Persetujuan 1</th>
                    <th style="text-align: left;">Oleh</th>
                    <th style="text-align: left;">Persetujuan 2</th>
                    <th style="text-align: left;">Oleh</th>
                </tr>
                @foreach ($data as $item)
                {{-- {{ dd($item) }} --}}
                    <tr>
                        <td>{{$item->nik}}</td>
                        <td>{{$item->fullname}}</td>
                        <td>{{$item->gender == 'M' ? 'Laki-laki' : 'Perempuan'}}</td>
                        <td style="text-align: center">{{$item->leave_type}}</td>
                        <td>{{date('m-d-Y', strtotime($item->start_date))}}</td>
                        <td>{{date('m-d-Y', strtotime($item->end_date))}}</td>
                        @php
                            if($item->approved1 == 'X') {
                                $status1 = 'Menunggu Persetujuan';
                                $color = "bg-info";
                            } else if($item->approved1 == 'Y') {
                                $status1 = 'Pengajuan Disetujui';
                                $color = "bg-success";
                            } else if($item->approved1 == 'N') {
                                $status1 = 'Pengajuan Ditolak';
                                $color = "bg-danger";
                            }
                        @endphp
                        <td><span class="{{$color}}" style="color: aliceblue; padding:1px 5px;">{{$status1}}</span></td>
                        <td>{{$item->approved1_by}}</td>
                        @php
                            if($item->approved1 == 'N') {
                                $status2 = '-------------------';
                                $color = "bg-danger";
                            } else {
                                if($item->approved2 == 'X') {
                                    $status2 = 'Menunggu Persetujuan';
                                    $color = "bg-info";
                                } else if($item->approved2 == 'Y') {
                                    $status2 = 'Pengajuan Disetujui';
                                    $color = "bg-success";
                                } else if($item->approved2 == 'N') {
                                    $status2 = 'Pengajuan Ditolak';
                                    $color = "bg-danger";
                                }
                            }
                        @endphp
                        <td><span class="{{$color}}" style="color: aliceblue; padding:1px 5px;">{{$status2}}</span></td>
                        <td>{{$item->approved2_by}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
        
</body>
</html>