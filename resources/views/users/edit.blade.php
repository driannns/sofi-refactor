@extends('layouts.app')

@section('content')
    {{-- <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('users.index') !!}">User</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol> --}}
        <ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>PENGGUNA</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{!! route('users.index') !!}" class="text-dark">PENGGUNA</a> / UBAH PENGGUNA</h6>
    </div>
</ol>

    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}
             <div class="row">
                 <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                            <i class="fa fa-edit fa-lg"></i>
                            <strong>Edit User</strong>
                        </div>
                        <div class="card-body">
                          @include('users.fields')
                        </div>
                    </div>
                </div>
                @if(!empty($child))
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                        <i class="fa fa-history fa-lg"></i>
                        <strong>Data Detail {{( $isDosen ? "Dosen":"Mahasiswa")}}</strong>
                    </div>
                    <div class="card-body">
                      @if($isDosen)
                      <!-- nip Field -->
                      <div class="form-group">
                          {!! Form::label('nip', 'NIP') !!}
                          {!! Form::text('nip', $child->nip, ['class' => 'form-control']) !!}
                      </div>

                      <!-- jfa Field -->
                      <div class="form-group">
                          {!! Form::label('jfa', 'JFA') !!}
                          {!! Form::text('jfa', $child->jfa, ['class' => 'form-control']) !!}
                      </div>
                      @else
                      <!-- Tak Field -->
                      <div class="form-group">
                          {!! Form::label('tak', 'TAK') !!}
                          {!! Form::text('tak', $child->tak, ['class' => 'form-control']) !!}
                      </div>

                      <!-- Eprt Field -->
                      <div class="form-group">
                          {!! Form::label('eprt', 'EPRT') !!}
                          {!! Form::text('eprt', $child->eprt, ['class' => 'form-control']) !!}
                      </div>
                      @endif
                      <!-- kk Field -->
                      <div class="form-group">
                          {!! Form::label('kk', 'Kelompok Keahlian') !!}
                          <select class="form-control" name="kk">
                            <option value="Cybernetics" {{ $child->kk == "Cybernetics" ? 'selected' : '' }}>Cybernetics</option>
                            <option value="Engineering Management System" {{ $child->kk == "Engineering Management System" ? 'selected' : '' }}>Engineering Management System</option>
                            <option value="Enterprise and Industrial System" {{ $child->kk == "Enterprise and Industrial System" ? 'selected' : '' }}>Enterprise and Industrial System</option>
                            <option value="Production and Manufacturing System" {{ $child->kk == "Production and Manufacturing System" ? 'selected' : '' }}>Production and Manufacturing System</option>
                          </select>
                      </div>

                    </div>
                  </div>
                </div>
                @endif
         </div>
            {!! Form::close() !!}
    </div>
@endsection
