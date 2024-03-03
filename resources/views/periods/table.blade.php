@php
    $admin = auth()->user()->isAdmin();
    $superadmin = auth()->user()->isSuperadmin();
    $ppm = auth()->user()->isPpm()
@endphp
<div class="table-responsive-sm">
    <table class="table table-striped" id="periods-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Start Date</th>
            <th>End Date</th>
{{--            <th>Description</th>--}}
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach($periods as $period)
        <tr>
            <td>{{ $period->name }}</td>
          <td>{{ date('d-m-Y', strtotime($period->start_date)) }}</td>
          <td>{{ date('d-m-Y', strtotime($period->end_date)) }}</td>
{{--          <td>{{ $period->description }}</td>--}}
          <td>{{ $period->created_at }}</td>
          <td>{{ $period->updated_at }}</td>
          <td>
            {!! Form::open(['route' => ['periods.destroy', $period->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                @if(!$ppm)
              <a href="{{ route('periods.show', [$period->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
              <a href="{{ route('periods.edit', [$period->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
              {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
              <a href="{{ route('exports.score', [$period->id]) }}" class='btn btn-primary'>Download Nilai</a>
                @endif
                <a href="{{ route('exports.revisions', [$period->id]) }}" class='btn btn-primary'>Download List Revisi</a>
            </div>
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script type="text/javascript">
    $('#periods-table').DataTable({
        pageLength: 15,
        order: [[ 3, "desc" ]],
    });
</script>
@endpush()