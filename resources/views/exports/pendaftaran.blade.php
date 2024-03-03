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
      <td>Jumlah bimbingan Pemb 1 dan 2</td>
      <td>Status SK TA(Aktif/tidak aktif)</td>
      <td>Judul TA (B.Ind)</td>
      <td>Judul TA (B. Ingg)</td>
      <td>Kelompok Keahlian</td>
      <td>Peminatan</td>
      <td>Dosen Wali</td>
      <td>IPK sementara</td>
      <td>Total SKS Lulus</td>
      <td>Skor EPrT</td>
      <td>Skor TAK</td>
      <td>Status tunggakan keuangan</td>
    </tr>
  </thead>
  <tbody>
    @foreach($sidangs as $sidang)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $sidang->mahasiswa->user->nama }}</td>
      <td>{{ $sidang->mahasiswa_id }}
      <td>{{ $sidang->mahasiswa->study_program }}</td>

      @if($extensions[$loop->index] != null)
      <td>{{ $extensions[$loop->index]->class }}</td>
      <td>{{ $extensions[$loop->index]->mobilephone }}</td>
      @else
      <td>-</td>
      <td>-</td>
      @endif

      <td>{{ $sidang->pembimbing1->user->nama }}</td>
      <td>{{ $sidang->pembimbing2->user->nama }}</td>
      @php
      $dataBimbingan = explode(";", $sidang->form_bimbingan);
      if(count($dataBimbingan)>1){
        $bimbingan1 = $dataBimbingan[0];
        $bimbingan2 = $dataBimbingan[1];
      }else{
        $bimbingan1 = "tidak ada data";
        $bimbingan2 = "tidak ada data";
      }
      @endphp
      <td>
        Pembimbing 1 = {{ $bimbingan1 }}<br>
        Pembimbing 2 = {{ $bimbingan2 }}
      </td>

      @if($extensions[$loop->index] != null)
      <td>{{ $extensions[$loop->index]->finaltask_status }}</td>
      @else
      <td>-</td>
      @endif

      <td>{{ $sidang->judul }}</td>

      @if($extensions[$loop->index] != null)
      <td>{{ $extensions[$loop->index]->titile_eng }}</td>
      @else
      <td>-</td>
      @endif

      <td>{{ $sidang->mahasiswa->kk }}</td>
      @if($sidang->mahasiswa->peminatan != null)
      <td>{{ $sidang->mahasiswa->peminatan->nama }}</td>
      @else
      <td>-</td>
      @endif

      @if($extensions[$loop->index] != null)
      <td>{{ $extensions[$loop->index]->lecturercode }}</td>
      <td>{{ $extensions[$loop->index]->ipk }}</td>
      <td>{{ $extensions[$loop->index]->credit_complete }}</td>
      <td>{{ $extensions[$loop->index]->eprt }}</td>
      <td>{{ $extensions[$loop->index]->tak }}</td>
      <td>{{ $extensions[$loop->index]->statustunggakan }}</td>
      @else
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>{{ $sidang->mahasiswa->eprt }}</td>
      <td>{{ $sidang->mahasiswa->tak }}</td>
      <td>-</td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>