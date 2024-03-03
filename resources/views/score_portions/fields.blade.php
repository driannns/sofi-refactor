<!-- Period Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period_id', 'Period Sidang:') !!}
    {!! Form::select('period_id', $period, null, ['class' => 'select2 form-control']) !!}
</div>

<!-- Study Program Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('study_program_id', 'Program Studi:Program Studi:') !!}
    {!! Form::select('study_program_id', $studyPrograms, null, ['class' => 'select2 form-control']) !!}
</div>

<!-- Pembimbing Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pembimbing', 'Pembimbing:') !!}
    {!! Form::number('pembimbing', null, ['class' => 'form-control','placeholder' => 'Ex: 50.01', 'step'=>'.01']) !!}
</div>

<!-- Penguji Field -->
<div class="form-group col-sm-6">
    {!! Form::label('penguji', 'Penguji:') !!}
    {!! Form::number('penguji', null, ['class' => 'form-control','placeholder' => 'Ex: 50.01', 'step'=>'.01']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('scorePortions.index') }}" class="btn btn-secondary">Cancel</a>
</div>
