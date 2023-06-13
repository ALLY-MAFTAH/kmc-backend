<!DOCTYPE html>
<html>

<head>
    <title> Login | {{ config('app.name', 'Smart Kinondoni') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/demo/style.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>

<body>
    <script src="../assets/js/preloader.js"></script>

    <div class="container">
        <div class="myCard">
            <div class="row">
                <div class="col-sm-6">
                    <div class="myLeftCtn">
                        <form class="myForm text-center" method="POST" action="{{ route('login') }}">
                            @csrf
                            <header>Sign In</header>
                            <div class="form-group">
                                <i class="fas fa-envelope"></i>
                                <input class="myInput form-control @error('email') is-invalid @enderror"
                                    placeholder="Email" type="email" name="email" autofocus required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="myInput form-control @error('password') is-invalid @enderror"
                                    type="password" name="password" placeholder="Password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group pl-4">
                                <input type="submit" class="butt" value="SIGN IN">
                                <br><br>
                                @if (Route::has('password.request'))
                                    <small> Forgot your password ? <a
                                            href="{{ route('password.request') }}" style="text-decoration: none">Reset</a></small>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6">
                  @include('includes.right_content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

</body>

</html>
