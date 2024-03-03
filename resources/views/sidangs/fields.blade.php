<!-- credit field -->
@if(Request::is('sidangs/create'))
<input type="text" name="credit_complete" value="{{ $sks_lulus }}" hidden>
<input type="text" name="credit_uncomplete" value="{{ $sks_belum_lulus }}" hidden>
@endif

<!-- Period Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('period_id', 'Period Sidang:') !!}
    @if(!Auth::user()->isSuperadmin())
    {!! Form::select('period_id', $allPeriod, null, ['class' => 'select2 form-control']) !!}
    @else
    {!! Form::select('period_id', $allPeriod, null, ['class' => 'select2 form-control','disabled']) !!}
    {!! Form::hidden('period_id', $sidang->period_id) !!}
    @endif
</div>

<!-- Mahasiswa Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('mahasiswa_id', 'NIM Mahasiswa:') !!}
    {!! Form::number('mahasiswa_id', $userInfo->nim, ['class' => 'form-control','disabled' => 'disabled']) !!}
    {!! Form::hidden('mahasiswa_id', $userInfo->nim) !!}
</div>

<!-- Pembimbing1 Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('pembimbing1_id', 'Kode Dosen Pembimbing 1:') !!}
    <select class="form-control select2" name="pembimbing1_id">
      <option value="">Pilih Pembimbing 1</option>
      @foreach($lecturers as $lecturer)
        @if($sidang == null)
        <option value="{{ $lecturer->id }}"
          {{ $lecturer->id == old('pembimbing1_id') ? 'selected' : '' }}>
            {{ $lecturer->code }} - {{ $lecturer->user->nama }}
        </option>
        @else
        <option value="{{ $lecturer->id }}"
          {{ $lecturer->id == $sidang->pembimbing1_id ? 'selected' : '' }}>
            {{ $lecturer->code }} - {{ $lecturer->user->nama }}
        </option>
        @endif
      @endforeach
    </select>
</div>

<!-- Pembimbing2 Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('pembimbing2_id', 'Kode Dosen Pembimbing 2:') !!}
    <select class="form-control select2" name="pembimbing2_id">
      <option value="">Pilih Pembimbing 2</option>
      @foreach($lecturers as $lecturer)
        @if($sidang == null)
        <option value="{{ $lecturer->id }}"
          {{ $lecturer->id == old('pembimbing2_id') ? 'selected' : '' }}>
            {{ $lecturer->code }} - {{ $lecturer->user->nama }}
        </option>
        @else
        <option value="{{ $lecturer->id }}"
          {{ $lecturer->id == $sidang->pembimbing2_id ? 'selected' : '' }}>
            {{ $lecturer->code }} - {{ $lecturer->user->nama }}
        </option>
        @endif
      @endforeach
    </select>
</div>

<!-- Judul Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('judul', 'Judul Tugas Akhir:') !!}
    {!! Form::textarea('judul', null, ['class' => 'form-control', 'rows' => 4, 'cols' => 2]) !!}
</div>

<!-- Form Bimbingan Field -->
<div class="form-group col-sm-12">
    {!! Form::label('form_bimbingan', 'Jumlah Bimbingan:') !!}
    {!! Form::text('form_bimbingan1', 'Pembimbing 1: '.$bimbingan1, ['class' => 'form-control','disabled']) !!}
    {!! Form::text('form_bimbingan2', 'Pembimbing 2: '.$bimbingan2, ['class' => 'form-control','disabled']) !!}
    {!! Form::hidden('form_bimbingan', $bimbingan1.";".$bimbingan2) !!}
</div>

<!-- Status Form Field -->
@if(Request::is('sidangs/create'))
<div class="form-group col-sm-12">
    {!! Form::label('lecturer_status', 'Status Igracias:') !!}
    {!! Form::text('lecturer_status', ($lecturer_status == "APPROVED" ? $lecturer_status : "BELUM APPROVED"), ['class' => 'form-control','readonly']) !!}
</div>
@endif

