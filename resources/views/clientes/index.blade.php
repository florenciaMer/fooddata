<?php
/** @var \App\Models\Cliente[]|Illuminate\Database\Eloquent\Collection $clientes */
/** @var \App\Models\Condicion[]|Illuminate\Database\Eloquent\Collection $condicion */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */

/** @var $clientes */
/** @var array $formParams  */
?>
@section('title', 'Listado de Clientes')
@extends('layout.main')
@section('main')

    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary ">Panel de Clientes</h1>
    </div>
    <section class="container height480">
        <p class="text-secondary font-size-19 py-2">Desde este panel podés administrar a los clientes</p>
         <div class="d-none-sm">
        </div>
        <div class="container-fluid d-flex">
            <table class="table table-hover table-prod">
                <thead>
                <tr>
                    <th># id</th>
                    <th>Nombre</th>
                    <th  class="d-none-mobile">Nombre Fantasía</th>
                    <th>Dirección</th>
                    <th class="d-none-mobile">IVA</th>

                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td class="col-sm-1">
                            {{$cliente->cliente_id}}</td>
                        <td class="col-sm-3">
                            {{$cliente->nombre}}
                        </td>
                        <td class="col-sm-3 d-none-mobile">
                            {{$cliente->nombreFantasia}}
                        </td>
                        <td class="col-sm-3">
                            {{$cliente->direccion}}
                        </td>
                        <td class="col-sm d-none-mobile">
                            {{$cliente->condicion->nombre}}
                        </td>
                        <td>
                            <span title="Editar" style="font-size: x-large;">
                            <a class="btn btn-success" href="{{ route('clientes.editarForm', ['cliente' => $cliente->cliente_id])}}"><ion-icon class="pointer-events" name="pencil-outline"></ion-icon></a>
                            </span>
                        </td>
                        <td>
                            <span title="Eliminar" style="font-size: x-large;">
                            <button type="button" class="btn btn-danger" aria-pressed="false" data-toggle="modal" data-target="#myModal{{$cliente->cliente_id}}"><ion-icon class="pointer-events" name="trash-outline"></ion-icon></button>
                            </span>
                            <!--  Modal -->
                            <div class="modal" id="myModal{{$cliente->cliente_id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h2 class="modal-title">Atención</h2>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Seguro que deseas eliminar el Cliente definitivamente?
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <form action="{{ route('clientes.eliminar', ['cliente' => $cliente->cliente_id]) }}" method="POST">
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

{{--            {{$clientes->links()}}--}}
        </div>
        <div class="text-end">
            <a class="navbar-brand float1 my-float" href="<?= url('/clientes/nuevo')?>">
            <span>+</span>
            </a>
        </div>
    </section>
@endsection



