@extends('layouts.app')

@section('content')
{{-- <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{!! route('schedules.index') !!}">Schedule</a>
    </li>
    <li class="breadcrumb-item active">Create</li>
</ol> --}}
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>JADWAL SIDANG</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / TAMBAH JADWAL SIDANG</h6>
    </div>
</ol>



<div class="container-fluid">
    <div class="animated fadeIn">
        @include('coreui-templates::common.errors')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <i class="fa fa-plus-square-o fa-lg"></i>
                        <strong>Create Schedule</strong>
                    </div> --}}
                    <div class="card-body">
                        {!! Form::open(['route' => 'schedules.store']) !!}

                        @include('schedules.fields')

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="jadwalPenguji" tabindex="-1" role="dialog" aria-labelledby="jadwalPenguji" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jadwal Dosen Penguji</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="f_dosen">Dosen</label>
                            <select name="f_dosen" id="f_dosen" class="form-control select2">

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="f_kk">KK</label>
                            <select name="f_kk" id="f_kk" class="form-control select2" >

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="f_date">Tanggal</label>
                            <input type="date" name="f_date" id="f_date" >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a href="#" class="btn btn-primary btn-sm" id="runFilterTableDosenPenguji">Filter</a>
                    </div>
            </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive-sm" style="overflow-x:scroll">
                            <table class="table datatable" id="tableDosenPenguji">
                                <thead>
                                    <tr>
                                        <th>Kode Dosen - Nama Lengkap</th>
                                        <th>KK</th>
                                        <th>Tanggal</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableDosenPenguji">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
  //  $("#tableDosenPenguji").DataTable();
    {{--  getTableDosenPenguji()  --}}
    {{--  getDosen();  --}}
    {{--  getKK()  --}}
    $("#runFilterTableDosenPenguji").click(function() {
        event.preventDefault();
        getTableDosenPenguji();
    });

    function getDosen() {
        $.getJSON("/schedule/get_select_jadwal_dosen_penguji?type=dosen", function(data) {
            var _select_html =  `<option value="" selected disabled>Pilih Dosen</option>  `;
            data.forEach(element => {
                _select_html +=   `<option value="${element.id}">${element.code} - ${element.nama}</option>  `;
            })
            $("#f_dosen").html(_select_html);
        });
    }

    function getKK() {
        $.getJSON("/schedule/get_select_jadwal_dosen_penguji?type=kk", function(data) {
            var _select_html =  `<option value="" selected disabled>Pilih Dosen</option> `;
            data.forEach(element => {
                _select_html += `<option value="${element.kk}}">${element.kk}</option> `;
            });
            $("#f_kk").html(_select_html);
        });
    }

    function getTableDosenPenguji() {
        var _url = "/schedule/get_jadwal_dosen_penguji";

        var filter_1 = $("#f_kk").val();
        var filter_2 = $("#f_date").val();
        var filter_3 = $("#f_dosen").val();
        console.log(filter_1);
        if (filter_1 != "") {
            _url += "?f_kk=" + filter_1;
        } else if (filter_1 == null) {
            _url += "?f_kk=none";
        } else {
            _url += "?f_kk=none";
        }
        if (filter_2 != "") {
            _url += "&f_date=" + filter_2;
        } else if (filter_2 == null) {
            _url += "&f_date=none";
        } else {
            _url += "&f_date=none";
        }
        if (filter_3 != "") {
            _url += "&f_dosen=" + filter_3;
        } else if (filter_3 == null) {
            _url += "&f_dosen=none";
        } else {
            _url += "&f_dosen=none";
        }

        $.getJSON(_url, function(data) {
            var _html = '';
            data.forEach(element => {
                _html += `
                    <tr>
                        <td>${element.code} - ${element.nama}</td>
                        <td>${element.kk}</td>
                        <td>${element.date}</td>
                        <td>${element.time}</td>
                        <td>${element.end_time}</td>
                    </tr>
                    `;
            });
            $("#bodyTableDosenPenguji").html(_html);
        });
    }
</script>
@endpush()