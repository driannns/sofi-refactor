<div class="table-responsive-sm">
    <table class="table table-striped" id="scores-table">
        <thead>
            <tr>
                <th>Value</th>
                <th>Percentage</th>
                <th>Component ID</th>
                <th>Jadwal ID</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($scores as $score)
            <tr>
                <td>{{ $score->value }}</td>
            <td>{{ $score->percentage }}</td>
            <td>{{ $score->component_id }}</td>
            <td>{{ $score->jadwal_id }}</td>
                <td>
                    {!! Form::open(['route' => ['scores.destroy', $score->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('scores.show', [$score->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('scores.edit', [$score->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
