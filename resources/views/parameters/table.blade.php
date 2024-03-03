<div class="table-responsive-sm">
    <table class="table table-striped datatable" id="parameters-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Value</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($parameters as $parameter)
        <tr>
          <td>{{ $parameter->name }}</td>
          <td>{{ $parameter->value }}</td>
          <td>
            <div class='btn-group'>
              <a href="{{ route('parameters.edit', [$parameter->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
            </div>
          </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
