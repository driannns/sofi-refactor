<!-- Feedback Field -->
<div class="form-group">
    {!! Form::label('feedback', 'Feedback:') !!}
    <p>{{ $statusLog->feedback }}</p>
</div>

<!-- Created By Field -->
<div class="form-group">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $statusLog->created_by }}</p>
</div>

<!-- Sidangs Id Field -->
<div class="form-group">
    {!! Form::label('sidangs_id', 'Sidangs Id:') !!}
    <p>{{ $statusLog->sidangs_id }}</p>
</div>

<!-- Workflow Type Field -->
<div class="form-group">
    {!! Form::label('workflow_type', 'Workflow Type:') !!}
    <p>{{ $statusLog->workflow_type }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $statusLog->name }}</p>
</div>

