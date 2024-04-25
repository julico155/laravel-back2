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
        <div class="login__img">
            <img src="{{asset('img/logo.png')}}" alt="">
        </div>

        <div class="login__forms">
            <form method="POST" action="{{ route('register') }}" class="login__create" id="login-up">
                @csrf
                <h1 class="login__title">Crear cuenta</h1>

                <div class="login__box">
                    <i class='bx bx-user login__icon'></i>
                    <input id="name" type="text" placeholder="Nombre de Usuario" class="login__input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>

                @error('name')
                        <span id="error" class="login__forgot">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror

                <div class="login__box">
                    <i class='bx bx-at login__icon'></i>
                    <input id="email" type="email" placeholder="Correo" class="login__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>

                @error('email')
                        <span id="error" class="login__forgot">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror

                <div class="login__box">
                    <i class='bx bx-lock-alt login__icon'></i>
                    <input id="password" type="password" placeholder="Contraseña" class="login__input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                </div>

                @error('password')
                    <span  id="error" class="login__forgot"><strong>{{ $message }}</strong></span>
                @enderror
                

                <div class="login__box">
                    <i class='bx bx-lock-alt login__icon'></i>
                    <input id="password-confirm" type="password" placeholder="Confirmar Contraseña" class="login__input" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div align="center">
                    <button type="submit" class="login__button" id="sign" align="center">
                        {{ __('Regístrate') }}
                    </button>
                </div>
                

                <div>
                    <span class="login__account">Ya tienes una cuenta?</span>
                    <span class="login__signup" id="sign-in">
                        <a href="{{url('login')}}">Iniciar sesión</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

 <script src="{{asset('js/login.js')}}"></script>
@endsection

