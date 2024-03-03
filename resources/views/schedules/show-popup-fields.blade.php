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
          <td class="font-weight-bold" style="white-space: nowrap;">JUDUL TA</td>
          <td>:</td>
          <td>{{ $schedule->sidang->judul }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">DOKUMEN TA</td>
          <td>:</td>
          <td>
            @if($schedule->sidang->dokumen_ta != null)
            <a href="/{{$documents->where('nama', $schedule->sidang->dokumen_ta)->first()->file_url}}" target="_blank" class='btn btn-primary'>
              Download
            </a>
            @else
            <a href="#" target="_blank" class='btn btn-primary disabled'>
              Data tidak ditemukan
            </a>
            @endif
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">JURNAL</td>
          <td>:</td>
          <td>
            @if($schedule->sidang->dokumen_ta != null)
            <a href="/{{$documents->where('nama', $schedule->sidang->makalah)->first()->file_url}}" target="_blank" class='btn btn-primary'>
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
          <td class="font-weight-bold" style="white-space: nowrap;">MATERI PRESENTASI</td>
          <td>:</td>
          <td>
            @if($schedule->presentasi_file != null)
            <a href="/{{$documents->where('nama', $schedule->presentasi_file)->first()->file_url}}" target="_blank" class='btn btn-primary'>
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
          <td class="font-weight-bold" style="white-space: nowrap;">KEPUTUSAN</td>
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
