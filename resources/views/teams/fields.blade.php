<!-- Name Field -->
<div class="form-group">
    {!! Form::text('name', null, ['class' => 'form-control',  'placeholder' => 'Masukan Nama Kelompok']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('teams.index') }}" class="btn btn-secondary">Batal</a>
</div>
