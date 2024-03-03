@extends('layouts.app')

@section('content')
{{-- <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('scores.index') !!}">Score</a>
          </li>
          <li class="breadcrumb-item active">Edit Score</li>
        </ol> --}}

<ol class="breadcrumb mb-0">
  <div class="col-12">
    <h3>NILAI</h3>
    <hr class="mt-0">
    <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / UBAH NILAI</h6>
  </div>
</ol>
<div class="container-fluid">
  <div class="animated fadeIn">
    @include('coreui-templates::common.errors')
    @if($schedule->sidang->status == "lulus")
    <div class="alert alert-warning" role="alert">
      Anda sudah tidak dapat mengubah nilai
    </div>
    @elseif($schedule->status == "sedang dilaksanakan" OR
    $schedule->flag_change_scores OR
    Auth()->user()->isSuperadmin() OR Carbon\Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +7 ) >= now())
    @else
    <div class="alert alert-warning" role="alert">
      Anda sudah tidak dapat mengubah nilai
    </div>
    @endif
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          {{-- <div class="card-header">
                            <i class="fa fa-plus-square-o fa-lg"></i>
                            <strong>Edit Score</strong>
                        </div> --}}
          <div class="card-body">
            @if( $lecturer_id )
            {!! Form::open(['route' => ['scores.update',[$schedule->id,'lid'=>$lecturer_id]],'method' => 'patch']) !!}
            @else
            {!! Form::open(['route' => ['scores.update',$schedule->id],'method' => 'patch']) !!}
            @endif
            @include('scores.fields')

            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection