@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>LIST SN DOKUMEN</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{!! route('verifyDocuments.index') !!}" class="text-dark">LIST SN DOKUMEN</a> / UBAH LIST SN DOKUMEN</h6>
        </div>
    </ol>
    {{-- <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('verifyDocuments.index') !!}">Verify Document</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol> --}}
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          {{-- <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Verify Document</strong>
                          </div> --}}
                          <div class="card-body">
                              {!! Form::model($verifyDocument, ['route' => ['verifyDocuments.update', $verifyDocument->id], 'method' => 'patch']) !!}

                              @include('verify_documents.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection