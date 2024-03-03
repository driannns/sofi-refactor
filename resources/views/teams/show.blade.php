@extends('layouts.app')

@section('content')
     {{-- <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('teams.index') }}">TIM</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
     </ol> --}}
     <ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>TIM</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('teams') }}" class="text-dark">TIM</a> / Detail</h6>
    </div>
</ol>

     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('coreui-templates::common.errors')
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-header">
                                 <strong>Detail</strong>
                                  <a href="{{ route('teams.index') }}" class="btn btn-light">Kembali</a>
                             </div>
                             <div class="card-body">
                                 @include('teams.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
@endsection
