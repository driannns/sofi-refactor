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
      <td>Jadwal Sidang (Hari, Tanggal)</td>
      <td>Jadwal Sidang (Jam)</td>
      <td>Jadwal Sidang (Ruang)</td>
{{--      <!-- <td>Judul TA (B.Ind)</td>--}}
{{--      <td>Judul TA (B. Ingg)</td> -->--}}
      <td>Kelompok Keahlian</td>
      <td>Peminatan</td>
      <td>Skor EPrT</td>
      <td>Dosen Wali</td>
    </tr>
  </thead>
  <tbody>
    @foreach($schedules as $schedule)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
      <td>{{ $schedule->sidang->mahasiswa_id }}
      <td>{{ $schedule->sidang->mahasiswa->study_program }}</td>

      @if($extensions[$loop->index] != null)
      <td>{{ $extensions[$loop->index]->class }}</td>
      <td>{{ $extensions[$loop->index]->mobilephone }}</td>
      @else
      <td>-</td>
      <td>-</td>
      @endif

      <td>{{ $schedule->sidang->pembimbing1->user->nama }}</td>
      <td>{{ $schedule->sidang->pembimbing2->user->nama }}</td>
      <td>{{ $schedule->detailpenguji1->user->nama }}</td>
      <td>{{ $schedule->detailpenguji2->user->nama }}</td>
      <td>{{ date('d-M-y', strtotime($schedule->date)) }}</td>
      <td>{{ date('H:i',strtotime($schedule->time)) }}</td>
      <td>{{ $schedule->ruang }}</td>

{{--      <!-- <td>{{ $schedule->sidang->judul }}</td>--}}

{{--      @if($extensions[$loop->index] != null)--}}
{{--      <td>{{ $extensions[$loop->index]->titile_eng }}</td>--}}
{{--      @else--}}
{{--      <td>-</td>--}}
{{--      @endif -->--}}

      <td>{{ $schedule->sidang->mahasiswa->kk }}</td>

      @if($schedule->sidang->mahasiswa->peminatan != null)
      <td>{{ $schedule->sidang->mahasiswa->peminatan->nama }}</td>
      @else
      <td>-</td>
      @endif

      @if($extensions[$loop->index] != null)
      <td>{{ $extensions[$loop->index]->eprt }}</td>
      <td>{{ $extensions[$loop->index]->lecturercode }}</td>
      @else
      <td>{{ $schedule->sidang->mahasiswa->eprt }}</td>
      <td>-</td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>
