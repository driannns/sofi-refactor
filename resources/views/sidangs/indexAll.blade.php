@extends('layouts.app')

@section('content')
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">Pendaftar TA</li>
    </ol> --}}
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>PENDAFTAR TA</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / PENDAFTAR TA</h6>
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
                                            <th>Jumlah Bimbingan</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                            <th>Diajukan pada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sidangs as $sidang)
                                        <tr>
                                            <td>{{ $sidang->mahasiswa_id }}</td>
                                            <td>{{ $sidang->mahasiswa->user->nama }}</td>
                                            <td>{{ $sidang->judul }}</td>
                                            <td><?php
                                                    $dataBimbingan = explode(";", $sidang->form_bimbingan);
                                                    if(count($dataBimbingan)>1){
                                                      $bimbingan1 = $dataBimbingan[0];
                                                      $bimbingan2 = $dataBimbingan[1];
                                                    }else
                                                    {
                                                      $bimbingan1 = "tidak ada data";
                                                      $bimbingan2 = "tidak ada data";
                                                    }
                                                    echo "Pembimbing 1: ".$bimbingan1."Pertemuan <br>"."Pembimbing 2: ".$bimbingan2. "Pertemuan";
                                                ?>
                                            </td>
                                            <td>{{ $sidang->period->name }}</td>
                                            <td>{{ $sidang->status }}<br>
                                                <button class='btn btn-primary' data-toggle="modal" data-target="#viewStatusLog_{{$sidang->id}}">
                                                    <i class="fa fa-list" style="color:white;"></i>
                                                    Detail
                                                </button>
                                            </td>
                                            <td>{{ $sidang->created_at }}</td>
                                        </tr>
                                        <div class="modal fade" id="viewStatusLog_{{$sidang->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">View Status Log</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <ol>
                                                                <li>Nama | Dibuat pada | Dibuat oleh</li>
                                                            @foreach ($sidang->statusLogs as $status)
                                                                <li>
                                                                    {{$status->name}} | {{$status->created_at}} | {{$status->user->username}}
                                                                </li>
                                                            @endforeach
                                                            </ol>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        order: [[ 6, "desc" ]],
    });
</script>
@endpush()
