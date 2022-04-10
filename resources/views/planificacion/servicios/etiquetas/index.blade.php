
<?php
/** @var \App\Models\Etiqueta[]|Illuminate\Database\Eloquent\Collection $etiquetas
 */
?>
@section('title', 'Listado de Etiquetas de Servicios')
@extends('layout.main')
@section('main')

    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary py-2">Administración de Etiquetas de Servicios</h1>
    </div>
<section class="container">
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
                @foreach($etiquetas as $etiqueta)
                    <tr>
                        <td class="col-sm-2">
                            {{$etiqueta->etiqueta_id}}
                        </td>
                        <td class="col-sm-6">
                            {{$etiqueta->nombre}}
                        </td>
                        <td class="col-sm-2">
                            <a class="btn btn-success" title="Editar" href="{{ route('etiquetas.editarForm', ['etiqueta'  => $etiqueta->etiqueta_id]) }}"><ion-icon class="pointer-events" name="pencil-outline"></ion-icon></a>
                        </td>
                        <td class="col-sm-2">
                            <button type="button" class="btn btn-danger" title="Eliminar" data-toggle="modal" data-target="#myModal{{$etiqueta->etiqueta_id}}"><ion-icon class="pointer-events" name="trash-outline"></ion-icon></button>

                    <!-- The Modal -->

                    <div class="modal" id="myModal{{$etiqueta->etiqueta_id}}">
                        <div class="modal-dialog">
                               <div class="modal-content">
                                   <!-- Modal Header -->
                                   <div class="modal-header">
                                       <h3 class="modal-title">Atención</h3>
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                   </div>
                                   <!-- Modal body -->
                                   <div class="modal-body">
                                       Seguro que deseas eliminar el etiqueta de receta definitivamente?
                                   </div>
                                   <!-- Modal footer -->
                                   <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                           Cancelar
                                       </button>
                                       <form action="{{ route('etiquetas.eliminar', ['etiqueta' => $etiqueta->etiqueta_id]) }}" method="POST">
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
        <a class="navbar-brand float1 my-float" target="_blank" href="<?= url('/etiquetas/nuevo')?>">
            <span>+</span>
        </a>
    </div>
</section>
@endsection


