<div class="table-responsive-sm" style="overflow-x:scroll">
    <table class="table table-striped" id="schedules-table">
        <thead>
          <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Judul TA</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Penguji</th>
            <th>Keputusan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($schedules as $schedule)
            <tr>
            <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
            <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
            <td>{{ $schedule->sidang->judul }}</td>
            <td>
              {{ date('d M y', strtotime($schedule->date)) }} {{ date('H:i',strtotime($schedule->time)) }}
            </td>
            <td>{{ $schedule->status }}</td>
            <td> Penguji 1 {{ $schedule->detailpenguji1->code }}
                Penguji 2{{ $schedule->detailpenguji2->code }}</td>
            <td>{{ $schedule->keputusan }}</td>
            <td>
                <a href="{{ route('scores.pembimbing.edit', [$schedule->id,'lid' => $schedule->sidang->pembimbing1->id,'code' => 'pembimbing']) }}" class='btn btn-primary w-100
                  {{ $schedule->status == "belum dilaksanakan" || $schedule->keputusan == "tidak lulus" ? "disabled" : "" }}'>
                  Ubah Nilai Pembimbing 1
                </a>
                <a href="{{ route('scores.pembimbing.edit', [$schedule->id,'lid' => $schedule->sidang->pembimbing2->id,'code' => 'pembimbing']) }}" class='btn btn-primary w-100
                  {{ $schedule->status == "belum dilaksanakan" || $schedule->keputusan == "tidak lulus" ? "disabled" : "" }}'>
                  Ubah Nilai Pembimbing 2
                </a>
                <a href="{{ route('scores.penguji.edit', [$schedule->id,'lid' => $schedule->detailpenguji1->id,'code' => 'penguji']) }}" class='btn btn-primary w-100
                  {{ ($schedule->status == "belum dilaksanakan") || $schedule->keputusan == "tidak lulus" ? "disabled" : "" }}'>
                  Ubah Nilai Penguji 1
                </a>
                <a href="{{ route('scores.penguji.edit', [$schedule->id,'lid' => $schedule->detailpenguji2->id,'code' => 'penguji']) }}" class='btn btn-primary w-100
                  {{ ($schedule->status == "belum dilaksanakan") || $schedule->keputusan == "tidak lulus" ? "disabled" : "" }}'>
                  Ubah Nilai Penguji 2
                </a>
                <a href="{{ route('scores.simpulan', [$schedule->id]) }}" class='btn btn-danger w-100
                  {{ $schedule->status == "belum dilaksanakan" || $schedule->keputusan == "tidak lulus" ? "disabled" : "" }}'>
                  Simpulan Nilai
                </a>
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
