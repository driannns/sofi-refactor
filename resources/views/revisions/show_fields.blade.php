<div class="table-responsive-sm bg-light p-5 mb-3">
    <h3 class="font-weight-bold">Daftar Revisi Penguji 1</h3>
    <table class="table table-striped datatable" id="revisions-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi Revisi</th>
                <th>Halaman</th>
                <th>Status</th>
                <th>Oleh</th>
                <th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($revisions as $revision)
            @if($revision->isPenguji1())
            <tr>
                <td>{{ $counter++ }}</td>
                <td class="col-4">  {{ $revision->deskripsi }}</td>
                <td class="text-center">{{ $revision->hal }}</td>
                <td class="text-center">
                    @if ($revision->status == 'sudah dikirim')
                    <span class="badge badge-warning">SUDAH DIKIRIM</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-primary">SEDANG DIKERJAKAN</span>
                    @elseif ($revision->status == 'diterima')
                    <span class="badge badge-success">DITERIMA</span>
                    @elseif ($revision->status == 'disetujui')
                    <span class="badge badge-success">DISETUJUI</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-danger">DITOLAK</span>
                    @endif
                </td>
                <td class="text-center">{{ $revision->lecturer->code }}</td>
                <td>
                    <button type="button" class='btn btn-success modal-document' data-toggle="modal"
                        data-target="#viewDokumenTA" data-document="{{$revision->dokumen->file_url}}"
                        {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}>
                        Detail
                    </button>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-responsive-sm bg-light p-5 mb-3">
    <h3 class="font-weight-bold">Daftar Revisi Penguji 2</h3>
    <table class="table table-striped datatable" id="revisions-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi Revisi</th>
                <th>Halaman</th>
                <th>Status</th>
                <th>Oleh</th>
                <th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($revisions as $revision)
            @if($revision->isPenguji2())
            <tr>
                <td>{{ $counter++ }}</td>
                <td>{{ $revision->deskripsi }}</td>
                <td class="text-center">{{ $revision->hal }}</td>
                <td class="text-center">
                    @if ($revision->status == 'sudah dikirim')
                    <span class="badge badge-warning">SUDAH DIKIRIM</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-primary">SEDANG DIKERJAKAN</span>
                    @elseif ($revision->status == 'diterima')
                    <span class="badge badge-success">DITERIMA</span>
                    @elseif ($revision->status == 'disetujui')
                    <span class="badge badge-success">DISETUJUI</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-danger">DITOLAK</span>
                    @endif
                </td>
                <td class="text-center">{{ $revision->lecturer->code }}</td>
                <td>
                    <button type="button" class='btn btn-success modal-document' data-toggle="modal"
                        data-target="#viewDokumenTA" data-document="{{$revision->dokumen->file_url}}"
                        {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}>
                        Detail
                    </button>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-responsive-sm bg-light p-5 mb-3">
    <h3 class="font-weight-bold">Daftar Revisi Pembimbing 1</h3>
    <table class="table table-striped datatable" id="revisions-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi Revisi</th>
                <th>Halaman</th>
                <th>Status</th>
                <th>Oleh</th>
                <th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($revisions as $revision)
            @if($revision->isPembimbing1())
            <tr>
                <td>{{ $counter++ }}</td>
                <td>{{ $revision->deskripsi }}</td>
                <td class="text-center">{{ $revision->hal }}</td>
                <td class="text-center">
                    @if ($revision->status == 'sudah dikirim')
                    <span class="badge badge-warning">SUDAH DIKIRIM</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-primary">SEDANG DIKERJAKAN</span>
                    @elseif ($revision->status == 'diterima')
                    <span class="badge badge-success">DITERIMA</span>
                    @elseif ($revision->status == 'disetujui')
                    <span class="badge badge-success">DISETUJUI</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-danger">DITOLAK</span>
                    @endif
                </td>
                <td class="text-center">{{ $revision->lecturer->code }}</td>
                <td>
                    <button type="button" class='btn btn-success modal-document' data-toggle="modal"
                        data-target="#viewDokumenTA" data-document="{{$revision->dokumen->file_url}}"
                        {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}>
                        Detail
                    </button>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-responsive-sm bg-light p-5 mb-3">
    <h3 class="font-weight-bold">Daftar Revisi Pembimbing 2</h3>
    <table class="table table-striped datatable" id="revisions-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Deskripsi Revisi</th>
                <th>Halaman</th>
                <th>Status</th>
                <th>Oleh</th>
                <th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($revisions as $revision)
            @if($revision->isPembimbing2())
            <tr>
                <td>{{ $counter++ }}</td>
                <td>{{ $revision->deskripsi }}</td>
                <td class="text-center">{{ $revision->hal }}</td>
                <td class="text-center">
                    @if ($revision->status == 'sudah dikirim')
                    <span class="badge badge-warning">SUDAH DIKIRIM</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-primary">SEDANG DIKERJAKAN</span>
                    @elseif ($revision->status == 'diterima')
                    <span class="badge badge-success">DITERIMA</span>
                    @elseif ($revision->status == 'disetujui')
                    <span class="badge badge-success">DISETUJUI</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-danger">DITOLAK</span>
                    @endif
                </td>
                <td class="text-center">{{ $revision->lecturer->code }}</td>
                <td>
                    <button type="button" class='btn btn-success modal-document' data-toggle="modal"
                        data-target="#viewDokumenTA" data-document="{{$revision->dokumen->file_url}}"
                        {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}>
                        Detail
                    </button>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

@if($revisions != '[]')
<div class="modal fade" id="viewDokumenTA" tabindex="-1" role="dialog" aria-labelledby="feedbackModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Dokumen TA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <embed src="/{{$revision->dokumen->file_url}}" frameborder="0" width="100%" height="400px">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.modal-document').on('click', function () {
            var data = '/' + $(this).data('document');
            console.log(data);
            $('#viewDokumenTA embed').attr('src', data);
        });
    });

</script>
@endpush
