
<?php
/** @var \App\Models\Categoria[]|Illuminate\Database\Eloquent\Collection $unidades
 */
?>
@section('title', 'Listado de unidades')
@extends('layout.main')
@section('main')
    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary py-2">Unidades</h1>
    </div>
<section class="container minheight430">
    <h2 class="text-secondary font-size-19 p-2">Detalle:</h2>
    <article>
        <table class="table table-hover table-prod">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            </thead>
            <tbody>
                @foreach($unidades as $unidad)
                    <tr>
                        <td>
                            {{$unidad->unidad_id}}
                        </td>
                        <td>
                            {{$unidad->nombre}}
                        </td>
                        <td>
                            <a class="btn btn-success" title="Editar" href="{{ route('unidades.editarForm', ['unidad'  => $unidad->unidad_id]) }}"><ion-icon class="pointer-events" name="pencil-outline"></ion-icon></a>
                        </td>
                        <td>
                            <button type="button" title="Eliminar"class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$unidad->unidad_id}}"><ion-icon class="pointer-events" name="trash-outline"></ion-icon></button>

                    <!-- The Modal -->

                    <div class="modal" id="myModal{{$unidad->unidad_id}}">
                        <div class="modal-dialog">
                               <div class="modal-content">
                                   <!-- Modal Header -->
                                   <div class="modal-header">
                                       <h3 class="modal-title">Atención</h3>
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                   </div>
                                   <!-- Modal body -->
                                   <div class="modal-body">
                                       Seguro que deseas eliminar la unidad definitivamente?
                                   </div>
                                   <!-- Modal footer -->
                                   <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                           Cancelar
                                       </button>
                                       <form action="{{ route('unidades.eliminar', ['unidad' => $unidad->unidad_id]) }}" method="POST">
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
            </tbody>
            @endforeach
        </table>

    </article>
    <div class="text-end">
        <a class="navbar-brand float1 my-float" href="<?= url('/unidades/nuevo')?>">
            <span>+</span>
        </a>
    </div>
</section>
@endsection


