<div class="table-responsive-sm">
  <table class="table table-striped table-borderless">
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">NIM</td>
          <td>:</td>
          <td>{{ $sidang->mahasiswa_id }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Pembimbing 1</td>
          <td>:</td>
          <td>{{ $sidang->pembimbing1->code.' - '.$sidang->pembimbing1->user->nama }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Pembimbing 2</td>
          <td>:</td>
          <td>{{ $sidang->pembimbing2->code.' - '.$sidang->pembimbing2->user->nama }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Judul TA</td>
          <td>:</td>
          <td>{{ $sidang->judul }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Jumlah Bimbingan</td>
          <td>:</td>
          <td>
            <p>{{ "Pembimbing 1: ".ucwords($bimbingan1)." Pertemuan" }}</p>
            <p>{{ "Pembimbing 2: ".ucwords($bimbingan2)." Pertemuan" }}</p>
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">TAK</td>
          <td>:</td>
          <td>{{ $sidang->tak }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">EPRT</td>
          <td>:</td>
          <td>{{ $sidang->eprt }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Dokumen TA</td>
          <td>:</td>
          <td>
          @if($sidang->dokumen_ta)
          <a href="/{{$dokumen_ta->file_url}}" class="btn btn-outline-primary" download>Download</a>
          @else
          <a href="#" target="_blank" class='btn btn-primary disabled'>
              Data tidak ditemukan
            </a>
          @endif
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Jurnal</td>
          <td>:</td>
          <td>
          @if($sidang->makalah)
          <a href="/{{$makalah->file_url}}" class="btn btn-outline-primary" download>Download</a>
          @else
          <a href="#" target="_blank" class='btn btn-primary disabled'>
              Data tidak ditemukan
            </a>
          @endif
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Status</td>
          <td>:</td>
          <td>
            @if ($sidang->status == 'lulus')
                    <span class="badge badge-success">Lulus</span>
                    @elseif ($sidang->status == 'belum dijadwalkan')
                    <span class="badge badge-secondary">Belum Dijadwakan</span>
                    @elseif ($sidang->status == 'sudah dijadwalkan')
                    <span class="badge badge-info">Dijadwakan</span>
                     @elseif ($sidang->status == 'tidak lulus')
                    <span class="badge badge-danger">Tidak Lulus</span>
                    @elseif ($sidang->status == 'ditolak oleh admin')
                    <span class="badge badge-danger">Ditolak Oleh Admin</span>
                    @elseif ($sidang->status == 'pengajuan')
                    <span class="badge badge-warning">Pengajuan</span>
                    @elseif ($sidang->status == 'disetujui oleh pembimbing2')
                    <span class="badge badge-primary">Disetujui Oleh Pembimbing 2</span>
                    @elseif ($sidang->status == 'disetujui oleh pembimbing1')
                    <span class="badge badge-primary">Disetujui Oleh Pembimbing 1</span>
                  @endif  
          </td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Bahasa</td>
          <td>:</td>
          <td>{{ $sidang->is_english == 0 ? 'Indonesia' : 'Inggris' }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Periode</td>
          <td>:</td>
          <td>{{ $sidang->period->name }}</td>
        </tr>
  </table>
</div>
