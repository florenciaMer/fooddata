@section('title', 'Operaciones de Stock')
@extends('layout.main')
@section('main')
    <h1 class="d-none">Operaciones de Stock</h1>
       <div class="container d-flex trama">
            <section class="minheight570">
                <div class="d-flex flex-column m-5 ">
                    <h2 class="border-bottom-1 font-weight-bold fs-6 p-2 py-2">Operaciones </br>con Ingredientes</h2>
                        <ul class="list-group list-unstyled">

                            <li class="border-bottom-1"><a class="dropdown-item p-2" href="<?= url('/ingredientes')?>">Ingredientes</a></li>

                            <li class="border-bottom-1"><a class="dropdown-item p-2" href="<?= url('/categorias')?>">Categorías</a></li>

                            <li class="border-bottom-1"><a class="dropdown-item p-2" href="<?= url('/unidades')?>">Unidades de Medida</a></li>

                        </ul>
                </div>

            </section>
       </div>
@endsection
