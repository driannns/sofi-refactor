@if($isPrint)
  @include('documents.partitions.headerPrint')
@else
  @include('documents.partitions.header')
@endif
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
              @if($attendances->where('role_sidang', 'mahasiswa')->first() != null)
              <td>{{ $attendances->where('role_sidang', 'mahasiswa')->first()->user->nama }}</td>
              @else
              <td>Peserta Tidak Hadir</td>
              @endif
              <td class="text-center">PESERTA</td>
              @if($attendances->where('role_sidang', 'mahasiswa')->first() != null)
              <td>Hadir</td>
              @else
              <td>-</td>
              @endif
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
@include('documents.partitions.footer')
