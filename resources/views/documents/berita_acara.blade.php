@php
use Carbon\Carbon;
$date = Carbon::today()->locale('id_ID');    
@endphp
{{--  @if($isPrint)  --}}
  {{--  @include('documents.partitions.headerPrint')  --}}
{{--  @else  --}}
  @include('documents.partitions.header')
{{--  @endif  --}}
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
          <div id="lulus" style="height:30px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'lulus' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:80px">Lulus</span>
          <div id="lulus_bersyarat" style="height:30px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'lulus bersyarat' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:80px">Lulus Bersyarat</span>
          <div id="tidak_lulus" style="height:30px;min-width:30px; border:1px solid black; padding:4px 10px 4px 10px; display:inline">
            {{ $schedule->keputusan == 'tidak lulus' ? 'V' : '' }}
          </div>
          <span style="margin-left:10px; margin-right:80px">Tidak Lulus</span>
        </div>
      </div>
    </div>
  </div>
@include('documents.partitions.footer')