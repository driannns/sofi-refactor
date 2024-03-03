@php
use Carbon\Carbon;
$date = Carbon::today()->locale('id_ID');    
@endphp
{{--  @if($isPrint)  --}}
  {{--  @include('documents.partitions.headerPrint')  --}}
{{--  @else  --}}
<html>
<head>
  <meta charset="UTF-8">
  <title>{{config('app.name')}}</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/css/coreui.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/coreui-icons-free@1.0.1-alpha.1/coreui-icons-free.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
<style type="text/css">
  .row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.table-bordered {
    border: 1px solid #c8ced3;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #c8ced3;
}
@media (max-width: 575.98px)
.table-responsive-sm {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.text-center {
    text-align: center!important;
}
.text-right{
  text-align: right!important;
}
.text-justify{
  text-align: justify!important;
}
.mb-5, .my-5 {
    margin-bottom: 3rem!important;
}
.pull-right{
  float: right;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
user agent stylesheet
div {
    display: block;
}
body {
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
}
body {
    margin: 0;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: .875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #23282c;
    text-align: left;
    background-color: #e4e5e6;
}
:root {
    --blue: #20a8d8;
    --indigo: #6610f2;
    --purple: #6f42c1;
    --pink: #e83e8c;
    --red: #f86c6b;
    --orange: #f8cb00;
    --yellow: #ffc107;
    --green: #4dbd74;
    --teal: #20c997;
    --cyan: #17a2b8;
    --white: #fff;
    --gray: #73818f;
    --gray-dark: #2f353a;
    --light-blue: #63c2de;
    --primary: #20a8d8;
    --secondary: #c8ced3;
    --success: #4dbd74;
    --info: #63c2de;
    --warning: #ffc107;
    --danger: #f86c6b;
    --light: #f0f3f5;
    --dark: #2f353a;
    --breakpoint-xs: 0;
    --breakpoint-sm: 576px;
    --breakpoint-md: 768px;
    --breakpoint-lg: 992px;
    --breakpoint-xl: 1200px;
    --font-family-sans-serif: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    --font-family-monospace: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
}
html {
    font-family: sans-serif;
    line-height: 1.15;
    -webkit-text-size-adjust: 100%;
    -ms-text-size-adjust: 100%;
    -ms-overflow-style: scrollbar;
    -webkit-tap-highlight-color: transparent;
}
</style>
</head>
<body style="background:white; overflow-x:hidden">

<div class="row">
  <div class="col-sm-12">
    <div class="table-responsive-sm m-5">
      <table class="table table-bordered table-sm">
        <tr>
          <td rowspan="5" style="width:10px">
            <img src="{{ $logo }}" alt="" height="100px" width="100px">
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">Universitas Telkom 1</td>
          <td>No.Formulir</td>
          <td>TEL_U-AK-FRI-PSI-FM-004/006</td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">Jl. Telekomunikasi No. 1 Ters. Buah Batu Bandung 40257</td>
          <td>Revisi</td>
          <td>00</td>
        </tr>
        <tr>
          <td rowspan="2" class="text-center font-weight-bold" style="vertical-align : middle;text-align:center;">
            @if(Request::is('cetak/berita_acara/*'))
            LEMBAR BERITA ACARA TUGAS AKHIR
            @elseif(Request::is('cetak/nilai_sidang/*'))
            LEMBAR PENILAIAN SIDANG TUGAS AKHIR
            @elseif(Request::is('cetak/form_nilai_penguji/*'))
            FORMULIR PENILAIAN PENGUJI SIDANG TUGAS AKHIR
            @elseif(Request::is('cetak/form_nilai_pembimbing/*'))
            FORMULIR PENILAIAN PEMBIMBING SIDANG TUGAS AKHIR
            @elseif(Request::is('cetak/daftar_hadir/*'))
            LEMBAR DAFTAR HADIR SIDANG TA
            @elseif(Request::is('cetak/revisi/*'))
            LEMBAR PERBAIKAN SIDANG TUGAS AKHIR
            @endif
          </td>
          <td>Berlaku Efektif</td>
          <td>14 Oktober 2010</td>
        </tr>
        <tr>
          <td>Hal.</td>
          <td>1 dari 1</td>
        </tr>
      </table>
    </div>
  </div>
</div>
{{--  @endif  --}}
  <div class="row">
    <div class="col-md-12 text-center mb-5">
      <h2 class="font-weight-bold">Berita Acara Sidang Tugas Akhir</h2>
    </div>
  </div>

  <div class="container mb-5">
    <div class="row">
      <div class=" col-sm-12" style="padding:0px 100px 0px 100px">
        <p class="text-justify" >
          Pada hari ini, {{ $schedule->date->isoFormat('dddd D MMMM Y') }} telah diselenggarakan Sidang Tugas Akhir mahasiswa
          Fakultas Rekayasa Industri Universitas Telkom, sebagai berikut:
        </p>
        <table class="table table-borderless">
          <tr>
            <td style="width:50px">NAMA</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
          </tr>
          <tr>
            <td style="width:50px">NIM</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
          </tr>
          <tr>
            <td style="width:50px">JUDUl TA</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->judul }}</td>
          </tr>
          <tr>
            <td style="width:50px">PEMBIMBING</td>
            <td style="width:10px">:</td>
            <td>
              1. {{ $schedule->sidang->pembimbing1->user->nama }}<br>
              2. {{ $schedule->sidang->pembimbing2->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="width:50px">PENGUJI</td>
            <td style="width:10px">:</td>
            <td>
              1. {{ $schedule->detailpenguji1->user->nama }}<br>
              2. {{ $schedule->detailpenguji2->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="width:50px">TEMPAT</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->ruang }}</td>
          </tr>
          <tr>
            <td style="width:50px">WAKTU</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->time }}</td>
          </tr>
        </table>
        <p class="text-justify mb-4">
          Setelah mempertimbangkan dan memperhatikan beberapa aspek penilaian, maka Tim Sidang
          yang terdiri dari Pembimbing dan Penguji memutuskan : bahwa mahasiswa yang namanya
          tercantum diatas dinyatakan,
        </p>
        <div class="text-center">
          <div id="lulus" style="height:20px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'lulus' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:60px">Lulus</span>
          <div id="lulus_bersyarat" style="height:20px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'lulus bersyarat' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:60px">Lulus Bersyarat</span>
          <div id="tidak_lulus" style="height:20px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'tidak lulus' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:80px">Tidak Lulus</span>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
