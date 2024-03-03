<div class="table-responsive-sm">
    <table class="table table-striped" id="verifyDocuments-table">
        <thead>
            <tr>
                <th>Serial Number</th>
        <th>Perihal</th>
        <th>Nim</th>
        <th>Created By</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($verifyDocuments as $verifyDocument)
            <tr>
                <td>{{ $verifyDocument->serial_number }}</td>
            <td>{{ $verifyDocument->perihal }}</td>
            <td>{{ $verifyDocument->nim }}</td>
            <td>{{ $verifyDocument->created_by }}</td>
                <td>
{{--                    {!! Form::open(['route' => ['verifyDocuments.destroy', $verifyDocument->id], 'method' => 'delete']) !!}--}}
                    <div class='btn-group'>
                        <a href="{{ route('verifyDocuments.show', [$verifyDocument->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('verifyDocuments.edit', [$verifyDocument->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
{{--                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
{{--                    {!! Form::close() !!}--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
