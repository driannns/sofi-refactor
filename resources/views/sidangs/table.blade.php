<div class="table-responsive-sm" style="overflow-x:scroll">
    <table class="table table-striped" id="sidangs-table">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Judul TA</th>
                <th>Jumlah Bimbingan</th>
                @if(auth()->user()->isAdmin())
                <th>Tak</th>
                <th>Eprt</th>
                <th>Bahasa Sidang</th>
                <th>Periode</th>
                <th>SKS</th>
                @endif
                <th>Dokumen TA</th>
                <th>Jurnal</th>
                <th>Status</th>
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
                        echo "Pembimbing 1: ".$bimbingan1." Pertemuan <br>"."Pembimbing 2: ".$bimbingan2." Pertemuan";
                    ?>
                </td>
                @if(auth()->user()->isAdmin())
                <td>{{ $sidang->tak }}</td>
                <td>{{ $sidang->eprt }}</td>
                <td>{{ $sidang->is_english == 0 ? 'Indonesia' : 'Inggris' }}</td>
                <td>{{ $sidang->period->name }}</td>
                <td>{{ 'Lulus: '.$sidang->credit_complete}}<br>{{'Belum: '.$sidang->credit_uncomplete }}</td>
                @endif
                <td>
                  @if($sidang->dokumen_ta != null)
                  <a href="/uploads/ta/{{$sidang->dokumen_ta}}" class="btn btn-outline-primary" download>Download</a>
                  @endif
                </td>
                <td>
                  @if($sidang->makalah != null)
                  <a href="/uploads/makalah/{{$sidang->makalah }}" class="btn btn-outline-primary" download>Download</a>
                  @endif
                </td>
                <td class="text-center">
                  @if ($sidang->status == 'lulus')
                    <span class="badge badge-success">LULUS</span>
                  @elseif ($sidang->status == 'belum dijadwalkan')
                    <span class="badge badge-secondary">BELUM DIJADWAKAN</span>
                    @elseif ($sidang->status == 'tidak lulus (sudah update dokumen)')
                        <span class="badge badge-secondary">SIDANG ULANG<br>SUDAH UPDATE DOKUMEN</span>
                    @elseif ($sidang->status == 'tidak lulus (belum dijadwalkan)')
                        <span class="badge badge-secondary">SIDANG ULANG<br>BELUM DIJADWAKAN</span>
                    @elseif ($sidang->status == 'sudah dijadwalkan')
                    <span class="badge badge-info">DIJADWAKAN</span>
                     @elseif ($sidang->status == 'tidak lulus')
                    <span class="badge badge-danger">TIDAK LULUS</span>
                    @elseif ($sidang->status == 'ditolak oleh admin')
                    <span class="badge badge-danger">DITOLAK OLEH ADMIN</span>
                    @elseif ($sidang->status == 'pengajuan')
                    <span class="badge badge-warning">PENGAJUAN</span>
                    @elseif ($sidang->status == 'disetujui oleh pembimbing2')
                    <span class="badge badge-primary">DISETUJUI OLEH PEMBIMBING 2</span>
                    @elseif ($sidang->status == 'disetujui oleh pembimbing1')
                    <span class="badge badge-primary">DISETUJUI OLEH PEMBIMBING 1</span>
                    @elseif ($sidang->status == 'telah disetujui admin')
                        <span class="badge badge-primary">DISETUJUI OLEH ADMIN</span>
                  @endif
                </td>
                <td>{{ date('d M Y', strtotime($sidang->created_at)) }}</td>
                <td>
                    @if(auth()->user()->isAdmin()&& !auth()->user()->isSuperadmin())
                      @if(in_array($sidang->status,array('belum disetujui admin')))
                      <div class='btn-group'>
                          <button class='btn btn-success' data-toggle="modal" data-target="#feedbackAcceptAdminModal_{{$sidang->id}}" {{ $sidang->pembimbingBelumSetuju() ? 'disabled' : '' }}>
                            <i class="fa fa-check" style="color:white;"></i>
                          </button>
                          <button class='btn btn-danger' data-toggle="modal" data-target="#feedbackRejectAdminModal_{{$sidang->id}}" {{ $sidang->pembimbingBelumSetuju() ? 'disabled' : '' }}>
                            <i class="fa fa-times" style="color:white;"></i>
                          </button>
                      </div>
                      @elseif(in_array($sidang->status,array('sudah dijadwalkan')))
                      <div class='btn-group w-100'>
                        <a href="{{ route('schedules.show', [$sidang->schedules[0]->id]) }}" class='btn btn-light w-100'>
                          Lihat Jadwal
                        </a>
                      </div>
                      @endif
                      <div class='btn-group w-100'>
                          <a href="{{ route('sidangs.updateData', [$sidang->id]) }}" class='btn btn-light w-100'>
                              Update
                          </a>
                      </div>
                    @elseif( (auth()->user()->isPIC() || auth()->user()->isSuperadmin()) && Request::is('sidangs/pic*'))
                    <div class='btn-group'>
                        @if($sidang->status=='belum dijadwalkan' OR $sidang->status == 'tidak lulus (belum dijadwalkan)')
                        <a href="{{ route('schedules.create', [$sidang->mahasiswa->team->id]) }}" class='btn btn-primary'>Jadwalkan</a>
                        @elseif($sidang->status == 'sudah dijadwalkan' OR $sidang->status == 'tidak lulus (sudah dijadwalkan)')
                        <button type="button" class='btn btn-primary' disabled>Sudah Dijadwalkan</button>
                        @endif
                    </div>
                    @endif
                    @if(auth()->user()->isPembimbing() && Request::is('sidangs/pembimbing*'))
                    <div class='btn-group'>
                        @if($sidang->status == 'sudah dijadwalkan')
                          @if($sidang->schedules->last()->status == 'telah dilaksanakan')
                          <a href="{{ route('revisions.show', $sidang->schedules->last()->id) }}" class="btn btn-success text-white">List Revisi</a>
                          @else
                          <a href="#" class="btn btn-dark text-white disabled">List Revisi</a>
                          @endif
                        @else
                        <a href="#" class="btn btn-dark text-white disabled">List Revisi</a>
                        @endif
                    </div>
                    @endif
                </td>
            </tr>
            <!--Modal Section -->
            @if(auth()->user()->isAdmin())
              <div class="modal fade" id="feedbackAcceptAdminModal_{{$sidang->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                <form action="{{ route('sidangs.approve', [$sidang->id]) }}" method="post">
                  @csrf
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">Feedback</label>
                            <textarea class="form-control" id="message-text" name="feedback"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">Bahasa Sidang</label>
                            <p>
                              <small>Pastikan anda melihat nilai EPRT mahasiswa yang bersangkutan</small>
                            </p>
                            <select class="form-control" name="bahasa">
                                <option value="indonesia">Indonesia</option>
                                <option value="inggris">Inggris</option>
                            </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Approve Sidang</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div class="modal fade" id="feedbackRejectAdminModal_{{$sidang->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                <form action="{{ route('sidangs.feedback', [$sidang->id]) }}" method="post">
                  @csrf
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">Feedback</label>
                            <textarea class="form-control" id="message-text" name="feedback"></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Feedback</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            @endif

            @if(auth()->user()->isPembimbing())
              <div class="modal fade" id="feedbackAcceptPembimbingModal_{{$sidang->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                <form action="{{ route('sidangs.terimaPengajuan', [$sidang->id]) }}" method="post">
                  @csrf
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Penyetujuan Pengajuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">Komentar</label>
                            <textarea class="form-control" id="message-text" name="feedback"></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Setujui Pengajuan</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div class="modal fade" id="feedbackRejectPembimbingModal_{{$sidang->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                <form action="{{ route('sidangs.tolakPengajuan', [$sidang->id]) }}" method="post">
                  @csrf
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Penolakan Pengajuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="message-text" class="col-form-label">Komentar</label>
                            <textarea class="form-control" id="message-text" name="feedback"></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script type="text/javascript">
    $('#sidangs-table').DataTable({
        pageLength: 15,

        order: [[ 12, "desc" ]],

        order: [[ 7, "desc" ]],

    });
</script>
@endpush()
