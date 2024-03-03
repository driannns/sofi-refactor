<div class="table-responsive-sm">
    <table class="table table-striped datatable" id="peminatans-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Kelompok Keahlian</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($peminatans as $peminatan)
        <tr>
          <td>{{ $peminatan->nama }}</td>
          <td>{{ $peminatan->kk }}</td>
          <td>
            {!! Form::open(['route' => ['peminatans.destroy', $peminatan->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
              <a href="{{ route('peminatans.show', [$peminatan->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
              <a href="{{ route('peminatans.edit', [$peminatan->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
              {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
            </div>
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
