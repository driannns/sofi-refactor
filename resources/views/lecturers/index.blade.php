@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>HAK AKSES</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('lecturers.index') !!}" class="text-dark">BERANDA</a> / HAK AKSES</h6>
        </div>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             {{-- <i class="fa fa-align-justify"></i>
                             Data Role Dosen dan Admin --}}
                             <a class="pull-right" href="{{ route('lecturers.create') }}"><i class="fa fa-plus-square fa-lg"></i></a>
                         </div>
                         <div class="card-body">
                             @include('lecturers.table')
                              <div class="pull-right mr-3">

                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection
