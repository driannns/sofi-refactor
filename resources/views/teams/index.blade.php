@php
$isIndividu = auth()->user()->student->team->isIndividu(
auth()->user()->student->nim
);

$isSudahDijadwalkan = auth()->user()->student->sidangs[0]->isSudahDijadwalkan(
auth()->user()->student->nim
);
@endphp

@extends('layouts.app')

@section('content')
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>TIM</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{!! route('home') !!}" class="text-dark">BERANDA</a> / TIM
            {{-- @if(!$isIndividu && !$isSudahDijadwalkan)
          <a class="ml-2" href="{{ url('/teams/'.$team->id.'/edit') }}"><i class="fa fa-edit fa-lg"></i></a>
            <a class="ml-2" href="{{ url('/create-member') }}"><i class="fa fa-plus-square fa-lg"></i></a>
            @endif --}}

        </h6>
    </div>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
             @include('coreui-templates::common.errors')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <span class="font-weight-bold">{{ strtoupper($team->name) }}</span>
                        @if(!$isIndividu && !$isSudahDijadwalkan)
                        {{-- <a class="pull-right btn btn-primary btn-sm" href="{{ url('/create-member') }}">TAMBAH</a>
                        <a class="pull-right btn btn-primary btn-sm"
                            href="{{ url('/teams/'.$team->id.'/edit') }}">UBAH</a> --}}

                        <button class="pull-right btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modaltambah">TAMBAH ANGGOTA</button>
                        <button class="pull-right mr-2 btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modalubah">UBAH NAMA TIM</button>
                        @endif
                    </div>
                    <div class="card-body">
                        @include('teams.table')
                        <div class="pull-right mr-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modaltambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Anggota Tim</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="" action="/store-member" method="post">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <!-- Name Field -->
                    <div class="form-group col-8">
                        {!! Form::label('nim', 'NIM Anggota Tim:') !!}
                        <select class="form-control select2" name="nim">
                            <option value="" readonly> -- Silahkan pilih nama anggota -- </option>
                            @foreach($students as $student)
                            <option value="{{ $student->nim }}">{{ $student->nim }} - {{ $student->user->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    {!! Form::submit('Tambah', ['class' => 'btn btn-primary']) !!}
                    <button data-dismiss="modal" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- MODAL UBAH TIM  --}}
<div class="modal fade" id="modalubah">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Ubah Nama Tim</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::model($team, ['route' => ['teams.update', $team->id], 'method' => 'patch']) !!}
            <!-- Modal body -->
            <div class="modal-body">

                <!-- Name Field -->
                <div class="form-group">
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nama Kelompok'])
                    !!}
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                <button data-dismiss="modal" class="btn btn-secondary">Batal</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection
