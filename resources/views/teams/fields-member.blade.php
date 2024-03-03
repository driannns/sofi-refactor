<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nim', 'Nim Anggota Tim:') !!}
    <select class="form-control select2" name="nim">
      @foreach($students as $student)
        <option value="{{ $student->nim }}">{{ $student->nim }} - {{ $student->user->nama }}</option>
      @endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Tambah', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('teams.index') }}" class="btn btn-secondary">Batal</a>
</div>
