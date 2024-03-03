<div class="table-responsive-sm" style="overflow-x:scroll">
    <table class="table table-striped" id="schedules-table">
        <thead>
          <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Waktu</th>
            <th>Penguji & Pembimbing</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
        @foreach($schedules as $schedule)
            <tr>
              <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
              <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
              <td>
                {{ date('d M y', strtotime($schedule->date)) }} {{ date('H:i',strtotime($schedule->time)) }}
              </td>
              <td> Penguji 1 {{ $schedule->detailpenguji1->user->nama }} <br>
                  Penguji 2 {{ $schedule->detailpenguji2->user->nama }}<br>
                  Pembimbing 1 {{ $schedule->sidang->pembimbing1->user->nama }}<br>
                  Pembimbing 2 {{ $schedule->sidang->pembimbing2->user->nama }}
              </td>
              <td>
                @if (count( $schedule->masalah() ) == 0)
                  {{ 'tidak ada masalah' }}
                @else
                  <ul>
                  @foreach( $schedule->masalah() as $masalah )
                    <li>{{ $masalah }} </li>
                  @endforeach
                  </ul>
                @endif
              </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script type="text/javascript">
  $('.view').on("click", function () {
        var position = $(this).data('position');
        detail = "{{ url('/schedule') }}"+"/"+position;
        $("#detail").attr("src", detail);
    });
    $('#schedules-table').DataTable({
        pageLength: 15,
        order: [[ 3, "desc" ]]
    });
</script>
@endpush()
