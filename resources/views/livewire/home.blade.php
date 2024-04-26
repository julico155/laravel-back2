<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
        <script src="{{ asset('js/home.js') }}"></script>
    </head>
    <div class="container">
        <ul class="nav nav-tabs card-header-tabs mx-2 my-4">
            <li class="nav-item">
                <a wire:click="$set('opcion', true)" class="nav-link @if ($opcion) active @endif">Mis
                    proyectos</a>
            </li>
            <li class="nav-item">
                <a wire:click="$set('opcion', false)"
                    class="nav-link @if (!$opcion) active @endif">Mis colaboraciones</a>
            </li>
        </ul>
        <div align="right">
            @if ($opcion)
                <button class="boton-crear" wire:click="$set('modalCrear', true)">Crear
                    proyecto</button>
            @else
                <button class="boton-crear" wire:click="$set('modalUnirse', true)">Unirse a un
                    proyecto</button>
            @endif
        </div>

        <div class="my-5">
            <div class="container">
                <div class="row justify-content-center">
                    @forelse ($proyectos as $proyecto)
                        <div class="col-12 col-md-4 align-self-center">
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
                                                <button wire:click="verProyecto('{{ $proyecto->id }}')" class="boton">
                                                    <img class="img" src="{{ asset('img/grupo.png') }}">
                                                </button>
                                            </div>
                                            <div>
                                                <button wire:click="modalEdit('{{ $proyecto->id }}')" class="boton">
                                                    <img class="img" src="{{ asset('img/lapiz.png') }}">
                                                </button>
                                            </div>
                                            <div>
                                                <button wire:click="modalDestroy('{{ $proyecto->id }}')" class="boton">
                                                    <img class="img" src="{{ asset('img/eliminar.png') }}">
                                                </button>
                                            </div>
                                        @endif
                                    </section>
                                </div>
                                <div class="card-body">
                                    <div class="input-group">
                                        <label>Descripcion:
                                            <b>{{ $proyecto->descripcion }}</b></label>
                                    </div>
                                    <div align="center" class="mt-4">
                                        @if ($opcion)
                                            <a wire:click="compartirProyecto('{{ $proyecto->codigo }}')" class="myButtonShare">Compartir</a>
                                        @endif
                                        <a href="{{ route('descargarCodigoPhp', ['codigo' => $proyecto->codigo]) }}" class="btn btn-sm btn-primary">Descargar Php</a>
                                        <a href="{{ route('descargarCodigoPython', ['codigo' => $proyecto->codigo]) }}" class="btn btn-sm btn-primary">Descargar Python</a>
                                        <a href="{{ route('descargarCodigoJava', ['codigo' => $proyecto->codigo]) }}" class="btn btn-sm btn-primary">Descargar Java</a>

                                        <a href="http://3.144.74.15:8080/uml-sequence?room={{ $proyecto->codigo }}&username={{ auth()->user()->token }}" class="myButton">Ingresar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        
    </div>
    {{-- crear proyecto --}}
    @if ($modalCrear)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Crear proyecto</h5>
                        </div>
                        <div class="modal-body">
                            <h4>Nombre:</h4>
                            <input type="text" wire:model="nombre" class="form-control">
                            @if ($errormodal)
                                <small class="text-danger">Campo Requerido</small>
                            @endif
                            <h4>Descripcion:</h4>
                            <input type="text" wire:model="descripcion" class="form-control">
                            @if ($errormodal)
                                <small class="text-danger">Campo Requerido</small>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="storeProyecto()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- editar proyecto --}}
    @if ($modalEdit)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar proyecto</h5>
                        </div>
                        <div class="modal-body">
                            <h4>Nombre:</h4>
                            <input type="text" wire:model="nombre" class="form-control">
                            @if ($errormodal)
                                <small class="text-danger">Campo Requerido</small>
                            @endif
                            <h4>Descripcion:</h4>
                            <input type="text" wire:model="descripcion" class="form-control">
                            @if ($errormodal)
                                <small class="text-danger">Campo Requerido</small>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary"
                                wire:click="updateProyecto()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- eliminar proyecto --}}
    @if ($modalDestroy)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="card-header">
                            <div class="d-flex align-items-center text-center justify-content-center">
                                <h5>¿Estás seguro?</h5>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div align="center">
                                <button type="button" class="btn btn-secondary btn-sm my-2 mx-2"
                                    wire:click="cancelar()">Cancelar</button>
                                <button wire:click="destroyProyecto()"
                                    class="btn btn-danger btn-sm my-2 mx-2">Eliminar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- UNIRSE A UN PROYECTO --}}
    @if ($modalUnirse)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Unirse a un proyecto</h5>
                        </div>
                        <div class="modal-body">
                            <h4>Clave del proyecto:</h4>
                            <input type="text" wire:model="codigo" placeholder="Ingrese la clave"
                                class="form-control">
                            @if ($errormodal)
                                <small class="text-danger">
                                    @if ($registrado)
                                        Ya formas parte de este proyecto.
                                    @else
                                        Campo Requerido.
                                    @endif
                                </small>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary"
                                wire:click="unirseProyecto()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($modalCompartir)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Clave del proyecto:</h5>
                            <button wire:click="cancelar()" class="boton">
                                <img class="img" src="{{ asset('img/salir.png') }}">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="m-0 row justify-content-center">
                                <div class="col-8 text-center">
                                    <p id="joinLink" style="width: 100%" wire:model="codigo" class="form-control">
                                        {{ $codigo }}</p>
                                </div>
                                <div class="col-auto text-center">
                                    <input type="button" class="btn btn-primary" onclick="copyLink()"
                                        data-toggle="tooltip" title="Copy to Clipboard" value="Copy Link" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ver usuarios --}}
    @if ($modalUsers)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel"><b>Usuarios agregados</b></h4>
                        </div>
                        <div class="modal-body">
                            @foreach ($users as $user)
                                <div class="row my-2">
                                    <div class="col-8">
                                        <h5>- {{ $user->name }}</h5>
                                    </div>
                                    <div align="right"class="col-4">
                                        <button
                                            wire:click="destroyProyectouser('{{ $user->id }}','{{ $user->proyecto_id }}')"
                                            class="boton">
                                            <img class="img" src="{{ asset('img/salir.png') }}">
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">salir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
