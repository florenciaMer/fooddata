<?php
/** @var \App\Models\ClienteServicios[]|Illuminate\Database\Eloquent\Collection $clienteServicios */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Etiqueta[] $etiquetas */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Etiqueta[] $etiquetasLista */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Cliente[] $clienteItems */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Cliente[] $clienteIte */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var  $cliente */
/** @var \App\Models\Usuario $usuarios */
/** @var \App\Models\Condicion $condiciones */
/** @var \App\Models\Etiqueta $etiqueta */
///** @var \App\Models\ClienteServicios $clienteServicios */
/** @var \App\Models\Usuario $usuario */
/** @var array $formParams  */
 $cont=0 ;
?>
@section('title', 'Editar Cliente')
@extends('layout.main')
@section('main')

    <div class="container">
        <div class="container d-flex flex-column text-center bg-light p-3">
            <h1 class="text-secondary py-2">Editar Cliente</h1>
            <h2 class="text-secondary font-size-19">Completá el Formulario</h2>
        </div>
        <form action="{{ route('clientes.editar', ['cliente' => $cliente->cliente_id]) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre" class="my-2">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control p-2 @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $cliente->nombre) }}"
                       @error('nombre') aria-describedby="error-nombre"
                    @enderror>
                @error('nombre')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <input type="hidden" name="cliente_id" value="{{$cliente->cliente_id}}">
            <div class="form-group">
                <label for="nombreFantasia" class="my-2">Nombre Fantasía</label>
                <input type="text" id="nombreFantasia" name="nombreFantasia" class="form-control p-2 @error('nombreFantasia') is-invalid @enderror"
                       value="{{ old('nombreFantasia', $cliente->nombreFantasia) }}"
                       @error('nombreFantasia') aria-describedby="error-nombreFantasia"
                    @enderror>
                @error('nombreFantasia')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="direccion" class="my-2">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control p-2 @error('direccion') is-invalid @enderror"
                       value="{{ old('direccion', $cliente->direccion) }}"
                       @error('direccion') aria-describedby="error-direccion"
                    @enderror>
                @error('direccion')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="condicion_id" class="my-2">Condición de iva</label>
                <select id="condicion_id" name="condicion_id" class="form-control p-2">
                    @foreach($condiciones as $condicion)
                        <option value="{{ $condicion->condicion_id }}" @if(old('condicion_id', $cliente->condicion->condicion_id) == $condicion->condicion_id)
                        selected @endif>{{ $condicion->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-block btn-primary m-2">Editar</button>
        </form>

        {{-- ============================================Listado de Servicios por cliente ===================       --}}

        <div class="card-body">
        <div class="card-body">
            <div class="table table-striped">
                <div class="container-fluid d-flex">
                    <div class="container d-flex flex-column text-center bg-light p-3">
                        <div class="fs-3 align-items-md-start text-md-start text-black-50 font-size-19">Listado de Servicios del Cliente</div>
                    </div>
                </div>
                <div class="form-group mx-5 mt-5 d-flex bg-light w-50 justify-content-between">
                    <div class="form-group mx-1 mt-3 d-flex bg-light">
                        <span class="p-2 mx-4 text-black-50 font-size-19"> Servicio </span>
                        <span class="marginl2 p-2 text-black-50 font-size-19">Precio</span>
                        <span class="text-light">Editar</span>
                        <span class="text-light">Eliminar</span>
                    </div>
                </div>
                @if($clienteServicios->count() > 0)

                    @foreach($clienteServicios as $clienteIte)
                        <div class="d-flex col-row">
                        <form action="{{ route('clienteServicios.editar', ['cliente' => $cliente->cliente_id]) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <span class="visually-hidden"> {{$cont = $cont +1}} </span>
                            <div class="d-flex col-row">
                                    <div class="form-group d-flex flex-row p-3">
                                        <select id="{{$clienteIte->cliente_id+$cont}}" disabled name="usuario_id" class="visually-hidden p-2 form-control">
                                            @foreach($usuarios as $usuario)
                                                <option value="{{ $usuario->usuario_id }}"
                                                @if(old('usuario_id', $usuario->usuario_id)
                                                    == $usuario->usuario_id) @endif>{{$usuario->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                {{--es el servicio--}}
                                <div class="d-flex col-row">

                                    <select id="{{$clienteIte->cliente_id+300+$cont}}" name="etiqueta_id" class="p-2 m-3 form-control my-3">
                                        @foreach($etiquetas as $etiqueta)
                                            <option value="{{ $etiqueta->etiqueta_id }}" @if(old('etiqueta_id', $clienteIte->etiqueta_id) == $etiqueta->etiqueta_id) selected @endif>{{ $etiqueta->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="{{$clienteIte->cliente_id+600+$cont}}"  name="cliente_id"
                                           value="{{ old('cliente_id', $clienteIte->cliente_id) }}">

                                    <input type="hidden" id="{{$clienteIte->clienteServicio_id+1000}}" name="clienteServicio_id"
                                           value="{{$clienteIte->clienteServicio_id}}"
                                    >
                                </div>
                                <div class="d-flex col-row">
                                    <input type="number" min="1" required id="{{$clienteIte->cliente_id+$cont+2000}}" name="precio" class="form-control p-2 m-3 @error('precio') is-invalid @enderror"
                                       value="{{ old('precio', $clienteIte->precio) }}"
                                       @error('precio') aria-describedby="error-precio"
                                    @enderror>
                                    @error('precio')
                                    <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                                    @enderror

                                </div>
                               <button class="btn btn-block h-25 my-3 color-check"><ion-icon name="checkmark-outline"></ion-icon>
                               </button>
                            </div>
                        </form>

                            <button type="button" class="btn btn-block p-0 btn-danger h-25 my-4" data-toggle="modal"
                                    data-target="#myModal{{$clienteIte->etiqueta_id, $cliente->cliente_id}}">
                                <ion-icon name="trash-outline"></ion-icon></button>

                            <div class="tooltip top">Posa el ratón encima de mi
                                <span class="tiptext">Texto del tooltip</span>
                            </div>
                </div>
                        <!-- The Modal -->
                        <div class="modal" id="myModal{{$clienteIte->etiqueta_id, $cliente->cliente_id}}">
                            <div class="modal-dialog">
                                <div class="modal-content bg-light">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h3 class="modal-title">Atención</h3>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Seguro que deseas eliminar la categoria definitivamente?
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <form action="{{ route('clienteServicios.eliminar', ['etiqueta' =>
                                                        $clienteIte->etiqueta_id, 'cliente' =>
                                                        $clienteIte->cliente_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>

            {{-- =============================================== etiqueta (servicio) nuevo ==================================--}}
                    <div class="container-fluid d-flex">
                        <div class="container d-flex flex-column text-center bg-light p-3">
                            <div class="fs-3 text-secondary font-size-19 text-md-start text-black-50">Desde este panel podés agregar servicios</div>
                        </div>
                    </div>
        <div class="container">
            @foreach($etiquetas as $etiqueta)
                <form action="{{route('clienteServicios.agregar')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <span class="visually-hidden"> {{$cont = $cont +3}} </span>
                    <div class="d-flex w-25 align-items-center">
                        <input type="hidden" id="{{ $etiqueta->etiqueta_id +$cont+ 5000}}" class="col-4" name="etiqueta_id"
                        value=" {{ $etiqueta->etiqueta_id }}">

                        <input type="text" id="{{$etiqueta->etiqueta_id+$cont+3500}}" value="{{$etiqueta->nombre}}"
                               class="col-auto form-control m-2 col-4">
                        <input type="number" placeholder="Ingresá el precio" min="1"
                               id="{{$etiqueta->etiqueta_id+$cont+6500}}"
                               name="precio" class="col-auto form-control m-2 col-4"
                               required>
                        @foreach($usuarios as $usuario)
                        <input type="hidden" id="{{$usuario->usuario_id+$cont+5500}}"  name="usuario_id"
                           value="{{ old('usuario_id', $usuario->usuario_id) }}">
                        @endforeach
                        <input type="hidden" id="{{$usuario->usuario_id+$cont+7500}}"  name="cliente_id"
                           value="{{ old('cliente_id', $cliente->cliente_id) }}">

                        <span title="Agregar" style="font-size: x-large;">
                          <button class="btn btn-success col-auto m-2"><ion-icon class="pointer-events" name="add-circle-outline"></ion-icon></button>
                        </span>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
    </div>
@endsection
