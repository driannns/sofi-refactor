<!-- Period Id Field -->
<div class="form-group">
    {!! Form::label('period_id', 'Period Id:') !!}
    <p>{{ $scorePortion->period_id }}</p>
</div>

<!-- Study Program Id Field -->
<div class="form-group">
    {!! Form::label('study_program_id', 'Study Program Id:') !!}
    <p>{{ $scorePortion->study_program_id }}</p>
</div>

<!-- Pembimbing Field -->
<div class="form-group">
    {!! Form::label('pembimbing', 'Pembimbing:') !!}
    <p>{{ $scorePortion->pembimbing }}</p>
</div>

<!-- Penguji Field -->
<div class="form-group">
    {!! Form::label('penguji', 'Penguji:') !!}
    <p>{{ $scorePortion->penguji }}</p>
</div>

