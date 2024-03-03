<!-- Value Field -->
<div class="form-group">
    {!! Form::label('value', 'Value:') !!}
    <p>{{ $interval->value }}</p>
</div>

<!-- Ekuivalensi Field -->
<div class="form-group">
    {!! Form::label('ekuivalensi', 'Ekuivalensi:') !!}
    <p>{{ $interval->ekuivalensi }}</p>
</div>

<!-- Unsur Penilaian Field -->
<div class="form-group">
    {!! Form::label('unsur_penilaian', 'Unsur Penilaian:') !!}
    <p>{{ $interval->unsur_penilaian }}</p>
</div>

<!-- Component Id Field -->
<div class="form-group">
    {!! Form::label('component_id', 'Component Id:') !!}
    <p>{{ $interval->component_id }}</p>
</div>

