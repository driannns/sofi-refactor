<div class="table-responsive-sm">
    <table class="table table-striped" id="dokumenLogs-table">
        <thead>
            <tr>
                <th>Sidang Id</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>File Url</th>
                <th>Created By</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dokumenLogs as $dokumenLog)
            <tr>
                <td>{{ $dokumenLog->sidang_id }}</td>
            <td>{{ $dokumenLog->nama }}</td>
            <td>{{ $dokumenLog->jenis }}</td>
            <td>{{ $dokumenLog->file_url }}</td>
            <td>{{ $dokumenLog->created_by }}</td>
                <td>
                    {!! Form::open(['route' => ['dokumenLogs.destroy', $dokumenLog->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('dokumenLogs.show', [$dokumenLog->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('dokumenLogs.edit', [$dokumenLog->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
