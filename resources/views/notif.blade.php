@extends('layouts.app')

@section('content')
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">Notification</li>
    </ol> --}}
    <ol class="breadcrumb mb-0">
    <div class="col-12">
        <h3>NOTIFIKASI</h3>
        <hr class="mt-0">
        <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / NOTIFIKASI</h6>
    </div>
</ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Notification
                         </div> --}}
                         <div class="card-body">
                             <div class="table-responsive-sm">
                                <table class="table table-striped datatable" id="periods-table">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Pesan</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Dibuat pada</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(auth()->user()->notifications as $notif)
                                        <tr>
                                            <td>{{ $notif->data['title'] }}</td>
                                            <td>{{ $notif->data['message'] }}</td>
                                            <td>{{ $notif->data['created_by'] }}</td>
                                            <td>{{ date('d-M-Y H:i', strtotime($notif->created_at)) }}</td>
                                            <td>{{ $notif->read_at ? "sudah dibaca" : "belum dibaca" }}</td>
                                            <td>
                                                @if ( !($notif->read_at))
                                                <div class='btn-group'>
                                                    <a href="{{ $notif->markAsRead() }}" class='btn btn-ghost-success'>Tandai sudah dibaca</a>
                                                </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

