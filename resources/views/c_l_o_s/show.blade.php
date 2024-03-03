@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>CLOS</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('cLOS.index') !!}" class="text-dark">CLOS</a> / DETAIL CLOS</h6>
        </div>
    </ol>
     {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('cLOS.index') }}">C L O</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
     </ol> --}}
     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('coreui-templates::common.errors')
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-header">
                                 <strong>Details</strong>
                                  <a href="{{ route('cLOS.index') }}" class="btn btn-light">Back</a>
                             </div>
                             <div class="card-body">
                                 @include('c_l_o_s.show_fields')
                             </div>
                         </div>
                     </div>
                 </div>
          </div>
    </div>
@endsection
