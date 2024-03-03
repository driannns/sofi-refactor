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
                    Pastikan data dibawah sudah benar, terutama status approval. Jika ada perbedaan data, silahkan hubungi admin sebelum submit
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
                        
                                {!! Form::open(['route' => 'sidangs.store', 'enctype' => 'multipart/form-data','id'=>'frm1']) !!}
                                   @include('sidangs.fields')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection 


