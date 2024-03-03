@extends('layouts.app')

@section('content')
{{-- <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('schedules.index') }}">Schedule</a>
  </li>
  <li class="breadcrumb-item active">Detail</li>
</ol> --}}
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>JADWAL</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / DETAIL</h6>
    </div>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    @include('coreui-templates::common.errors')
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            {{-- <strong>Details</strong> --}}
            @if(Auth::user()->isAdmin())
            <a href="{{ URL::previous() }}" class="btn btn-light">Kembali</a>
            @elseif(Auth::user()->isPembimbing() OR Auth::user()->isPenguji())
            <a href="{{ route('schedule.penguji') }}" class="btn btn-light">JADWAL PENGUJI</a>
            <a href="{{ route('schedule.pembimbing') }}" class="btn btn-light mr-3">JADWAL PEMBIMBING</a>
            @else
            <a href="{{ route('schedules.index') }}" class="btn btn-light">Kembali</a>
            @endif
          </div>
          <div class="card-body">
            @include('schedules.show_fields')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
