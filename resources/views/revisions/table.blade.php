<div class="table-responsive">
  <table class="table table-striped" id="revisions-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Mahasiswa</th>
        <th>Judul</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @php
        $counter = 1;
      @endphp
      @foreach($schedules as $schedule)
      @if($schedule->revisions != '[]')
      <tr class="bg-white" id="{{ 'user_'.$schedule->id }}">
        <td>{{ $counter++ }}</td>
        <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
        <td>{{ $schedule->sidang->judul }}</td>
        <td  >
          <div class='btn-group'>
            <button type="button" class='btn btn-info text-white' data-toggle="collapse" data-target="#accordion{{$loop->iteration}}" class="clickable">
              <i class="fa fa-eye"></i> Lihat Revisi
            </button>
          </div>
        </td>
      </tr>

      <tr class="bg-light hide-table-padding">
        <td colspan="6">
          <div id="accordion{{$loop->iteration}}" class="collapse {{ session('current') == $schedule->id ? 'show' : '' }}">
            <a class="pull-right mb-2" href="{{ route('revisions.create', $schedule->id) }}"><i class="fa fa-plus-square fa-lg"></i></a>
            <a class="pull-right mr-1" href="{{ route('revisions.edit', $schedule->id) }}"><i class="fa fa-edit fa-lg"></i></a>
            <table class="table my-4">
              <thead class="bg-info">
                <tr>
                  <th>No</th>
                  <th>Deskripsi Revisi</th>
                  <th>Halaman</th>
                  <th>Status</th>
                  <th>File Dokumen TA</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $counters = 1;
                @endphp
                <div class="alert alert-warning" role="alert">
                  @if( $schedule->durasi_revisi == 7 )
                    Batas revisi sampai tanggal {{ Carbon\Carbon::parse($schedule->date)->addDays(7)->format('d M Y')}}
                  @else
                    Batas revisi sampai tanggal {{ Carbon\Carbon::parse($schedule->date)->addDays(14)->format('d M Y')}}
                  @endif
                </div>
                <?php echo "<pre>";//print_r($schedule->revisions[6]->dokumen_mahasiswa)?>
                @foreach($schedule->revisions as $revision)
                @if($revision->lecturer_id == Auth::user()->lecturer->id)
                {{-- @if($revision->status != 'disetujui') --}}

                <tr class="bg-white">
                  <td class="col-3">{{ $counters++ }}</td>
                  <td class="col-3">  {{ $revision->deskripsi }}</td>
                  <td>{{ $revision->hal }}</td>
                  <td>
                    @if ($revision->status == 'sudah dikirim')
                        <span class="badge badge-warning">SUDAH DIKIRIM</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                        <span class="badge badge-primary">SEDANG DIKERJAKAN</span>
                    @elseif ($revision->status == 'diterima')
                        <span class="badge badge-success">DITERIMA</span>
                    @elseif ($revision->status == 'disetujui')
                        <span class="badge badge-success">DISETUJUI</span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                        <span class="badge badge-danger">DITOLAK</span>    
                    @endif
                    {{-- {{ $revision->status }}</td> --}}
                  <td>
                    {{-- <a  href="/{{$revision->dokumen->file_url}}" class='btn btn-success'  {{ $revision->status == 'sedang dikerjakan' ? 'disabled' : '' }} download>
                      Download Revisi</i>
                    </a> --}}
                    <button class='btn btn-outline-success' data-toggle="modal" data-target="#viewRevisionLogs_{{$revision->id}}" {{ $revision->status == 'sedang dikerjakan' ? 'disabled' : '' }}>
                      Download
                    </button>
                  </td>
                  <td>
                    <div class="row">
                      {{--  <form class="" action="{{ route('revisions.dosen.approve', $revision->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Apa anda yakin?')" {{ $revision->status == 'sudah dikirim' ? '' : 'disabled' }}>
                          Approve
                        </button>
                      </form>  --}}

                      <button href="{{ url('revision/dosen/approve', $revision->id) }}" class="btn btn-success setuju-confirm"  {{$revision->status == 'sudah dikirim' ? '' : 'disabled'}} id="setuju-confirm"  data-role="{{$revision->status == 'sudah dikirim' ? '' : 'disabled'}} {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}" >Approve</button>

                      <button class='btn btn-danger text-white' data-toggle="modal" data-target="#feedback_{{$revision->id}}" {{ $revision->status == 'sudah dikirim' ? '' : 'disabled' }}>
                        Tolak
                      </button>
                      @if(Auth::user()->username == 'ekkynovrizalam')
                      <form class="" action="{{ route('revisions.destroy', $revision->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }} ">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                      @endif
                    </div>
                  </td>
                </tr>
                {{-- @endif --}}

                {{-- Modal Section --}}
                <div class="modal fade" id="feedback_{{$revision->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                  <form class="" action="{{ route('revisions.dosen.tolak', $revision->id) }}" method="post">
                    @csrf
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Penolakan Revisi</h5>
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
                          <button type="submit" class="btn btn-danger">Tolak Revisi</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="modal fade" id="viewRevisionLogs_{{$revision->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Riwayat Revisi</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                          <embed type="" src="{{ route('revisions.logsEmbed', [$revision->id])}}" width="100%" height="500px">
                    </div>
                    <div class="modal-footer">
                      @if(isset($revision->dokumen_mahasiswa))
                      <a  href="/{{$revision->dokumen_mahasiswa->file_url}}" class='btn btn-success'  {{ $revision->status == 'sedang dikerjakan' ? 'disabled' : '' }} download>
                        Download Revisi</i>
                      </a> 
                      @else
                      <a  href="/{{$revision->dokumen->file_url}}" class='btn btn-success'  {{ $revision->status == 'sedang dikerjakan' ? 'disabled' : '' }} download>
                        Download Revisi</i>
                      </a> 
                      @endif
                    </div>
                  </div>
                  </div>
              </div>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
</div>

@push('scripts')
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">


<script type="text/javascript">
$('.setuju-confirm').on('click', function (event) {
  event.preventDefault();
  const url = $(this).attr('href');
  Swal.fire({
      title: 'Anda Sudah Yakin?',
      text: 'Setuju!',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#f86c6b',
      confirmButtonColor: '#43afd6',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Ya',
      reverseButtons: true

  }) .then((res) => {
      if(res.value){
          console.log('confirmed');
          window.location.href = url;
      }else if(res.dismiss == 'cancel'){
          console.log('cancel');
          return false;
      }
      else if(res.dismiss == 'esc'){
          console.log('cancle-esc**strong text**');
      }
  });
});

</script>
@endpush
