@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>PERIODE</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('periods.index') !!}" class="text-dark">PERIODE</a> / TAMBAH PERIODE</h6>
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
                                <strong>Create Period</strong>
                            </div> --}}
                            <div class="card-body">
                                {!! Form::open(['route' => 'periods.store']) !!}

                                   @include('periods.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
