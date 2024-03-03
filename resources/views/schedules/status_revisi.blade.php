@extends('layouts.app')
@php
    $admin = auth()->user()->isAdmin();
    $pembimbing = auth()->user()->isPembimbing();
    $pic = auth()->user()->isPIC();
    $penguji = auth()->user()->isPenguji();
    $student = auth()->user()->isStudent();
@endphp

@section('content')
        <ol class="breadcrumb mb-0">
        <div class="col-12">
            <h3>STATUS REVISI MAHASISWA</h3>
            <hr class="mt-0">
            <h6 class="mb-3"><a href="{{ route('home') }}" class="text-dark">BERANDA</a> / STATUS REVISI MAHASISWA</h6>
        </div>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             @if (Session::has('error'))
                  <div class="alert alert-danger" role="alert">
                      {{Session::get('error')}}
                  </div>
             @endif
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         {{-- <div class="card-header">
                             <i class="fa fa-align-justify"></i>
                             Status Revisi Mahasiswa
                         </div> --}}
                         <div class="card-body">
                            @php
                            $userInfo = auth()->user();
                          @endphp
                          <div class="table-responsive-sm" style="overflow-x:scroll">
                              <table class="table table-striped" id="schedules-table">
                                  <thead>
                                    <tr>
                                      <th>NIM</th>
                                      <th>Nama</th>
                                      <th>Tanggal Sidang</th>
                                      <th>Pembimbing</th>
                                      <th>Penguji</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($schedules as $schedule)
                                    @php
                                        $isHadir = $userInfo->isHadirSidang($schedule->id);
                                        $isNilai = $userInfo->isNilaiSidang($schedule->id);
                                    @endphp
                                      <tr>
                                      <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
                                      <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
                                      <td>
                                        {{ date('d M y', strtotime($schedule->date)) }}
                                      </td>
                                      <td>
                                        <ol>
                                            <li>{{$schedule->sidang->pembimbing1->user->nama}}</li>
                                            <li>{{$schedule->sidang->pembimbing2->user->nama}}</li>
                                        </ol>
                                      </td>
                                      <td>
                                          <ol>
                                              <li>{{$schedule->detailpenguji1->user->nama}}</li>
                                              <li>{{$schedule->detailpenguji2->user->nama}}</li>
                                          </ol>
                                      </td>
                                      </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                          </div>

                          @if($userInfo->isPIC() && Request::is('schedules'))
                            @if($schedules != '[]')
                            <div class="modal fade" id="detailSidangModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                              <form action="" method="post">
                                @csrf
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Detail Sidang</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                          <embed id="detail" src="" frameborder="0" width="100%" height="400px">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                            @endif
                          @endif

                          @push('scripts')
                          <script type="text/javascript">
                            $('.view').on("click", function () {
                                  var position = $(this).data('position');
                                  detail = "{{ url('/schedule') }}"+"/"+position;
                                  $("#detail").attr("src", detail);
                              });
                              @if($userInfo->isAdmin())
                                $('#schedules-table').DataTable({
                                    pageLength: 15,
                                    "aaSorting": []
                                });
                              @else
                              $('#schedules-table').DataTable({
                                  pageLength: 15,
                                  order: [[ 3, "desc" ]]
                              });
                              @endif
                          </script>
                          @endpush()

                              <div class="pull-right mr-3">

                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection
