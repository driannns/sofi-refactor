@extends('layouts.app_embed')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
             <div class="row">
                 <div class="col-lg-12">
                    <div class="table-responsive-sm" style="overflow-x:scroll">
                      <table class="table table-striped" id="schedules-table">
                          <thead>
                            <tr>
                              <th>NIM</th>
                              <th>Nama</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Ruang</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($schedules as $schedule)
                              <tr>
                                <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
                                <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
                                <td>
                                  {{ date('d-M-y', strtotime($schedule->date)) }}
                                </td>
                                <td>{{ $schedule->time }}</td>
                                <td>{{ $schedule->ruang }}</td>
                                <td>{{ $schedule->status }}</td>
                                <td>
                                    <div class='btn-group'>
                                      @if( $schedule->status == 'telah dilaksanakan' )
                                      <a class='btn btn-primary' target="_blank" href="{{ route('cetak.all', [$schedule->id,$schedule->sidang->period_id,'print' => 'true'])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Cetak Semua
                                      </a>
                                      @endif
                                      {{-- <a class='btn btn-primary' target="_blank" href="{{ route('cetak.berita_acara', [$schedule->id,'print' => 'true'])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Berita Acara
                                      </a>
                                        <a class='btn btn-primary' target="_blank" href="{{ route('cetak.revisi', [$schedule->id,'print' => 'true'])}}">
                                            <i class="fa fa-print" style="color:white;"></i>
                                            Revisi
                                        </a>
                                      <a class='btn btn-primary' target="_blank" href="{{ route('cetak.form_nilai_penguji', [$schedule->sidang->period_id,'print' => 'true',$schedule->id,1])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Form Penilaian Penguji 1
                                      </a>
                                      <a class='btn btn-primary' target="_blank" href="{{ route('cetak.form_nilai_penguji', [$schedule->sidang->period_id,'print' => 'true',$schedule->id,2])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Form Penilaian Penguji 2
                                      </a>
                                      <a class='btn btn-primary' target="_blank" href="{{ route('cetak.form_nilai_pembimbing', [$schedule->sidang->period_id,'print' => 'true',$schedule->id,1])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Form Penilaian Pembimbing 1
                                      </a>
                                      <a class='btn btn-primary' target="_blank" href="{{ route('cetak.form_nilai_pembimbing', [$schedule->sidang->period_id,'print' => 'true',$schedule->id,2])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Form Penilaian Pembimbing 2
                                      </a>
                                      <a class='btn btn-primary' target="_blank" href="{{ route('cetak.nilai_sidang', [$schedule->id,'print' => 'true'])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Nilai Sidang
                                      </a>
                                      <a class='btn btn-primary' target="_blank" href="{{ route('cetak.daftar_hadir', [$schedule->id,'print' => 'true'])}}">
                                        <i class="fa fa-print" style="color:white;"></i>
                                        Daftar Hadir
                                      </a> --}}
                                    </div>
                                </td>
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
             </div>
         </div>
    </div>
@endsection
