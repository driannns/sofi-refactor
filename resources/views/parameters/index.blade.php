@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>PARAMETERS</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / PARAMETERS</h6>
        </div>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Parameters
                         </div> --}}
                         <div class="card-body">
                             @include('parameters.table')
                              <div class="pull-right mr-3">

                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

