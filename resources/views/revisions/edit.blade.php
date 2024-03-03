@extends('layouts.app')

@section('content')
    {{-- <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('revisions.index') !!}">Revision</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol> --}}
        <ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>REVISI</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / UBAH REVISI</h6>
    </div>
</ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             @include('flash::message')
             @if($isLate)
             <div class="alert alert-warning">
               Sudah mencapai batas revisi, tidak dapat menambah atau mengubah revisi lagi
             </div>
             @endif
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          {{-- <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Ubah Revisi</strong>

                          </div> --}}
                          <div class="card-body">
                            <form action="{{ route('revisions.update', $schedule->id) }}" id="frm1" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                @include('revisions.fields')
                             </form>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
