<!-- Nip Field -->
<div class="form-group col-sm-12">
    {!! Form::label('nip', 'NIP:') !!}
    <select class="form-control select2" name="user_id">
      @if(Request::is('*edit'))
        <option value="{{ $user->id }}">
          {{ $user->nama }} - {{ $user->lecturers == null ? 'Belum ada NIP' : $user->lecturers->nip  }}
        </option>
      @else
        @foreach($users as $user)
          <option value="{{ $user->id }}">
            {{ $user->nama }} - {{ $user->lecturers == null ? 'Belum ada NIP' : $user->lecturers->nip  }}
          </option>
        @endforeach
      @endif
    </select>
</div>

<!-- role Field -->
<div class="form-group col-sm-12">
    {!! Form::label('code', 'Role:') !!}
    <select class="form-control select2" name="role">
      @foreach($roles as $role)
        @if(Request::is('*edit'))
          <option value="{{ $role->id }}"
            {{ $lecturer->user->roles[0]->id == $role->id ? 'selected' : '' }}>
            {{ ucwords($role->nama) }}
          </option>
        @else
          <option value="{{ $role->id }}">
            {{ ucwords($role->nama) }}
          </option>
        @endif
      @endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Batal</a>
</div>
