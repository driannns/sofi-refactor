{{-- <div class="row">
  <div class="col-md-12 my-3 text-center">
    <h1>Rekap Nilai Sidang Tugas Akhir</h1>
  </div>
</div>

@foreach($penilai as $pen)
<!-- interval -->
<div class="row">
  <div class="col-md-12 mb-3">
<p>Nama Dosen : {{ $pen['lecturer']->user->nama }} - {{ $pen['lecturer']->code }}</p>
<div class="table-responsive-lg font-weight-normal" style="overflow-x: scroll; height: 400px;">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">CLO</th>
        <th>Deskripsi CLO</th>
        <th>Unsur Penilaian / Rubrikasi</th>
        <th class="text-center">Bobot</th>
        <th style="width:200px !important">Interval</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pen['clos'] as $clo)
      @if(($clo->components[0]->penguji == 1 AND $pen['role'] == 'penguji') OR ($clo->components[0]->pembimbing == 1 AND $pen['role'] == 'pembimbing') )
      <tr>
        <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
        <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
        <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
      </tr>
      @foreach($clo->components as $component)
        @php
          $value = null;
        @endphp
        @if($pen['scores'] != null)
          @foreach($pen['scores'] as $score)
            @if($score->component_id == $component->id)
              @php
                $value = $score->value;
              @endphp
            @endif
          @endforeach
        @endif
        @if($pen['role'] == 'penguji')
          @if($component->penguji == 1)
          <tr>
            <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
            <td>{{ $clo->precentage }}%</td>
            <td>
              <select class="form-control" name="value[]" disabled>
                @if($pen['scores'] != null AND $value != null)
                  @foreach($component->intervals->sortBy('value') as $interval)
                  <option value="" {{ $value == $interval->ekuivalensi ? 'selected' : "" }}>{{ $interval->value }}</option>
                  @endforeach
                @else
                  <option value="">Belum Mengisi</option>
                @endif
              </select>
            </tr>
            @endif
        @else
            @if($component->pembimbing == 1)
            <tr>
              <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
              <td>{{ $clo->precentage }}%</td>
              <td>
                <select class="form-control" name="value[]" disabled>
                  @if($pen['scores'] != null AND $value != null)
                    @foreach($component->intervals->sortBy('value') as $interval)
                    <option value="">{{ $interval->value }}</option>
                    @endforeach
                  @else
                    <option value="">Belum Mengisi</option>
                  @endif
                </select>
              </tr>
              @endif
          @endif
          @endforeach
          @endif
          @endforeach
        </tbody>
      </table>
    </div>
    @if($pen['scores'] != null)
    <div class="form-group col-sm-12 mt-3">
      <p>Nilai yang {{ $pen['lecturer']->code }} beri sebesar : <span class="font-weight-bold">{{ $pen['currentScore'] }}</span></p>
    </div>
    @endif
    <hr>
  </div>
</div>
@endforeach

<!-- nilai yang diberikan dosen -->
<div class="row">
  <div class="col-md-12 my-3 text-center">
    <h1>Nilai Sidang Tugas Akhir</h1>
  </div>
</div>
<div class="row">
  <div class="col-md-12 mb-5">
    <div class="table-responsive-lg" style="background:white;">
      <table class="table table-bordered">
        <tr style="background-color:#20a8d8!important; color:white">
          <th>Nama Dosen</th>
          <th>Kode</th>
          <th>Sebagai</th>
          <th>Nilai</th>
        </tr>
        @foreach($penilai as $pen)
        <tr>
          <td colspan="">{{ $pen['lecturer']->user->nama }}</td>
          <td colspan="">{{ $pen['lecturer']->code }}</td>
          <td colspan="">{{ ucfirst($pen['role']) }}</td>
          <td colspan="">{{ $pen['currentScore'] }}</td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>--}}

{{-- <div class="row">
  <div class="col-md-12 m-3 text-center">
    <h1>Total Nilai Sidang Tugas Akhir</h1>
  </div>
</div> --}}

<!-- nilai akhir -->
<div class="table-responsive-lg">
  <table class="table table-bordered text-center">
    <tr>
      <th rowspan="4" class="h3 bg-secondary" style="border: 1px solid #acb0b3"><br> Penilai <br> Sidang <br> Tugas Akhir</th>
      <th colspan="2" class="h5 bg-secondary" style="border: 1px solid #acb0b3">Kriteria Penilaian</th>
      <th colspan="2" class="h5 bg-secondary" style="border: 1px solid #acb0b3">Unsur Penilaian</th>
      <th rowspan="" class="h5 bg-secondary" style="border: 1px solid #acb0b3">Nilai</th>
      <th rowspan="" class="h5 bg-secondary" style="border: 1px solid #acb0b3">Indeks</th>
    </tr>
    <tr>
      <td><b> PB 1</b></td>
      <td><b> PB 2</b></td>
      <td><b> P 1</b></td>
      <td><b> P 2</b></td>
      <td rowspan="3">{{ $nilaiTotal }}</td>
      <td rowspan="3">{{ $indeks }}</td>
    </tr>
    <tr>
      <td colspan="">{{ $nilaiPembimbing1 }}</td>
      <td colspan="">{{ $nilaiPembimbing2 }}</td>
      <td colspan="">{{ $nilaiPenguji1 }}</td>
      <td colspan="">{{ $nilaiPenguji2 }}</td>
    </tr>
    <tr>
      <td colspan="2">{{$porsi_nilai? $porsi_nilai->pembimbing:'60'}}% x (PB1 + PB2)/2</td>
      <td colspan="2">{{$porsi_nilai? $porsi_nilai->pembimbing:'40'}}% x (P1 + P2)/2</td>
    </tr>
  </table>
</div>

<!-- putusan -->
@if( !auth()->user()->isAdmin() || (auth()->user()->isAdmin() && auth()->user()->isPenguji()) || auth()->user()->isSuperadmin() )
<form class="form" action="{{ route('scores.simpulan.proses', [$schedule->id]) }}" method="post">
  @csrf
  <div class="form-group col-sm-6">
    <h5>Putusan Sidang:</h5>
    <select class="form-control" id='putusan' name="putusan"
    {{ ($nilaiPenguji1 == 0 OR
    $nilaiPenguji2 == 0 OR
    $nilaiPembimbing1 == 0 OR
    $nilaiPembimbing2 == 0) ? 'disabled' : ''}}>
      <option value="0">--Pilihan Keputusan Sidang--</option>
      <option value="lulus" {{ $schedule->keputusan == "lulus" ? 'selected' : '' }}>Lulus</option>
      <option value="lulus bersyarat" {{ $schedule->keputusan == "lulus bersyarat" ? 'selected' : '' }}>Lulus Bersyarat</option>
      <option value="tidak lulus" {{ $schedule->keputusan == "tidak lulus" ? 'selected' : '' }}>Tidak Lulus</option>
    </select>
  </div>
  <div class="form-group col-sm-6" id='pilihan_durasi'>
    <label for="durasi_revisi">Durasi Revisi</label>
    <select class="form-control" name="durasi_revisi"
    {{ ($nilaiPenguji1 == 0 OR
    $nilaiPenguji2 == 0 OR
    $nilaiPembimbing1 == 0 OR
    $nilaiPembimbing2 == 0) ? 'disabled' : ''}}>
      <option value="7" {{ $schedule->durasi_revisi == 7 ? 'selected' : '' }}>1 Minggu</option>
      <option value="14" {{ $schedule->durasi_revisi == 14 ? 'selected' : '' }}>2 Minggu</option>
    </select>
  </div>

  <!-- Submit Field -->
  <div class="form-group col-sm-12 mt-3">
    <button type="submit" name="button" class="btn btn-primary form"
    {{ ($nilaiPenguji1 == 0 OR
    $nilaiPenguji2 == 0 OR
    $nilaiPembimbing1 == 0 OR
    $nilaiPembimbing2 == 0) ? 'disabled' : ''}}>
      Simpan
    </button>
    <a href="{{ route('schedule.penguji') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endif

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">
<script type="text/javascript">
$(document).ready(function () {
    var elements = $('#pilihan_durasi').hide();
    $('#putusan').on('change', function () {
      console.log('masuk ni');
        var value = $(this).val();

        console.log('Value: '.value);
        if (value == 'lulus bersyarat') { // if somethings' selected
            elements.show(); // show the ones we want
        }else{
            elements.hide(); // hide all the elements
        }
    }) // Setup the initial states
});


$('.form').on('submit', function (e) {
  e.preventDefault();
  var form = this;
  var data = $(this).serialize();
  Swal.fire({
      title: "Apakah Anda Yakin?",
      text: 'Jika sudah disimpan, tidak bisa diubah kembali.',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#f86c6b',
      confirmButtonColor: '#43afd6',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Simpan',
      reverseButtons: true

  })
  .then((res) => {
      if(res.value){
          console.log('confirmed');
          form.submit();
      }else if(res.dismiss == 'cancel'){
          console.log('cancel');
          return false;
      }
      else if(res.dismiss == 'esc'){
          console.log('cancle-esc**strong text**');
          return false;

      }
  });
});
</script>


@endpush
