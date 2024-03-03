@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>PARAMETERS</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('peminatans.index') !!}" class="text-dark">PARAMETERS</a> / UBAH PARAMETERS</h6>
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
                              <strong>Edit Parameter</strong>
                          </div> --}}
                          <div class="card-body">
                              {!! Form::model($parameter, ['route' => ['parameters.update', $parameter->id], 'method' => 'patch']) !!}

                              @include('parameters.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
