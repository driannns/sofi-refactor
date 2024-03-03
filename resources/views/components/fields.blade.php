<!-- Clo Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('clo_id', 'Code CLO:') !!}
    {!! Form::text('clo_code', $clo->code, ['class' => 'form-control','readonly' => 'true']) !!}
    {!! Form::number('clo_id', $clo->id, ['class' => 'form-control','hidden' => 'true']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Percentage Field -->
<div class="form-group col-sm-6">
    {!! Form::label('percentage', 'Percentage:') !!}
    {!! Form::number('percentage', null, ['class' => 'form-control']) !!}
</div>

<!-- Unsur Penilaian Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('unsur_penilaian', 'Unsur Penilaian:') !!}
    {!! Form::textarea('unsur_penilaian', null, ['class' => 'form-control']) !!}
</div>

<!-- Pembimbing Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pembimbing', 'Pembimbing:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('pembimbing', 0) !!}
        {!! Form::checkbox('pembimbing', '1', null) !!}
    </label>
</div>


<!-- Penguji Field -->
<div class="form-group col-sm-6">
    {!! Form::label('penguji', 'Penguji:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('penguji', 0) !!}
        {!! Form::checkbox('penguji', '1', null) !!}
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('components.index') }}" class="btn btn-secondary">Cancel</a>
</div>
