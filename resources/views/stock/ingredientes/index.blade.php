<?php
/** @var \App\Models\Ingrediente[]|Illuminate\Database\Eloquent\Collection $ingredientes
 */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */

/** @var $ingrediente */
/** @var array $formParams  */
?>
@section('title', 'Listado de ingredientes')
@extends('layout.main')
@section('main')
    <div class="d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary">Panel de Ingredientes</h1>
    </div>
    <div class="container">
        <p class="text-secondary font-size-19 py-2">Desde este panel podés administrar a los Ingredientes</p>
         <div class="d-none-sm">
            <p class="font-size-19 fw-bold my-3">Buscador</p>
            <form action="{{route('ingredientes.index')}}" method="get">
                <div class="form-group mb-3">
                    <label class="visually-hidden"> Ingrediente</label>
                    <input type="text" name="nombre"  placeholder="Nombre del Ingrediente" value="{{old('nombre',$formParams['nombre'])  ??null}}"
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
                    <th class="d-none-mobile">Categoria</th>
                    <th>Nombre</th>
                    <th>U-Medida</th>
                    <th>Precio</th>
                    <th class="d-none-mobile">Impuesto</th>

                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ingredientes as $ingrediente)
                    <tr>
                        <td class="d-none-mobile">
                            {{$ingrediente->ingrediente_id}}
                        </td>
                        <td class="d-none-mobile">
                            {{$ingrediente->categoria->nombre}}
                        </td>
                        <td>
                            {{$ingrediente->nombre}}
                        </td>
                        <td>
                            {{ $ingrediente->unidad->nombre}}</td>
                        <td>
                            $ {{$ingrediente->precio/100}}.-
                        </td>
                        <td class="d-none-mobile">
                             {{$ingrediente->impuesto}}%
                        </td>

                        <td>

                          <a class="btn btn-success" title="Editar" href="{{ route('ingredientes.editarForm', ['ingrediente' => $ingrediente->ingrediente_id]) }}"><ion-icon class="pointer-events" name="pencil-outline"></ion-icon></a>
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger" title="Eliminar" data-toggle="modal" data-target="#myModal{{$ingrediente->ingrediente_id}}"><ion-icon class="pointer-events" name="trash-outline"></ion-icon></button>
                            <!--  Modal -->
                            <div class="modal" id="myModal{{$ingrediente->ingrediente_id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h2 class="modal-title">Atención</h2>
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
                                            <form action="{{ route('ingredientes.eliminar', ['ingrediente' => $ingrediente->ingrediente_id]) }}" method="POST">
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
            <div class="text-end">
                <a class="navbar-brand float1 my-float" href="<?= url('/ingredientes/nuevo')?>">
                    <span>+</span>
                </a>
            </div>
        </div>
            {{$ingredientes->links()}}
    </div>
@endsection