<!-- KK Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('kk', 'Kelompok Keahlian:') !!}
    {!! Form::text('form_bimbingan1', $userInfo->kk, ['class' => 'form-control','disabled']) !!}
</div>

<!-- peminatansns Field -->
<div class="form-group col-sm-12">
    {!! Form::label('peminatans', 'Peminatan:') !!}
    <select class="form-control select2" name="peminatan">
      <option value="">Pilih Peminatan</option>
      @if($peminatans != null)
      @foreach($peminatans as $peminatan)
        @if($sidang == null)
        <option value="{{ $peminatan->id }}"
          {{ $peminatan->id == old('$peminatan') ? 'selected' : '' }}>
            {{ $peminatan->nama }}
        </option>
        @else
        <option value="{{ $peminatan->id }}"
          {{ $peminatan->id == $userInfo->peminatan_id ? 'selected' : '' }}>
            {{ $peminatan->nama }}
        </option>
        @endif
      @endforeach
      @endif
    </select>
</div>

<!-- Eprt Field -->
<div class="form-group col-sm-12">
    {!! Form::label('eprt', 'EPRT:') !!}
    {!! Form::text('eprt', $userInfo->eprt, ['class' => 'form-control','disabled']) !!}
    {!! Form::hidden('eprt', $userInfo->eprt) !!}
</div>

<!-- Tak Field -->
<div class="form-group col-sm-12">
    {!! Form::label('tak', 'TAK:') !!}
    {!! Form::text('tak', $userInfo->tak, ['class' => 'form-control','disabled']) !!}
    {!! Form::hidden('tak', $userInfo->tak) !!}
</div>

@if(!Auth::user()->isSuperadmin())
<!-- Dokumen Ta Field -->
<div class="form-group col-sm-12">
    {!! Form::label('dokumen_ta', 'Draft Dokumen TA:') !!}
    @if($sidang)
      @if($sidang->dokumen_ta)
      <p>
        <a href="/{{$dokumen_ta->file_url}}" class="btn btn-primary" download>Download</a>
      </p>
      @else
      <p>
        <a href="#" target="_blank" class='btn btn-primary disabled'>
            Data tidak ditemukan
        </a>
      </p>
      @endif
    @endif
    {!! Form::file('dokumen_ta', null, ['class' => 'form-control']) !!}
</div>

<!-- Makalah Field -->
<div class="form-group col-sm-12">
    {!! Form::label('makalah', 'Jurnal:') !!}
    @if($sidang)
      @if($sidang->makalah)
      <p>
        <a href="/{{$makalah->file_url}}" class="btn btn-primary" download>Download</a>
      </p>
      @else
      <p>
        <a href="#" target="_blank" class='btn btn-primary disabled'>
            Data tidak ditemukan
        </a>
      </p>
      @endif
    @endif
    {!! Form::file('makalah', null, ['class' => 'form-control']) !!}
</div>
@else
<!-- Bahasa Field -->
<div class="form-group col-sm-12">
    {!! Form::label('is_english', 'Bahasa:') !!}
    {!! Form::select('is_english', $languages, null, ['class' => 'select2 form-control']) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', $status_list, null, ['class' => 'select2 form-control']) !!}
</div>

<!-- Komentar Field -->
<div class="form-group col-sm-12" id='field_komentar' style="display:none;">
    {!! Form::label('komentar', 'Komentar:') !!}
    {!! Form::textarea('komentar', null, ['class' => 'form-control']) !!}
</div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
  <a href="javascript:attend2()" class="btn btn-primary" >Simpan</a>
    <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
</div>


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.16.6/sweetalert2.min.css">
<script>
    function attend2(link) {
        console.log(link)
        Swal.fire({
            title: 'Pastikan semua data anda benar.',
            text: 'Apakah anda yakin akan menyimpan data?',
            icon: 'info',
            showCancelButton: true,
            cancelButtonColor: '#f86c6b',
            confirmButtonColor: '#43afd6',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Simpan',
            reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("frm1").submit();
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
        });
        }
</script>

@endpush



