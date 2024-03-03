<!-- Serial Number Field -->
<div class="form-group">
    {!! Form::label('serial_number', 'Serial Number:') !!}
    <p>{{ $verifyDocument->serial_number }}</p>
</div>

<!-- Perihal Field -->
<div class="form-group">
    {!! Form::label('perihal', 'Perihal:') !!}
    <p>{{ $verifyDocument->perihal }}</p>
</div>

<!-- Nim Field -->
<div class="form-group">
    {!! Form::label('nim', 'Nim:') !!}
    <p>{{ $verifyDocument->nim }}</p>
</div>

<!-- Created By Field -->
<div class="form-group">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $verifyDocument->created_by }}</p>
</div>

