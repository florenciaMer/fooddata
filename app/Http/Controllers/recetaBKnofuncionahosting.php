{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php

/** @var \App\Models\Usuario $usuarios */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Unidad[] $unidades */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Categoria[] $categorias */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\RecetaItem[] $recetaItems */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Tipo[] $tipos */
/** @var \App\Models\Usuario $usuarios */
/**@var \App\Models\Ingrediente $ingrediente  */
/**@var \App\Models\Ingrediente $ingredientes  */
/** @var \App\Models\Unidad $unidad */
/** @var \App\Models\Categoria $categoria */
/** $total */
$total = 0;
$cont = 0;
$total_add = 0;
$i=0;
$constant = 'http://localhost:81/tesis/prueba/';

/** @var \App\Models\Ingrediente[]|Illuminate\Database\Eloquent\Collection $ingredientes */
/** @var \App\Models\Ingrediente[]|Illuminate\Database\Eloquent\Collection $ingredienteEncontrado */
/** @var $ingrediente */
/** @var array $formParams  */
/** @var \App\Models\Usuario $usuario */

?>


@section('title', 'Editar Receta')
@extends('layout.main')
@section('main')
<div class="container my-4 w-90porc-mobile margin-0-mobile">
    <div class="contenedor100 azulOscuro">
        <p class="text-white m-0 fs-4">Editar Receta<p>
    </div>
    <h2 class="text-secondary font-size-19 py-3 text-center">Desde este panel podes editar las Recetas</h2>

    <form action="{{ route('recetas.editarCabecera', ['receta' => $receta->receta_id]) }}" method="post"
          enctype="multipart/form-data" class="d-flex flex-column">
        @csrf
        @method('PUT')
        <div class="card w-50 mobile-width-100porc  m-auto">
            {{--                <img src="..." class="card-img-top" alt="...">--}}
            <div class="card-body">
                <label for="nombre" class="d-none">Receta</label>
                <input type="text" id="nombre"  required name="nombre" class="bg-input-celeste text-center form-control fw-bold bg-light @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $receta->nombre) }}"
                       @error('nombre') aria-describedby="error-nombre"
                @enderror>
                @error('nombre')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <div class="card-body">
                <div class="d-flex flex-row">
                    <input type="text" id="lbl" value="Porciones" disabled class="form-control">
                    <input type="number" step="0.01"  min="0.1" id="base"  required name="base" class="text-center form-control fw-bold bg-light @error('base') is-invalid @enderror"
                           value="{{ old('base', $receta->base) }}"
                           @error('base') aria-describedby="error-base"
                    @enderror>
                    @error('base')
                    <div class="alert alert-danger" id="error-base">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row">
                    <label for="tipo_id" class="visually-hidden my-2">Tipo</label>
                    <select id="tipo_id" name="tipo_id" class="form-control">
                        @foreach($tipos as $tipo)
                        <option value="{{$tipo->tipo_id}}"
                                @if(old('tipo_id', $receta->tipo_id) ==
                        $tipo->tipo_id) selected
                        @endif>{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body pbottom-0">
                <div class="d-flex flex-row">
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror">{{old('descripcion', $receta->descripcion)}}
                    </textarea>
                </div>
            </div>
            <div class="bg-check w-95 my-1 text-center m-auto rounded-1">
                <button title="Editar datos" class="text-white bg-check btn btn-block float-md-left">Modificar datos
                </button>
            </div>
        </div>
    </form>
    <div class="card-body">
        @if($receta->recetaItem()->count() > 0)
        <div class="form-group mx-1 mt-3 d-flex bg-light justify-content-between d-none-mobile">
            <span class= "d-none-mobile m-auto fs-6 py-2 align-items-md-start text-md-start text-black-50 font-size-19"> Usuario </span>
            <span class="m-auto fs-6 py-2 align-items-md-start text-md-start text-black-50 font-size-19">Ingrediente</span>
            <span class="m-auto fs-6 text-black-50 font-size-19">U-Med</span>
            <span class="m-auto fs-6 py-2 align-items-md-start text-md-start text-black-50 font-size-19">Cantidad</span>
            <span class="d-none-mobile m-auto fs-6 py-2 align-items-md-end text-md-start text-black-50 font-size-19">Costo</span>
            <span class="d-none-mobile m-auto fs-6 py-2 align-items-md-start text-md-start text-black-50 font-size-19">Costo total</span>
            <span class="visibility-hidden text-black-50 font-size-19 fs-6 py-2 align-items-md-start text-md-start">Editar</span>
            <span class="visibility-hidden text-black-50 font-size-19 fs-6 py-2 align-items-md-start text-md-start">Eliminar</span>
        </div>
        <p class="p-2 m-2 bg-light pc-d-none fw-bold text-center">Ingredientes cargados</p>

        @foreach($receta->recetaItem as $i => $recetaIte)
        {{--       @foreach($receta->recetaItem as $recetaIte)--}}
        <div class="d-flex flex-column">
            <div class="d-flex flex-row">
                <form action="{{ route('recetasItems.editar', ['receta' => $receta->receta_id]) }}" method="post"
                      class="d-flex flex-row w-100 flex-column-mobile">
                    @csrf
                    @method('PUT')
                    <span class="visually-hidden"> {{$cont = $cont +1}} </span>
                    <div class="form-group m-2">
                        {{--                    <select id="usuario_id{{$recetaIte->usuario_id + $cont}}" disabled name="usuario_id" class="p-2 form-control">--}}
                            <input type="text" id="usuario_id{{$recetaIte->recetaItem_id}}" disabled
                                   name="usuario_id" class="form-control d-none-mobile"
                                   value="{{ old('usuario_id', $recetaIte->usuario->nombre) }}">
                    </div>
                    <input type="hidden" id="recetaItem_id_{{$recetaIte->recetaItem_id}}" name="recetaItem_id"
                           value="{{$recetaIte->recetaItem_id}}"
                    >
                    <input type="hidden" id="ingrediente_ant{{$recetaIte->ingrediente_id}}" name="ingrediente_ant"
                           value="{{$recetaIte->ingrediente->nombre}}"
                    >
                    {{-- *************      select ingredientes para dinamico--}}

                    <div class="form-group m-2">
                        <label for="ingrediente_id{{$i}}" class="visually-hidden">Ingrediente</label>
                        <select id="ingrediente_id{{$i}}"
                                data-id="{{$i}}" name="ingrediente_id"
                                class="ingSelect p-2 form-control">
                            @foreach($ingredientes as $ingrediente)
                            <option value="{{ $ingrediente->ingrediente_id }}" @if(old('ingrediente_id', $recetaIte->ingrediente->ingrediente_id) == $ingrediente->ingrediente_id) selected @endif>{{ $ingrediente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group m-2">
                        <input type="hidden" id="recetaItem_id{{$recetaIte->recetaItem_id}}" disabled
                               name="recetaItem_id" class="form-control"
                               value="{{ old('recetaItem_id', $recetaIte->recetaItem_id) }}">

                        <label for="unidad_id{{$i}}" class="visually-hidden"></label>
                        <input type="text" id="unidad_id{{$i}}" disabled name="unidad_id"
                               class="form-control @error('unidad_id') is-invalid @enderror"
                               value="{{ old('unidad_id', $recetaIte->ingrediente->unidad->nombre) }}"
                               @error('unidad_id') aria-describedby="error-unidad_id"
                        @enderror>
                        @error('unidad_id')
                        <div class="alert alert-danger" id="error-unidad_id">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group m-2">
                        <label for="cant{{$i}}" class="visually-hidden">Cant</label>
                        <input type="number" min="0.1" step="0.01"  required id="cant{{$i}}" name="cant" class="cantFirst form-control p-2 text-center @error('cant') is-invalid @enderror"
                               data-id="{{$i}}" value="{{ old('cant', $recetaIte->cant) }}"
                               @error('cant') aria-describedby="error-cant"
                        @enderror>
                        @error('cant')
                        <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group m-2 d-none-mobile">
                        <label for="precio{{$i}}" class="visually-hidden">Precio U.</label>
                        <input type="text" disabled id=precio{{$i}} name="precio" class="form-control text-center p-2 @error('precio') is-invalid @enderror"
                               value="{{ old('precio', $recetaIte->ingrediente->precio/100) }}.-"
                               @error('precio') aria-describedby="error-precio"
                        @enderror>
                        @error('precio')
                        <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group m-2 d-none-mobile">
                        <label for="precioTot{{$i}}" class="visually-hidden">Costo total</label>
                        <input type="text" disabled id="precioTot{{$i}}" name="precio" class="form-control text-center p-2 @error('precio') is-invalid @enderror"
                               value="{{ old('precio', $recetaIte->ingrediente->precio/100 * $recetaIte->cant) }}.-"
                               @error('precio') aria-describedby="error-precio"
                        @enderror>
                        @error('impuesto')
                        <div class="alert alert-danger" id="error-impuesto">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="visually-hidden d-none-mobile">{{$total = $total + $recetaIte->ingrediente->precio/100 * $recetaIte->cant}}</div>
                    <button title="Confirmar" class="btn btn-block btn-success mx-2 my-1"><ion-icon class="pointer-events" name="pencil-outline"></ion-icon></button>
                </form>
                <button title="Eliminar" type="button" class="d-none-mobile btn
                  btn-block btn-danger my-1" data-toggle="modal"
                        data-target="#myModal{{$recetaIte->ingrediente->ingrediente_id, $receta->receta_id}}"><ion-icon class="pointer-events" name="trash-outline"></ion-icon></button>
                <!-- The Modal -->
                <div class="modal" id="myModal{{$recetaIte->ingrediente_id, $receta->receta_id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h3 class="modal-title">Atención</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                Seguro que deseas eliminar el ingrediente definitivamente?
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Cancelar
                                </button>
                                <form action="{{ route('recetasItems.eliminar', ['ingrediente' =>
                                $recetaIte->ingrediente_id, 'receta' =>
                                $receta->receta_id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--             boton eliminar mobile--}}
            <div class="pc-d-none">
                <button title="Eliminar" type="button" class="w-95 btn btn-block btn-danger mx-2 my-2 d-block-mobile"
                        data-toggle="modal"
                        data-target="#myModal{{$recetaIte->ingrediente->ingrediente_id, $receta->receta_id}}">
                    <ion-icon class="pointer-events" name="trash-outline"></ion-icon></button>
                <!-- The Modal -->
                <div class="modal" id="myModal{{$recetaIte->ingrediente_id, $receta->receta_id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h3 class="modal-title">Atención</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                Seguro que deseas eliminar el ingrediente definitivamente?
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Cancelar
                                </button>
                                <form action="{{ route('recetasItems.eliminar', ['ingrediente' =>
                                $recetaIte->ingrediente_id, 'receta' =>
                                $receta->receta_id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <form action="{{route('recetasItems.agregar')}}" method="post"  class="d-none-mobile mobile-mleft-14px d-flex flex-row" enctype="multipart/form-data">
                @csrf

                <span class="visually-hidden"> {{$cont = $cont +1}} </span>
                <div class="form-group m-2 d-none-mobile">
                    <input type="text" id="usuario_id_add{{auth()->user()->usuario_id}}" disabled
                           name="usuario_id" class="form-control"
                           value="{{ old('usuario_id',auth()->user()->nombre)}}">
                </div>
                <input type="hidden" id="receta_id" name="receta_id" value=" {{ $recetaIte->receta_id }}">
                {{-- ******************      select ingredientes para dinamico--}}
                <div class="form-group m-2">
                    <label for="ingrediente_id__{{$i}}"  class="visually-hidden m-2">Ingrediente</label>
                    <select id="ingrediente_id__{{$i}}"
                            data-id="{{$i}}" name="ingrediente_id"
                            class="ingSelectAdd p-2 form-control">
                        @foreach($ingredientes as $ingrediente)
                        <option value="{{ $ingrediente->ingrediente_id }}" @if(old('ingrediente_id', $recetaIte->ingrediente->ingrediente_id) == $ingrediente->ingrediente_id) selected @endif>{{ $ingrediente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group m-2">
                    <label for="unidad_id_add{{$i}}" class="visually-hidden"></label>
                    <input type="text" id="unidad_id_add{{$i}}" disabled name="unidad_id"
                           class="form-control @error('unidad_id') is-invalid @enderror"

                           @error('unidad_id') aria-describedby="error-unidad_id"
                    @enderror>
                    @error('unidad_id')

                    <div class="alert alert-danger" id="error-unidad_id">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group m-2">
                    <label for="cant_add{{$i}}" class="visually-hidden">Cant</label>
                    <input type="number" min="0.1" step="0.01"  required id="cant_add{{$i}}" name="cant_add" class="inputCantAdd form-control p-2 text-center @error('cant') is-invalid @enderror"
                           data-id="{{$i}}"
                           @error('cant') aria-describedby="error-cant"
                    @enderror>
                    @error('cant')
                    <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group m-2 d-none-mobile">
                    <label for="precio_add{{$i}}" class="visually-hidden">Precio U.</label>
                    <input type="text" disabled id="precio_add{{$i}}" name="precio"
                           class="form-control text-center p-2 @error('precio') is-invalid @enderror"
                           value="{{ old('precio', $recetaIte->ingrediente->precio/100) }}"
                           @error('precio') aria-describedby="error-precio"
                    @enderror>
                    @error('precio')
                    <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group m-2 d-none-mobile">
                    <label for="precioTot_add{{$i}}" class="visually-hidden">Costo total</label>
                    <input type="text" disabled id="precioTot_add{{$i}}" name="precio" class="form-control text-center p-2 @error('precio') is-invalid @enderror"
                           value="{{ old('precio', $recetaIte->ingrediente->precio/100 * $recetaIte->cant) }}.-"
                           @error('precio') aria-describedby="error-precio"
                    @enderror>
                    @error('impuesto')
                    <div class="alert alert-danger" id="error-impuesto">{{ $message }}</div>
                    @enderror
                </div>
                <div class="visually-hidden">{{$total_add = $total_add + $recetaIte->ingrediente->precio/100 * $recetaIte->cant}}</div>

                <button title="Agregar" class="btn btn-block btn-success mx-2 my-1"><ion-icon class="pointer-events" name="add-circle-outline"></ion-icon></button>
                <button type="button" class="btn btn-block btn-danger my-1 bg-transparent disabled border-0 " data-toggle="modal"
                        data-target="#myModal{{$recetaIte->ingrediente->ingrediente_id, $receta->receta_id}}"><ion-icon name="trash-outline"></ion-icon></button>

            </form>


            {{--             agregar mobile--}}
            <p class="p-2 m-2 bg-light pc-d-none fw-bold text-center">Agregar Ingrediente</p>
            <form action="{{route('recetasItems.agregar')}}" method="post"
                  class="d-none-mobile mobile-mleft-14px d-flex d-none-mobile flex-column pc-d-none flex-row" enctype="multipart/form-data">
                @csrf

                <span class="visually-hidden"> {{$cont = $cont +1}} </span>
                <div class="form-group m-2 d-none-mobile">
                    <input type="text" id="usuario_id_add{{auth()->user()->usuario_id}}" disabled
                           name="usuario_id" class="form-control"
                           value="{{ old('usuario_id',auth()->user()->nombre)}}">
                </div>
                <input type="hidden" id="receta_id" name="receta_id" value=" {{ $recetaIte->receta_id }}">
                {{-- ******************      select ingredientes para dinamico--}}
                <div class="form-group m-2">
                    <label for="ingrediente_id__{{$i}}"  class="visually-hidden m-2">Ingrediente</label>
                    <select id="ingrediente_id__{{$i}}"
                            data-id="{{$i}}" name="ingrediente_id"
                            class="ingSelectAddMas p-2 form-control">
                        @foreach($ingredientes as $ingrediente)
                        <option value="{{ $ingrediente->ingrediente_id }}" @if(old('ingrediente_id', $recetaIte->ingrediente->ingrediente_id) == $ingrediente->ingrediente_id) selected @endif>{{ $ingrediente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                {{--                            ****************************************--}}
                <div class="form-group m-2">
                    <label for="unidad_id_addMobile" class="visually-hidden"></label>
                    <input type="text" id="unidad_id_addMobile" disabled name="unidad_id"
                           class="form-control @error('unidad_id') is-invalid @enderror"

                           @error('unidad_id') aria-describedby="error-unidad_id"
                    @enderror>
                    @error('unidad_id')

                    <div class="alert alert-danger" id="error-unidad_id">{{ $message }}</div>
                    @enderror
                </div>
                {{--                            ******************************--}}
                <div class="form-group m-2">
                    <label for="cant_add{{$i}}" class="visually-hidden">Cant</label>
                    <input type="number" min="0.1" step="0.01"  required id="cant_add{{$i}}" name="cant_add" class="inputCantAdd form-control p-2 text-center @error('cant') is-invalid @enderror"
                           data-id="{{$i}}"
                           @error('cant') aria-describedby="error-cant"
                    @enderror>
                    @error('cant')
                    <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group m-2 d-none-mobile">
                    <label for="precio_add{{$i}}" class="visually-hidden">Precio U.</label>
                    <input type="text" disabled id="precio_add{{$i}}" name="precio"
                           class="form-control text-center p-2 @error('precio') is-invalid @enderror"
                           value="{{ old('precio', $recetaIte->ingrediente->precio/100) }}"
                           @error('precio') aria-describedby="error-precio"
                    @enderror>
                    @error('precio')
                    <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group m-2 d-none-mobile">
                    <label for="precioTot_add{{$i}}" class="visually-hidden">Costo total</label>
                    <input type="text" disabled id="precioTot_add{{$i}}" name="precio" class="form-control text-center p-2 @error('precio') is-invalid @enderror"
                           value="{{ old('precio', $recetaIte->ingrediente->precio/100 * $recetaIte->cant) }}.-"
                           @error('precio') aria-describedby="error-precio"
                    @enderror>
                    @error('impuesto')
                    <div class="alert alert-danger" id="error-impuesto">{{ $message }}</div>
                    @enderror
                </div>
                <div class="visually-hidden">{{$total_add = $total_add + $recetaIte->ingrediente->precio/100 * $recetaIte->cant}}</div>

                <button title="Agregar" class="w-95 btn btn-block btn-success mx-2 my-2 d-block-mobile""><ion-icon class="pointer-events" name="add-circle-outline"></ion-icon></button>
                <button type="button" class="btn btn-block btn-danger my-1 bg-transparent disabled border-0" data-toggle="modal"
                        data-target="#myModal{{$recetaIte->ingrediente->ingrediente_id, $receta->receta_id}}"><ion-icon name="trash-outline"></ion-icon></button>

            </form>
        </div>
        <div class="card-body">
            <div class="total">
                <div class="d-flex flex-row">
                    <label class="d-flex form-control text-center" for="total1">Costo Unitario</label>
                    <div class="visually-hidden">{{$total_add}} </div>
                    <input id="total1" name="total1"  class="text-center" disabled type="text" value="${{number_format($total/$receta->base,2)}}.-">
                </div>
            </div>
        </div>
    </div>
</div>

@endif
@if($receta->recetaItem()->count() == 0)
{{--    si no hay ingredientes aun--}}
<div class="form-group mx-1 mt-3 d-flex bg-light mx-2">
    <span class="p-2 text-black-50 font-size-19">Usuario</span>
    <span class="marginl2 p-2 text-black-50 font-size-19">Ingrediente</span>
    <span class="marginl8 fs-6 p-2 align-items-md-start text-md-start text-black-50 font-size-19">U-med</span>
    <span class="marginl12 fs-6 p-2 align-items-md-start text-md-start text-black-50 font-size-19">Cantidad</span>

    <span class="text-light">Editar</span>
    <span class="text-light">Eliminar</span>
</div>

<form action="{{route('recetasItems.agregar')}}" method="post"  class="d-flex flex-row m-auto " enctype="multipart/form-data">
    @csrf
    <span class="visually-hidden"> {{$cont = $cont +1}}> </span>
    <div class="form-group p-2">
        <select id="usuario_id_Add{{auth()->user()->usuario_id}}" disabled name="usuario_id" class=" p-2 form-control">
            <option value="{{auth()->user()->nombre}}">{{auth()->user()->nombre}}</option>
        </select>
    </div>
    <input type="hidden" id="receta_id" name="receta_id" value=" {{ $receta->receta_id }}">
    {{--       select ingredientes para dinamico--}}
    <div class="form-group m-2">


        {{--        ACA EL SELECT DEL ALTA/--}}
        <label for="ingrediente_id_add" class="visually-hidden m-2">Ingrediente</label>
        <select id="selectIngrediente_id_add"
                name="ingrediente_id"
                class="selectIngrediente_id_add p-2 form-control w-200"
                data-id="{{$i}}">
            @foreach($ingredientes as $ingrediente)
            <option value="{{ $ingrediente->ingrediente_id }}">{{ $ingrediente->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group m-2 d-none-mobile">
        <label for="unidad_id_add_id_add_add" class="visually-hidden">Unidad problema</label>
        <input type="text" id="unidad_id_add_id_add" disabled name="unidad_id"
               class="form-control @error('unidad_id') is-invalid @enderror"
               @error('unidad_id') aria-describedby="error-unidad_id"
        @enderror>
        @error('unidad_id')

        <div class="alert alert-danger" id="error-unidad_id">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group m-2">
        <label for="cant_add" class="visually-hidden">Cant</label>
        <input type="number" min="0.1" step="0.01"  required id="cant_add" name="cant_add" class="form-control p-2 text-center @error('cant')
                    is-invalid @enderror"
               @error('cant') aria-describedby="error-cant"
        @enderror>
        @error('cant')
        <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
        @enderror
    </div>
    <button class="btn btn-block btn-success mx-2 my-1"><ion-icon name="add-circle-outline"></ion-icon></button>
</form>
<div class="card-body">
    <div class="total">
        <div class="d-flex flex-row">
            <label class="d-flex form-control text-center text-light bg-dark" for="total1">Costo Unitario</label>
            <div class="visually-hidden">{{number_format($total_add,2)}}</div>
            <input id="total1" name="total1"  class="text-center bg-dark text-light" disabled type="text" value="${{number_format($$total/$receta->base,2)}}.-">
        </div>
    </div>
</div>
@endif
</div>


<script>
    window.addEventListener('DOMContentLoaded', function() {
        const ingSelect = document.querySelectorAll('.ingSelect');
        ingSelect.forEach(elem => (
            elem.addEventListener('change', function () {

                const id = this.dataset.id;
                const unidadInput = document.getElementById('unidad_id' + id);
                const xhr = new XMLHttpRequest();

                xhr.open('GET', '/combos/generar_combo_unidades.php?i=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            unidadInput.value = xhr.responseText;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
        const ingSelect2 = document.querySelectorAll('.ingSelect');
        ingSelect2.forEach(elem => (
            elem.addEventListener('change', function () {

                const id = this.dataset.id;
                const precioInput = document.getElementById('precio' + id);
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/combos/generar_combo_precios.php?ip=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            precioInput.value = xhr.responseText;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
        const ingSelect3 = document.querySelectorAll('.ingSelect');
        ingSelect3.forEach(elem => (
            elem.addEventListener('change', function () {

                const id = this.dataset.id;
                const precioInputTot = document.getElementById('precio' + id);
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/combos/generar_combo_precios.php?ip=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            const tot = xhr.response * document.getElementById('cant' + id).value;
                            console.log(tot);
                            document.getElementById('precioTot' + id).value = '$' + tot;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
// ingrediente nuevo


        const ingSelectAdd = document.querySelectorAll('.ingSelectAdd');
        ingSelectAdd.forEach(elem => (
            elem.addEventListener('change', function () {
                // Instanciamos el objeto XHR.
                const id = this.dataset.id;
                const unidadInput = document.getElementById('unidad_id_add' + id);

                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/combos/generar_combo_unidades.php?i=' + this.value);
                xhr.addEventListener('readystatechange', function () {
                    // Este evento se dispara cada vez que el readyState cambia.
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            unidadInput.value = xhr.responseText;


                            alert(xhr.responseText);
                        }
                    }
                });
                xhr.send(null);
            }))
        )
        const ingSelectAddPrecio = document.querySelectorAll('.ingSelectAdd');
        ingSelectAddPrecio.forEach(elem => (
            elem.addEventListener('change', function () {
                const id = this.dataset.id;
                const precioInput = document.getElementById('precio_add' + id);
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/combos/generar_combo_precios.php?ip=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            precioInput.value = xhr.responseText;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
        const ingSelectAddPrecioTot = document.querySelectorAll('.ingSelectAdd');
        ingSelectAddPrecioTot.forEach(elem => (
            elem.addEventListener('change', function () {
                const id = this.dataset.id;
                const precioInputTot = document.getElementById('precio_add' + id);
                const xhr = new XMLHttpRequest();
                xhr.open('GET', '/combos/generar_combo_precios.php?ip=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            const tot = xhr.response * document.getElementById('cant_add' + id).value;
                            document.getElementById('precioTot_add' + id).value = tot;
                        }
                    }
                });
                xhr.send(null);
            }))
        )

        const inputCantAdd = document.querySelectorAll('.inputCantAdd');
        inputCantAdd.forEach(elem => (
            elem.addEventListener('change', function () {
                const id = this.dataset.id;
                const precioInput = document.getElementById('precio_add' + id).value

                const tot = parseInt(precioInput) * parseInt(document.getElementById('cant_add' + id).value);
                document.getElementById('precioTot_add' + id).value = tot;
            }))
        )

        const inputCantFirst = document.querySelectorAll('.cantFirst');
        inputCantFirst.forEach(elem => (
            elem.addEventListener('change', function () {
                const id = this.dataset.id;
                const precioInputFirst = document.getElementById('precio' + id).value

                const tot = parseInt(precioInputFirst) * parseInt(document.getElementById('cant' + id).value);
                document.getElementById('precioTot' + id).value = tot;
            }))
        )
        // **********************************************
        // ALTA INICIAL = ingrediente_id_add unidad_id_add cant_add


        const ingSelectAddMas1 = document.querySelectorAll('.ingSelectAddMas');
        ingSelectAddMas1.forEach(elem => (
            elem.addEventListener('change', function () {

                const id = this.dataset.id;
                const unidadInputAdd1 = document.getElementById('unidad_id_addMobile');

                const xhr = new XMLHttpRequest();

                xhr.open('GET', '/combos/generar_combo_unidades.php?i=' + this.value);
                xhr.addEventListener('readystatechange', function () {

                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            unidadInputAdd1.value = xhr.responseText;
                        }
                    }
                });
                xhr.send(null);
            }))
        )
    })

</script>

@endsection
