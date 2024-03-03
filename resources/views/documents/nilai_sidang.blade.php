@if($isPrint)
  @include('documents.partitions.headerPrint')
@else
  @include('documents.partitions.header')
@endif

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
              <td rowspan="3">{{ number_format($nilaiTotal,0) }}</td>
              <td rowspan="3">{{ $indeks }}</td>
            </tr>
            <tr>
              <td colspan="">{{ number_format($nilaiPembimbing1,0) }}</td>
              <td colspan="">{{ number_format($nilaiPembimbing2,0) }}</td>
              <td colspan="">{{ number_format($nilaiPenguji1,0) }}</td>
              <td colspan="">{{ number_format($nilaiPenguji2,0) }}</td>
            </tr>
            <tr>
              <td colspan="2">{{$porsi_nilai? $porsi_nilai->pembimbing:'60'}}% x (PB1 + PB2)/2</td>
              <td colspan="2">{{$porsi_nilai? $porsi_nilai->pembimbing:'40'}}% x (P1 + P2)/2</td>
            </tr>
          </table>
        </div>
        <p class="mb-4">
          Konversi Nilai:<br>
          A>80&emsp;80>AB>70&emsp;70>B>65&emsp;65>BC>60&emsp;60>C>50&emsp;50>D>40&emsp;E<40
        </p>
      </div>
    </div>
  </div>
@include('documents.partitions.footer')
