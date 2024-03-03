@extends('layouts.app')

@section('content')
<ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>TIM</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{!! route('teams.index') !!}" class="text-dark">TIM</a> / TAMBAH ANGGOTA TIM</h6>
    </div>
</ol>

<div class="container-fluid">
    <div class="animated fadeIn">
        @include('coreui-templates::common.errors')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <i class="fa fa-plus-square-o fa-lg"></i>
                        <strong>Tambah Anggota Team</strong>
                    </div> --}}
                    <div class="card-body">
                        <form class="" action="/store-member" method="post">
                            @csrf
                            @include('teams.fields-member')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
