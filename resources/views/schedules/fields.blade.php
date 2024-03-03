<!-- Sidang Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team', 'TIM') !!}
    {!! Form::text('team', $team->name, ['class' => 'form-control','readonly' => 'true']) !!}
</div>

<hr>
@foreach($students as $student)
<p>IDENTITAS MAHASISWA {{ $loop->iteration }}</p>
<input type="text" name="sidang_id[]" value="{{ $student->sidangs[0]->id }}" hidden>
<div class="form-group col-sm-6">
    {!! Form::label('nim', 'NIM') !!}
    {!! Form::number('nim[]', $student->nim, ['class' => 'form-control','readonly' => 'true']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('nama', 'NAMA') !!}
    {!! Form::text('nama[]', $student->user->nama, ['class' => 'form-control','readonly' => 'true']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('judul', 'JUDUL') !!}
    {!! Form::textarea('judul[]', $student->sidangs[0]->judul, ['class' => 'form-control','readonly' => 'true', 'rows' => '3']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('judul', 'KELOMPOK KEAHLIAN') !!}
    {!! Form::text('kk[]', $student->kk, ['class' => 'form-control','readonly' => 'true','id'=>'kk']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('judul', 'PEMINATAN') !!}
    @if($student->peminatan_id != null)
    {!! Form::text('peminatan[]', $student->peminatan->nama, ['class' => 'form-control','readonly' => 'true']) !!}
    @else
    {!! Form::text('peminatan[]', null, ['class' => 'form-control','readonly' => 'true']) !!}
    @endif
</div>
<div class="form-group col-sm-6">
    {!! Form::label('pembimbing1', 'PEMBIMBING 1') !!}
    {!! Form::text('pembimbing1[]', $student->sidangs[0]->pembimbing1->code." - ".$student->sidangs[0]->pembimbing1->user->nama, ['class' => 'form-control','readonly' => 'true']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('pembimbing2', 'PEMBIMBING 2') !!}
    {!! Form::text('pembimbing2[]', $student->sidangs[0]->pembimbing2->code." - ".$student->sidangs[0]->pembimbing2->user->nama, ['class' => 'form-control','readonly' => 'true']) !!}
</div>
<hr>
@endforeach


<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'TANGGAL SIDANG') !!}
    {!! Form::text('date', old('date'), ['class' => 'form-control getdate','id'=>'date']) !!}
</div>

<!-- Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time', 'WAKTU SIDANG') !!}
    {!! Form::text('time', old('time'), ['class' => 'form-control time', 'id'=>'time']) !!}

</div>


<!-- Penguji1 Field -->
{{-- <div class="form-group col-sm-6">
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#jadwalPenguji">
        Lihat Jadwal Dosen Penguji
    </a>
</div>  --}}
<div class="form-group col-sm-6">
    <div id="gantidosen"> </div>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('penguji1', 'PENGUJI 1') !!}
    <select class="form-control select2" name="penguji1" id="penguji1">
        <option value="">Pilih Penguji 1</option>
        @foreach($penguji1 as $penguji)
        @if($schedule == null)
        <option value="{{ $penguji->id }}" {{ $penguji->id == old('penguji1') ? 'selected' : '' }}>
            {{ $penguji->user->nama }} - {{ $penguji->kk }}
        </option>
        @else
        <option value="{{ $penguji->id }}" {{ $penguji->id == $schedule->penguji1 ? 'selected' : '' }}>
            {{ $penguji->user->nama }} - {{ $penguji->kk }}
        </option>
        @endif
        @endforeach
    </select>
</div>
<div class="form-group col-sm-6">
    <div id="gantidosen2"> </div>

    <div class="alert alert-danger" id="alertBox" role="alert" style="display:none">
        Mohon pilih penguji lainnya, Penguji ini sudah memiliki jadwal
    </div>

</div>
<!-- Penguji2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('penguji2', 'PENGUJI 2') !!}
    <select class="form-control select2" name="penguji2" id="penguji2">
        <option value="">Pilih Penguji 2</option>
        @foreach($penguji2 as $penguji)
        @if($schedule == null)
        <option value="{{ $penguji->id }}" {{ $penguji->id == old('penguji2') ? 'selected' : '' }}>
            {{ $penguji->user->nama }} - {{ $penguji->kk }}
        </option>
        @else
        <option value="{{ $penguji->id }}" {{ $penguji->id == $schedule->penguji2 ? 'selected' : '' }}>
            {{ $penguji->user->nama }} - {{ $penguji->kk }}
        </option>
        @endif
        @endforeach
    </select>
</div>


<!-- Ruang Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ruang', 'RUANG SIDANG / LINK VIDEO CONFERENCE') !!}
    {!! Form::text('ruang', old('ruang'), ['class' => 'form-control', 'id'=>'ruang']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>

</div>

@push('scripts')
<script type="text/javascript">
    $('#date').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate: new Date(),
        useCurrent: true,
        icons: {
            up: "icon-arrow-up-circle icons font-2xl",
            down: "icon-arrow-down-circle icons font-2xl"
        },
        sideBySide: true
    });


    $('#time').datetimepicker({
        format: 'HH:mm',
        stepping: 30,
        useCurrent: true,
        icons: {
            up: "icon-arrow-up-circle icons font-2xl",
            down: "icon-arrow-down-circle icons font-2xl"
        }
    });
</script>
@if(isset($schedule->date))
@php($old_date = date('Y-m-d',strtotime($schedule->date)))
<script>
    $(document).ready(function () {
        $("#date").val("{{$old_date}}");
        // $("#date").datetimepicker('setDate', "{{$old_date}}");
    })
</script>
@endif
<script type="text/javascript">
    var date_input1 = document.getElementById('penguji1');
    // {{-- $('#ruang').on('keyup',function(){ --}}
    date_input1.onchange = function() {
        $("#gantidosen").empty();
        // $tanggal = $('#date').val();
        // $penguji1 = $('#penguji1').val();
        // $time = $('#time').val();
        $.ajax({
            type: 'get',
            url: "{{URL::to('search/schedule/getpenguji1')}}",
            data: {
                'date': $('#date').val(),
                'penguji1': $('#penguji1').val(),
                'time': $('#time').val()
            },
            success: function(data) {
                $('#gantidosen').html(data);
            }
        });
        //cek penguji2

    }


    var time = document.getElementsByClassName('time');
    time.onchange = function() {
        $("#gantidosen").empty();
        $("#gantidosen2").empty();

    }
    var date_input2 = document.getElementById('penguji2');
    date_input2.onchange = function() {
        $("#gantidosen2").empty();
        $tanggal = $('#date').val();
        $penguji2 = $('#penguji2').val();
        $time = $('#time').val();
        var e1 = document.getElementById("penguji1");
        var e2 = document.getElementById("penguji2");
        var strUser1 = e1.options[e1.selectedIndex].text; //test2
        var strUser2 = e2.options[e2.selectedIndex].text; //test2

        if (strUser1 == strUser2) {
            x = document.getElementById("alertBox");
            x.style.display = "block";
        } else {

            $.ajax({
                type: 'get',
                url: "{{URL::to('search/schedule/getpenguji2')}}",
                data: {
                    'date': $tanggal,
                    'penguji2': $penguji2,
                    'time': $time
                },
                success: function(data) {
                    $('#gantidosen2').html(data);
                }
            });

            x = document.getElementById("alertBox");
            x.style.display = "none";


        }



    }
</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });
</script>
@endpush

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });
</script>