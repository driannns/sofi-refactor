<!-- Unsur Penilaian Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unsur_penilaian', 'Code CLO:') !!}
    {!! Form::text('unsur_penilaian', $component->clo->code, ['class' => 'form-control', 'readonly' ]) !!}
</div>

<!-- Unsur Penilaian Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unsur_penilaian', 'Code Component:') !!}
    {!! Form::text('unsur_penilaian', $component->code, ['class' => 'form-control', 'readonly']) !!}
    {!! Form::number('component_id', $component->id, ['class' => 'form-control', 'hidden']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Ekuivalensi Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ekuivalensi', 'Ekuivalensi:') !!}
    {!! Form::number('ekuivalensi', null, ['class' => 'form-control']) !!}
</div>

<!-- Unsur Penilaian Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unsur_penilaian', 'Unsur Penilaian:') !!}
    {!! Form::text('unsur_penilaian', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('intervals.index') }}" class="btn btn-secondary">Cancel</a>
</div>
