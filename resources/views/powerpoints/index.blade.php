@extends('layouts.app')

@section('content')

<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>MATERI PRESENTASI</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / UPLOAD MATERI PRESENTASI</h6>
    </div>
</ol>


<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        @include('coreui-templates::common.errors')
        @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{Session::get('error')}}
        </div>
        @endif
        @if($sidang->status == 'tidak lulus' OR $sidang->status == 'tidak lulus (sudah update dokumen)' OR
        $sidang->status == 'tidak lulus (belum dijadwalkan)')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Update Data Sidang
                         </div> --}}
                    <div class="card-body">
                        <form class="" action="{{ route('sidang-ulang.update', $sidang->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="sidang_id" value="{{ $sidang->id }}" hidden>
                            <div class="form-group col-sm-6">
                                <p>Pastikan anda mengupload berkas TA sesuai yang anda revisi</p>
                                <div class="form-group">
                                    <label for="">Periode Sidang Ulang</label>
                                    {!! Form::select('period_id', $periods, $oldPeriod, ['class' => 'select2
                                    form-control'])!!}
                                </div>
                                <div class="form-group">
                                    <label for="">Dokumen TA Sidang Ulang</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input forminput" name="dokumen_ta">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Jurnal Sidang Ulang</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input forminput" name="makalah">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                                <button type="submit" name="button" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Materi Presentasi
                         </div> --}}

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h2 class="text-right">PILIH FILE MATERI PRESENTASI</h2>
                                <p class="text-right">Format file <b> .ppt </b> atau <b> .pptx </b> (maksimal 10mb)</p>
                            </div>

                            <div class="col">
                                <form class="" action="{{ route('slides.upload') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="sidang_id" value="{{ $sidang->id }}" hidden>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            {{-- <input type="file" class="custom-file-input forminput" name="slide"> --}}
                                            @if($slide != null)
                                            <input type="file" class="custom-file-input forminput" name="slide">
                                            <label class="custom-file-label">{{ $slide->file_url }}</label>
                                             @elseif ($slide == null)
                                             <input type="file" class="custom-file-input forminput" name="slide" required>
                                             <label class="custom-file-label">Upload File</label>
                                             @endif
                                        </div>
                                    </div>
                                    @if($slide != null)
                                    <div class="row ml-0">
                                    <a href="/{{ $slide->file_url }}" class="btn btn-danger mr-2">Download</a><br>
                                    <button type="submit" name="button" class="btn btn-outline-primary">Upload Ulang</button>
                                    </div>
                                    @elseif ($slide == null)
                                    <button type="submit" name="button" class="btn btn-primary">Upload</button>
                                    @endif
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.forminput').on('change', function () {
            var fileName = $(this).val();
            $(this).next('.custom-file-label').html(fileName);
        })
    });

</script>
@endpush
