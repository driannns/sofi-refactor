<div class="table-responsive-sm">
    <table class="table table-striped datatable" id="components-table">
        <thead>
          <tr>
            <th>Code CLO</th>
            <th>Code Component</th>
            <th>Description</th>
            <th>Percentage</th>
            <th>Unsur Penilaian</th>
            <th>Pembimbing</th>
            <th>Penguji</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($components as $component)
            <tr>
              <td>{{ $component->clo->code }}</td>
              <td>{{ $component->code }}</td>
              <td>{{ $component->description }}</td>
              <td>{{ $component->percentage }}</td>
              <td>{{ $component->unsur_penilaian }}</td>
              <td>{{ $component->pembimbing == 1 ? 'Berlaku' : 'Tidak Berlaku' }}</td>
              <td>{{ $component->penguji == 1 ? 'Berlaku' : 'Tidak Berlaku' }}</td>
              <td>
                {!! Form::open(['route' => ['components.destroy', $component->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                  <a href="{{ route('components.show', [$component->id]) }}" class='btn btn-success'><i class="fa fa-eye"></i></a>
                  <a href="{{ route('components.edit', [$component->id]) }}" class='btn btn-info'><i class="fa fa-edit" style="color:white;"></i></a>
                  <a href="{{ route('intervals.create', [$component->id]) }}" class='btn btn-warning' style="color:white;">Tambah Interval</a>
                  {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
              </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
