@section('title', 'Operaciones de Planificación')
@extends('layout.main')
@section('main')
    <h1 class="d-none">Planificación</h1>
    <div class="container d-flex flex-column minheight570 trama">
        <section class="minheight430">
            <div class="d-flex flex-row m-auto flex-column-mobile">
                <ul class="list-group w-25 list-unstyled mx-5">
                    <p class="fw-bold border-bottom-1 p-2 ">Gestión de Información</p>
                    <li class="border-bottom-1"><a class="dropdown-item w-100 p-2" href="<?= url('/recetas')?>">Recetas</a></li>
                    <li class="border-bottom-1"><a class="dropdown-item w-100 p-2" href="<?= url('/tipos')?>">Tipos de Recetas</a></li>
                    <li class="border-bottom-1"><a class="dropdown-item w-100 p-2" href="<?= url('/etiquetas')?>">Servicios</a></li>
                </ul>
                <ul class="list-group w-25 list-unstyled mx-5">
                    <p class="fw-bold border-bottom-1 p-2 ">Operaciones</p>
                    <li class="border-bottom-1"><a class="dropdown-item w-100 p-2" href="<?= url('/indexCarga')?>">Carga de Planificación</a></li>
                    <li class="border-bottom-1"><a class="d-none-mobile dropdown-item w-100 p-2" href="<?= url('/indexApertura')?>">Servicios Planificados</a></li>
                </ul>
                <ul class="list-group w-25 list-unstyled mx-5">
                    <p class="fw-bold border-bottom-1 p-2 ">Presupuestos</p>
                    <li class="border-bottom-1"><a class="dropdown-item w-100 p-2" href="<?= url('/serviciosPlanificados')?>">Costos por Servicio</a></li>
    {{--                <li class="border-bottom-1"><a class="dropdown-item w-100 p-2" href="<?= url('/presupuestos/index')?>">Costos por Servicio</a></li>--}}
                </ul>
            </div>
        </section>

    </div>
@endsection
