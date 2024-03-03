<div class="table-responsive-sm" style="overflow-x:scroll">
    <table class="table table-striped" id="sidangs-table">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Judul TA</th>
                <th>Jumlah Bimbingan</th>
                <th>Tak</th>
                <th>Eprt</th>
                <th>Bahasa Sidang</th>
                <th>Periode</th>
                <th>SKS</th>
                <th>Dokumen TA</th>
                <th>Jurnal</th>
                <th>Status</th>
                <th>Diajukan pada</th>
                <th>Action</th>
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
                        echo "Pembimbing 1: ".$bimbingan1."<br>"."Pembimbing 2: ".$bimbingan2;
                    ?>
                </td>
                <td>{{ $sidang->tak }}</td>
                <td>{{ $sidang->eprt }}</td>
                <td>{{ $sidang->is_english == 0 ? 'Indonesia' : 'Inggris' }}</td>
                <td>{{ $sidang->period->name }}</td>
                <td>{{ 'Lulus: '.$sidang->credit_complete}}<br>{{'Belum: '.$sidang->credit_uncomplete }}</td>
                <td>
                  @if($sidang->dokumen_ta != null)
                  <a href="/uploads/ta/{{$sidang->dokumen_ta}}" class="btn btn-primary" download>Download</a>
                  @endif
                </td>
                <td>
                  @if($sidang->makalah != null)
                  <a href="/uploads/makalah/{{$sidang->makalah }}" class="btn btn-primary" download>Download</a>
                  @endif
                </td>
                <td>{{ $sidang->status }}</td>
                <td>{{ $sidang->created_at }}</td>
                <td>
                      @if($sidang->schedules != "[]")
                        @if(in_array($sidang->status,array('lulus','tidak lulus','sidang ulang','lulus bersyarat')))
                        <div class='btn-group w-100'> 
                            <button class='btn btn-primary w-100' data-toggle="modal" data-target="#viewTabelDocument_{{$sidang->id}}">
                              <i class="fa fa-print" style="color:white;"></i>
                              Cetak
                            </button>
                        </div>
                        @endif
                      @endif
                </td>
            </tr>
            <!--Modal Section -->
              <div class="modal fade" id="viewTabelDocument_{{$sidang->id}}" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Dokumen Download</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                          <embed type="" src="{{ route('schedules.listEmbed', [$sidang->id])}}" width="100%" height="500px">
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

@push('scripts')
<script type="text/javascript">
    $('#sidangs-table').DataTable({
        pageLength: 15,
        columnDefs: [ { type: 'date-eu', 'targets': [12] } ],
        order: [[ 12, "desc" ]]
    });
</script>
@endpush()
