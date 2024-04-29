@extends('layouts.app')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('css/styles-login.css')}}">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <title>BigPack-Login</title>
</head>
<div class="login">
    <div class="login__content">


        <div class="login__forms">
            <form method="POST" action="{{ route('login') }}" class="login__registre" id="login-in">
                    @csrf
                <h1 class="login__title">Iniciar sesión</h1>

                <div class="login__box">
                    <i class='bx bx-user login__icon'></i>
                    <input id="email" type="email" placeholder="Correo" class="login__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                @error('email')
                    <span id="error" class="login__forgot">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
               

                <div class="login__box">
                    <i class='bx bx-lock-alt login__icon'></i>
                    <input id="password" type="password" placeholder="Contraseña" class="login__input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>

                @error('password')
                    <span id="error" class="login__forgot">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <a href="#" class="login__forgot">Olvidaste tu contraseña?</a>

                <div align="center">
                    <button type="submit" class="login__button">
                        {{ __('Ingresar') }}
                    </button>
                </div>

                <div>
                    <span class="login__account">No tienes una cuenta?</span>
                    <span class="login__signin" id="sign-up">
                        <a href="{{url('register')}}">Regístrate</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

 <script src="{{asset('js/login.js')}}"></script>
@endsection
