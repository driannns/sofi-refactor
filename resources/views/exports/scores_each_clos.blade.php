<table>
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIM</td>
    <td>Program Studi</td>
    @foreach($clos->groupBy('code') as $clo)
    <td>{{ $clo[0]->components[0]->code }}</td>
    @endforeach
  </tr>
  @foreach($schedules as $index => $schedule)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
    <td>{{ $schedule->sidang->mahasiswa_id }}</td>
    <td>{{ $schedule->sidang->mahasiswa->study_program }}</td>
    @foreach($clos->groupBy('code') as $clo)
    @if(empty($score_clos[$index][$clo[0]->components[0]->id]))
    <td>-</td>
    @else
    <td>{{ $score_clos[$index][$clo[0]->components[0]->id] }}</td>
    @endif
    @endforeach
  </tr>
  @endforeach
</table>
