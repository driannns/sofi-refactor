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
      <td>Angkatan</td>
      <td>Jumlah Semester</td>
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
      <td>{{ $extensions[$loop->index]->angkatan }}</td>
      <td>{{ $extensions[$loop->index]->semester }}</td>
        @if($extensions[$loop->index]->semester <= 8)
        <td>Lulus Tepat Waktu</td>
        @else
        <td>Tidak Lulus Tepat Waktu</td>
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