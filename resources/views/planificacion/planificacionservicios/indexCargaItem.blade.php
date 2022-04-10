<?php
/** @var \App\Models\Cliente $clientes */
/** @var \App\Models\Receta $recetas */
/** @var \App\Models\Tipo $tipos */
/** @var \App\Models\Etiqueta $etiquetas */
/** @var  $receta */
/** @var  $etiqueta */
/** @var $tipo */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var  $cliente */
/** @var \App\Http\Controllers\PlanificacionItemController $planificacionItem*/
/** @var \App\Models\Planificacion $planificacion */
/** @var \App\Models\PlanificacionItem $planificacionItem */

?>
@section('title', 'Planificación de Servicios')
@extends('layout.main')
@section('main')
    <div class="container">
        <div class="contenedor gris">
            <p class="text-white m-0 fs-4">Planificación de Servicios<p>
        </div>
        @foreach($planificacion as $i => $plan)
            <form action="{{ route('planificacion.agregarCabecera') }}"
                  method="post" class="d-flex flex-column align-items-center position-revert"
                  enctype="multipart/form-data">
                @csrf

                <div class="card w-50 mobile-w-75 p-2 m-3 m-auto form-group">
                    <input type="hidden" value="{{ $plan->cliente_id}}" id="cliente_id" name="cliente_id">
                    <div class="card-body">
                        <input type="hidden"  id="planificacion_id{{$i+25}}" name="planificacion_id" class="text-center form-control fw-bold bg-light "
                               value="{{$plan->planificacion_id}}">
                        <select id="cliente_id{{$i}}" name="cliente_id" class="form-control p-2 bg-input-rojo">
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->cliente_id }}" @if(old('cliente_id', $plan->cliente_id) == $cliente->cliente_id)
                                selected @endif>{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row mobile-padding-0">
                            <input type="text" id="lbl" value="Fecha" disabled class="form-control">
                            <input type="date" id="fecha{{$i}}"  required name="fecha" class="txtFecha text-center form-control fw-bold bg-light @error('fecha') is-invalid @enderror"
                                   value="{{ old('fecha', $plan->fecha) }}"
                                   @error('fecha') aria-describedby="error-fecha"
                                @enderror>
                            @error('base')
                            <div class="alert alert-danger" id="error-fecha">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row mobile-padding-0">
                            <label for="contexto{{$i}}" class="visually-hidden my-2">Contexto</label>
                            <select id="contexto{{$i}}" name="contexto" class="form-control p-2 ">
                                <option value="{{ $plan->contexto }}"
                                        selected >{{ $plan->contexto }}</option>
                                <option value="Escenario">Escenario</option>
                                <option value="Cotización">Cotización</option>
                                <option value="Licitación">Licitación</option>
                                <option value="Servicio Habitual">Servicio Habitual</option>
                                <option value="Servicio Especial">Servicio Especial</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-row mobile-padding-0">
                        <input type="text" id="lbl{{$i}}" value="Observaciones" disabled class="form-control d-none-mobile">
                        <textarea type="text" id="observaciones{{$i}}" name="observaciones"
                                  class="d-none-mobile text-center form-control fw-bold bg-light @error('observaciones') is-invalid @enderror"
                                  value="{{ old('observaciones', $plan->observaciones) }}"
                                  @error('observaciones') aria-describedby="error-observaciones"
                            @enderror>
                            @error('base')

                            <div class="alert alert-danger" id="error-fecha">{{ $message }}</div>
                            @enderror
                        </textarea>
                    </div>
                    <div class="card-body d-flex flex-row">
                        <input type="text" id="lblCant{{$i}}" value="Cantidad" disabled class="form-control">

                        <input type="text" id="cant{{$i}}" name="cant" class="text-center form-control p-2 @error('cant') is-invalid @enderror"
                               value="{{ old('cant', $plan->cant) }}"
                               @error('cant') aria-describedby="error-cant"
                            @enderror>
                        @error('cant')
                        <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="card-body d-flex flex-row justify-content-around form-group">
                        <button title="Cargar" class="btn btn-success" type="submit" name="cargar" value="boton">Cargar Servicio</button>
                        <div>
                            <button class="p-6 btn bg-check mobile-w-75 mobile-margin-0 mobile-w-75 text-white" title="Modificar Datos">
                                Editar Campos
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{--      PC ****************** carga de planificacion items RECETAS *************    --}}
            <div class="container w-10 d-flex align-items-center flex-column text-center my-4">
                <div class="table table-striped d-flex flex-column justify-content-center">
                    <div class="form-group mx-2 d-flex bg-input-rojo w-75 px-4 ">
                        <label class="d-none-mobile fs-6 py-2 text-black-50 font-size-19">Servicio </label>
                        <label class="d-none-mobile ml-100 fs-6 py-2 ml-100 text-black-50 font-size-19">Tipo </label>
                        <label class="d-none-mobile ml-200 fs-6 p-2 align-items-md-start text-md-start text-black-50 font-size-19">Receta</label>
                        <label class="d-none-mobile ml-200 fs-6 p-2 ml-300 text-black-50 font-size-19">Cantidad</label>
                    </div>
                </div>
            </div>

            {{--    si hay una planificacion item cargada--}}
            @if($planificacionItem->count() > 0)
                @foreach($planificacionItem as $i => $planItem)
                    <div class="fs-6 my-3 w-100 bg-light pc-d-none">Registro {{$i+1}}</div>
                    <div class="d-flex flex-row flex-column-mobile">

                        <form action="{{ route('planificacionItem.editarItem',
                ['planificacion' => $planItem->planificacionItem_id]) }}"
                              method="post" class="d-flex flex-column-mobile mobile-padding-0 align-items-center">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="usuario_id{{$i}}"  name="usuario_id"
                                   value="{{ old('usuario_id', $planItem->usuario_id) }}">
                            <input type="hidden" id="planificacionItem_id{{$i}}" name="planificacionItem_id" value="{{$planItem->planificacionItem_id}}">

                            <input type="hidden" id="planificacion_id{{$i+55}}"  name="planificacion_id"
                                   value="{{ old('planificacion_id', $planItem->planificacion_id) }}">
                            {{--es el servicio--}}
                            <div class="d-flex col-row mobile-width-100porc">
                                <select id="etiqueta_id{{$i}}" name="etiqueta_id"
                                        class="mobile-margin-0 form-select my-2 mx-1">
                                    @foreach($etiquetas as $etiqueta)
                                        <option value="{{ $etiqueta->etiqueta_id }}" @if(old('etiqueta_id', $planItem->etiqueta_id) == $etiqueta->etiqueta_id) selected @endif>{{ $etiqueta->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--filtro para recetas por tipo de rec--}}
                            <div class="d-flex col-row mobile-width-100porc">
                                <select id="tipo_id{{$i+3}}" name="tipo_id" class="mobile-margin-0 mobile-w-75 w-250 form-select my-2 select-tipo"
                                        data-id="{{$i}}">
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->tipo_id }}" @if(old('tipo_id', $planItem->tipo_id) == $tipo->tipo_id) selected @endif>{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                                {{--                            <input type="hidden" id="cliente_id{{$i}}"  name="cliente_id"--}}
                                {{--                                   value="{{ old('cliente_id', $planItem->cliente_id) }}">--}}
                            </div>
                            <input type="hidden" id="fecha2{{$i}}" name="fecha"
                                   value="{{ $plan->fecha}}">
                            <div class="d-flex col-row mx-1 mobile-margin-0 mobile-width-100porc">
                                <select id="receta_id{{$i}}" disabled name="receta_id" class="mobile-margin-0 mobile-w-75 w-250 form-select my-2 select-tipo">
                                    @foreach($recetas as $receta)
                                        <option value="{{ $receta->receta_id }}" @if(old('receta_id', $planItem->receta_id) == $receta->receta_id) selected @endif>{{ $receta->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex col-row mobile-width-100porc">
                                <input type="number" min="1" required id="cant_rec{{$i}}" name="cant_rec" class="mobile-padding-1 mobile-margin-0 mobile-w-75 text-center form-control m-2 mx-0 @error('cant_rec') is-invalid @enderror"
                                       value="{{ old('cant_rec', $planItem->cant_rec) }}"
                                       @error('cant_rec') aria-describedby="error-cant_rec"
                                    @enderror>
                                @error('cant_rec')
                                <div class="alert alert-danger" id="error-cant_rec">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mobile-margin-5px mobile-width-100porc">
                                <button class="btn bg-check m-3 mobile-margin-0 mobile-width-100porc text-white" title="Editar Campos"><ion-icon name="checkmark-outline"></ion-icon>
                                </button>
                            </div>
                        </form>
                        <div class="mobile-margin-5px">
                            <button type="button" title="Eliminar"
                                    class="p-10px mobile-margin-0 mobile-w-75 btn height40 my-3 bg-danger trash-white my-4" title="Eliminar" data-toggle="modal"
                                    data-target="#myModal2{{$planItem->planificacionItem_id}}"><ion-icon class="pointer-events" name="trash-outline" ></ion-icon></button>
                        </div>
                        <!-- The Modal -->
                        <div class="modal" id="myModal2{{$planItem->planificacionItem_id}}">
                            <div class="modal-dialog">
                                <div class="modal-content bg-light">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h3 class="modal-title">Atención</h3>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Seguro que deseas eliminar el item definitivamente?
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <form action="{{ route('planificacionItem.eliminarItemCargaItem', ['planificacionItem' =>
                                $planItem->planificacionItem_id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" id="contexto{{$i}}"
                                                   value="{{$plan->contexto}}" name="contexto">

                                            <input type="hidden" id="fi{{$i}}"
                                                   value="{{$plan->fecha}}" name="fi">

                                            <input type="hidden" id="ff{{$i}}"
                                                   value="{{$plan->fecha}}" name="ff">

                                            <input type="hidden" id="cliente_id{{$i}}"
                                                   value="{{$plan->cliente_id}}" name="cliente_id">

                                            <input type="hidden" id="planificacion_id{{$i}}"
                                                   value="{{$plan->planificacion_id}}" name="planificacion_id">

                                            <button class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--***************** si no hay planificacion cargada ************--}}
            @endif
    </div>
    @foreach($planificacion as $i => $plan)
        <div class="container m-auto d-flex flex-column">

            <div class="d-flex flex-row marginTopMenos19 flex-column-mobile mobile-width-100porc">
                <form action="{{route('planificacionItem.agregarItem')}}"
                      class="my-2 mboton-mobile-5px d-flex flex-column-mobile mobile-padding-0 mobile-width-100porc" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="planificacion_id{{$i+2}}" class="col-4" name="planificacion_id"
                           value=" {{$plan->planificacion_id}}">
                    <input type="hidden" name="usuario_id" value="{{auth()->user()->usuario_id}}">
                    <input type="hidden" name="fecha"  value="{{$plan->fecha}}">

                    <div class="d-flex col-row mobile-width-100porc margintb-mobile-20px">
                        <select id="etiqueta_id{{$i+22}}" name="etiqueta_id"
                                class="mobile-margin-0 form-select my-2">
                            @foreach($etiquetas as $etiqueta)
                                <option value="{{ $etiqueta->etiqueta_id }}" >{{ $etiqueta->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex col-row mobile-width-100porc">
                        <select id="tipo_id{{$i+1}}" name="tipo_id"
                                class="my-2 p-2 mobile-width-100porc w-250 mx-3 form-select
                        mobile-margin-0 m-2 select-tipo-add"
                                data-id="{{$i+1}}">
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->tipo_id }}"
                                        @if(old('$this->tipo_id') == $tipo->tipo_id)
                                        selected @endif>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" id="fecha2{{$i+22}}" name="fecha"
                           value="{{ $plan->fecha}}">
                    <div class="d-flex col-row mobile-width-100porc margintb-mobile-20px">
                        <select id="receta_id_add" name="receta_id" disabled
                                class="p-2 mobile-width-100porc w-250 mx-2 form-select
                        mobile-margin-0 m-2 inputCantAdd">
                            @foreach($recetas as $receta)
                                <option value="{{ $receta->receta_id }}"
                                        @if(old('$this->receta_id') == $receta->receta_id)
                                        selected @endif>{{ $receta->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex col-row mobile-width-100porc marginb-mobile-20px">
                        <input type="number" placeholder="Cantidad" min="1" required id="cant_rec{{$i+22}}" name="cant_rec"
                               class="mx-3 padding-1 mobile-margin-0 mobile-w-75 text-center form-control m-2 @error('cant_rec') is-invalid @enderror"
                               @error('cant_rec') aria-describedby="error-cant_rec"
                               data-id="{{$i+22}}">
                        @enderror>
                        @error('cant')
                        <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <button title="Agregar" class="d-flex justify-content-center flex-column height40 marginLeft12 marginTop10 btn bg-success mobile-margin-0 mobile-width-100porc text-white"><ion-icon class="pointer-events" name="add-circle-outline">+</ion-icon></button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
        @endforeach
        </div>
        </div>

        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                const ingSelect = document.querySelectorAll('.select-tipo');
                ingSelect.forEach(elem => (
                    elem.addEventListener('click', function () {
                        // Instanciamos el objeto XHR.
                        const id = this.dataset.id;
                        const selectRecetaInput = document.getElementById('receta_id'+ id);
                        selectRecetaInput.disabled = false;
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', 'http://localhost:81/tesis/tesis/app/generar_combo_recetas.php?i=' + this.value);
                        xhr.addEventListener('readystatechange', function () {
                            // Este evento se dispara cada vez que el readyState cambia.
                            if(xhr.readyState === 4) {
                                // Ahora que sé que la respuesta llegó entera, procedemos a preguntar si llegó bien.
                                if(xhr.status === 200) {
                                    // Ahora puedo usar el contenido de la respuesta.
                                    selectRecetaInput.innerHTML = xhr.responseText;
                                }
                            }
                        });
                        xhr.send(null);
                    }))
                )

                const ingSelectAdd = document.querySelectorAll('.select-tipo-add');
                ingSelectAdd.forEach(elem => (
                    elem.addEventListener('click', function () {
                        // Instanciamos el objeto XHR.
                        const id = this.dataset.id;
                        const selectRecetaInput = document.getElementById('receta_id_add');
                        selectRecetaInput.disabled = false;
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', 'http://localhost:81/tesis/tesis/app/generar_combo_recetas.php?i=' + this.value);
                        xhr.addEventListener('readystatechange', function () {
                            // Este evento se dispara cada vez que el readyState cambia.
                            if(xhr.readyState === 4) {
                                // Ahora que sé que la respuesta llegó entera, procedemos a preguntar si llegó bien.
                                if(xhr.status === 200) {
                                    // Ahora puedo usar el contenido de la respuesta.
                                    selectRecetaInput.innerHTML = xhr.responseText;
                                }
                            }
                        });
                        xhr.send(null);
                    }))
                )
//habilitar la receta cuando clickea en cantidad add
                const inputCantAdd = document.querySelectorAll('.inputCantAdd');
                inputCantAdd.forEach(elem => (
                    elem.addEventListener('click', function () {
                        // Instanciamos el objeto XHR.
                        const id = this.dataset.id;
                        const selectRecetaInput = document.getElementById('receta_id_add');
                        selectRecetaInput.disabled = false;
                    }))
                )
            });
            window.onload = function(){
                var fecha = new Date(); //Fecha actual
                document.getElementById('txtFecha').value = fecha;
            }

        </script>
@endsection
