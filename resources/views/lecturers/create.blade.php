@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>HAK AKSES</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('lecturers.index') !!}" class="text-dark">HAK AKSES</a> / TAMBAH HAK AKSES</h6>
        </div>
    </ol>

     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Tambah Hak Akses</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'lecturers.store']) !!}

                                   @include('lecturers.fields')

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Tambah Admin</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'users.addAdmin','method'=>'post']) !!}

                                <!-- Username Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('username', 'Username:') !!}
                                    {!! Form::text('username', null, ['class' => 'form-control']) !!}
                                </div>

                                <!-- Nama Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('nama', 'Nama:') !!}
                                    {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                                </div>

                                <!-- Password Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('password', 'Password:') !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>

                                <!-- Submit Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::submit('Tambah Admin', ['class' => 'btn btn-primary']) !!}
                                    <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
