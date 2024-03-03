<!-- Schedule Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('schedule_id', 'Schedule Id:') !!}
    {!! Form::number('schedule_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Role Sidang Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role_sidang', 'Role Sidang:') !!}
    {!! Form::text('role_sidang', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
</div>
