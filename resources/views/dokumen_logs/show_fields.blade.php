<!-- Sidang Id Field -->
<div class="form-group">
    {!! Form::label('sidang_id', 'Sidang Id:') !!}
    <p>{{ $dokumenLog->sidang_id }}</p>
</div>

<!-- Nama Field -->
<div class="form-group">
    {!! Form::label('nama', 'Nama:') !!}
    <p>{{ $dokumenLog->nama }}</p>
</div>

<!-- Jenis Field -->
<div class="form-group">
    {!! Form::label('jenis', 'Jenis:') !!}
    <p>{{ $dokumenLog->jenis }}</p>
</div>

<!-- File Url Field -->
<div class="form-group">
    {!! Form::label('file_url', 'File Url:') !!}
    <p>{{ $dokumenLog->file_url }}</p>
</div>

<!-- Created By Field -->
<div class="form-group">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $dokumenLog->created_by }}</p>
</div>

