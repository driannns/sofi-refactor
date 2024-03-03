@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>CLOS</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('home') !!}" class="text-dark">BERANDA</a> / CLOS</h6>
        </div>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             CLOS
                             <a class="pull-right btn btn-primary" href="{{ route('cLOS.create') }}"><i class="fa fa-plus-square fa-lg text-white"></i></a>
                             <a class="pull-right btn btn-success mr-2" href="{{ route('clo.clone') }}">Clone CLO Period</a>
                         </div>
                         <div class="card-body">
                             @include('c_l_o_s.table')
                              <div class="pull-right mr-3">

                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection
