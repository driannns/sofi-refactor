@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>ATTENDANCES</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('attendances.index') !!}" class="text-dark">ATTENDANCES</a> / TAMBAH ATTENDANCES</h6>
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
                                <strong>Create Attendance</strong>
                            </div> --}}
                            <div class="card-body">
                                {!! Form::open(['route' => 'attendances.store']) !!}

                                   @include('attendances.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
