@extends('layouts.app')

@section('content')
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>REVISI TA</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / REVISI TA</h6>
    </div>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        @if($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
        @endif
        <div class="row">
            @if(auth()->user()->isStudent())
            <div class="col-lg-12">
                @else
                <div class="col-lg-12">
                    @endif
                    <div class="card">
                        {{-- <div class="card-header">
            <i class="fa fa-align-justify"></i>
            Revisions
            @if(!auth()->user()->isStudent())
            <input type="text" id="myInput" class="form-control pull-right" style="width:150px;" placeholder="Search..">
            @endif
          </div> --}}
                        <div class="card-body">
                            @if(auth()->user()->isStudent())
                            <form class="" id="devel-generate-content-form" action="{{ route('revisions.mahasiswa.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if($revisions != '[]')
                                <input type="text" name="sidang_id" value="{{ $revisions[0]->schedule->sidang_id }}" hidden>
                                @endif
                                @include('revisions.table_mahasiswa')
                                @else
                                @include('revisions.table')
                                @endif
                                <div class="pull-right mr-3">

                                </div>

                                @if(auth()->user()->isStudent())
                                @if($revisions != '[]')
                                @if ($revisions[0]->schedule->sidang->status=='lulus')
                                <a class="pull-left mt-3 btn btn-primary text-light disabled">UPLOAD FILE REVISI</a>
                               @else
                                <a class="pull-left mt-3 btn btn-primary text-light" data-toggle="modal" data-target="#filerevisi">UPLOAD FILE REVISI</a>
                                {{-- MODAL FILE REVISI  --}}
                                @endif
                                @endif
                                <div class="modal fade" id="filerevisi">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">PILIH DOKUMEN REVISI</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form class="" action="{{ route('revisions.mahasiswa.update') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col">
                                                            <h2 class="text-right">PILIH FILE DOKUMEN REVISI</h2>
                                                            <p class="text-right">Format file <b> PDF </b> (maksimal 5mb)
                                                            </p>
                                                        </div>

                                                        <div class="col">
                                                            <div class="input-group mb-3">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="forminput" name="dokumen_ta">
                                                                    <label class="custom-file-label">Choose file</label>
                                                                </div>
                                                            </div>
                                                            @if($revisions != '[]')
                                                            <button type="submit" name="button" class="btn btn-primary">Upload Revisi</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>

                                            <!-- Modal footer -->
                                            {{-- <div class="modal-footer">
                                                {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                                                <button data-dismiss="modal" class="btn btn-secondary">Batal</button>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                                @endif


                        </div>
                    </div>
                </div>
                @if(auth()->user()->isStudent())

                {{-- <div class="col-lg-12">
                    <h5></h5>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            FORM INPUT REVISI
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h2 class="text-right">PILIH FILE DOKUMEN REVISI</h2>
                                    <p class="text-right">Format file <b> PDF </b> (maksimal 5mb)</p>
                                </div>

                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="forminput"
                                                name="dokumen_ta">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                    @if($revisions != '[]')
                                    <button type="submit" name="button" class="btn btn-primary">Upload Revisi</button>
                                    @endif
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        @endif
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#forminput').on('change', function() {
            var fileName = $(this).val();
            $(this).next('.custom-file-label').html(fileName);
        })

        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#revisions-table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush
