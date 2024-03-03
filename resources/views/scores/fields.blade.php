@php
$role = request()->segment(count(request()->segments())-1);
@endphp
<!-- role -->
<input type="text" name="role" value="{{ request()->segment(count(request()->segments())-1) }}" hidden>
<!-- jadwal id -->
<input type="text" name="jadwal_id" value="{{ request()->segment(count(request()->segments())) }}" hidden>

<!-- interval -->
{{-- <p>Anda sedang memberi nilai kepada : <span class="font-weight-bold">{{ $schedule->sidang->mahasiswa->user->nama }} - {{ $schedule->sidang->mahasiswa->nim }}</span></p> --}}


<div class="form-group row">
  <label class="col-sm-2 col-form-label font-weight-bold">NAMA LENGKAP</label>
  <div class="col-sm-10">
    <span> : {{ $schedule->sidang->mahasiswa->user->nama }} /
      {{ $schedule->sidang->mahasiswa->nim }}</span>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label font-weight-bold">JUDUL TUGAS AKHIR</label>
  <div class="col-sm-6">
    <span> : {{ $schedule->sidang->judul}}</span>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label font-weight-bold">JENIS SIDANG</label>
  <div class="col-sm-10">
    <span> :
      {{Str::contains($schedule->sidang->mahasiswa->team->name,'Individu') ? 'INDIVIDU' : 'KELOMPOK'}}</span>
  </div>
</div>

<div class="table-responsive-lg" style="overflow-x: scroll">
  <span class="btn btn-outline-primary float-right mb-2" data-toggle="modal" data-target="#nilaidosen">Informasi Nilai</span>

  {{-- MODAL NILAI DOSEN  --}}
  <div class="modal fade" id="nilaidosen">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">INFORMASI NILAI</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Dosen</th>
                <th>Status Nilai</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- diubah -->
                <td><b> PENGUJI 1</b> <br> ({{$penguji1->code}} - {{$penguji1->user->nama}})</td>
                <td>@if($npenguji1 > 0 )
                  <span class="badge badge-success">Sudah Mengisi Nilai</span>
                  @else
                  <span class="badge badge-secondary">Belum Mengisi Nilai</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td><b> PENGUJI 2</b> <br> ({{$penguji2->code}} - {{$penguji2->user->nama}})</td>
                <td>
                  @if($npenguji2 > 0 )
                  <span class="badge badge-success">Sudah Mengisi Nilai</span>
                  @else
                  <span class="badge badge-secondary">Belum Mengisi Nilai</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td><b> PEMBIMBING 1</b> <br> ({{$pembimbing1->code}} - {{$pembimbing1->user->nama}})</td>
                <td>
                  @if($npembimbing1 > 0 )
                  <span class="badge badge-success">Sudah Mengisi Nilai</span>
                  @else
                  <span class="badge badge-secondary">Belum Mengisi Nilai</span>
                  @endif

                </td>
              </tr>
              <tr>
                <td><b> PEMBIMBING 2</b> <br> ({{$pembimbing2->code}} - {{$pembimbing2->user->nama}})</td>
                <td>
                  @if($npembimbing2 > 0 )
                  <span class="badge badge-success">Sudah Mengisi Nilai</span>
                  @else
                  <span class="badge badge-secondary">Belum Mengisi Nilai</span>
                  @endif
                </td>
              </tr>
              <!-- akhir -->
            </tbody>
          </table>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button data-dismiss="modal" class="btn btn-secondary">Kembali</button>
        </div>
      </div>
    </div>
  </div>



  <table class="table table-bordered">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">CLO</th>
        <th>Deskripsi CLO</th>
        <th>Unsur Penilaian / Rubrikasi</th>
        <th class="text-center">Bobot</th>
        <th style="width:100px !important">Interval</th>
      </tr>
    </thead>
    <tbody>
      @foreach($clos as $clo)
      @if(($clo->components[0]->penguji == 1 AND $role == 'penguji') OR ($clo->components[0]->pembimbing == 1 AND $role == 'pembimbing') )
      <tr>
        <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
        <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
        <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
      </tr>
      @foreach($clo->components as $component)
      @if($scores != null)
      @foreach($scores as $score)
      @if($score->component_id == $component->id)
      @php
      $value = $score->value;
      @endphp
      @endif
      @endforeach
      @endif
      @if($role == 'penguji')
      @if($component->penguji == 1)
      <tr>
        <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
        <td>{{ $clo->precentage }}%</td>
        <td>
          <input type="text" name="component_id[]" value="{{ $component->id }}" hidden>
          <input type="number" name="percentage[]" value="{{ $clo->precentage }}" hidden>
          <select class="form-control" name="value[]">
            {{-- <option readonly>--Piihan Keputusan Sidang---</option> --}}
            @if($scores != null)
            @foreach($component->intervals->sortBy('value') as $interval)
            <option value="{{ $interval->ekuivalensi }}" {{ $value == $interval->ekuivalensi ? 'selected' : "" }}>{{ $interval->value }}</option>
            @endforeach
            @else
            @foreach($component->intervals->sortBy('value') as $interval)
            <option value="{{ $interval->ekuivalensi }}">{{ $interval->value }}</option>
            @endforeach
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
          <input type="text" name="component_id[]" value="{{ $component->id }}" hidden>
          <input type="number" name="percentage[]" value="{{ $clo->precentage }}" hidden>
          <select class="form-control" name="value[]">
            {{-- <option readonly selected>--Piihan Keputusan Sidang---</option> --}}
            @if($scores != null)
            @foreach($component->intervals->sortBy('value') as $interval)
            <option value="{{ $interval->ekuivalensi }}" {{ $value == $interval->ekuivalensi ? 'selected' : "" }}>{{ $interval->value }}</option>
            @endforeach
            @else
            @foreach($component->intervals->sortBy('value') as $interval)
            <option value="{{ $interval->ekuivalensi }}">{{ $interval->value }}</option>
            @endforeach
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

