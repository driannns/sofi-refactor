@extends('layouts.app')

@section('content')
    {{--  <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="{!! route('sidangs.index') !!}">Sidang</a>
      </li>
      <li class="breadcrumb-item active">Create</li>
    </ol>  --}}

    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3> PENDAFTARAN SIDANG </h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / PENDAFTARAN SIDANG</h6>
        </div>
    </ol>

     <div class="container-fluid">
          <div class="animated fadeIn">
                @include('coreui-templates::common.errors')
                @if (Session::has('error'))
                     <div class="alert alert-danger" role="alert">
                         {{Session::get('error')}}
                     </div>
                @endif
                @if(Request::is('sidangs/create'))
                <div class="alert alert-warning" role="alert">
                    Setiap file yang yang diupload akan menggantikan file yang sudah ada
                </div>
                @endif
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            {{--  <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Create Sidang</strong>
                            </div>  --}}
                            <div class="card-body">

                                {!! Form::open(['route' => ['sidangs.storeSkPenguji', $sidang->id], 'enctype' => 'multipart/form-data','id'=>'frm1']) !!}
                                    <!-- Mahasiswa Id Field -->
                                    <div class="form-group col-sm-12">
                                        {!! Form::label('mahasiswa_id', 'NIM Mahasiswa:') !!}
                                        {!! Form::number('mahasiswa_id', $sidang->mahasiswa->nim, ['class' => 'form-control','disabled' => 'disabled']) !!}
                                    </div>
                                    <!-- Judul Field -->
                                    <div class="form-group col-sm-12 col-lg-12">
                                        {!! Form::label('judul', 'Judul Tugas Akhir:') !!}
                                        {!! Form::textarea('judul', $sidang->judul, ['class' => 'form-control', 'rows' => 4, 'cols' => 2,'disabled'=>'disabled']) !!}
                                    </div>
                                    <!-- Makalah Field -->
                                    <div class="form-group col-sm-12">
                                        {!! Form::label('sk_penguji_file', 'Upload SK Penguji:') !!}
                                        {!! Form::file('sk_penguji_file', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <!-- Submit Field -->
                                    <div class="form-group col-sm-12">
                                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                        <a href="{{ route('sidangs.indexSuratTugasPenguji') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection


