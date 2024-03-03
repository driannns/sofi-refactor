<div class="table-responsive-sm">
    <table class="table table-striped datatable" id="cLOS-table">
        <thead>
        <tr>
            <th>Code</th>
            <th>Precentage</th>
            <th>Description</th>
            <th>Untuk Periode</th>
            <th>Prodi</th>
            <th>Pembimbing</th>
            <th>Penguji</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cLOS as $cLO)
            <tr>
                <td>{{ $cLO->code }}</td>
                <td>{{ $cLO->precentage }}</td>
                <td>{{ $cLO->description }}</td>
                <td>{{ $cLO->period->name }}</td>
                <td>{{ $cLO->study_program ? $cLO->study_program->name:"-" }}</td>
                <td>{{ $cLO->components[0]->pembimbing == 1 ? 'Berlaku' : 'Tidak Berlaku' }}</td>
                <td>{{ $cLO->components[0]->penguji == 1 ? 'Berlaku' : 'Tidak Berlaku' }}</td>
                <td>
                    {!! Form::open(['route' => ['cLOS.destroy', $cLO->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('cLOS.show', [$cLO->id]) }}" class='btn btn-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('cLOS.edit', [$cLO->id]) }}" class='btn btn-info'><i class="fa fa-edit"
                                                                                               style="color:white;"></i></a>
                        <a href="{{ route('clo.preview', [$cLO->period_id,$cLO->study_program_id?$cLO->study_program_id:-1,'pembimbing']) }}"
                           target="_blank" class='btn btn-warning' style="color:white;">Preview Pembimbing</a>
                        <a href="{{ route('clo.preview', [$cLO->period_id,$cLO->study_program_id?$cLO->study_program_id:-1,'penguji']) }}"
                           target="_blank" class='btn btn-warning' style="color:white;">Preview Penguji</a>
                    <!-- <a href="{{ route('components.create', [$cLO->id]) }}" class='btn btn-warning' style="color:white;">Tambah Component</a> -->
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
