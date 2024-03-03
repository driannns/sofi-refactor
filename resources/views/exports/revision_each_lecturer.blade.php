<table>
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIM</td>
    <td>Program Studi</td>
    <td>Peminatan</td>
    <td>Periode Akademik</td>
    <td>Judul TA</td>
    <td>Pembimbing 1</td>
    <td>Catatan revisi</td>
    <td>Pembimbing 2</td>
    <td>Catatan revisi</td>
    <td>Penguji 1</td>
    <td>Catatan revisi</td>
    <td>Penguji 2</td>
    <td>Catatan revisi</td>
  </tr>
  @foreach($schedules as $index => $schedule)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
    <td>{{ $schedule->sidang->mahasiswa_id }}</td>
    <td>{{ $schedule->sidang->mahasiswa->study_program }}</td>
    <td>{{ $schedule->sidang->mahasiswa->peminatan }}</td>
    <td>{{ $schedule->sidang->period->name }}</td>
    <td>{{ $schedule->sidang->judul }}</td>
    <td>{{ $schedule->sidang->pembimbing1->user->nama }}</td>
    <td>
    @foreach($schedule->revisions_pembimbing1 as $key => $revision)
    {{$key}}:{{ $revision->deskripsi }} <br>
    @endforeach
    </td>
    <td>{{ $schedule->sidang->pembimbing2->user->nama }}</td>
    <td>
      @foreach($schedule->revisions_pembimbing2 as $key => $revision)
        {{$key}}:{{ $revision->deskripsi }} <br>
      @endforeach
    </td>
    <td>{{ $schedule->detailpenguji1->user->nama }}</td>
    <td>
      @foreach($schedule->revisions_penguji1 as $key => $revision)
        {{$key}}:{{ $revision->deskripsi }} <br>
      @endforeach
    </td>
    <td>{{ $schedule->detailpenguji2->user->nama }}</td>
    <td>
      @foreach($schedule->revisions_penguji2 as $key => $revision)
        {{$key}}:{{ $revision->deskripsi }} <br>
      @endforeach
    </td>
  </tr>
  @endforeach
</table>
