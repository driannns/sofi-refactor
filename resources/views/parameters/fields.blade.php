<!-- nama Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nama:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    @if($parameter->id == 'periodAcademic')
    {!! Form::select('value', $periodeList, null, ['class' => 'form-control']) !!}
    @else
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('parameters.index') }}" class="btn btn-secondary">Cancel</a>
</div>
