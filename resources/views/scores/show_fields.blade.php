<!-- Value Field -->
<div class="form-group">
    {!! Form::label('value', 'Value:') !!}
    <p>{{ $score->value }}</p>
</div>

<!-- Percentage Field -->
<div class="form-group">
    {!! Form::label('percentage', 'Percentage:') !!}
    <p>{{ $score->percentage }}</p>
</div>

<!-- Component Id Field -->
<div class="form-group">
    {!! Form::label('component_id', 'Component Id:') !!}
    <p>{{ $score->component_id }}</p>
</div>

<!-- Jadwal Id Field -->
<div class="form-group">
    {!! Form::label('jadwal_id', 'Jadwal Id:') !!}
    <p>{{ $score->jadwal_id }}</p>
</div>

