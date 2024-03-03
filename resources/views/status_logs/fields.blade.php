<!-- Feedback Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('feedback', 'Feedback:') !!}
    {!! Form::textarea('feedback', null, ['class' => 'form-control']) !!}
</div>

<!-- Created By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_by', 'Created By:') !!}
    {!! Form::number('created_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Sidangs Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sidangs_id', 'Sidangs Id:') !!}
    {!! Form::number('sidangs_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Workflow Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('workflow_type', 'Workflow Type:') !!}
    {!! Form::text('workflow_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('statusLogs.index') }}" class="btn btn-secondary">Cancel</a>
</div>
