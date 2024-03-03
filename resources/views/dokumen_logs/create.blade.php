@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>DOCUMENT LOGS</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('dokumenLogs.index') !!}" class="text-dark">DOCUMENT LOGS</a> / TAMBAH DOCUMENT LOGS</h6>
        </div>
    </ol>
    {{-- <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('dokumenLogs.index') !!}">Dokumen Log</a>
      </li>
      <li class="breadcrumb-item active">Create</li>
    </ol> --}}
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create Dokumen Log</strong>
                            </div> --}}
                            <div class="card-body">
                                {!! Form::open(['route' => 'dokumenLogs.store']) !!}

                                   @include('dokumen_logs.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
