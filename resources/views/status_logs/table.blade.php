<div class="table-responsive-sm">
    <table class="table table-striped" id="statusLogs-table">
        <thead>
            <tr>
                <th>Feedback</th>
        <th>Created By</th>
        <th>Sidangs Id</th>
        <th>Workflow Type</th>
        <th>Name</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($statusLogs as $statusLog)
            <tr>
                <td>{{ $statusLog->feedback }}</td>
            <td>{{ $statusLog->created_by }}</td>
            <td>{{ $statusLog->sidangs_id }}</td>
            <td>{{ $statusLog->workflow_type }}</td>
            <td>{{ $statusLog->name }}</td>
                <td>
                    {!! Form::open(['route' => ['statusLogs.destroy', $statusLog->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('statusLogs.show', [$statusLog->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('statusLogs.edit', [$statusLog->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>