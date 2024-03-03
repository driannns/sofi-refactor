@extends('layouts.app')

@section('content')

<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>TIM</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{!! route('teams.index') !!}" class="text-dark">TIM</a> / BUAT TIM</h6>
    </div>
</ol>
@include('flash::message')

{{-- <li class="breadcrumb-item">
         <a href="{!! route('teams.index') !!}">Team</a>
      </li>
      <li class="breadcrumb-item active">Create</li> --}}
<div class="container-fluid">
    <div class="animated fadeIn">
        {{-- @include('flash::message') --}}
         @include('coreui-templates::common.errors')
        <div class="row">
            <div class="col-lg-4 offset-2">
                <div class="card" style="min-height: 300px">
                    <div class="card-body text-center">
                        {{-- {!! Form::open(['route' => 'teams.store']) !!}

                        @include('teams.fields')

                        {!! Form::close() !!}

                        <hr>

                        <!-- individu Field -->
                        <div class="form-group col-sm-12">
                            <p>Dengan menekan button dibawah, maka anda memilih untuk sidang secara individu</p>
                            <form class="" action="{{ route('teams.individu') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary" name="button"
                            onclick="return confirm('apakah anda yakin?')">Sidang Individu</button>
                        </form>
                    </div> --}}

                    <h3>SIDANG INDIVIDU</h3>
                    <i class="fa fa-user mb-4 mt-3" style="font-size: 80px"></i>

                    <p>Dengan menekan button dibawah, maka anda memilih untuk sidang secara individu</p>

                    <button class="btn btn-primary" name="button" data-toggle="modal" data-target="#individu">Sidang
                        Individu</button>

                    {{-- MODAL SIDANG INDIVIDU  --}}
                    <div class="modal fade" id="individu">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Perhatian</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body text-center">
                                    <form class="" action="{{ route('teams.individu') }}" method="post">
                                        @csrf
                                        <h5>Apa anda yakin untuk memilih Sidang Individu?</h5><br>
                                        <button data-dismiss="modal" class="btn btn-secondary">Tidak</button>
                                        <button type="submit" class="btn btn-primary" name="button">Iya</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="min-height: 300px">
                <div class="card-body text-center">
                    <h3>SIDANG KELOMPOK</h3>
                    <i class="fa fa-users mb-4 mt-3" style="font-size: 80px"></i>
                    {!! Form::open(['route' => 'teams.store']) !!}
                    @include('teams.fields')
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>
</div>
</div>
</div>
@endsection
