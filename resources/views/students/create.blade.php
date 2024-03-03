@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>STUDENT</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('students.index') !!}" class="text-dark">STUDENT</a> / TAMBAH STUDENT</h6>
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
                                <strong>Create Student</strong>
                            </div> --}}
                            <div class="card-body">
                                {!! Form::open(['route' => 'students.store']) !!}

                                   @include('students.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
