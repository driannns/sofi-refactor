<table>
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIM</td>
    <td>Program Studi</td>
    @foreach($clos as $clo)
      @foreach($clo_pembimbing as $clo_pem)
      @if($clo->id == $clo_pem->id)
      <td>{{ $clo->components[0]->code }} - 1 ({{ $clo->precentage }}%)</td>
      @endif
      @endforeach
      @foreach($clo_penguji as $clo_peng)
      @if($clo->id == $clo_peng->id)
      <td>{{ $clo->components[0]->code }} - 2 ({{ $clo->precentage }}%)</td>
      @endif
      @endforeach
    @endforeach
  </tr>
  @foreach($schedules as $schedule)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
    <td>{{ $schedule->sidang->mahasiswa_id }}</td>
    <td>{{ $schedule->sidang->mahasiswa->study_program }}</td>
    @foreach($clos as $clo)
      @foreach($clo_pembimbing as $clo_pem)
      @if($clo->id == $clo_pem->id)
      <td>{{ $scores[$schedule->sidang->mahasiswa_id]['pembimbing'][$clo->code] }}</td>
      @endif
      @endforeach
      @foreach($clo_penguji as $clo_peng)
      @if($clo->id == $clo_peng->id)
      <td>{{ $scores[$schedule->sidang->mahasiswa_id]['penguji'][$clo->code] }}</td>
      @endif
      @endforeach
    @endforeach
  </tr>
  @endforeach
</table>
