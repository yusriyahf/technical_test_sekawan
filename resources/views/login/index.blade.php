<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambang</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/tambangwhite.png') }}" />
  <link rel="stylesheet" href="css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('images/logos/tambanglogo.png') }}" width="180" alt="">
                </a>
                {{-- <p class="text-center">Tambang Application</p> --}}
                
                <!-- Display login error message -->
                @if(session('loginError'))
                    <div class="alert alert-danger">
                        {{ session('loginError') }}
                    </div>
                @endif

                <form method="POST" action="/login">
                  @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="username" name="username" class="form-control @error('username') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('username') }}" autocomplete="off">
                    @error('username') 
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" autocomplete="off">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" type="submit">Login</button>
                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="libs/jquery/dist/jquery.min.js"></script>
  <script src="libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