@if($scores != null)
<div class="form-group col-sm-12 mt-3">
  <p>Nilai yang anda beri sebesar : <span class="font-weight-bold" id="final-score">{{ $currentScore }}, {{$grade}}</span></p>
</div>
@else
<div class="form-group col-sm-12 mt-3">
  <p>Nilai yang anda beri sebesar : <span class="font-weight-bold" id="final-score">0</span></p>
</div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12 mt-3">
  @if($schedule->sidang->status == "lulus")
  {!! Form::submit('Simpan', ['class' => 'btn btn-primary btn-submit', 'disabled', 'id'=>"setuju-confirm"]) !!}
  @elseif($schedule->status == "sedang dilaksanakan" OR
  $schedule->flag_change_scores OR
  Auth()->user()->isSuperadmin() OR Carbon\Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +7 ) >= now())
  {{-- <button href="{{ route('scores.store') }}" class="btn btn-success btn-submit" id="setuju-confirm">Approve</button> --}}

  {{-- {!! Form::submit('Simpan', ['class' => 'btn btn-primary ','onClick' => 'return confirm("apakah anda yakin ? pastikan nilai anda sudah benar dan kami tidak menyarankan ada nilai 0 lebih dari 5 komponen")']) !!}  --}}
  {!! Form::submit('Simpan', ['class' => 'btn btn-primary btn-submit', 'id'=>"setuju-confirm"]) !!}
  @else
  {!! Form::submit('Simpan', ['class' => 'btn btn-primary btn-submit', 'disabled', 'id'=>"setuju-confirm"]) !!}

  {{-- {!! Form::submit('Simpan', ['class' => 'btn btn-primary','disabled','onClick' => 'return confirm("apakah anda yakin ? pastikan nilai anda sudah benar dan kami tidak menyarankan ada nilai 0 lebih dari 5 komponen")']) !!}  --}}
  @endif

  @if($role == "penguji")
  <a href="{{ route('schedule.penguji') }}" class="btn btn-secondary">Batal</a>
  @else
  <a href="{{ route('schedule.pembimbing') }}" class="btn btn-secondary">Batal</a>
  @endif
</div>
<!-- diubah -->
@push('scripts')
<script type="text/javascript">
  $("select[name='value[]']").change(function() {
    var output = document.getElementById("final-score")
    output.textContent = getScore()
  })

  function getScore() {
    var percentage = $("input[name='percentage[]']").map(function() {
      return $(this).val();
    }).get().map(Number);
    var ekuivalensi = $("select[name='value[]']").map(function() {
      return $(this).val();
    }).get().map(Number);
    var nilai = 0
    var totalPercentage = 0


    for (i = 0; i < percentage.length; i++) {
      nilai = nilai + (percentage[i] * ekuivalensi[i])
      totalPercentage = totalPercentage + percentage[i]
    }

    if (totalPercentage != 0) {
      nilai = nilai / totalPercentage
    } else {
      nilai = 0
    }

    if (nilai <= 40) {
      grade = '(E)'
    } else if (nilai > 40 && nilai <= 50) {
      grade = '(D)'
    } else if (nilai > 50 && nilai <= 60) {
      grade = '(C)'
    } else if (nilai > 60 && nilai <= 65) {
      grade = '(BC)'
    } else if (nilai > 65 && nilai <= 70) {
      grade = '(B)'
    } else if (nilai > 70 && nilai <= 80) {
      grade = '(AB)'
    } else if (nilai > 80) {
      grade = '(A)'
    } else {
      grade = '(A)'
    }
    return [nilai, grade]
  }
</script>
<!-- akhir -->
@endpush()

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">
<script>
  $('.btn-submit').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Pastikan nilai anda sudah benar dan kami tidak menyarankan ada nilai 0 lebih dari 5 komponen.",

      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#FF585E',
      confirmButtonColor: '#00A8DC',
      cancelButtonText: 'Batal',
      confirmButtonText: 'Simpan',
      reverseButtons: true

    }).then((res) => {
      if (res.value) {
        console.log('confirmed');
        form.submit();
      } else if (res.dismiss == 'cancel') {
        console.log('cancel');
        return false;
      } else if (res.dismiss == 'esc') {
        console.log('cancle-esc**strong text**');
        return false;

      }
    });
  });
</script>

@endpush
