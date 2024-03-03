<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Tak Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tak', 'Tak:') !!}
    {!! Form::text('tak', null, ['class' => 'form-control']) !!}
</div>

<!-- Eprt Field -->
<div class="form-group col-sm-6">
    {!! Form::label('eprt', 'Eprt:') !!}
    {!! Form::text('eprt', null, ['class' => 'form-control']) !!}
</div>

<!-- Studentscol Field -->
<div class="form-group col-sm-6">
    {!! Form::label('studentscol', 'Studentscol:') !!}
    {!! Form::text('studentscol', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', 'Team Id:') !!}
    {!! Form::number('team_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
</div>
