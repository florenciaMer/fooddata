<?php
/** @var \App\Models\Receta[]|Illuminate\Database\Eloquent\Collection $recetas */
/** @var \App\Models\RecetaItem[]|Illuminate\Database\Eloquent\Collection $recetaItem */
/** @var \App\Models\Ingrediente[]|Illuminate\Database\Eloquent\Collection $ingrediente */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var $total */
/** @var $recetas */
/** @var $recetaItem */
/** @var array $formParams  */
$total = 0;

?>
@section('title', 'Listado de Recetas')
@extends('layout.main')
@section('main')

    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary ">Panel de Recetas</h1>
    </div>
    <section class="container">
        <p class="text-secondary font-size-19 py-2">Desde este panel podés administrar a las Recetas</p>
         <div class="d-none-sm">
            <p class="font-size-19 fw-bold my-3">Buscador</p>
            <form action="{{route('recetas.index')}}" method="get">
                <div class="form-group mb-3">
                    <label class="visually-hidden"> Receta</label>
                    <input type="text" name="nombre"  placeholder="Nombre de la Receta" value="{{old('nombre',$formParams['nombre'])  ??null}}"
                           class="form-control">

                    @error('nombreFind') is-invalid
                    @enderror
                    @error('nombreFind') aria-describedby="error-nombreFind"
                    @enderror
                    @error('nombreFind')
                    <div class="alert alert-danger" id="error-nombreFind">{{ $message }}
                    </div>
                    @enderror
                    @error('nombreFindVacio')
                    @enderror
                    @error('nombreFindVacio')
                    @enderror
                    @error('nombreFindVacio')
                    <div class="alert alert-danger" id="error-nombreFindVacio">{{ $message }}
                    </div>
                    @enderror
                </div>
                <button class="btn-primary" type="submit">Buscar</button>
            </form>
        </div>
        <div class="container-fluid d-flex">
            <table class="table table-hover table-prod">
                <thead>
                <tr>
                    <th class="d-none-mobile"># id</th>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Costo sin imp</th>
                    <th class="d-none-mobile">Base</th>

                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($recetas as $receta)
                    <tr>
                        <td class="col-sm-1 d-none-mobile">
                            <div class="visually-hidden">{{$total = 0}}</div>
                            {{$receta->receta_id}}
                        </td>
                        <td class="col-sm">
                            {{$receta->tipos->nombre}}
                        </td>
                        <td class="col-sm">
                            {{$receta->nombre}}
                        </td>
                        <td class="col-sm">
                            @foreach($receta->recetaItem as $recetaIte)
                                <div class="visually-hidden">{{$total = $total + $recetaIte->ingrediente->precio/100 * $recetaIte->cant}} </div>
                            @endforeach
                                $ {{$total/$receta->base}}.-
                         </td>
                        <td class="col-sm-1 d-none-mobile">
                             {{$receta->base}}
                        </td>
                        <td>
                            <a class="btn btn-success" title="Editar" href="{{ route('recetas.editarForm', ['receta' => $receta->receta_id]) }}"><ion-icon class="pointer-events" name="pencil-outline"></ion-icon></a>
                        </td>
                        <td>
                            <button type="button" title="Eliminar" class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$receta->receta_id}}"><ion-icon name="trash-outline"></ion-icon></button>
                            <!--  Modal -->
                            <div class="modal" id="myModal{{$receta->receta_id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h2 class="modal-title">Atención</h2>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Seguro que deseas eliminar el receta definitivamente?
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <form action="{{ route('recetas.eliminar', ['receta' => $receta->receta_id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>


        </div>
        <div class="text-end">
            <a class="navbar-brand float1 my-float" href="<?= url('/recetas/nuevo')?>">
            <span>+</span>
            </a>
        </div>
        {{$recetas->links()}}
    </section>

@endsection



