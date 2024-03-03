@php
$userInfo = auth()->user();
@endphp
@if($schedules != '[]')
<form>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label font-weight-bold">Nama Lengkap</label>
        <div class="col-sm-10">
            <span> : {{ $schedules[0]->sidang->mahasiswa->user->nama }} /
                {{ $schedules[0]->sidang->mahasiswa->nim }}</span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label font-weight-bold">Judul Tugas Akhir</label>
        <div class="col-sm-6">
            <span> : {{ $schedules[0]->sidang->judul}}</span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label font-weight-bold">Jenis Sidang</label>
        <div class="col-sm-10">
            <span> :
                {{Str::contains($schedules[0]->sidang->mahasiswa->team->name,'Individu') ? 'INDIVIDU' : 'KELOMPOK'}}</span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label font-weight-bold">Anggota</label>
        <div class="col-sm-10">
            @foreach ($teams as $team)
            <span> : {{$team->sidang->mahasiswa->user->nama}} / {{ $team->sidang->mahasiswa->nim }}</span><br>
            @endforeach
        </div>
    </div>
</form>
@endif
<div class="table-responsive-sm" style="overflow-x:scroll">
    <table class="table table-striped text-center" id="schedules-table">
        <thead>
            <tr>
                <th>Jadwal</th>
                <th>Jam</th>
                <th>Penguji 1</th>
                <th>Penguji 2</th>
                <th>Status</th>
                <th>Daftar Hadir</th>
                <th>Ruang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            @php
            $isHadir = $userInfo->isHadirSidang($schedule->id);
            $isNilai = $userInfo->isNilaiSidang($schedule->id);
            @endphp
            <tr>
                <td data-order="{{$schedule->date}}">
                    {{ date('d M y', strtotime($schedule->date)) }}
                </td>
                <td>{{ date('H:i',strtotime($schedule->time)) }}</td>
                <td>{{ $schedule->detailpenguji1->code }}</td>
                <td>{{ $schedule->detailpenguji2->code }}</td>
                <td>
                    @if ($schedule->status == 'belum dilaksanakan')
                    <span class="badge badge-secondary">BELUM DILAKSANAKAN</span>
                    @elseif($schedule->status == 'telah dijadwalkan')
                    <span class="badge badge-info">DIJADWALKAN</span>
                    @elseif($schedule->status == 'telah dilaksanakan')
                    <span class="badge badge-primary">TERLAKSANA</span>
                    @elseif ($schedule->status == 'sedang dilaksanakan')
                    <span class="badge badge-success">BERLANGSUNG</span>
                    @endif

                    {{-- {{ strtoupper($schedule->status) }} --}}
                </td>

                <td>

                    <form class="form" action="{{ route('attendances.hadir', [$schedule->id]) }}" method="post">
                        @csrf
                        <input type="text" name="date" value="{{ date('Y-m-d', strtotime($schedule->date)) }}" hidden>
                        <input type="text" name="time" value="{{ date('H:i', strtotime($schedule->time)) }}" hidden>

                        <!-- @if ($schedule->date <= \Carbon\Carbon::today() && $schedule->status == 'sedang dilaksanakan')
                        <button type="submit" class='btn btn-outline-primary btn-sm form'
                            {{ $isHadir ? 'disabled' : '' }}>
                            Daftar Hadir
                        </button>
                        @elseif($schedule->date > \Carbon\Carbon::today())
                        <button disabled type="submit" class='btn btn-outline-primary btn-sm form'
                            {{ $isHadir ? 'disabled' : '' }}>
                            Daftar Hadir
                        </button>
                        @elseif($schedule->status == 'belum dilaksanakan')
                        <button disabled type="submit" class='btn btn-outline-primary btn-sm form'
                            {{ $isHadir ? 'disabled' : '' }}>
                            Daftar Hadir
                        </button>
                        @elseif($schedule->status == 'telah dilaksanakan')
                        <button disabled type="submit" class='btn btn-outline-primary btn-sm form'
                            {{ $isHadir ? 'disabled' : '' }}>
                            Daftar Hadir
                        </button>
                        @endif -->
                        <button class='btn btn-outline-primary btn-sm form' {{ $schedule->status == "sedang dilaksanakan" ? '' : 'disabled' }} {{ $isHadir ? 'disabled' : '' }}>
                            Daftar Hadir
                        </button>
                        {{-- <hr class="mt-0 mb-0"> --}}
                    </form>
                </td>
{{--
                @if( Str::contains($schedule->ruang,['http', '.co']))
                <td>
                    @if ($schedule->date <= \Carbon\Carbon::today() && $schedule->status == 'sedang dilaksanakan')
                        <a href="javascript:attend()" class="btn btn-success btn-sm">Google Meet</a>
                        @elseif($schedule->date > \Carbon\Carbon::today())
                        <span class="badge badge-warning">{{ strtoupper('Belum Memasuki Jadwal Sidang') }}</span>
                        @elseif($schedule->status == 'belum dilaksanakan')
                        <span class="badge badge-warning">{{ strtoupper('Penguji 1 Belum Membuka Sidang') }}</span>
                        @elseif($schedule->status == 'telah dilaksanakan')
                        <span class="badge badge-success">{{ strtoupper('Sidang Telah Dilaksanakan') }}</span>
                        @endif
                </td>
                @else --}}
                @if( Str::contains($schedule->ruang,['http', '.co']))
                    <td>
                        <a href="javascript:attend('{{Str::contains($schedule->ruang,['http']) ? $schedule->ruang : 'https://'.$schedule->ruang}}')"
                           class="btn btn-success btn-sm">Virtual Room</a>
                    </td>
                @else
                    <td>{{ $schedule->ruang }}</td>
                @endif
                {{-- @endif --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">
<script type="text/javascript">
    $(document).ready(function () {
        $('#schedules-table_filter').append(
            '<br><span style="font-weight: bold;font-style: italic;font-size:11px">*Diharapkan menggunakan akun SSO pada Google Meet</span><br>'
            )
    });

    $('.view').on("click", function () {
        var position = $(this).data('position');
        detail = "{{ url('/schedule') }}" + "/" + position;
        $("#detail").attr("src", detail);
    });
    $('#schedules-table').DataTable({
        lengthChange: false,
        pageLength: 15,
        order: [
            [3, "desc"]
        ]
    });
</script>

@if($schedules != '[]')
<script>
    function attend(link) {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Diharapkan menggunakan akun SSO pada Google Meet',
            icon: 'info',
            confirmButtonColor: '#00A8DC',
            confirmButtonText: 'Ok'
        }).then(function () {
            window.open(link,"_blank");
        });
    }


    $('.form').on('submit', function (e) {
        e.preventDefault();
        var form = this;
        var data = $(this).serialize();
        Swal.fire({
            title: "Apakah Anda Yakin",
            text: "Dengan menekan tombol hadir, maka sidang akan dimulai. Apakah anda yakin  !",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#FF585E',
            confirmButtonColor: '#00A8DC',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hadir',
            reverseButtons: true

        }) .then((res) => {
            if(res.value){
                console.log('confirmed');
                form.submit();
            }else if(res.dismiss == 'cancel'){
                console.log('cancel');
                return false;
            }
            else if(res.dismiss == 'esc'){
                console.log('cancle-esc**strong text**');
                return false;

            }
        });
      });
</script>



@endif
@endpush()
