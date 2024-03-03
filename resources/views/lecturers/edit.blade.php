@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>HAK AKSES</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('lecturers.index') !!}" class="text-dark">HAK AKSES</a> / UBAH HAK AKSES</h6>
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
                              <strong>Edit Lecturer</strong>
                          </div> --}}
                          <div class="card-body">
                              {!! Form::model($lecturer, ['route' => ['lecturers.update', $lecturer->id], 'method' => 'patch']) !!}

                              @include('lecturers.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
