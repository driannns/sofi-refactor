<div class="table-responsive-sm">
    <table class="table table-striped" id="scorePortions-table">
        <thead>
            <tr>
                <th>Periode Sidang</th>
        <th>Program Studi</th>
        <th>Pembimbing</th>
        <th>Penguji</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($scorePortions as $scorePortion)
            <tr>
                <td>{{ $scorePortion->period->name }}</td>
            <td>{{ $scorePortion->studyProgram ? $scorePortion->studyProgram->name:"-" }}</td>
            <td>{{ $scorePortion->pembimbing }}</td>
            <td>{{ $scorePortion->penguji }}</td>
                <td>
                    {!! Form::open(['route' => ['scorePortions.destroy', $scorePortion->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('scorePortions.show', [$scorePortion->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('scorePortions.edit', [$scorePortion->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>