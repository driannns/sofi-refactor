@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>CLOS</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('cLOS.index') !!}" class="text-dark">CLOS</a> / UBAH CLOS</h6>
        </div>
    </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('flash::message')
             @if($errors->any())
                 {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
             @endif
             @include('coreui-templates::common.errors')
             {!! Form::model($cLO, ['route' => ['cLOS.update', $cLO->id], 'method' => 'patch']) !!}
             <div class="row">
                 <div class="col-sm-6">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-plus-square-o fa-lg"></i>
                             <strong>Create C L O</strong>
                         </div>
                         <div class="card-body">
                                @include('c_l_o_s.fields')
                         </div>
                     </div>
                 </div>
                 <div class="col-sm-6">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-plus-square-o fa-lg"></i>
                             <strong>Setting Interval</strong>
                         </div>
                         <div class="card-body">
                                 @include('c_l_o_s.interval_fields')
                         </div>
                     </div>
                 </div>
             </div>
              {!! Form::close() !!}
         </div>
    </div>
@endsection
