@if($isPrint)
  @include('documents.partitions.headerPrint')
@else
  @include('documents.partitions.header')
@endif

  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="font-weight-bold">Formulir Penilaian Pembimbing Sidang Tugas Akhir</h2>
    </div>
  </div>

  <div class="container mb-5">
    <div class="row">
      <div class="col-sm-12" style="padding:0px 150px 0px 150px">
        <div class="table-responsive-sm m-5">
          <table class="table table-bordered table-sm">
            <thead>
              <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">CLO</th>
                <th>Deskripsi CLO</th>
                <th>Unsur Penilaian / Rubrikasi</th>
                <th class="text-center">Bobot</th>
                <th colspan="5">Interval</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clos as $clo)
              @if($clo->components[0]->pembimbing == 1)
              <tr>
                <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
                <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
              </tr>
              @foreach($clo->components as $component)
              @if($scores != null)
                @foreach($scores as $score)
                  @if($score->component_id == $component->id)
                    @php
                      $value = $score->value;
                    @endphp
                  @endif
                @endforeach
              @endif
                <tr>
                  <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
                  <td>{{ $clo->precentage }}%</td>
                  @foreach($component->intervals->sortBy('value') as $interval)
                  @if($score != null)
                  <td class="text-center {{ $value == $interval->ekuivalensi ? 'font-weight-bold' : "" }}">{{ $interval->value }}</td>
                  @endif
                  @endforeach
                </tr>
              @endforeach
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@include('documents.partitions.footer')
