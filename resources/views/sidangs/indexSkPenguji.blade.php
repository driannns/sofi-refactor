@extends('layouts.app')

@section('content')
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">Pendaftar TA</li>
    </ol> --}}
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>Daftar Sidang</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / Daftar Sidang</h6>
        </div>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Pendaftar TA
                         </div> --}}
                         <div class="card-body">
                            <div class="table-responsive-sm" style="overflow-x:scroll">
                                <table class="table table-striped" id="sidangs-table">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Judul TA</th>
                                            <th>Periode</th>
                                            <th>Diajukan pada</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sidangs as $sidang)
                                        <tr>
                                            <td>{{ $sidang->mahasiswa_id }}</td>
                                            <td>{{ $sidang->mahasiswa->user->nama }}</td>
                                            <td>{{ $sidang->judul }}</td>
                                            <td>{{ $sidang->period->name }}</td>
                                            <td>{{ $sidang->created_at }}</td>
                                            <td>
                                                <div class='btn-group w-100'>
                                                    @if($sidang->sk_penguji_file == null)
                                                        <a href="{{ route('sidangs.SkPengujiForm', [$sidang->id]) }}" class='btn btn-light w-100'>
                                                            Upload SK Penguji
                                                        </a>
                                                    @else
                                                        <a href="{{ route('sidangs.SkPengujiForm', [$sidang->id]) }}" class='btn btn-light w-100'>
                                                            Reupload SK Penguji
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                              <div class="pull-right mr-3">
                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('#sidangs-table').DataTable({
        pageLength: 15,
    });
</script>
@endpush()
