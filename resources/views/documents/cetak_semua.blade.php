<html>
<head>
  <meta charset="UTF-8">
  <title>Dokumentasi TA_{{$schedule->sidang->mahasiswa->nim}}</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/css/coreui.min.css">
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@icon/coreui-icons-free@1.0.1-alpha.1/coreui-icons-free.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
</head>

@if ($isPrint)
<body style="background:white; overflow-x:hidden" onload="window.print();">
@else
<body style="background:white; overflow-x:hidden">
@endif

  @php
  use Carbon\Carbon;
  $date = Carbon::today()->locale('id_ID');
  @endphp

  {{-- Berita Acara --}}
  @include('documents.partitions.header_all',['print' =>"berita_acara"])

  <div class="row">
    <div class="col-md-12 text-center mb-5">
      <h2 class="font-weight-bold">Berita Acara Sidang Tugas Akhir</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row">
      <div class="col-sm-12" style="padding:0px 200px 0px 200px">
        <p>
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
        <p class="mb-4">
          Setelah mempertimbangkan dan memperhatikan beberapa aspek penilaian, maka Tim Sidang
          yang terdiri dari Pembimbing dan Penguji memutuskan : bahwa mahasiswa yang namanya
          tercantum diatas dinyatakan,
        </p>
        <div class="hasil">
          <div id="lulus"
            style="height:30px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'lulus' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:80px">Lulus</span>
          <div id="lulus_bersyarat"
            style="height:30px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'lulus bersyarat' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:80px">Lulus Bersyarat</span>
          <div id="tidak_lulus"
            style="height:30px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'tidak lulus' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:80px">Tidak Lulus</span>
        </div>
      </div>
    </div>
  </div>
  @include('documents.partitions.footer_all',['print' => "berita_acara"])


  {{-- Revisi --}}
  <div style="page-break-after: always;"></div>
  @include('documents.partitions.header_all',['print'=>"revisi"])

  <div class="row">
    <div class="col-md-12 text-center mb-5">
      <h2 class="font-weight-bold">LEMBAR PERBAIKAN TUGAS AKHIR</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row" style="margin:0 10% 0 10%">
      <div class="col-sm-12">
        <table class="table table-borderless">
          <tr>
            <td style="white-space:nowrap;">NAMA</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">NIM</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">JUDUl TA</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->judul }}</td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PEMBIMBING 1</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->sidang->pembimbing1->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PEMBIMBING 2</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->sidang->pembimbing2->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PENGUJI 1</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->detailpenguji1->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PENGUJI 2</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->detailpenguji2->user->nama }}
            </td>
          </tr>
        </table>
        <div class="table-responsive-lg" style="background:white;">
          <table class="table table-bordered text-center">
            <tr>
              <td>
                <h6>Hal-hal yang harus diperbaiki dalam buku laporan Tugas Akhir</h6>
                @if( count($revisions_ta) > 0)
                <ul class="text-left">
                  @foreach($revisions_ta as $revisi)
                  <li>{{$revisi->deskripsi}}</li>
                  @endforeach
                </ul>
                @else
                Tidak ada Catatan Revisi
                @endif
              </td>
            </tr>
            <tr>
              <td>
                <h6>Hal-hal yang harus diperbaiki dalam jurnal Tugas Akhir</h6>
                @if( count($revisions_makalah) > 0)
                <ul class="text-left">
                  @foreach($revisions_makalah as $makalah)
                  <li>{{$makalah->deskripsi}}</li>
                  @endforeach
                </ul>
                @else
                Tidak ada Catatan Revisi
                @endif
              </td>
            </tr>
          </table>
        </div>
        <p class="mb-4 font-weight-bold">
          *Perbaikan paling lambat dikumpulkan satu minggu setelah sidang.
        </p>
      </div>
    </div>
  </div>
  @include('documents.partitions.footer_all',['print'=> "revisi"])


  {{-- Form Nilai Penguji 1--}}
  <div style="page-break-after: always;"></div>
  @include('documents.partitions.header_all',['print'=>"form_nilai_penguji_1"])

  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="font-weight-bold">Formulir Penilaian Penguji Sidang Tugas Akhir</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row">
      <div class="col-sm-12" style="padding:0px 150px 0px 150px">
        <div class="table-responsive-sm m-5">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">CLO</th>
                <th>Deskripsi CLO</th>
                <th>Unsur Penilaian / Rubrikasi</th>
                <th class="text-center">Bobot</th>
                <th colspan="5">Interval</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clos_penguji_1 as $clo)
              @if($clo->components[0]->penguji == 1)
              <tr>
                <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
              </tr>
              @foreach($clo->components as $component)
              @if($scores_penguji_1 != null)
              @foreach($scores_penguji_1 as $score)
              @if($score->component_id == $component->id)
              @php
              $value = $score->value;
              @endphp
              @endif
              @endforeach
              @endif
              <tr>
                <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
                <td>{{ $clo->precentage }}%</td>
                @foreach($component->intervals->sortBy('value') as $interval)
                @if($score != null)
                <td class="text-center {{ $value == $interval->ekuivalensi ? 'font-weight-bold' : "" }}">
                  {{ $interval->value ?? '-' }}</td>
                @endif
                @endforeach
              </tr>
              @endforeach
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @include('documents.partitions.footer_all',['print'=> "form_nilai_penguji_1"])


  {{-- Form Nilai Penguji 2--}}
  <div style="page-break-after: always;"></div>
  @include('documents.partitions.header_all',['print'=>"form_nilai_penguji_2"])

  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="font-weight-bold">Formulir Penilaian Penguji Sidang Tugas Akhir</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row">
      <div class="col-sm-12" style="padding:0px 150px 0px 150px">
        <div class="table-responsive-sm m-5">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">CLO</th>
                <th>Deskripsi CLO</th>
                <th>Unsur Penilaian / Rubrikasi</th>
                <th class="text-center">Bobot</th>
                <th colspan="5">Interval</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clos_penguji_2 as $clo)
              @if($clo->components[0]->penguji == 1)
              <tr>
                <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
              </tr>
              @foreach($clo->components as $component)
              @if($scores_penguji_2 != null)
              @foreach($scores_penguji_2 as $score)
              @if($score->component_id == $component->id)
              @php
              $value = $score->value;
              @endphp
              @endif
              @endforeach
              @endif
              <tr>
                <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
                <td>{{ $clo->precentage }}%</td>
                @foreach($component->intervals->sortBy('value') as $interval)
                @if($score != null)
                <td class="text-center {{ $value == $interval->ekuivalensi ? 'font-weight-bold' : "" }}">
                  {{ $interval->value }}</td>
                @endif
                @endforeach
              </tr>
              @endforeach
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @include('documents.partitions.footer_all',['print'=> "form_nilai_penguji_2"])


  {{-- Form Nilai Pembimbing 1--}}
  <div style="page-break-after: always;"></div>
  @include('documents.partitions.header_all',['print'=> "form_nilai_pembimbing_1"])

  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="font-weight-bold">Formulir Penilaian Pembimbing Sidang Tugas Akhir</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row">
      <div class="col-sm-12" style="padding:0px 150px 0px 150px">
        <div class="table-responsive-sm m-5">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">CLO</th>
                <th>Deskripsi CLO</th>
                <th>Unsur Penilaian / Rubrikasi</th>
                <th class="text-center">Bobot</th>
                <th colspan="5">Interval</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clos_pembimbing_1 as $clo)
              @if($clo->components[0]->pembimbing == 1)
              <tr>
                <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
              </tr>
              @foreach($clo->components as $component)
              @if($scores_pembimbing_1 != null)
              @foreach($scores_pembimbing_1 as $score)
              @if($score->component_id == $component->id)
              @php
              $value = $score->value;
              @endphp
              @endif
              @endforeach
              @endif
              <tr>
                <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
                <td>{{ $clo->precentage }}%</td>
                @foreach($component->intervals->sortBy('value') as $interval)
                @if($score != null)
                <td class="text-center {{ $value == $interval->ekuivalensi ? 'font-weight-bold' : "" }}">
                  {{ $interval->value }}</td>
                @endif
                @endforeach
              </tr>
              @endforeach
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @include('documents.partitions.footer_all',['print'=> "form_nilai_pembimbing_1"])


  {{-- Form Nilai Pembimbing 2--}}
  <div style="page-break-after: always;"></div>
  @include('documents.partitions.header_all',['print'=> "form_nilai_pembimbing_2"])

  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="font-weight-bold">Formulir Penilaian Pembimbing Sidang Tugas Akhir</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row">
      <div class="col-sm-12" style="padding:0px 150px 0px 150px">
        <div class="table-responsive-sm m-5">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">CLO</th>
                <th>Deskripsi CLO</th>
                <th>Unsur Penilaian / Rubrikasi</th>
                <th class="text-center">Bobot</th>
                <th colspan="5">Interval</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clos_pembimbing_2 as $clo)
              @if($clo->components[0]->pembimbing == 1)
              <tr>
                <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
              </tr>
              @foreach($clo->components as $component)
              @if($scores_pembimbing_2 != null)
              @foreach($scores_pembimbing_1 as $score)
              @if($score->component_id == $component->id)
              @php
              $value = $score->value;
              @endphp
              @endif
              @endforeach
              @endif
              <tr>
                <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
                <td>{{ $clo->precentage }}%</td>
                @foreach($component->intervals->sortBy('value') as $interval)
                @if($score != null)
                <td class="text-center {{ $value == $interval->ekuivalensi ? 'font-weight-bold' : "" }}">
                  {{ $interval->value }}</td>
                @endif
                @endforeach
              </tr>
              @endforeach
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @include('documents.partitions.footer_all',['print'=> "form_nilai_pembimbing_2"])


  {{-- Nilai Sidang--}}
  <div style="page-break-after: always;"></div>
  @include('documents.partitions.header_all',['print'=> "nilai_sidang"])

  <div class="row">
    <div class="col-md-12 text-center mb-5">
      <h2 class="font-weight-bold">Nilai Sidang Tugas Akhir</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row" style="margin:0 20% 0 20%">
      <div class="col-sm-12">
        <table class="table table-borderless">
          <tr>
            <td style="white-space:nowrap;">NAMA</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">NIM</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">JUDUl TA</td>
            <td style="width:10px">:</td>
            <td>{{ $schedule->sidang->judul }}</td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PEMBIMBING 1</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->sidang->pembimbing1->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PEMBIMBING 2</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->sidang->pembimbing2->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PENGUJI 1</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->detailpenguji1->user->nama }}
            </td>
          </tr>
          <tr>
            <td style="white-space:nowrap;">PENGUJI 2</td>
            <td style="width:10px">:</td>
            <td>
              {{ $schedule->detailpenguji2->user->nama }}
            </td>
          </tr>
        </table>
        <div class="table-responsive-lg" style="background:white;">
          <table class="table table-bordered text-center">
            <tr>
              <th rowspan="4">Penilai Sidang Tugas Akhir</th>
              <th colspan="2">Kriteria Penilaian</th>
              <th colspan="2">Unsur Penilaian</th>
              <th rowspan="">Nilai</th>
              <th rowspan="">Indeks</th>
            </tr>
            <tr>
              <td>PB 1</td>
              <td>PB 2</td>
              <td>P 1</td>
              <td>P 2</td>
              <td rowspan="3">{{ number_format($nilaiTotal,2) }}</td>
              <td rowspan="3">{{ $indeks }}</td>
            </tr>
            <tr>
              <td colspan="">{{ number_format($nilaiPembimbing1,2) }}</td>
              <td colspan="">{{ number_format($nilaiPembimbing2,2) }}</td>
              <td colspan="">{{ number_format($nilaiPenguji1,2) }}</td>
              <td colspan="">{{ number_format($nilaiPenguji2,2) }}</td>
            </tr>
            <tr>
              <td colspan="2">{{$porsi_nilai? $porsi_nilai->pembimbing:'60'}}% x (PB1 + PB2)/2</td>
              <td colspan="2">{{$porsi_nilai? $porsi_nilai->pembimbing:'40'}}% x (P1 + P2)/2</td>
            </tr>
          </table>
        </div>
        <p class="mb-4">
          Konversi Nilai:<br>
          A>80&emsp;80>AB>70&emsp;70>B>65&emsp;65>BC>60&emsp;60>C>50&emsp;50>D>40&emsp;E<40 </p> </div> </div> </div>
  @include('documents.partitions.footer_all',['print'=> "nilai_sidang"])


  {{-- Daftar Hadir --}}
  <div style="page-break-after: always;"></div>
  @include('documents.partitions.header_all',['print'=> "daftar_hadir"])

  <div class="row">
    <div class="col-md-12 text-center mb-5">
      <h2 class="font-weight-bold">DAFTAR HADIR PESERTA PENGUJI & PEMBIMBING SIDANG TUGAS AKHIR</h2>
    </div>
  </div>
  <div class="container mb-5">
    <div class="row">
      <div class="col-sm-12" style="padding:0px 150 0px 150">
        <table class="table table-borderless">
          <tr>
            <td style="white-space:nowrap;">NAMA</td>
            <td style="width:10px">:</td>
            @if($attendances != "[]")
            <td>{{ $attendances[0]->schedule->sidang->mahasiswa->user->nama }}</td>
            @endif
          </tr>
          <tr>
            <td style="white-space:nowrap;">NIM</td>
            <td style="width:10px">:</td>
            @if($attendances != "[]")
            <td>{{ $attendances[0]->schedule->sidang->mahasiswa->nim }}</td>
            @endif
          </tr>
          <tr>
            <td style="white-space:nowrap;">JUDUl TA</td>
            <td style="width:10px">:</td>
            @if($attendances != "[]")
            <td>{{ $attendances[0]->schedule->sidang->judul }}</td>
            @endif
          </tr>
          <tr>
            <td style="white-space:nowrap;">TANGGAL</td>
            <td style="width:10px">:</td>
            @if($attendances != "[]")
            <td>{{ $attendances[0]->schedule->date->isoFormat('DD-MMM-YY') }}</td>
            @endif
          </tr>
          <tr>
            <td style="white-space:nowrap;">WAKTU</td>
            <td style="width:10px">:</td>
            @if($attendances != "[]")
            <td>{{ $attendances[0]->schedule->time }}</td>
            @endif
          </tr>
          <tr>
            <td style="white-space:nowrap;">TEMPAT</td>
            <td style="width:10px">:</td>
            @if($attendances != "[]")
            <td>{{ $attendances[0]->schedule->ruang }}</td>
            @endif
          </tr>
        </table>
        <table class="table table-bordered">
          <thead class="text-center font-weight-bold">
            <tr>
              <th>NO</th>
              <th>NAMA</th>
              <th>POSISI</th>
              <th>TANDA TANGAN</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">1</td>
              <td>{{ $attendances[0]->schedule->sidang->mahasiswa->user->nama }}</td>
              <td class="text-center">PESERTA</td>
              <td>Hadir</td>
            </tr>
            <tr>
              <td class="text-center">2</td>
              @if($attendances->where('role_sidang', 'pembimbing1')->first() != null)
              <td>{{ $attendances->where('role_sidang', 'pembimbing1')->first()->user->nama }}</td>
              @else
              <td>Pembimbing 1 Tidak Hadir</td>
              @endif
              <td class="text-center">PEMBIMBING I</td>
              @if($attendances->where('role_sidang', 'pembimbing1')->first() != null)
              <td>Hadir</td>
              @else
              <td>-</td>
              @endif
            </tr>
            <tr>
              <td class="text-center">3</td>
              @if($attendances->where('role_sidang', 'pembimbing2')->first() != null)
              <td>{{ $attendances->where('role_sidang', 'pembimbing2')->first()->user->nama }}</td>
              @else
              <td>Pembimbing 2 Tidak Hadir</td>
              @endif
              <td class="text-center">PEMBIMBING II</td>
              @if($attendances->where('role_sidang', 'pembimbing2')->first() != null)
              <td>Hadir</td>
              @else
              <td>-</td>
              @endif
            </tr>
            <tr>
              <td class="text-center">4</td>
              @if($attendances->where('role_sidang', 'penguji1')->first() != null)
              <td>{{ $attendances->where('role_sidang', 'penguji1')->first()->user->nama }}</td>
              @else
              <td>Penguji 1 Tidak Hadir</td>
              @endif
              <td class="text-center">PENGUJI I</td>
              @if($attendances->where('role_sidang', 'penguji1')->first() != null)
              <td>Hadir</td>
              @else
              <td>-</td>
              @endif
            </tr>
            <tr>
              <td class="text-center">5</td>
              @if($attendances->where('role_sidang', 'penguji2')->first() != null)
              <td>{{ $attendances->where('role_sidang', 'penguji2')->first()->user->nama }}</td>
              @else
              <td>Penguji 2 Tidak Hadir</td>
              @endif
              <td class="text-center">PENGUJI II</td>
              @if($attendances->where('role_sidang', 'penguji2')->first() != null)
              <td>Hadir</td>
              @else
              <td>-</td>
              @endif
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @include('documents.partitions.footer_all',['print'=> "daftar_hadir"])


</body>
<!-- jQuery 3.1.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</html>
