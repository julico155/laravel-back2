@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="{{ asset('js/home.js') }}"></script>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="row justify-content-center">
                <div class="col-12">
                    @forelse ($proyectos as $proyecto)
                        <div class="carousel-item @if ($loop->index == 0) active @endif">
                            <div class="row justify-content-center">
                                {{-- @foreach ($array as $proyecto) --}}
                                    <div class="col-3 align-self-center">
                                        <div class="card my-2 mx-4">
                                            <div class="card-header">
                                                <section class="layout">
                                                    <div><b>{{ $proyecto->nombre }}</b>
                                                        @if (!$opcion)
                                                            - creado por: {{ $proyecto->user->name }}
                                                        @endif
                                                    </div>
                                                    @if ($opcion)
                                                        <div class="marginLeft">
                                                            <button wire:click="verProyecto('{{ $proyecto->id }}')"
                                                                class="boton">
                                                                <img class="img"
                                                                    src="{{ asset('img/grupo.png') }}">
                                                            </button>
                                                        </div>
                                                        <div>
                                                            <button wire:click="modalEdit('{{ $proyecto->id }}')"
                                                                class="boton">
                                                                <img class="img"
                                                                    src="{{ asset('img/lapiz.png') }}">
                                                            </button>
                                                        </div>
                                                        <div>
                                                            <button wire:click="modalDestroy('{{ $proyecto->id }}')"
                                                                class="boton">
                                                                <img class="img"
                                                                    src="{{ asset('img/eliminar.png') }}">
                                                            </button>
                                                        </div>
                                                    @endif
                                                </section>
                                            </div>
                                            <div class="card-body">
                                                <div class="input-group">
                                                    <label>Descripcion: <b>{{ $proyecto->descripcion }}</b></label>
                                                </div>
                                                <div align="center" class="mt-4">
                                                    @if ($opcion)
                                                        <a wire:click="compartirProyecto('{{ $proyecto->codigo }}')"
                                                            class="myButtonShare">Compartir</a>
                                                    @endif
                                                    <a href="http://3.136.17.144:8080/uml-sequence?room={{ $proyecto->codigo }}&username={{ auth()->user()->token }}"
                                                        class="myButton">Ingresar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>

                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    {{-- </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div> --}}
@endsection

 {{-- <ul class="nav nav-tabs card-header-tabs mx-2 my-0">
                    <li class="nav-item">
                        <a wire:click="$set('opcion', true)"
                            class="nav-link @if ($opcion) active @endif">Tus proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="$set('opcion', false)"
                            class="nav-link @if (!$opcion) active @endif">Invitado</a>
                    </li>
                </ul> --}}
                {{-- <div class="card">
                    <div class="card-body"> --}}
