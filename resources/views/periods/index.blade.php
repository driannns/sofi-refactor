@extends('layouts.app')
@php
    $admin = auth()->user()->isAdmin();
    $superadmin = auth()->user()->isSuperadmin();
    $ppm = auth()->user()->isPpm()
@endphp
@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>PERIODE</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('home') !!}" class="text-dark">BERANDA</a> / PERIODE</h6>
        </div>
    </ol>
    <div class="container-fluid">\
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Periods
                             @if(!$ppm)
                             <a class="pull-right" href="{{ route('periods.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                             @endif
                         </div>
                         <div class="card-body">
                             @include('periods.table')
                              <div class="pull-right mr-3">

                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

