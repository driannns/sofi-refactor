@extends('layouts.app')

@php
$admin = auth()->user()->isAdmin();
$pembimbing = auth()->user()->isPembimbing();
$pic = auth()->user()->isPIC();
$penguji = auth()->user()->isPenguji();
$student = auth()->user()->isStudent();
@endphp

@section('content')
<ol class="breadcrumb  mb-0">
    @if($pembimbing AND Request::is('sidangs/pembimbing'))
    <div class="col-12">
        <h3>BIMBINGAN TA</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / BIMBINGAN TA</h6>
    </div>
    @elseif($pic AND Request::is('sidangs/pic'))
    <div class="col-12">
        <h3>PENJADWALAN SIDANG</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / PENJADWALAN SIDANG</h6>
    </div>
    @else
    <div class="col-12">
        <h3>PENGAJUAN SIDANG</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / PENGAJUAN SIDANG</h6>
    </div>
    @endif
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        @include('coreui-templates::common.errors')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        @if($pembimbing AND Request::is('sidangs/pembimbing'))
                        Bimbingan TA
                        @elseif($pic AND Request::is('sidangs/pic'))
                        Penjadwalan Sidang
                        @else
                        List Sidang
                        @endif
                    </div> --}}
                    <div class="card-body">
                        @include('sidangs.table')
                        <div class="pull-right mr-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