@php

$date = Carbon::today()->locale('id_ID');    
@endphp

@if(!Request::is('cetak/daftar_hadir/*'))
<div class="container mb-5">
  <div class="row">
    <div class="col-sm-12" style="padding:0px 200px 0px 200px">
      @if(Request::is('cetak/revisi/*'))
      <div class="pull-left">
        <table class="table table-bordered">
          <tr>
            <td colspan="2">
              <p>Perbaikan telah dilakukan sesuai dengan catatan di atas.</p>
            </td>
          </tr>
          <tr class="text-center">
            <td>
              Mengetahui,
            </td>
            <td>
              Menyetujui,
            </td>
          </tr>
          <tr>
            <td>
              <p class="mb-5">Bandung, {{ $schedule->date->isoFormat('dddd D MMMM Y') }}</p>
              <p class="text-center">{{ $schedule->detailpenguji2->user->nama }}</p>
            </td>
            <td>
              <p class="mb-5">Bandung, {{ $schedule->date->isoFormat('dddd D MMMM Y') }}</p>
              <p class="text-center">{{ $schedule->detailpenguji1->user->nama }}</p>
            </td>
          </tr>
        </table>
      </div>
      @endif
      <div class="pull-right">
        <table>
          @if(Request::is('cetak/revisi/*'))
          <tr>
            <td><br></td>
          </tr>
          <tr>
            <td><br></td>
          </tr>
          @endif
          <tr>
            <td class="text-center">
              <p>Bandung, {{ $schedule->date->isoFormat('dddd D MMMM Y') }}</p>
            </td>
          </tr>
          <tr>
            <td>
              @if(Request::is('download/berita_acara/*') OR Request::is('cetak/nilai_sidang/*') OR Request::is('cetak/revisi/*'))
              <p class="text-center font-weight-bold">Ketua Penguji Sidang</p>
              @elseif(Request::is('cetak/form_nilai_penguji/*/*/1'))
              <p class="font-weight-bold text-center">Dosen Penguji 1</p>
              @elseif(Request::is('cetak/form_nilai_penguji/*/*/2'))
              <p class="font-weight-bold text-center">Dosen Penguji 2</p>
              @elseif(Request::is('cetak/form_nilai_pembimbing/*/*/1'))
              <p class="font-weight-bold text-center">Dosen Pembimbing 1</p>
              @elseif(Request::is('cetak/form_nilai_pembimbing/*/*/2'))
              <p class="font-weight-bold text-center">Dosen Pembimbing 2</p>
              @endif
            </td>
          </tr>
          <tr>
            <td class="text-center">
           
            <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document))) }}">
            
              </td>
          </tr>
          <tr>
            <td>
              @if(Request::is('download/berita_acara/*') OR Request::is('cetak/nilai_sidang/*') OR Request::is('cetak/revisi/*'))
              <p class="text-center">{{ $schedule->detailpenguji1->user->nama }}</p>
              @elseif(Request::is('cetak/form_nilai_penguji/*') OR Request::is('cetak/form_nilai_pembimbing/*'))
              <p class="text-center">{{ $lecturer->user->nama }}</p>
              @endif
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

</body>
<!-- jQuery 3.1.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
 