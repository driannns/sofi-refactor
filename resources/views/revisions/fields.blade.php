<!-- Schedule Id Field -->
{!! Form::number('schedule_id', $schedule->id, ['class' => 'form-control','hidden'=>'true']) !!}
<div class="ml-2 mb-5">
    <div class="form-group row">
        <label class="col-sm-2 col-form-label font-weight-bold">NAMA LENGKAP</label>
        <div class="col-sm-10">
            <span> : {{ $schedule->sidang->mahasiswa->user->nama }} /
                {{ $schedule->sidang->mahasiswa->nim }}</span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label font-weight-bold">JUDUL TUGAS AKHIR</label>
        <div class="col-sm-6">
            <span> : {{ $schedule->sidang->judul}}</span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label font-weight-bold">JENIS SIDANG</label>
        <div class="col-sm-10">
            <span> :
                {{Str::contains($schedule->sidang->mahasiswa->team->name,'Individu') ? 'INDIVIDU' : 'KELOMPOK'}}</span>
        </div>
    </div>
    <div class="row float-right">
        {{-- <a href='javascript:attend()' class='btn btn-outline-primary  mb-2 ml-3 fileuploadspan' id='submit-button' >Upload file</a>  --}}
        <div class="btn btn-outline-primary mb-2 mr-3" data-toggle="modal" data-target="#informasirevisi"><a> Informasi Revisi</a></div>
    </div>

    {{-- MODAL INFORAMASI REVISI  --}}
    <div class="modal fade" id="informasirevisi">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">INFORMASI REVISI</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Dosen</th>
                                <th>Status Revisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b> PENGUJI 1</b> ({{$penguji1->nip}}/{{$penguji1->user->nama}})</td>
                                <td>@if($npenguji1 > 0 )
                                    <span class="badge badge-success">Sudah Mengisi Revisi</span>
                                    @else
                                    <span class="badge badge-secondary">Belum Mengisi Revisi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b> PENGUJI 2</b> ({{$penguji2->nip}}/{{$penguji2->user->nama}})</td>
                                <td>
                                    @if($npenguji2 > 0 )
                                    <span class="badge badge-success">Sudah Mengisi Revisi</span>
                                    @else
                                    <span class="badge badge-secondary">Belum Mengisi Revisi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><b> PEMBIMBING 1</b> ({{$pembimbing1->nip}}/{{$pembimbing1->user->nama}})</td>
                                <td>
                                    @if($npembimbing1 > 0 )
                                    <span class="badge badge-success">Sudah Mengisi Revisi</span>
                                    @else
                                    <span class="badge badge-secondary">Belum Mengisi Revisi</span>
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td><b> PEMBIMBING 2</b> ({{$pembimbing2->nip}}/{{$pembimbing2->user->nama}})</td>
                                <td>
                                    @if($npembimbing2 > 0 )
                                    <span class="badge badge-success">Sudah Mengisi Revisi</span>
                                    @else
                                    <span class="badge badge-secondary">Belum Mengisi Revisi</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-secondary">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="form-group col-sm-4">
    {!! Form::text('mahasiswa', $schedule->sidang->mahasiswa->user->nama, ['class' => 'form-control','readonly'=>'true']) !!}
  </div> --}}
</div>

<table class="table table-responsive-lg table-bordered datatable">
    <thead>
        <tr>
            <th>Deskripsi Revisi</th>
            <th>Halaman</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="revisionPlace">
        @if($revisions == null)
        <tr>
            <td>
                <div class="form-group col-sm-12">
                    {!! Form::textarea('deskripsi[]', null, ['class' => 'form-control','rows' => '1', 'cols' =>
                    '50']) !!}
                </div>
            </td>
            <td>
                <div class="form-group col-sm-12">
                    {!! Form::text('hal[]', null, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>

            </td>
            <td>
                <!-- <a href='javascript:attend()' class='btn btn-outline-primary w-100 fileuploadspan '>Upload</a> -->
            </td>
        </tr>
        @else
        @foreach($revisions as $revision)
        <tr>
            <input type="text" name="revision_id[]" value="{{ $revision->id }}" hidden>
            <td>
                <div class="form-group col-sm-12">
                    {!! Form::textarea('deskripsi[]', $revision->deskripsi, ['class' => 'form-control','rows' => '1',
                    'cols' => '50']) !!}
                </div>
            </td>
            <td>
                <div class="form-group col-sm-12">
                    {!! Form::text('hal[]', $revision->hal, ['class' => 'form-control']) !!}
                </div>
            </td>
            <td>
                <div class="form-group col-sm-12">
                    @if ($revision->status == 'disetujui')
                    <span class="badge badge-success">{{ strtoupper($revision->status) }} </span>
                    @elseif ($revision->status == 'sudah dikirim')
                    <span class="badge badge-warning">{{ strtoupper($revision->status) }} </span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-secondary">{{ strtoupper($revision->status) }} </span>
                    @elseif ($revision->status == 'ditolak')
                    <span class="badge badge-danger">{{ strtoupper($revision->status) }} </span>
                    @endif
                </div>
            </td>

            <td>
                <input type="text" hidden name='dokumen_id[]' value="{{$revision->dokumen_id}}">
                @if($revisions != null)
                    @if(!file_exists($revision->dokumen->file_url) or ($revision->dokumen->jenis == "draft"))
                        File tidak ada
                    @else
                    <div class="form-group col-sm-3">
                        <button type="button" name="button" class="btn btn-outline-success" data-toggle="modal" data-target="#viewDokumenTA{{$revision->id}}">Lihat {{$revision->dokumen->nama}}</button>
                    </div>

                    @endif
                @else
                    <div class="form-group col-sm-5">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="forminput" name="dokumen_ta">
                                <label class="custom-file-label">Upload</label>
                            </div>
                        </div>
                    </div>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<div class="form-group col-sm-12">
    <button type="button" id="addRevisi" class='btn btn-outline-success'
    @if ($schedule->sidang->status == "lulus" && Carbon\Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +7 ) >= now())
        disabled
        @elseif ($schedule->sidang->status == "lulus")
        disabled
        @else
        {{ $isLate ? 'disabled' : '' }}
        @endif > Tambah Baris Revisi </button>
    @if ($schedule->sidang->status == "lulus" AND Carbon\Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +7 ) >= now())
    <a href="#" class="btn btn-primary disabled">Upload File</a>
    @elseif ($schedule->sidang->status == "lulus")
    <a href="#" class="btn btn-primary disabled">Upload File</a>
    @else
    <a href="javascript:attend2()" data-toggle="modal" data-target="#modalupload" class="btn btn-primary {{ $isLate ? 'disabled' : '' }}">Upload File <div class="namafile"> </div></a>
    @endif

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    @if ($schedule->sidang->status == "lulus" AND Carbon\Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +7 ) >= now())
    <a href="#" class="btn btn-primary disabled">Simpan</a>
    @elseif ($schedule->sidang->status == "lulus")
    <a href="#" class="btn btn-primary disabled">Simpan</a>
    @else
    <a href="javascript:attend2()" class="btn btn-primary {{ $isLate ? 'disabled' : '' }}">Simpan</a>
    @endif
    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-secondary">Batal</a>
