@extends('layouts.app')

@section('content')
{{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">Users</li>
    </ol> --}}
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>PENGGUNA</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{!! route('home') !!}" class="text-dark">BERANDA</a> / PENGGUNA</h6>
    </div>
</ol>

<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class='btn-group pull-right'>
                            <a class="btn btn-primary" href="{{ route('users.index') }}"><i
                                    class="fa fa-filter fa-lg"></i> Semua</a>
                            <a class="btn btn-primary" href="{{ route('users.index',['filter'=>'student']) }}"><i
                                    class="fa fa-filter fa-lg"></i> Filter Mahasiswa</a>
                            <a class="btn btn-primary" href="{{ route('users.index',['filter'=>'lecturer']) }}"><i
                                    class="fa fa-filter fa-lg"></i> Filter Dosen</a>
                            <a class="btn btn-success" href="{{ route('users.syncLecturer') }}"><i
                                    class="fa fa-refresh fa-lg"></i> Sync Data Dosen</a>
                            <a class="btn btn-success" href="{{ route('users.syncStudents') }}"><i
                                    class="fa fa-refresh fa-lg"></i> Sync Data Mhs</a>
                            <a class="btn btn-primary" href="{{ route('users.create') }}"><i
                                    class="fa fa-plus-square fa-lg"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('users.table')
                        <div class="pull-right mr-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
