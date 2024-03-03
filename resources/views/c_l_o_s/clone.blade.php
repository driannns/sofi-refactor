@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>CLOS</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('home') !!}" class="text-dark">BERANDA</a> / CLONE CLOS</h6>
        </div>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('flash::message')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <i class="fa fa-align-justify"></i>
                            Clone CLO
                        </div> --}}
                        <div class="card-body">
                            <form action="{{ route('clo.clone.proses') }}" method="post">
                                @csrf
                                <div class="form-group col-sm-6">
                                    <label for="">Clone dari period:</label>
                                    <select class="form-control select2" name="from_period" id="from_period">
                                        <option value="">Pilih period</option>
                                        @foreach($periods as $period)
                                            <option value="{{ $period->id }}">{{ $period->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <select class="form-control select2" name="from_prodi" id="from_prodi">
                                        <option value="">Pilih Program Studi</option>
                                        @foreach($programStudies as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Preview period yang akan diclone:</label><br>
                                    <a id="pembimbing_preview" href="#" target="_blank" class='btn btn-warning'
                                       style="color:white;">Preview Pembimbing</a>
                                    <a id="penguji_preview" href="#" target="_blank" class='btn btn-warning'
                                       style="color:white;">Preview Penguji</a>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Ke period:</label>
                                    <select class="form-control select2" name="to_period">
                                        <option value="">Pilih period</option>
                                        @foreach($periods as $period)
                                            <option value="{{ $period->id }}">{{ $period->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <select class="form-control select2" name="to_prodi" id="to_prodi">
                                        <option value="">Pilih Program Studi</option>
                                        @foreach($programStudies as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <p>Dengan menekan save, maka seluruh data pada period yang dituju akan terhapus dan
                                        digantikan dengan hasil clone</p>
                                </div>
                                <div class="form-group col-sm-12">
                                    <button type="submit" name="button" class="btn btn-primary">Save</button>
                                    <a href="{{ route('cLOS.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#from_period").change(function () {
                var period_id = $(this).children("option:selected").val();
                var prodi_id = $("#from_prodi").children("option:selected").val();
                if(prodi_id == '')
                    prodi_id = -1
                $("#pembimbing_preview").attr("href", "/clo/preview/" + period_id + "/" + prodi_id + "/pembimbing");
                $("#penguji_preview").attr("href", "/clo/preview/" + period_id + "/" + prodi_id + "/penguji");
            });
            $("#from_prodi").change(function () {
                var period_id = $("#from_period").children("option:selected").val();
                var prodi_id = $(this).children("option:selected").val();
                if(period_id != '') {
                    $("#pembimbing_preview").attr("href", "/clo/preview/" + period_id + "/" + prodi_id + "/pembimbing");
                    $("#penguji_preview").attr("href", "/clo/preview/" + period_id + "/" + prodi_id + "/penguji");
                }
            });
        });
    </script>
@endpush
