<html>
<head>
  <meta charset="UTF-8">
  <title>{{config('app.name')}}</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 4.1.1 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/css/coreui.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/coreui-icons-free@1.0.1-alpha.1/coreui-icons-free.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">

  <!-- datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  <!-- select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body style="background:white; overflow-x:hidden">
  <div class="row">
    <div class="col-md-12 text-center my-3">
      <h1>Formulir Penilaian {{ ucfirst($role) }}</h1>
    </div>
  </div>

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
        <tr>
          <td rowspan="{{ $clo->components->count()+1 }}" class="text-center">{{ $loop->iteration }}</td>
          <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->code }}</td>
          <td rowspan="{{ $clo->components->count()+1 }}">{{ $clo->description }}</td>
        </tr>
        @foreach($clo->components as $component)
        @if($role == 'penguji')
          @if($component->penguji == 1)
          <tr>
            <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
            <td>{{ $clo->precentage }}%</td>
            @foreach($component->intervals->sortBy('value') as $interval)
            <td class="text-center">{{ $interval->value }}</td>
            @endforeach
          </tr>
          @endif
        @else
          @if($component->pembimbing == 1)
          <tr>
            <td>{!! nl2br(e($component->unsur_penilaian)) !!}</td>
            <td>{{ $clo->precentage }}%</td>
            @foreach($component->intervals->sortBy('value') as $interval)
            <td class="text-center">{{ $interval->value }}</td>
            @endforeach
          </tr>
          @endif
        @endif
        @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
</body>
<!-- jQuery 3.1.1 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
