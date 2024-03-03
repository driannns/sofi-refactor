@if($print!='daftar_hadir')
<div class="container mb-5">
  <div class="row">
    <div class="col-sm-12" style="padding:0px 200px 0px 200px">
      @if($print =='revisi')
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
          @if($print=='revisi')
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
              @if($print == 'berita_acara' OR $print == 'nilai_sidang' OR $print == 'revisi')
              <p class="font-weight-bold text-center">Ketua Penguji Sidang</p>
              @elseif($print == 'form_nilai_penguji_1')
              <p class="font-weight-bold text-center">Dosen Penguji 1</p>
              @elseif($print == 'form_nilai_penguji_2')
              <p class="font-weight-bold text-center">Dosen Penguji 2</p>
              @elseif($print == 'form_nilai_pembimbing_1')
              <p class="font-weight-bold text-center">Dosen Pembimbing 1</p>
              @elseif($print == 'form_nilai_pembimbing_2')
              <p class="font-weight-bold text-center">Dosen Pembimbing 2</p>
              @endif
            </td>
          </tr>
          <tr>
            <td class="text-center">
              @if($print == 'berita_acara')
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document_berita_acara)); !!}
              @elseif($print == 'nilai_sidang')
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document_nilai_sidang)); !!}
              @elseif($print == 'revisi')
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document_revisi)); !!}
              @elseif($print == 'form_nilai_penguji_1')
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document_form_nilai_penguji_1)); !!}
              @elseif($print == 'form_nilai_penguji_2')
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document_form_nilai_penguji_2)); !!}
              @elseif($print == 'form_nilai_pembimbing_1')
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document_form_nilai_pembimbing_1)); !!}
              @elseif($print == 'form_nilai_pembimbing_2')
              {!! QrCode::size(100)->generate(\Illuminate\Support\Facades\URL::to('/doc_verify/'.$sn_document_form_nilai_pembimbing_2)); !!}
              @endif
            </td>
          </tr>
          <tr>
            <td>
              @if($print == 'berita_acara' OR $print == 'nilai_sidang' OR $print == 'revisi')
              <p class="text-center">{{ $schedule->detailpenguji1->user->nama }}</p>
              @elseif($print == 'form_nilai_penguji_1')
              <p class="text-center">{{ $lecturer_penguji_1->user->nama }}</p>
              @elseif($print == 'form_nilai_penguji_2')
              <p class="text-center">{{ $lecturer_penguji_2->user->nama }}</p>
              @elseif($print == 'form_nilai_pembimbing_1')
              <p class="text-center">{{ $lecturer_pembimbing_1->user->nama }}</p>
              @elseif($print == 'form_nilai_pembimbing_2')
              <p class="text-center">{{ $lecturer_pembimbing_2->user->nama }}</p>
              @endif
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endif
