@extends('layouts.app')

@section('content')
    {{-- <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('sidangs.index') !!}">Sidang</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol> --}}
    
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>SIDANG</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / <a href="{!! route('sidangs.index') !!}" class="text-dark">SIDANG</a></h6>
    </div>
</ol>

    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             @if (Session::has('error'))
                  <div class="alert alert-danger" role="alert">
                      {{Session::get('error')}}
                  </div>
             @endif
             <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        {{-- <div class="card-header">
                            <i class="fa fa-edit fa-lg"></i>
                            <strong>Edit Data Sidang</strong>
                        </div> --}}
                        <div class="card-body">
                            {!! Form::model($sidang, ['route' => ['sidangs.update', $sidang->id], 'files' => true, 'id'=> 'frm1', 'method' => 'PUT']) !!}

                            @include('sidangs.fields')

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="card">
                    {{-- <div class="card-header">
                        <i class="fa fa-history fa-lg"></i>
                        @if ( auth()->user()->isSuperadmin() )
                        <strong>Riwayat Proses</strong>
                        @else
                        <strong>Riwayat Proses Pengajuan</strong>
                        @endif
                    </div> --}}
                    <div class="card-body">
                      <div class="table-responsive-sm"  style="height:100vh; overflow-y:scroll">
                        <table class="table table-striped" id="sidangs-table">
                            <thead>
                              <tr>
                                <td>Tanggal</td>
                                <td>Nama Event</td>
                                <td>Komentar</td>
                                <td>Oleh</td>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($status_logs as $log)
                                <tr>
                                  <td>{{ date('l, d F Y - d:m', strtotime($log->created_at)) }}</td>
                                  <td>{{$log->name}}</td>
                                  <td>{{$log->feedback}}</td>
                                  <td>{{$log->user->username}}</td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
             </div>
         </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('#status').on('change', function() {
      if ($("#status").val() != '0') {
        $("#field_komentar").show()
      } else {
        $("#field_komentar").hide()
      }
    });
</script>
@endpush()
