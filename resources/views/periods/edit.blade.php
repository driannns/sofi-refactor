@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>PERIODE</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('periods.index') !!}" class="text-dark">PERIODE</a> / UBAH PERIODE</h6>
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
                              <strong>Edit Period</strong>
                          </div> --}}
                          <div class="card-body">
                              {!! Form::model($period, ['route' => ['periods.update', $period->id], 'method' => 'patch']) !!}

                              @include('periods.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
