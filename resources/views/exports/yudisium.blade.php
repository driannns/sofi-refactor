<table>
  <thead>
    <tr>
      <td>No</td>
      <td>Nama</td>
      <td>NIM</td>
      <td>Program Studi</td>
      <td>Kelas Asal</td>
      <td>No HP mahasiswa</td>
      <td>Pemb 1</td>
      <td>Pemb 2</td>
      <td>Penguji 1</td>
      <td>Penguji 2</td>
      <td>Status SK TA(Aktif/tidak aktif)</td>
      <td>Judul TA (B.Ind)</td>
      <td>Judul TA (B. Ingg)</td>
      <td>Kelompok Keahlian</td>
      <td>Peminatan</td>
      <td>Dosen Wali</td>
      <td>Nilai Pembimbing 1</td>
      <td>Nilai Pembimbing 2</td>
      <td>Nilai Penguji 1</td>
      <td>Nilai Penguji 2</td>
      <td>Total Nilai</td>
      <td>IPK</td>
      <td>Hasil Yudisium</td>
      <td>Total SKS Lulus</td>
      <td>Skor EPrT</td>
      <td>Skor TAK</td>
      <td>Catatan Komisi Etik</td>
      <td>Persyaratan Cumlaude</td>
      <td>Keterangan</td>
    </tr>
  </thead>
  <tbody>
    @foreach($schedules as $schedule)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
      <td>{{ $schedule->sidang->mahasiswa_id }}
      <td>{{ $schedule->sidang->mahasiswa->study_program }}</td>

      @if($extensions[$loop->index]['api'] != null)
      <td>{{ $extensions[$loop->index]['api']->class }}</td>
      <td>{{ $extensions[$loop->index]['api']->mobilephone }}</td>
      @else
      <td>-</td>
      <td>-</td>
      @endif

      <td>{{ $schedule->sidang->pembimbing1->user->nama }}</td>
      <td>{{ $schedule->sidang->pembimbing2->user->nama }}</td>
      <td>{{ $schedule->detailpenguji1->user->nama }}</td>
      <td>{{ $schedule->detailpenguji2->user->nama }}</td>

      @if($extensions[$loop->index]['api'] != null)
      <td>{{ $extensions[$loop->index]['api']->finaltask_status }}</td>
      @else
      <td>-</td>
      @endif

      <td>{{ $schedule->sidang->judul }}</td>

      @if($extensions[$loop->index]['api'] != null)
      <td>{{ $extensions[$loop->index]['api']->titile_eng }}</td>
      @else
      <td>-</td>
      @endif

      <td>{{ $schedule->sidang->mahasiswa->kk }}</td>

      @if($schedule->sidang->mahasiswa->peminatan != null)
      <td>{{ $schedule->sidang->mahasiswa->peminatan->nama }}</td>
      @else
      <td>-</td>
      @endif

      @if($extensions[$loop->index]['api'] != null)
      <td>{{ $extensions[$loop->index]['api']->lecturercode }}</td> 
      @else
      <td>-</td>
      @endif

      <td>{{ $extensions[$loop->index]['score']['nilaiPembimbing1'] }}</td>
      <td>{{ $extensions[$loop->index]['score']['nilaiPembimbing2'] }}</td>
      <td>{{ $extensions[$loop->index]['score']['nilaiPenguji1'] }}</td>
      <td>{{ $extensions[$loop->index]['score']['nilaiPenguji2'] }}</td>
      <td>{{ $extensions[$loop->index]['score']['nilaiTotal'] }}</td>

      @if($extensions[$loop->index]['api'] != null)
      <td>{{ $extensions[$loop->index]['api']->ipk }}</td>
      <td>{{ $extensions[$loop->index]['api']->yudisiumstatus }}</td>
      <td>{{ $extensions[$loop->index]['api']->credit_complete }}</td>
      <td>{{ $extensions[$loop->index]['api']->eprt }}</td>
      <td>{{ $extensions[$loop->index]['api']->tak }}</td> 
      <td>{{ $extensions[$loop->index]['api']->catatan_etik }}</td> 
      <td>{{ $extensions[$loop->index]['api']->journal_media }}</td> 
      @else
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>{{ $schedule->sidang->mahasiswa->eprt }}</td>
      <td>-</td>
      <td>-</td>
      <td>-</td>
      @endif

      <td>
      @if (count( $schedule->masalah() ) == 0)
        {{ 'tidak ada masalah' }}
      @else
        <ul>
        @foreach( $schedule->masalah() as $masalah )
          <li>{{ $masalah }} </li><br>
        @endforeach
        </ul>
      @endif
      </td>

    </tr>
    @endforeach
  </tbody>
</table>