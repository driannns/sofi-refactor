@extends('layouts.app')

@php
$admin = auth()->user()->isAdmin();
$pembimbing = auth()->user()->isPembimbing();
$pic = auth()->user()->isPIC();
$penguji = auth()->user()->isPenguji();
$student = auth()->user()->isStudent();
$superadmin = auth()->user()->isSuperadmin();
@endphp

@section('content')
<ol class="breadcrumb mb-0">
    @if($pembimbing AND Request::is('schedule/pembimbing'))
    <div class="col-12">
        <h3>JADWAL BIMBINGAN</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / JADWAL BIMBINGAN</h6>
    </div>
    @elseif($penguji AND Request::is('schedule/penguji'))
    <div class="col-12">
        <h3>JADWAL SIDANG PENGUJI</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / JADWAL SIDANG PENGUJI</h6>
    </div>
    @elseif($pic AND Request::is('schedules'))
    <div class="col-12">
        <h3>JADWAL SIDANG KK</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / JADWAL SIDANG KK</h6>
    </div>
    @elseif($admin AND Request::is('schedule/admin'))
    <div class="col-12">
        <h3> PERUBAHAN HAK AKSES </h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / PERUBAHAN HAK AKSES </h6>
    </div>
    @elseif($superadmin AND Request::is('schedule/bermasalahSuperAdmin'))
    <div class="col-12">
        <h3>SELURUH SIDANG BERMASALAH</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / SELURUH SIDANG BERMASALAH</h6>
    </div>
    @elseif($admin AND Request::is('schedule/bermasalah'))
    <div class="col-12">
        <h3>SELURUH SIDANG BERMASALAH</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / SELURUH SIDANG BERMASALAH</h6>
    </div>
    @elseif($superadmin AND Request::is('schedule/superadmin'))
    <div class="col-12">
        <h3>SELURUH JADWAL SIDANG</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / SELURUH JADWAL SIDANG</h6>
    </div>
    @elseif($admin AND Request::is('schedule/bukaAkses'))
    <div class="col-12">
        <h3>SELURUH JADWAL SIDANG KK</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / SELURUH JADWAL SIDANG KK</h6>
    </div>
    @elseif($pic AND Request::is('schedule/bukaAkses'))
    <div class="col-12">
        <h3>BUKA AKSES MENU</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / BUKA AKSES MENU</h6>
    </div>
    @elseif($student AND Request::is('schedule/mahasiswa'))
    <div class="col-12">
        <h3>JADWAL SIDANG MAHASISWA</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / JADWAL SIDANG MAHASISWA</h6>
    </div>
    @endif
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{Session::get('error')}}
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             @if($pembimbing AND Request::is('schedule/pembimbing'))
                             Jadwal Sidang Bimbingan
                             @elseif($penguji AND Request::is('schedule/penguji'))
                             Jadwal Sidang Penguji
                             @elseif($pic AND Request::is('schedules'))
                             Jadwal Sidang KK
                             @elseif($superadmin AND Request::is('schedule/superadmin'))
                             Seluruh Jadwal Sidang
                             @elseif($pic AND Request::is('schedule/bukaAkses'))
                             Seluruh Jadwal Sidang KK
                             @endif
                             @if(auth()->user()->isPIC() && !Request::is('schedule/bukaAkses'))
                              <a class="pull-right" href="{{ route('sidangs.pic') }}"><i
                        class="fa fa-plus-square fa-lg"></i></a>
                    @endif
                </div> --}}
                <div class="card-body">
                    @if($superadmin AND Request::is('schedule/superadmin'))
                    @include('schedules.tableSuperadmin')
                    @elseif(Request::is('schedule/bermasalah'))
                    @include('schedules.tableBermasalah')
                    @elseif(Request::is('schedule/bermasalahSuperAdmin'))
                    @include('schedules.tableBermasalah')
                    @elseif(Request::is('schedule/mahasiswa'))
                    @include('schedules.tableMahasiswa')
                    @else
                    @include('schedules.table')
                    @endif
                    <div class="pull-right mr-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
