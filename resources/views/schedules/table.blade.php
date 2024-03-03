@php
    $userInfo = auth()->user();
@endphp
<div class="row">
    <div class="col-sm-6"></div>
    {{-- <div class="col-sm-6">
        <button class="btn btn secondary" data-toggle="modal" data-target="#jadwalPenguji">Lihat Jadwal Dosen
            Penguji</button>
    </div> --}}
</div>
<div class="table-responsive-sm" style="overflow-x:scroll">
    <table class="table table-striped" id="schedules-table">
        <thead>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Judul TA</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Ruang</th>
            @if(($userInfo->isStudent() || $userInfo->isDosen()) && !Request::is('schedules') &&
            !Request::is('schedule/bukaAkses') && !Request::is('schedule/admin-before'))
                <th>Daftar Hadir</th>
            @endif
            <th>Status</th>
            @if($userInfo->isStudent())
                <th>Penguji 1</th>
                <th>Penguji 2</th>
                <th>Keputusan</th>
            @endif
            @if($userInfo->isAdmin() && ( Request::is('schedule/admin') || Request::is('schedule/bermasalah') ))
                <th>KK</th>
            @endif
            @if($userInfo->isDosen() && Request::is('schedule/penguji'))
                <th>Surat Tugas</th>
            @endif
            @if(!(Request::is('schedule/admin-before')))
            <th>Aksi</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($schedules as $schedule)
            @php
                $isHadir = $userInfo->isHadirSidang($schedule->id);
                $isNilai = $userInfo->isNilaiSidang($schedule->id);
            @endphp
            <tr>
                <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
                <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
                <td>{{ $schedule->sidang->judul }}</td>
                <td data-order="{{$schedule->date}}">
                    {{ date('d M y', strtotime($schedule->date)) }}
                </td>
                <td>{{ date('H:i',strtotime($schedule->time)) }}</td>

                @if( Str::contains($schedule->ruang,['http', '.co']))
                    <td>
                        <a href="javascript:attend('{{Str::contains($schedule->ruang,['http']) ? $schedule->ruang : 'https://'.$schedule->ruang}}')"
                           class="btn btn-success btn-sm">Virtual Room</a>
                    </td>
                @else
                    <td>{{ $schedule->ruang }}</td>
                @endif
                @if(($userInfo->isStudent() || $userInfo->isDosen()) && !Request::is('schedules') &&
                !Request::is('schedule/bukaAkses') && !Request::is('schedule/admin-before'))
                    <td>

                        @if($userInfo->lecturer->id == $schedule->penguji1)
                            <form class="form" action="{{ route('attendances.hadir', [$schedule->id]) }}" method="post">
                                @csrf
                                <input type="text" name="date" value="{{ date('Y-m-d', strtotime($schedule->date)) }}"
                                       hidden>
                                <input type="text" name="time" value="{{ date('H:i', strtotime($schedule->time)) }}"
                                       hidden>
                            {{-- {{$isHadir}} --}}


                                {{-- @if($schedule->date > \Carbon\Carbon::today() && $schedule->status == 'belum dilaksanakan'
                                ) @else disabled @endif {{ $isHadir ? 'disabled' : '' }}> --}}
                            {{-- @if ($schedule->date <= \Carbon\Carbon::today() && $schedule->status == 'sedang dilaksanakan')
                                <button type="submit" class='btn btn-outline-primary form' disabled>
                                    Daftar Hadir
                                </button>
@elseif($schedule->date > \Carbon\Carbon::today() && $schedule->status == 'belum dilaksanakan')
                                <button type="submit" class='btn btn-outline-primary form' disabled>
                                    Daftar Hadir
                                </button>
@elseif($schedule->date <= \Carbon\Carbon::today() && $schedule->status == 'belum dilaksanakan')
                                <button type="submit" class='btn btn-outline-primary form'>
                                    Daftar Hadir
                                </button>
                                @elseif($schedule->status == 'telah dilaksanakan')
                                <button type="submit" class='btn btn-outline-primary form' disabled>
                                    Daftar Hadir
                                </button>
                                @endif --}}
                                @php($wwwaktu = date('Y-m-d',strtotime($schedule->date)) . " " . date('H:i',
                                strtotime($schedule->time)))
                                <button type="submit" class='btn btn-outline-primary form' {{ ( date('Y-m-d H:i')>= date('Y-m-d
                            H:i', strtotime($wwwaktu))
                            )
                            ? ($schedule->status == 'belum dilaksanakan') ?'':'disabled'
                            : 'disabled'
                            }}>
                                    Daftar Hadir
                                </button>
                            </form>
                        @else
                            <form class="form" action="{{ route('attendances.hadir', [$schedule->id]) }}" method="post">
                                @csrf
                                <input type="text" name="date" value="{{ date('Y-m-d', strtotime($schedule->date)) }}"
                                       hidden>
                                <input type="text" name="time" value="{{ date('H:i', strtotime($schedule->time)) }}"
                                       hidden>
                                <button class='btn btn-outline-primary form' {{ $schedule->status == "sedang dilaksanakan" ? ''
                            : 'disabled' }} {{ $isHadir ? 'disabled' : '' }}>
                                    Daftar Hadir
                                </button>
                                {{--
                                <hr class="mt-0 mb-0"> --}}
                            </form>
                        @endif
                    </td>
                @endif

                <td class="text-center">
                    @if ($schedule->status == 'telah dilaksanakan')
                        <span class="badge badge-success">TERLAKSANA</span>
                    @elseif ($schedule->status == 'sedang dilaksanakan')
                        <span class="badge badge-warning">BERLANGSUNG</span>
                    @elseif ($schedule->status == 'belum dilaksanakan')
                        <span class="badge badge-secondary">BELUM DILAKSANAKAN</span>
                    @endif

                    {{-- {{ $schedule->status }} --}}

                </td>

                @if($userInfo->isStudent())
                    <td>{{ $schedule->detailpenguji1->code }}</td>
                    <td>{{ $schedule->detailpenguji2->code }}</td>
                    <td>{{ $schedule->keputusan }}</td>
                    <td>
                        <div class='btn-group'>
                            {{-- <form class="" action="{{ route('attendances.hadir', [$schedule->id]) }}" method="post">
                                @csrf
                                <input type="text" name="date" value="{{ date('Y-m-d', strtotime($schedule->date)) }}"
                                    hidden>
                                <input type="text" name="time" value="{{ date('H:i', strtotime($schedule->time)) }}" hidden>
                                <button type="submit" class='btn btn-outline-primary border-0  rounded-0' {{
                                    $schedule->status == "sedang dilaksanakan" ? '' : 'disabled' }} {{ $isHadir ? 'disabled'
                                    : '' }} onclick="return confirm('apakah anda yakin ?')">
                                    Daftar Hadir
                                </button>
                                <hr class="mt-0 mb-0">
                            </form> --}}
                        </div>
                    </td>
                @elseif($userInfo->isPIC() && Request::is('schedules'))


                    <td>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">


                                <button type="button" data-toggle="modal" data-target="#detailSidangModal"
                                        class='btn btn-outline-primary border-0  view w-100'
                                        data-position="{{ $schedule->id }}">
                                    Detail
                                </button>
                                <hr class="mt-0 mb-0">
                                <a href="{{ route('schedules.edit', [$schedule->id]) }}" class='btn btn-outline-primary border-0  w-100
                          {{ $schedule->status != "belum dilaksanakan" ? "disabled" : "" }}'>
                                    Ubah Jadwal
                                </a><br>
                                <hr class="mt-0 mb-0">
                                <a href="{{ url('/schedules/delete',$schedule->sidang->mahasiswa->team_id )}}"
                                   class="btn btn-outline-primary border-0 w-100 delete-confirm {{$schedule->status != 'belum dilaksanakan' ? 'disabled' : '' }}"
                                   id="delete-confirm" data-role="">Hapus</a>
                                <hr class="mt-0 mb-0">

                                <form class="" action="{{ route('schedules.berita_acara.show', [$schedule->id]) }}"
                                      method="get">
                                    @csrf
                                    <button type="submit" class='btn btn-outline-primary border-0  rounded-0 w-100' {{
                                    $schedule->status == 'belum dilaksanakan' ? 'disabled' : '' }}>
                                        Berita Acara
                                    </button>
                                    <hr class="mt-0 mb-0">
                                </form>
                            </div>
                    </td>


                    {{-- <td>
                        {!! Form::open(['route' => ['schedules.destroy', $schedule->sidang->mahasiswa->team_id], 'method' =>
                        'delete']) !!}
                        <div class='btn-group '>
                            <button type="button" data-toggle="modal" data-target="#detailSidangModal"
                                class='btn btn-success view' data-position="{{ $schedule->id }}">
                                Lihat
                            </button>
                            <a hr ef="{{ route('schedules.edit', [$schedule->id]) }}" class='btn btn-info text-white
                              {{ $schedule->status != "belum dilaksanakan" ? "disabled" : "" }}'>
                                <i class="fa fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn
                            btn-danger', 'onclick' => "return confirm('Are you sure?')",($schedule->status != "belum
                            dilaksanakan" ? "disabled" : "" )]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td> --}}

                @elseif($userInfo->isPembimbing() && Request::is('schedule/pembimbing'))
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a href="{{ route('schedules.show', [$schedule->id]) }}"
                                   class='btn btn-outline-primary border-0  w-100'>
                                    Detail
                                </a>
                                <hr class="mt-0 mb-0">
                                {{-- <form action="{{ route('attendances.hadir', [$schedule->id]) }}" method="post">
                                    @csrf
                                    <input type="text" name="date" value="{{ date('Y-m-d', strtotime($schedule->date)) }}"
                                        hidden>
                                    <input type="text" name="time" value="{{ date('H:i', strtotime($schedule->time)) }}"
                                        hidden>
                                    <button type="submit" class='btn btn-outline-primary border-0  rounded-0  w-100' {{
                                        $schedule->status == "sedang dilaksanakan" ? '' : 'disabled' }} {{ $isHadir ?
                                        'disabled' : '' }} onclick="return confirm('apakah anda yakin ?')">
                                        Daftar Hadir
                                    </button>
                                    <hr class="mt-0 mb-0">
                                </form> --}}
                                @if($isNilai)
                                    <a href="{{ route('scores.pembimbing.edit', [$schedule->id]) }}"
                                       class='btn btn-outline-primary border-0  w-100'>
                                        Ubah Nilai
                                    </a>
                                    <hr class="mt-0 mb-0">
                                @else
                                    <a href="{{ route('scores.pembimbing.create', [$schedule->id]) }}" class='btn btn-outline-primary border-0  w-100
                  {{ $schedule->status == "sedang dilaksanakan" ? "" : "disabled" }}
                                    {{ $isHadir ? "" : "disabled" }}'>
                                        Nilai
                                    </a>
                                @endif
                                <hr class="mt-0 mb-0">
                                <a href="{{ route('revisions.create', $schedule->id) }}" class='btn btn-outline-primary border-0  w-100
                  {{ ($schedule->status != "belum dilaksanakan" OR $schedule->flag_add_revision) ? "" : "disabled" }}
                                {{ $isHadir ? "" : "disabled" }}'>
                                    Revisi TA
                                </a>
                                <hr class="mt-0 mb-0">
                                <form class="" action="{{ route('schedules.berita_acara.show', [$schedule->id]) }}"
                                      method="get">
                                    @csrf
                                    <button type="submit" class='btn btn-outline-primary border-0  rounded-0 w-100' {{
                                    $schedule->status == 'belum dilaksanakan' ? 'disabled' : '' }}>
                                        Berita Acara
                                    </button>
                                    <hr class="mt-0 mb-0">
                                </form>
                            </div>
                    </td>


                @elseif($userInfo->isPenguji() && Request::is('schedule/penguji'))
                    <td>
                        @if($schedule->sidang->sk_penguji_file != null)
                            <a href="/uploads/sk_penguji/{{$schedule->sidang->sk_penguji_file}}" class="btn btn-outline-primary" download>Download</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>

                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a href="{{ route('schedules.show', [$schedule->id]) }}"
                                   class='btn btn-outline-primary border-0 w-100'>
                                    Detail
                                </a>
                                <hr class="mt-0 mb-0">
                                {{-- @if($userInfo->lecturer->id == $schedule->penguji1)
                                <form class="" action="{{ route('attendances.hadir', [$schedule->id]) }}" method="post">
                                    @csrf
                                    <input type="text" name="date" value="{{ date('Y-m-d', strtotime($schedule->date)) }}"
                                        hidden>
                                    <input type="text" name="time" value="{{ date('H:i', strtotime($schedule->time)) }}"
                                        hidden>
                                    <button type="submit" class='btn btn-outline-primary border-0  rounded-0 w-100'
                                        onclick="return confirm('Dengan menekan tombol hadir, maka sidang akan dimulai. apakah anda yakin ?')"
                                        {{ $isHadir ? 'disabled' : '' }}>
                                        Daftar Hadir
                                    </button>
                                    <hr class="mt-0 mb-0">
                                </form>
                                @else
                                <form class="" action="{{ route('attendances.hadir', [$schedule->id]) }}" method="post">
                                    @csrf
                                    <input type="text" name="date" value="{{ date('Y-m-d', strtotime($schedule->date)) }}"
                                        hidden>
                                    <input type="text" name="time" value="{{ date('H:i', strtotime($schedule->time)) }}"
                                        hidden>
                                    <button type="submit" class='btn btn-outline-primary border-0 rounded-0 w-100' {{
                                        $schedule->status == "sedang dilaksanakan" ? '' : 'disabled' }} {{ $isHadir ?
                                        'disabled' : '' }} onclick="return confirm('apakah anda yakin ?')">
                                        Daftar Hadir
                                    </button>
                                    <hr class="mt-0 mb-0">
                                </form>
                                @endif --}}
                                @if($isNilai)
                                    <a href="{{ route('scores.penguji.edit', [$schedule->id]) }}"
                                       class='btn btn-outline-primary border-0 w-100'>
                                        Ubah Nilai
                                    </a>
                                    <hr class="mt-0 mb-0">
                                @else
                                    <a href="{{ route('scores.penguji.create', [$schedule->id]) }}" class='btn btn-outline-primary border-0  w-100
                  {{ $schedule->status == "sedang dilaksanakan" ? "" : "disabled" }}
                                    {{ $isHadir ? "" : "disabled" }}'>
                                        Nilai
                                    </a>
                                @endif
                                <hr class="mt-0 mb-0">
                                <a href="{{ route('revisions.create', $schedule->id) }}" class='btn btn-outline-primary border-0 w-100
                {{ ($schedule->status != "belum dilaksanakan" OR $schedule->flag_add_revision) ? "" : "disabled" }}
                                {{ $isHadir ? "" : "disabled" }}'>
                                    Revisi TA
                                </a>
                                <hr class="mt-0 mb-0">
                                @if($userInfo->lecturer->id == $schedule->penguji1)
                                    <a href="{{ route('scores.simpulan', [$schedule->id]) }}" class='btn btn-outline-primary border-0  w-100
                  {{ $schedule->status == "sedang dilaksanakan" ? "" : "disabled" }}
                                    {{ $isHadir ? "" : "disabled" }}'>
                                        Simpulan Nilai
                                    </a>
                                    <hr class="mt-0 mb-0">
                                @endif
                                <form class="" action="{{ route('schedules.berita_acara.show', [$schedule->id]) }}"
                                      method="get">
                                    @csrf
                                    <button type="submit" class='btn btn-outline-primary border-0  rounded-0 w-100' {{
                                    $schedule->status == 'belum dilaksanakan' ? 'disabled' : '' }}>
                                        Berita Acara
                                    </button>
                                    <hr class="mt-0 mb-0">
                                </form>
                            </div>
                    </td>


                @elseif(($userInfo->isAdmin() || $userInfo->isPIC() ) && ( Request::is('schedule/admin') ||
                Request::is('schedule/bukaAkses') || Request::is('schedule/bermasalah') ))
                    @if(!$userInfo->isPIC() || $userInfo->isAdmin())
                        <td>
                            {{ $schedule->sidang->mahasiswa->kk }}
                        </td>
                    @endif
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a href="{{ route('schedules.show', [$schedule->id]) }}"
                                   class='btn btn-outline-primary border-0  w-100'>
                                    Detail
                                </a>
                                <hr class="mt-0 mb-0">
                                @if( Request::is('schedule/bermasalah') )
                                    <a href="{{ route('scores.simpulan', [$schedule->id]) }}" class='btn btn-outline-primary border-0  w-100
                  {{ $schedule->status == "sedang dilaksanakan" ? "" : "disabled" }}'>
                                        Simpulan Nilai
                                    </a>
                                    <hr class="mt-0 mb-0">
                                    <a href="{{ route('revisions.show', [$schedule->id]) }}"
                                       class='btn btn-outline-primary border-0  w-100'>
                                        Lihat Revisi
                                    </a>
                                    <hr class="mt-0 mb-0">
                                @else
                                    <a href="{{ route('schedule.addFlag', [$schedule->id,'code' => 'rev']) }}"
                                       class='btn btn-outline-primary border-0  {{ $schedule->status != "belum dilaksanakan" ? "" : "disabled" }} w-100'>
                                        Buka Revisi
                                    </a>
                                    <hr class="mt-0 mb-0">
                                    <a href="{{ route('schedule.addFlag', [$schedule->id,'code' => 'scr']) }}"
                                       class='btn btn-outline-primary border-0  {{ $schedule->status != "belum dilaksanakan" ? "" : "disabled" }} w-100'>
                                        Buka Penilaian
                                    </a>
                                    <hr class="mt-0 mb-0">
                                @endif

                            </div>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if($userInfo->isPIC() && Request::is('schedules'))
    @if($schedules != '[]')
        <div class="modal fade" id="detailSidangModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModal"
             aria-hidden="true">
            <form action="" method="post">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Sidang</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <embed id="detail" src="" frameborder="0" width="100%" height="400px">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endif

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">

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
            pageLength: 15,
            order: [
                [3, "desc"]
            ]
        });


        $('.disabled').click(function (e) {
            e.preventDefault();
        })
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Anda Sudah Yakin?',
                text: 'Data ini Dihapus!',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#FF585E',
                confirmButtonColor: '#00A8DC',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus',
                reverseButtons: true

            }).then((res) => {
                if (res.value) {
                    console.log('confirmed');
                    window.location.href = url;
                } else if (res.dismiss == 'cancel') {
                    console.log('cancel');
                    return false;
                } else if (res.dismiss == 'esc') {
                    console.log('cancle-esc**strong text**');
                }
            });
        });

        $('.form').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var data = $(this).serialize();
            Swal.fire({
                title: "Apakah Anda Yakin",
                text: "Dengan menekan tombol hadir, maka sidang akan dimulai. Apakah anda yakin ?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#FF585E',
                confirmButtonColor: '#00A8DC',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hadir',
                reverseButtons: true

            })
                .then((res) => {
                    if (res.value) {
                        console.log('confirmed');
                        form.submit();
                    } else if (res.dismiss == 'cancel') {
                        console.log('cancel');
                        return false;
                    } else if (res.dismiss == 'esc') {
                        console.log('cancle-esc**strong text**');
                        return false;

                    }
                });
        });
    </script>

    @if($schedules != '[]')
        <script>
            function attend(link) {
                console.log(link)
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Diharapkan menggunakan Email SSO pada Google Meet',
                    icon: 'info',
                    confirmButtonText: 'Ok'
                }).then(function () {
                    window.open(link, "_blank");
                });
            }
        </script>
    @endif
@endpush()
