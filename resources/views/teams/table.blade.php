<div class="table-responsive-sm">
    <table class="table table-striped datatable" id="teams-table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Name</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $member->nim }}</td>
                <td>{{ ucwords($member->user->nama) }}</td>
                <td>

                    @if($isSudahDijadwalkan)
                    <div class='btn-group'>
                        <a href="#" class="btn btn-primary">Lihat Jadwal</a>
                    </div>
                    @else
                    {{-- {!! Form::open(['route' => ['teams.destroy', $member->nim], 'method' => 'delete']) !!}
                      <div class='btn-group'>
                          @if(Auth::user()->id == $member->team_id)
                            {!! Form::button('Tinggalkan', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Apakah anda yakin ?')"]) !!}
                          @else
                            {!! Form::button('Tinggalkan', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Jika anda menghapus diri anda, maka anda akan meninggalkan team. Apakah anda yakin ?')"]) !!}
                          @endif
                      </div>
                      {!! Form::close() !!} --}}

                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                        data-target="#hapustim">Tinggalkan</button>


                    {{-- MODAL HAPUS TIM  --}}
                    <div class="modal fade" id="hapustim">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Perhatian</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body text-center">

                                    {!! Form::open(['route' => ['teams.destroy', $member->nim], 'method' => 'delete'])
                                    !!}
                                    <div class='btn-group'>
                                        @if(Auth::user()->id == $member->team_id)
                                        {!! Form::button('Tinggalkan', ['type' => 'submit', 'class' => 'btn btn-danger
                                        btn-sm']) !!}
                                        @else
                                        <center>
                                          <h5>Jika anda memilih tinggalkan, maka anda akan meninggalkan tim.</h5>
                                          <br>
                                        <button type="submit" class="btn btn-danger" data-toggle="modal"
                                            data-target="#hapustim">Tinggalkan</button>
                                        <button data-dismiss="modal" class="btn btn-secondary">Batal</button>

                                        </center>

                                        @endif
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>



                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
