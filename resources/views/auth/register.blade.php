<!DOCTYPE html>
<html lang="en">
<head>
  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>{{ config('app.name') }}</title>
  <meta name="description" content="CoreUI Template - InfyOm Laravel Generator">
  <meta name="keyword" content="CoreUI,Bootstrap,Admin,Template,InfyOm,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/css/coreui.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/coreui-icons-free@1.0.1-alpha.1/coreui-icons-free.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <style media="screen">
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 33px
  }
  .select2-container .select2-selection--single {
    height: 36px;
  }
  </style>
</head>
<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mx-4">
          <div class="card-body p-4">
            <form method="post" action="{{ url('/register') }}">
              @csrf
              <input id="tak" type="text" name="tak" hidden>
              <input id="eprt" type="text" name="eprt" hidden>
              <h1>Register</h1>
              <p class="text-muted">Create your account</p>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <span>NIM</span>
                  </span>
                </div>
                <select id="nim" class="form-control select2 {{ $errors->has('username')?'is-invalid':'' }}"
                name="username" value="{{ old('username') }}" placeholder="NIM">
                  <option value="">Pilih NIM</option>
                  @foreach($students as $student)
                  <option value="{{ $student->studentid }}"
                    data-nama="{{ $student->fullname }}"
                     data-prodi="{{ $student->studyprogramname }}"
                      data-kelas="{{ $student->class }}"
                      data-eprt="{{ $student->eprt }}"
                      data-tak="{{ $student->tak }}"
                      {{ old('username') == $student->studentid ? 'selected' : '' }}>{{ $student->studentid }}</option>
                  @endforeach
                </select>
                @if ($errors->has('username'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('username') }}</strong>
                </span>
                @endif
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>
                </div>
                <input id="nama" type="text" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" name="name" value="{{ old('name') }}"
                placeholder="Full Name" readonly>
                @if ($errors->has('name'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>
                </div>
                <input id="prodi" type="text" class="form-control {{ $errors->has('prodi')?'is-invalid':'' }}" name="prodi" value="{{ old('prodi') }}"
                placeholder="Prodi" readonly>
                @if ($errors->has('prodi'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('prodi') }}</strong>
                </span>
                @endif
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-user"></i>
                  </span>
                </div>
                <input id="kelas" type="text" class="form-control {{ $errors->has('kelas')?'is-invalid':'' }}" name="prodi" value="{{ old('kelas') }}"
                placeholder="Kelas" readonly>
                @if ($errors->has('kelas'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('prodi') }}</strong>
                </span>
                @endif
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input type="password" class="form-control {{ $errors->has('password')?'is-invalid':''}}" name="password" placeholder="Password">
                @if ($errors->has('password'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
              <div class="input-group mb-4">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="icon-lock"></i>
                  </span>
                </div>
                <input type="password" name="password_confirmation" class="form-control"
                placeholder="Confirm password">
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
              </div>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
              <a href="{{ url('/login') }}" class="text-center btn btn-light btn-block btn-flat my-3">I already have a membership</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- CoreUI and necessary plugins-->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script type="text/javascript">
      $(document).ready(function() {
        $('#nim').on('change', function(){
          var nama = $('#nim option:selected').data('nama');
          var prodi = $('#nim option:selected').data('prodi');
          var kelas = $('#nim option:selected').data('kelas');
          var eprt = $('#nim option:selected').data('eprt');
          var tak = $('#nim option:selected').data('tak');
          $('#nama').val(nama);
          $('#prodi').val(prodi);
          $('#kelas').val(kelas);
          $('#eprt').val(eprt);
          $('#tak').val(tak);
        });
        $('.select2').select2();
      });
  </script>

</body>
</html>
