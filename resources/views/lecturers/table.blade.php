<div class="table-responsive-sm">
  <table class="table table-striped datatable" id="lecturers-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kode</th>
        <th>NIP</th>
        <th>Kelompok Keahlian</th>
        <th>Role</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; ?>
      @foreach($users as $user)
        @foreach($user->roles as $role)
        @if($role->role_code == 'RLPIC' OR $role->role_code == 'RLADM' OR $role->role_code == 'RLSPR' OR $role->role_code == 'RLDSN')
        <tr>
          <td><?= $i++ ?></td>
          <td>{{ $user->nama }}</td>
          @if($user->lecturers != null)
          <td>{{ $user->lecturers->code }}</td>
          <td>{{ $user->lecturers->nip == null ? 'Belum diinputkan' : $user->lecturers->nip}}</td>
          <td>{{ $user->lecturers->kk == null ? 'Belum diinputkan' : $user->lecturers->kk}}</td>
          @else
          <td>-</td>
          <td>-</td>
          <td>-</td>
          @endif
          <td>{{ ucwords($role->nama) }}</td>
          <td>
            <form class="" action="{{ url('/lecturer/delete') }}" method="post">
              @csrf
              <input type="text" name="role" value="{{ $role->id }}" hidden>
              <input type="text" name="id" value="{{ $user->id }}" hidden>
              <div class='btn-group'>
                {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
              </div>
            </form>
          </td>
        </tr>
        @endif
        @endforeach
      @endforeach
    </tbody>
  </table>
</div>
