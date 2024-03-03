<div class="table-responsive-sm">
    <table class="table table-striped" id="attendances-table">
        <thead>
            <tr>
                <th>Schedule Id</th>
        <th>User Id</th>
        <th>Role Sidang</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->schedule_id }}</td>
            <td>{{ $attendance->user_id }}</td>
            <td>{{ $attendance->role_sidang }}</td>
                <td>
                    {!! Form::open(['route' => ['attendances.destroy', $attendance->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('attendances.show', [$attendance->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('attendances.edit', [$attendance->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>