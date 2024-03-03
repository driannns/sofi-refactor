@extends('layouts.app')

@section('content')
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>EXPORT DOKUMEN</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{!! route('home') !!}" class="text-dark">BERANDA</a> / EXPORT DOKUMEN</h6>
    </div>
</ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         {{-- <div class="card-header">
                             <i class="fa fa-download"></i>
                            Export Data Mahasiswa
                         </div> --}}
                         <div class="card-body">
                                <form action="{{ route('export.proses') }}" method="post">
                                @csrf
                                <div class="form-group col-sm-6">
                                    <label for="">Jenis Dokumen</label>
                                    <select class="form-control" name="jenis_dokumen">
                                    <option value="">Pilih Jenis Dokumen</option>
                                    <option value="pendaftar_sidang" {{ old('jenis_dokumen') == 'pendaftar_sidang' ? 'selected' : '' }}>Pendaftar Sidang</option>
                                    <option value="jadwal_sidang" {{ old('jenis_dokumen') == 'jadwal_sidang' ? 'selected' : '' }}>Jadwal Sidang</option>
                                    <option value="sidang_yudisium" {{ old('jenis_dokumen') == 'sidang_yudisium' ? 'selected' : '' }}>Sidang Yudisium</option>
                                    <option value="tepat_waktu" {{ old('jenis_dokumen') == 'tepat_waktu' ? 'selected' : '' }}>Mahasiswa Lulus Tepat Waktu</option>
                                    <option value="cumlaude" {{ old('jenis_dokumen') == 'cumlaude' ? 'selected' : '' }}>Mahasiswa Cumlaude</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Berdasarkan</label>
                                    <select class="form-control" name="berdasarkan" id="berdasarkan">
                                    <option value="">Pilih Berdasarkan</option>
                                    <option value="periods">Periods</option>
                                    <option value="range">Range Tanggal</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="table-responsive-sm p-5 my-3 border" id="periods" hidden>
                                        <table class="table table-striped" id="periods-table">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($periods as $period)
                                            <tr>
                                                <td>{{ $period->name }}</td>
                                                <td>{{ date('d-m-Y', strtotime($period->start_date)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($period->end_date)) }}</td>
                                                <td>
                                                    <div class='btn-group'>
                                                    <button type="submit" class='btn btn-primary' value="{{ $period->id }}" name="period_id">Download</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 range" hidden>
                                    <label for="">Tanggal Awal</label>
                                    <input type="text" class="form-control datepicker" name="tanggal_awal">
                                </div>
                                <div class="form-group col-sm-6 range" hidden>
                                    <label for="">Tanggal Akhir</label>
                                    <input type="text" class="form-control datepicker" name="tanggal_akhir">
                                </div>
                                <div class="form-group col-sm-6">
                                    <button class="btn btn-primary" id="download" type="submit">Download</button>
                                 </div>
                                </form>
                                <div class="pull-right mr-3"></div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#periods-table').DataTable({
        pageLength: 15,
        order: [[ 3, "desc" ]],
    });

    $('#berdasarkan').on('change', function(){
        var ket = $(this).children("option:selected").val();
        if(ket == 'periods'){
            $('#periods').removeAttr('hidden');
            $('.range').attr('hidden',true);
            $('#download').attr('hidden', true);
        }else if(ket == 'range'){
            $('#periods').attr('hidden',true);
            $('.range').removeAttr('hidden');
            $('#download').removeAttr('hidden');
        }else{
            $('#periods').attr('hidden', true);
            $('.range').attr('hidden', true);
            $('#download').removeAttr('hidden');
        }
    });

    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: true,
        icons: {
            up: "icon-arrow-up-circle icons font-2xl",
            down: "icon-arrow-down-circle icons font-2xl"
        },
        sideBySide: true
    })
</script>
@endpush()
