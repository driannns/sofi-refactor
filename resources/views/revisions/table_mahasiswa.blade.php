@if(count($revisions)>0)
<div class="alert alert-warning" role="alert">
    @if( $revisions[count($revisions)-1]->schedule->durasi_revisi == 7 )
    Batas revisi anda sampai tanggal
    <b>{{ Carbon\Carbon::parse($revisions[count($revisions)-1]->schedule->date)->addDays((7-2))->format('d M Y')}}</b>.
    <br>
    Jika melebihi batas tersebut, maka anda dinyatakan <b><u>tidak lulus</u></b> dan <b><u>harus sidang ulang</u></b>!
    @else
    Batas revisi anda sampai tanggal
    <b>{{ Carbon\Carbon::parse($revisions[count($revisions)-1]->schedule->date)->addDays((14-2))->format('d M Y')}}</b>
    <br>
    Jika melebihi batas tersebut, maka anda dinyatakan <b><u>tidak lulus</u></b> dan <b><u>harus sidang ulang</u></b>!
    @endif
</div>
@endif
<div class="table-responsive ">
    <table class="table table-striped datatable" id="revisions-table">
        <thead>
            <tr>
                <th><input type="checkbox" onchange="checkAll(this)">
                    <span id="count-checked-checkboxes">0</span> selected
                    </th>
                <th>No</th>
                <th>Deskripsi Revisi</th>
                <th>Halaman</th>
                <th>Status</th>
                <th>Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revisions as $revision)
            <tr>
                <td>
                    <input type="checkbox" name="revision_id[]" id="cekcekbox" value="{{ $revision->id }}"
                    {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}
                    {{ $revision->schedule->keputusan == 'tidak lulus' ? 'disabled' : '' }}>
                </td>
                <td>{{ $loop->iteration }}</td>
                {{--  <td class="col-xs-5 col-sm-3"> {{ $revision->deskripsi }} </td>  --}}

                <td   align="left"><textarea readonly rows="3"   style="min-width: 100%;height: 50% resize:none">{{ $revision->deskripsi }} </textarea></td>

                <td><input type="text" name="hal[{{ $revision->id }}]" value="{{ $revision->hal }}"
                        {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}
                        {{ $revision->schedule->keputusan == 'tidak lulus' ? 'disabled' : '' }}></td>
                <td class="text-center">
                    @if ($revision->status == 'disetujui')
                    <span class="badge badge-success">{{ strtoupper($revision->status) }} </span>
                    @elseif ($revision->status == 'sudah dikirim')
                    <span class="badge badge-warning">{{ strtoupper($revision->status) }} </span>
                    @elseif ($revision->status == 'sedang dikerjakan')
                    <span class="badge badge-secondary">{{ strtoupper($revision->status) }} </span>
                    @elseif ($revision->status == 'ditolak')
                    <span class="badge badge-danger">{{ strtoupper($revision->status) }} </span>
                    @endif

{{--
                    {{ strtoupper($revision->status) }} --}}


                </td>
                @if($revision->lecturer_id != Null)
                <td>{{ $revision->lecturer->code }}</td>
                @else
                <td></td>
                @endif
                <td>
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if(!file_exists($revision->dokumen->file_url) or ($revision->dokumen->jenis == "draft"))
                            <a href="javascript:attend('')" class="btn btn-outline-primary border-0 feedback-modal-button w-100  {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}">  Detail</a>
                        @elseif(file_exists($revision->dokumen->file_url))
                            <button type="button" class='btn btn-outline-primary btn-dokumen-revisi border-0 w-100' data-toggle="modal"
                                data-target="#viewDokumenTA" data-url="/{{$revision->dokumen->file_url}}" data-title="{{$revision->dokumen->id}}"
                                {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}>
                                Detail
                            </button><hr class="mt-0 mb-0">
                        @else
                            <a href="javascript:attend('')" class="btn btn-outline-primary border-0 feedback-modal-button w-100  {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}">  Detail</a>
                        @endif
                            <button type="button" class="btn btn-outline-primary border-0 feedback-modal-button w-100"
                                data-toggle="modal" data-target="#viewFeedback"
                                data-feedback="{{ $revision->feedback }}"
                                {{ $revision->feedback == null ? 'disabled' : '' }}>
                                Feedback
                            </button>
                        </div>
                    </div>

                    {{-- <button type="button" class='btn btn-success w-100' data-toggle="modal" data-target="#viewDokumenTA"
                        {{ $revision->status == 'sedang dikerjakan' ? '' : 'disabled' }}>
                    <i class="fa fa-eye"></i>
                    </button>
                    <button type="button" class='btn btn-info text-white feedback-modal-button w-100'
                        data-toggle="modal" data-target="#viewFeedback" data-feedback="{{ $revision->feedback }}"
                        {{ $revision->feedback == null ? 'disabled' : '' }}>
                        Feedback
                    </button> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($revisions != '[]')
<div class="modal fade" id="viewDokumenTA" tabindex="-1" role="dialog" aria-labelledby="feedbackModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDokumenTAtitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="ember_dokumen">
                    <!-- <embed src="/{{$revision->dokumen->file_url}}" type="application/pdf" frameborder="0" width="100%" height="400px"> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewFeedback" tabindex="-1" role="dialog" aria-labelledby="feedbackModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="feedback-modal"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">
<script type="text/javascript">
    $(document).ready(function () {
        $('.feedback-modal-button').on('click', function () {
            var data = $(this).data('feedback');
            $('#feedback-modal').html(data);
        });
        $(document).on('click','.btn-dokumen-revisi', function () {
            event.preventDefault()
            var url_ = $(this).data('url');
            var title_ = $(this).data('title');
            var data = `<embed src="${url_}" type="application/pdf" frameborder="0" width="100%" height="400px">`
            console.log(data);
            var doto = `View Dokumen TA`
            $('#viewDokumenTAtitle').html(doto);
            $('#ember_dokumen').html(data);
        });
    });

</script>
<script>
    function checkAll(ele) {
         var checkboxes = document.getElementsByTagName('input');
         var $checkboxes = $('#devel-generate-content-form td input[type="checkbox"]');
         if (ele.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
                     checkboxes[i].checked = true;
                     var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                     $('#count-checked-checkboxes').text(countCheckedCheckboxes);
                 }
                 var numberNotChecked = $('input:checkbox:not(":checked")').length;
                 var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                     $('#count-checked-checkboxes').text(countCheckedCheckboxes);
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                     var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
                     $('#count-checked-checkboxes').text(countCheckedCheckboxes);
                 }
             }
         }
     };

  </script>
  <script>
  $(document).ready(function(){

  var $checkboxes = $('#devel-generate-content-form td input[type="checkbox"]');

  $checkboxes.change(function(){
      var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
      $('#count-checked-checkboxes').text(countCheckedCheckboxes);
  });

  });

  </script>
  <script>
    function attend(link) {
        console.log(link)
        Swal.fire({
            title: 'Perhatian!',
            text: 'file tidak ada',
            icon: 'info',
            confirmButtonText: 'Tutup'
        });
    }

</script>
@endpush
