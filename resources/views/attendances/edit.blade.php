@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>ATTENDANCES</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('attendances.index') !!}" class="text-dark">ATTENDANCES</a> / UBAH ATTENDANCES</h6>
        </div>
    </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          {{-- <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Attendance</strong>
                          </div> --}}
                          <div class="card-body">
                              {!! Form::model($attendance, ['route' => ['attendances.update', $attendance->id], 'method' => 'patch']) !!}

                              @include('attendances.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
