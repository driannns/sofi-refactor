<div class="table-responsive-sm">
    <table class="table table-striped datatable" id="intervals-table">
        <thead>
          <tr>
            <th>Code CLO</th>
            <th>Code Component</th>
            <th>Value</th>
            <th>Ekuivalensi</th>
            <th>Unsur Penilaian</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($intervals as $interval)
        <tr>
          <td>{{ $interval->component->clo->code }}</td>
          <td>{{ $interval->component->code }}</td>
          <td>{{ $interval->value }}</td>
          <td>{{ $interval->ekuivalensi }}</td>
          <td>{{ $interval->unsur_penilaian }}</td>
          <td>
            {!! Form::open(['route' => ['intervals.destroy', $interval->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
              <a href="{{ route('intervals.show', [$interval->id]) }}" class='btn btn-success'><i class="fa fa-eye"></i></a>
              <a href="{{ route('intervals.edit', [$interval->id]) }}" class='btn btn-info'><i class="fa fa-edit" style="color:white;"></i></a>
              <a href="{{ route('clo.preview', [$interval->component->clo->period_id,'pembimbing']) }}" target="_blank" class='btn btn-warning' style="color:white;">Preview Pembimbing</a>
              <a href="{{ route('clo.preview', [$interval->component->clo->period_id,'penguji']) }}" target="_blank" class='btn btn-warning' style="color:white;">Preview Penguji</a>
              {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
            </div>
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
