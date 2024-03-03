@extends('layouts.app')

@section('content')
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">Simpulan Nilai</li>
    </ol> --}}
    <ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>SIMPULAN NILAI</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / SIMPULAN NILAI</h6>
    </div>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             @if($nilaiPenguji1 == 0 OR $nilaiPenguji2 == 0 OR $nilaiPembimbing1 == 0 OR $nilaiPembimbing2 == 0)
             <div class="alert alert-warning" role="alert">
                 @if($nilaiPenguji1 == 0)
                 Penguji 1 Belum Memberikan Nilai <br>
                 @endif
                 @if($nilaiPenguji2 == 0)
                 Penguji 2 Belum Memberikan Nilai <br>
                 @endif
                 @if($nilaiPembimbing1 == 0)
                 Pembimbing 1 Belum Memberikan Nilai <br>
                 @endif
                 @if($nilaiPembimbing2 == 0)
                 Pembimbing 2 Belum Memberikan Nilai <br>
                 @endif
             </div>
             @endif
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Simpulan Nilai --}}
                         <div class="card-body">
                             @include('scores.simpulan_fields')
                              <div class="pull-right mr-3">

                              </div>
                         </div>
                     {{-- </div> --}}
                  </div>
             </div>
         </div>
    </div>
@endsection
