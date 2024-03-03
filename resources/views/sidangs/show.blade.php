@extends('layouts.app')

@section('content')
    <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>INFORMASI PENDAFTARAN</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / INFORMASI PENDAFTARAN</h6>
        </div>
    </ol>
     <div class="container-fluid">
          <div class="animated fadeIn">
                 @include('coreui-templates::common.errors')
                 @if (Session::has('error'))
                      <div class="alert alert-danger" role="alert">
                          {{Session::get('error')}}
                      </div>
                 @endif
                 @if ($sidang->status == 'tidak lulus' OR $sidang->status == 'tidak lulus (sudah update dokumen)')
                 <div class="alert alert-warning" role="alert">
                      Sidang anda tidak lulus, anda diwajibkan untuk mengupload PPT dan membuat team baru. silahkan menuju menu 'Materi Presentasi'.
                </div>
                 @endif
                 <div class="row">
                        <div class="col-12 col-md-6">
                         <div class="card">
                             <div class="card-header">
                                 <strong>Detail</strong>
                             </div>
                             <div class="card-body">
                                 @include('sidangs.show_fields')
                             </div>
                         </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="card">
                            <div class="card-header">
                                <i class="fa fa-history fa-lg"></i>
                                <strong>Riwayat Proses Pengajuan</strong>
                            </div>
                            <div class="card-body">
                              <div class="table-responsive-sm"  style="height:50vh; overflow-y:scroll">
                                <table class="table table-striped" id="sidangs-table">
                                    <thead>
                                      <tr>
                                        <td>Tanggal</td>
                                        <td>Nama Event</td>
                                        <td>Komentar</td>
                                        <td>Oleh</td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($status_logs as $log)
                                        <tr>
                                          <td>{{ date('l, d F Y - d:m', strtotime($log->created_at)) }}</td>
                                          <td class="text-center">
                                            {{-- {{$log->name}} --}}

                                          @if ($log->name == 'belum dijadwalkan')
                                            <span class="badge badge-secondary">Belum Dijadwalkan</span>
                                          @elseif ($log->name == 'belum dilaksanakan')
                                            <span class="badge badge-secondary">Belum Dilaksanakan</span>
                                          @elseif ($log->name == 'belum disetujui admin')
                                            <span class="badge badge-secondary">Belum Disetujui Admin</span>
                                          @elseif ($log->name == 'dikembalikan')
                                            <span class="badge badge-secondary">Dikembalikan</span>

                                          @elseif ($log->name == 'disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                          @elseif ($log->name == 'disetujui oleh pembimbing1')
                                            <span class="badge badge-success">Disetujui Pembimbing 1</span>
                                          @elseif ($log->name == 'disetujui oleh pembimbing2')
                                            <span class="badge badge-success">Disetujui Pembimbing 2</span>
                                          @elseif ($log->name == 'sudah dijadwalkan')
                                            <span class="badge badge-success">Dijadwalkan</span>
                                          @elseif ($log->name == 'telah disetujui admin')
                                            <span class="badge badge-success">Disetujui Admin</span>

                                          @elseif ($log->name == 'pengajuan')
                                            <span class="badge badge-warning">Pengajuan</span>
                                          @elseif ($log->name == 'perbaikan berkas ke admin')
                                            <span class="badge badge-warning">Perbaikan Berkas Ke Admin</span>
                                          @elseif ($log->name == 'sedang dikerjakan')
                                            <span class="badge badge-warning">Sedang Dikerjakan</span>
                                          @elseif ($log->name == 'sedang dilaksanakan')
                                            <span class="badge badge-warning">Sedang Dilaksanakan</span>

                                          @elseif ($log->name == 'lulus')
                                            <span class="badge badge-primary">Lulus</span>

                                          @elseif ($log->name == 'ditolak oleh admin')
                                            <span class="badge danger">Ditolak Admin</span>

                                          @endif

                                          </td>
                                          <td>{{$log->feedback}}</td>
                                          <td>{{$log->user->username}}</td>
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
