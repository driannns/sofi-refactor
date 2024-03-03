<div class="table-responsive-sm">
    <table class="table table-striped" id="students-table">
        <thead>
            <tr>
                <th>Status</th>
        <th>Tak</th>
        <th>Eprt</th>
        <th>Studentscol</th>
        <th>User Id</th>
        <th>Team Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->status }}</td>
            <td>{{ $student->tak }}</td>
            <td>{{ $student->eprt }}</td>
            <td>{{ $student->studentscol }}</td>
            <td>{{ $student->user_id }}</td>
            <td>{{ $student->team_id }}</td>
                <td>
                    {!! Form::open(['route' => ['students.destroy', $student->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('students.show', [$student->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('students.edit', [$student->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>