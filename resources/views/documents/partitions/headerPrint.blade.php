<!doctype html>
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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body style="background:white; overflow-x:hidden">

<div class="row">
  <div class="col-sm-12">
    <div class="table-responsive-sm m-5">
      <table class="table table-bordered table-sm">
        <tr>
          <td rowspan="5" style="width:120px">
            <img src="{{ asset('images/telkom.png') }}" alt="" height="120px" width="120px">
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">Universitas Telkom</td>
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