</div>
@if($revisions != null)
@foreach($revisions as $revision)
<div class="modal fade" id="viewDokumenTA{{$revision->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Dokumen TA </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    @if(count($revisions) != 0)
                    <embed src="/{{$revision->dokumen->file_url}}" type="application/pdf" frameborder="0" width="100%" height="400px">
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

{{-- MODAL UPLOAD --}}

{!! Form::number('schedule_id', $schedule->id, ['class' => 'form-control','hidden'=>'true']) !!}
<div class="modal fade" id="modalupload">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Upload Dokumen</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            @csrf
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h2 class="text-right">PILIH FILE DOKUMEN REVISI</h2>
                        <p class="text-right">Format file <b> PDF </b> (maksimal 5mb)
                        </p>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileInput" required name="file">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Upload</button>
                    <button data-dismiss="modal" class="btn btn-secondary">Batal</button>
                </div>

            </div>
        </div>
    </div>


    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">

    <script type="text/javascript">
        $(document).ready(function() {

            $("textarea").each(function(textarea) {
                $(this).height($(this)[0].scrollHeight);
            });

            $('textarea').on('keyup', function() {
                $(this).height(5);
                if (this.scrollHeight > 5)
                    $(this).height(this.scrollHeight);
            })

            $('#fileInput').on('change', function() {
                var fileName = $(this).val();
                $(this).next('.custom-file-label').html(fileName);
            })

            $('#addRevisi').on('click', function() {
                var line =

                    "<tr>" +
                    "<td>" +
                    "<div class='form-group col-sm-12'>" +
                    "<textarea name='deskripsi[]' rows='1' cols='50' required class='form-control' ></textarea>" +
                    "</div>" +
                    "</td>" +
                    "<td>" +
                    "<div class='form-group col-sm-12'>" +
                    "<input type='text' name='hal[] ' required class='form-control' value=''>" +
                    "</div>" +
                    "</td>" +
                    "<td></td>" +
                    "<td>" +
                    "<div class='form-group col-sm-12'>" +

                    "<button type='button' name='btn-del' class='btn btn-danger w-100 delbutton'>" +
                    "Hapus Baris" +
                    "</button>" +
                    "</div>" +
                    "</td>" +
                    "</tr>";
                $('#revisionPlace').append(line);
            });

            $('#revisionPlace').on('click', '.delbutton', function(e) {
                $(this).closest('tr').remove();
            })
        });
        $('#fileInput').change(function(e) {
            var filename = this.files[0].name;
            $('.namafile').text(filename);
            $('#submit-button').data('tooltip', false)
                .tooltip({
                    title: filename
                });
            $('[data-toggle="modal"]').tooltip();
        });
    </script>
    </script>

    <script>
        function attend(link) {
            console.log(link)
            Swal.fire({
                title: 'Perhatian!',
                text: 'Upload dokumen tidak bisa dilakukan secara bersamaan.',
                icon: 'info',
                confirmButtonText: 'Ok'
            }).then(function() {
                $("#modalupload").modal();
            });
        }

        function attend2(link) {
            console.log(link)
            Swal.fire({
                title: 'Perhatian!',
                text: 'Pastikan data yang Anda masukan sudah benar dan revisi hanya dapat ditambahkan pada hari sidang berlangsung.',
                icon: 'info',
                showCancelButton: true,
                cancelButtonColor: '#f86c6b',
                confirmButtonColor: '#43afd6',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Simpan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("frm1").submit();
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        }
    </script>
    @endpush
