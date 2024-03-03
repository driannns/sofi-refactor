<div class="row">
  <div class="col-sm-12">
    <div class="table-responsive-sm m-5">
      <table class="table table-bordered table-sm">
        <tr>
          <td rowspan="5" style="width:120px">
            <img src="{{ asset('images/telkom.png') }}" alt="" height="120px" width="120px">
          </td>
        </tr>
        <tr>
          @if ($isPrint)
          <td class="text-center font-weight-bold">Universitas Telkom</td>
          @else
          <td class="text-center font-weight-bold">Universitas Telkom 1</td>
          @endif
          <td>No.Formulir</td>
          <td>TEL_U-AK-FRI-PSI-FM-004/006</td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">Jl. Telekomunikasi No. 1 Ters. Buah Batu Bandung 40257</td>
          <td>Revisi</td>
          <td>00</td>
        </tr>
        <tr>
          <td rowspan="2" class="text-center font-weight-bold" style="vertical-align : middle;text-align:center;">
            @if($print == 'berita_acara')
            LEMBAR BERITA ACARA TUGAS AKHIR
            @elseif($print == 'nilai_sidang')
            LEMBAR PENILAIAN SIDANG TUGAS AKHIR
            @elseif($print == 'form_nilai_penguji')
            FORMULIR PENILAIAN PENGUJI SIDANG TUGAS AKHIR
            @elseif($print == 'form_nilai_pembimbing')
            FORMULIR PENILAIAN PEMBIMBING SIDANG TUGAS AKHIR
            @elseif($print == 'daftar_hadir')
            LEMBAR DAFTAR HADIR SIDANG TA
            @elseif($print == 'revisi')
            LEMBAR PERBAIKAN SIDANG TUGAS AKHIR
            @endif
          </td>
          <td>Berlaku Efektif</td>
          <td>14 Oktober 2010</td>
        </tr>
        <tr>
          <td>Hal.</td>
          <td>1 dari 1</td>
        </tr>
      </table>
    </div>
  </div>
</div>
