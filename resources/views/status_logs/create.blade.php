@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>STATUS LOG</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('statusLogs.index') !!}" class="text-dark">STATUS LOG</a> / TAMBAH STATUS LOG</h6>
        </div>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create Status Log</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'statusLogs.store']) !!}

                                   @include('status_logs.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
