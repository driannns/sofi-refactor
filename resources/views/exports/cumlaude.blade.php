<table>
  <thead>
    <tr>
      <td>No</td>
      <td>Nama</td>
      <td>NIM</td>
      <td>Program Studi</td>
      <td>Kelompok Keahlian</td>
      <td>Peminatan</td>
      <td>IPK</td>
      <td>Jumlah Semester</td>
      <td>Persyaratan Cumlaude</td>
      <td>Keterangan</td>
    </tr>
  </thead>
  <tbody>
    @foreach($sidangs as $sidang)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $sidang->mahasiswa->user->nama }}</td>
      <td>{{ $sidang->mahasiswa_id }}
      <td>{{ $sidang->mahasiswa->study_program }}</td>
      <td>{{ $sidang->mahasiswa->kk }}</td>

      @if($sidang->mahasiswa->peminatan != null)
      <td>{{ $sidang->mahasiswa->peminatan->nama }}</td>
      @else
      <td>-</td>
      @endif

      @if($extensions[$loop->index] != null)
      <td>{{ $extensions[$loop->index]->ipk }}</td>
      <td>{{ $extensions[$loop->index]->semester }}</td>
      <td>{{ $extensions[$loop->index]->journal_media }}</td>
        @if($extensions[$loop->index]->semester <= 8 AND $extensions[$loop->index]->ipk >= 3.51)
        <td>Cumlaude</td>
        @else
        <td>Tidak Cumlaude</td>
        @endif
      @else
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>Data API Tidak Ditemukan</td>
      @endif
    
    </tr>
    @endforeach
  </tbody>
</table>