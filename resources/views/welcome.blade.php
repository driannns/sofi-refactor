<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@2.1.16/dist/css/coreui.min.css">
  <style>
  html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Nunito', sans-serif;
    font-weight: 200;
    height: 100vh;
    margin: 0;
  }

  .full-height {
    height: 100vh;
  }

  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }

  .position-ref {
    position: relative;
  }

  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .content {
    text-align: center;
  }

  .title {
    font-size: 84px;
  }

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }

  .m-b-md {
    margin-bottom: 30px;
  }
  </style>
</head>
<body>
  <div class="flex-center position-ref full-height flex-column">

    <div class="content">

      <img src="{{ asset('images/telkom.png') }}" alt="" height="200px" class="">

      <div class="title m-b-md mt-5">
        SOFI - Sidang Online FRI
      </div>

      <div class="links mb-4">
        <a href="#" class="">Aplikasi sidang online fakultas rekayasa industri</a>
      </div>
      @auth
      <div class="form-group">
        <a href="{{ url('/home') }}" class="btn btn-primary w-50 font-weight-bold">Home</a>
      </div>
      @else
      <div class="form-group">
        <a href="{{ route('loginSSO') }}" class="btn btn-primary w-50 font-weight-bold">Login</a>
      </div>
      <div>
        {{-- @if (Route::has('register'))
        <a href="{{ route('register') }}" class="btn btn-info w-50 text-white font-weight-bold">Register</a>
        @endif --}}
      </div>
      @endauth
    </div>
  </div>
</body>
</html>
