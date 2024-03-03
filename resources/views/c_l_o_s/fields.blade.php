<!-- Code Field -->

<div class="form-group col-sm-12">
    {!! Form::label('study_program_id', 'Program Studi:') !!}
    {!! Form::select('study_program_id', $studyPrograms, null, ['class' => 'select2 form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('period_id', 'Period Sidang:') !!}
    {!! Form::select('period_id', $period, null, ['class' => 'select2 form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('code', 'Code / Nama CLO:') !!}
    {!! Form::text('code', null, ['class' => 'form-control','placeholder' => 'Ex: CLO1']) !!}
</div>

<!-- Precentage Field -->
<div class="form-group col-sm-12">
    {!! Form::label('precentage', 'Precentage (%):') !!}
    {!! Form::number('precentage', null, ['class' => 'form-control','placeholder' => 'Ex: 50', 'step'=>'.01']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => 'Ex: Mampu menemukan GAP antara kebutuhan/permasalahan dengan kondisi eksisting organisasi/perusahaan']) !!}
</div>

<!-- rubrikasi Field -->
<div class="form-group col-sm-12">
    {!! Form::label('textarea', 'Rubrikasi:') !!}
    @if($cLO == null)
    {!! Form::textarea('rubrikasi', null, ['class' => 'form-control','placeholder' => 'Ex:
    1. GAP antara kebutuhan/permasalahan dengan kondisi eksisting tidak terdefinisikan dengan baik
    2. GAP antara kebutuhan/permasalahan dengan kondisi eksisting terdefinisikan dengan baik']) !!}
    @else
    {!! Form::textarea('rubrikasi', $cLO->components[0]->unsur_penilaian, ['class' => 'form-control','placeholder' => 'Ex:
    1. GAP antara kebutuhan/permasalahan dengan kondisi eksisting tidak terdefinisikan dengan baik
    2. GAP antara kebutuhan/permasalahan dengan kondisi eksisting terdefinisikan dengan baik']) !!}
    @endif
</div>

<!-- Pembimbing and penguji Field -->
<div class="form-group col-sm-12">
    @if($cLO == null)
    {!! Form::label('pembimbing', 'Pembimbing:') !!}
    <label class="checkbox-inline pr-3">
        {!! Form::hidden('pembimbing', 0) !!}
        {!! Form::checkbox('pembimbing', '1', null) !!}
    </label>
    {!! Form::label('penguji', 'Penguji:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('penguji', 0) !!}
        {!! Form::checkbox('penguji', '1', null) !!}
    </label>
    @else
    {!! Form::label('pembimbing', 'Pembimbing:') !!}
    <label class="checkbox-inline pr-3">
        {!! Form::hidden('pembimbing', 0) !!}
        {!! Form::checkbox('pembimbing', '1', $cLO->components[0]->pembimbing == 1 ? true : null) !!}
    </label>
    {!! Form::label('penguji', 'Penguji:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('penguji', 0) !!}
        {!! Form::checkbox('penguji', '1', $cLO->components[0]->penguji == 1 ? true : null) !!}
    </label>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('cLOS.index') }}" class="btn btn-secondary">Cancel</a>
</div>
