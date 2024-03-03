<div class="table-responsive-sm">
  <table class="table table-striped table-borderless">
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">NIM</td>
          <td>:</td>
          <td>{{ $schedule->sidang->mahasiswa_id }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">NAMA</td>
          <td>:</td>
          <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">PEMBIMBING 1</td>
          <td>:</td>
          <td>{{ $schedule->sidang->pembimbing1->code.' - '.$schedule->sidang->pembimbing1->user->nama }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">PEMBIMBING 2</td>
          <td>:</td>
          <td>{{ $schedule->sidang->pembimbing2->code.' - '.$schedule->sidang->pembimbing2->user->nama }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">PENGUJI 1</td>
          <td>:</td>
          <td>{{ $schedule->detailpenguji1->code.' - '.$schedule->detailpenguji1->user->nama }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">PENGUJI 2</td>
          <td>:</td>
          <td>{{ $schedule->detailpenguji2->code.' - '.$schedule->detailpenguji2->user->nama }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">JUDUL TA</td>
          <td>:</td>
          <td>{{ $schedule->sidang->judul }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">DOKUMEN TA</td>
          <td>:</td>
          <td>
          @if($documents->where('nama', $schedule->sidang->dokumen_ta)->first() != null)
          <a href="/{{$documents->where('nama', $schedule->sidang->dokumen_ta)->first()->file_url}}" class="btn btn-outline-primary" download>Download</a>
          @else
          <a href="#" target="_blank" class='btn btn-primary disabled'>
              DATA TIDAK DITEMUKAN
            </a>
          @endif
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">JURNAL</td>
          <td>:</td>
          <td>
          @if($documents->where('nama', $schedule->sidang->makalah)->first() != null)
          <a href="/{{$documents->where('nama', $schedule->sidang->makalah)->first()->file_url}}" class="btn btn-outline-primary" download>Download</a>
          @else
          <a href="#" target="_blank" class='btn btn-primary disabled'>
              DATA TIDAK DITEMUKAN
            </a>
          @endif
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">MATERI PRESENTASI</td>
          <td>:</td>
          <td>
            @if($schedule->presentasi_file != null AND $documents->where('nama', $schedule->presentasi_file)->first() != null)
            <a href="/{{$documents->where('nama', $schedule->presentasi_file)->first()->file_url}}" target="_blank" class='btn btn-outline-primary' download>
              Download
            </a>
            @else
            <a href="#" target="_blank" class='btn btn-primary disabled'>
              DATA TIDAK DITEMUKAN
            </a>
            @endif
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Keputusan</td>
          <td>:</td>
          <td>
            @if ($schedule->keputusan == null)
                <span class="badge badge-danger">BELUM DIPUTUSKAN</span>
            @elseif ($schedule->keputusan != null)
                <span class="badge badge-success">{{ strtoupper($schedule->keputusan) }}</span>
            @endif
            {{-- {{ $schedule->keputusan == null ? 'Belum Diputuskan' : $schedule->keputusan }} --}}
          </td>
        </tr>
  </table>
</div>
