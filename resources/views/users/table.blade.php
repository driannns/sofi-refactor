<div class="table-responsive-sm">
    <table class="table table-striped datatable" id="users-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lihat
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                            
                                <a href="{{ route('users.show', [$user->id]) }}" class='btn btn-success w-100'>Lihat</a>
                                <a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-info w-100'>Ubah</a>
                                @if( $user->username != 'admin' )
                                {!! Form::button('Hapus', ['type' => 'submit', 'class' => 'btn
                                btn-danger w-100', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                @endif
                            {!! Form::close() !!}
                        </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
