<!-- Sidang Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sidang_id', 'Sidang Id:') !!}
    {!! Form::number('sidang_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Nama Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nama', 'Nama:') !!}
    {!! Form::text('nama', null, ['class' => 'form-control']) !!}
</div>

<!-- Jenis Field -->
<div class="form-group col-sm-6">
    {!! Form::label('jenis', 'Jenis:') !!}
    {!! Form::text('jenis', null, ['class' => 'form-control']) !!}
</div>

<!-- File Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file_url', 'File Url:') !!}
    {!! Form::text('file_url', null, ['class' => 'form-control']) !!}
</div>

<!-- Created By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_by', 'Created By:') !!}
    {!! Form::number('created_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('dokumenLogs.index') }}" class="btn btn-secondary">Cancel</a>
</div>
