@php
use Carbon\Carbon;
$date = Carbon::today()->locale('id_ID');    
@endphp

@if(!Request::is('cetak/daftar_hadir/*'))
<div class="container mb-5">
  <div class="row">
    <div class="col-sm-12" style="padding:0px 200px 0px 200px">
      @if(Request::is('cetak/revisi/*'))
      <div class="pull-left">
        <table class="table table-bordered">
          <tr>
            <td colspan="2">
              <p>Perbaikan telah dilakukan sesuai dengan catatan di atas.</p>
            </td>
          </tr>
          <tr class="text-center">
            <td>
              Mengetahui,
            </td>
            <td>
              Menyetujui,
            </td>
          </tr>
          <tr>
            <td>
              <p class="mb-5">Bandung, {{ $schedule->date->isoFormat('dddd D MMMM Y') }}</p>
              <p class="text-center">{{ $schedule->detailpenguji2->user->nama }}</p>
            </td>
            <td>
              <p class="mb-5">Bandung, {{ $schedule->date->isoFormat('dddd D MMMM Y') }}</p>
              <p class="text-center">{{ $schedule->detailpenguji1->user->nama }}</p>
            </td>
          </tr>
        </table>
      </div>
      @endif
      <div class="pull-right">
        <table>
          @if(Request::is('cetak/revisi/*'))
          <tr>
            <td><br></td>
          </tr>
          <tr>
            <td><br></td>
          </tr>
          @endif
          <tr>
            <td>
              <p>Bandung, {{ $schedule->date->isoFormat('dddd D MMMM Y') }}</p>
            </td>
          </tr>
          <tr>
            <td>
              @if(Request::is('cetak/berita_acara/*') OR Request::is('cetak/nilai_sidang/*') OR Request::is('cetak/revisi/*'))
              <p class="font-weight-bold text-center">Ketua Penguji Sidang</p>
              @elseif(Request::is('cetak/form_nilai_penguji/*/*/1'))
              <p class="font-weight-bold text-center">Dosen Penguji 1</p>
              @elseif(Request::is('cetak/form_nilai_penguji/*/*/2'))
              <p class="font-weight-bold text-center">Dosen Penguji 2</p>
              @elseif(Request::is('cetak/form_nilai_pembimbing/*/*/1'))
              <p class="font-weight-bold text-center">Dosen Pembimbing 1</p>
              @elseif(Request::is('cetak/form_nilai_pembimbing/*/*/2'))
              <p class="font-weight-bold text-center">Dosen Pembimbing 2</p>
              @endif
            </td>
          </tr>
          <tr>
            <td class="text-center">
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document)); !!}
            </td>
          </tr>
          <tr>
            <td>
              @if(Request::is('cetak/berita_acara/*') OR Request::is('cetak/nilai_sidang/*') OR Request::is('cetak/revisi/*'))
              <p class="text-center">{{ $schedule->detailpenguji1->user->nama }}</p>
              @elseif(Request::is('cetak/form_nilai_penguji/*') OR Request::is('cetak/form_nilai_pembimbing/*'))
              <p class="text-center">{{ $lecturer->user->nama }}</p>
              @endif
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

</body>
<!-- jQuery 3.1.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
 


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<script>
  function demoFromHTML() {
      var pdf = new jsPDF('p', 'pt', 'letter');
      // source can be HTML-formatted string, or a reference
      // to an actual DOM element from which the text will be scraped.
      source = $('#content')[0];

      // we support special element handlers. Register them with jQuery-style 
      // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
      // There is no support for any other type of selectors 
      // (class, of compound) at this time.
      specialElementHandlers = {
          // element with id of "bypass" - jQuery style selector
          '#bypassme': function (element, renderer) {
              // true = "handled elsewhere, bypass text extraction"
              return true
          }
      };
      margins = {
          top: 80,
          bottom: 60,
          left: 40,
          width: 522
      };
      // all coords and widths are in jsPDF instance's declared units
      // 'inches' in this case
      pdf.fromHTML(
          source, // HTML string or DOM elem ref.
          margins.left, // x coord
          margins.top, { // y coord
              'width': margins.width, // max width of content on PDF
              'elementHandlers': specialElementHandlers
          },

          function (dispose) {
              // dispose: object with X, Y of the last line add to the PDF 
              //          this allow the insertion of new lines after html
              pdf.save('Test.pdf');
          }, margins
      );
  }
</script>