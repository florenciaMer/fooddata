{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Unidad[] $unidades */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Categoria[] $categorias */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Ingrediente[] $ingrediente */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\RecetaItem[] $recetaItems */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Tipo[] $tipos */
/** @var \App\Models\Usuario $usuarios */
/** $total
 */
$total = 0;
?>
@section('title', 'Editar Receta')
@extends('layout.main')
@section('main')
    <div class="container">
        <div class="container d-flex flex-column text-center bg-light p-3">
            <h1 class="text-secondary py-2">Editar Receta</h1>
            <h2 class="text-secondary font-size-19">Completá el Formulario</h2>
        </div>
        <div class="card w-50 m-auto">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <label for="nombre" class="d-none">Receta</label>
                <input type="text" id="nombre" name="nombre" class="text-center form-control fw-bold bg-light @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $receta->nombre) }}"
                       @error('nombre') aria-describedby="error-nombre"
                    @enderror>
                @error('nombre')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <div class="card-body">
                <div class="d-flex flex-row">
                    <input type="text" value="Base" disabled class="form-control">
                    <input type="text" id="base" name="base" class="form-control @error('base') is-invalid
                                @enderror"
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
                            <option value="{{ $tipo->tipo_id }}"
                                    @if(old('tipo_id', $receta->tipo_id) ==
                                    $tipo->tipo_id) selected
                                @endif>{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row">
                    <label for="descripcion" class="visually-hidden">Descripción</label>
                    <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror">{{old('descripcion', $receta->descripcion)}}
                        @error('descripcion') aria-describedby="error-descripcion"
                              @enderror
                        @error('base')
                              <div class="alert alert-danger" id="error-base">{{ $message }}</div>
                              @enderror
                        </textarea>

                    @error('descripcion')
                    <div class="alert alert-danger" id="error-descripcion">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                @if($receta->recetaItem()->count() > 0)
                    <tr>
                        <th>Usuario</th>
                        <th>Ingrediente</th>
                        <th>U-Med</th>
                        <th>Cant</th>
                        <th>Costo Unit</th>
                        <th>Costo Total</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    @foreach($receta->recetaItem as $recetaIte)

                        <form action="{{ route('recetasItems.editar', ['receta' => $receta->receta_id]) }}" method="post"
                        >
                            @csrf
                            @method('PUT')
                            <td>
                                <div class="form-group">
                                    <label for="usuario_id" class="visually-hidden my-2">Usuario</label>
                                    <select id="usuario_id" disabled name="usuario_id" class="p-2 form-control">
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->usuario_id }}" @if(old('usuario_id', $recetaIte->usuario->usuario_id) == $usuario->usuario_id) selected @endif>{{$usuario->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <input type="hidden" id="ingrediente_ant" name="ingrediente_ant"
                                       value="{{$recetaIte->ingrediente->ingrediente_id}}"
                                >
                                <div class="form-group">
                                    <label for="ingrediente_id" class="visually-hidden my-2">Ingrediente</label>
                                    <select id="ingrediente_id" name="ingrediente_id" class="p-2 form-control">
                                        @foreach($ingredientes as $ingrediente)
                                            <option value="{{ $ingrediente->ingrediente_id }}" @if(old('ingrediente_id', $recetaIte->ingrediente->ingrediente_id) == $ingrediente->ingrediente_id) selected @endif>{{ $ingrediente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="unidad_id" class="visually-hidden">Cant</label>
                                    <input type="text" id="unidad_id" disabled name="unidad_id" class="form-control p-2 @error('unidad_id') is-invalid @enderror"
                                           value="{{ old('unidad_id', $recetaIte->ingrediente->unidad->nombre) }}"
                                           @error('unidad_id') aria-describedby="error-unidad_id"
                                        @enderror>
                                    @error('unidad_id')
                                    <div class="alert alert-danger" id="error-unidad_id">{{ $message }}</div>
                                    @enderror
                                </div>
                            </td>

                            {{--                                <td>{{$recetaIte->ingrediente->unidad->nombre}}</td>--}}
                            <td>
                                <div class="form-group">
                                    <label for="cant" class="visually-hidden">Cant</label>
                                    <input type="text" id="cant" name="cant" class="form-control p-2 @error('cant') is-invalid @enderror"
                                           value="{{ old('cant', $recetaIte->cant) }}"
                                           @error('cant') aria-describedby="error-cant"
                                        @enderror>
                                    @error('cant')
                                    <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
                                    @enderror
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="cant" class="visually-hidden">Precio U.</label>
                                    <input type="text" disabled id="precio" name="precio" class="form-control p-2 @error('precio') is-invalid @enderror"
                                           value="$ {{ old('precio', $recetaIte->ingrediente->precio/100) }}.-"
                                           @error('precio') aria-describedby="error-precio"
                                        @enderror>
                                    @error('precio')
                                    <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                                    @enderror
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="impuesto" class="visually-hidden">Impuesto</label>
                                    <input type="text" disabled id="impuesto" name="impuesto" class="form-control p-2 @error('impuesto') is-invalid @enderror"
                                           value=" $ {{ old('impuesto', $recetaIte->ingrediente->precio/100 * $recetaIte->cant) }}.-"
                                           @error('impuesto') aria-describedby="error-impuesto"
                                        @enderror>
                                    @error('impuesto')
                                    <div class="alert alert-danger" id="error-impuesto">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="visually-hidden">{{$total = $total + $recetaIte->ingrediente->precio/100 * $recetaIte->cant}}</div>
                            </td>
                            <td><button class="btn btn-block btn-primary"><ion-icon name="pencil-outline"></ion-icon></button></td>
                        </form>


                        <td class="col-sm-2">
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#myModal{{$recetaIte->ingrediente->ingrediente_id, $receta->receta_id}}"><ion-icon name="trash-outline"></ion-icon></button>
                        </td>
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
                                        Seguro que deseas eliminar la categoria definitivamente?
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

                        </td>

                        </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>


{{--   nuevo form de alta--}}

            <div class="card-body">
                <table class="table table-striped">
                        <form action="{{ route('recetasItems.nuevo', ['receta' => $receta->receta_id]) }}" method="post"
                            >
                                @csrf
                            <td>
                                <div class="form-group">
                                    <label for="usuario_id" class="visually-hidden my-2">Usuario</label>
                                    <select id="usuario_id" disabled name="usuario_id" class="p-2 form-control">
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ auth()->user()->usuario_id}}" @if(old('usuario_id', auth()->user()->usuario_id)) selected @endif>{{$usuario->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                                <td>
                                    <input type="hidden" id="ingrediente_ant" name="ingrediente_ant"
                                           value="{{$recetaIte->ingrediente->ingrediente_id}}"
                                    >
                                    <div class="form-group">
                                        <label for="ingrediente_id" class="visually-hidden my-2">Ingrediente</label>
                                        <select id="ingrediente_id" name="ingrediente_id" class="p-2 form-control">
                                            @foreach($ingredientes as $ingrediente)
                                                <option value="{{ $ingrediente->ingrediente_id }}" @if(old('ingrediente_id', $recetaIte->ingrediente->ingrediente_id) == $ingrediente->ingrediente_id) selected @endif>{{ $ingrediente->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="unidad_id" class="visually-hidden">Cant</label>
                                        <input type="text" id="unidad_id" disabled name="unidad_id" class="form-control p-2 @error('unidad_id') is-invalid @enderror"
                                               value="{{ old('unidad_id', $recetaIte->ingrediente->unidad->nombre) }}"
                                               @error('unidad_id') aria-describedby="error-unidad_id"
                                            @enderror>
                                        @error('unidad_id')
                                        <div class="alert alert-danger" id="error-unidad_id">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>

                                {{--                                <td>{{$recetaIte->ingrediente->unidad->nombre}}</td>--}}
                                <td>
                                    <div class="form-group">
                                        <label for="cant" class="visually-hidden">Cant</label>
                                        <input type="text" id="cant" name="cant" class="form-control p-2 @error('cant') is-invalid @enderror"
                                               value="{{ old('cant', $recetaIte->cant) }}"
                                               @error('cant') aria-describedby="error-cant"
                                            @enderror>
                                        @error('cant')
                                        <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="cant" class="visually-hidden">Precio U.</label>
                                        <input type="text" disabled id="precio" name="precio" class="form-control p-2 @error('precio') is-invalid @enderror"
                                               value="$ {{ old('precio', $recetaIte->ingrediente->precio/100) }}.-"
                                               @error('precio') aria-describedby="error-precio"
                                            @enderror>
                                        @error('precio')
                                        <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="impuesto" class="visually-hidden">Impuesto</label>
                                        <input type="text" disabled id="impuesto" name="impuesto" class="form-control p-2 @error('impuesto') is-invalid @enderror"
                                               value=" $ {{ old('impuesto', $recetaIte->ingrediente->precio/100 * $recetaIte->cant) }}.-"
                                               @error('impuesto') aria-describedby="error-impuesto"
                                            @enderror>
                                        @error('impuesto')
                                        <div class="alert alert-danger" id="error-impuesto">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="visually-hidden">{{$total = $total + $recetaIte->ingrediente->precio/100 * $recetaIte->cant}}</div>
                                </td>
                                <td><button class="btn btn-block btn-primary"><ion-icon name="pencil-outline"></ion-icon></button></td>
                            </form>


                            <td class="col-sm-2">
                                <button type="button" disabled class="btn btn-danger" data-toggle="modal"
                                        data-target="#myModal{{$recetaIte->ingrediente->ingrediente_id, $receta->receta_id}}"><ion-icon name="trash-outline"></ion-icon></button>
                            </td>
                            <!-- The Modal -->


                            </tr>

                </table>
{{--                fin nuevo form--}}
            </div>
            <div class="total">
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row">
                        <label class="d-flex form-control flex-row" for="total">Costo total</label>
                        <input id="total"class="text-center" name="total" disabled type="text" value="${{$total/$receta->base}}.-">
                    </div>
                </div>
            </div>
            <div class="text-end">
                <a class="navbar-brand float1 my-float" target="_blank" href="{{ route('recetasItems.nuevo', ['receta' => $receta->receta_id]) }}">
                    <span>+</span>
                </a>
            </div>
        </div>
        {{--                    <input class="card-title">{{$receta->nombre}}>--}}
        {{--                    <input class="card-title">{{$receta->tipo}}>--}}
        {{--                    <input class="card-title">{{$receta->base}}>--}}

        {{--                    <p class="card-text">{{$receta->descripcion}}</p>--}}
        <div class="card-body">
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
        </div>

        <a class="btn m-4 bg-" href="<?= url('/recetas')?>">

            <span><ion-icon name="arrow-back-circle-outline"></ion-icon></span><span class="m-2">Volver </span>
        </a>
    </div>

    </section>
@endsection
