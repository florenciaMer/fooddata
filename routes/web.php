<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\PlanificacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\RecetasController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\RecetasItemsController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CondicionController;
use App\Http\Controllers\ClienteServiciosController;
use App\Http\Controllers\PlanificacionItemController;
use App\Http\Controllers\ServiciosPlanificadosController;
use App\Http\Controllers\PresupuestosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('login',[AuthController::class, 'loginForm'])->name('auth.login-form');
Route::post('login',[AuthController::class, 'login'])->name('auth.login');
Route::get('logout',[AuthController::class, 'logout'])->name('auth.logout');
Route::get('/usuarios',[UsuarioController::class, 'index'])->name('usuarios.index')->middleware(['auth','EsAdmin']);


Route::get('/usuarios/nuevo',[\App\Http\Controllers\UsuarioController::class, 'nuevo'])->name('usuarios.nuevo');
Route::post('/usuarios/crear',[\App\Http\Controllers\UsuarioController::class, 'crear'])->name('usuarios.crear');
Route::get('/usuarios/recupera',[\App\Http\Controllers\UsuarioController::class, 'recupera'])->name('usuarios.recupera');
Route::post('/usuarios/recuperaPost',[\App\Http\Controllers\UsuarioController::class, 'recuperaPost'])->name('usuarios.recuperaPost');

Route::get('/stock',[StockController::class, 'index'])->name('stock')->middleware(['auth']);

/* ============================ Ingredientes ========================================*/

Route::get('/ingredientes',[IngredienteController::class, 'index'])->name('ingredientes.index')->middleware(['auth']);
Route::get('ingredientes/nuevo',[IngredienteController::class, 'nuevo'])->name('ingredientes.nuevo')->middleware(['auth']);
Route::post('ingredientes/nuevo',[IngredienteController::class, 'crear'])->name('ingredientes.crear')->middleware(['auth']);

Route::get('/stock/ingredientes/{ingrediente}',[IngredienteController::class, 'ver'])->name('ingredientes.ver')->middleware(['auth']);
Route::delete('/stock/ingredientes/{ingrediente}/eliminar', [IngredienteController::class, 'eliminar'])->name('ingredientes.eliminar')->middleware(['auth']);

Route::get('/stock/ingredientes/{ingrediente}/editar', [IngredienteController::class, 'editarForm'])->name('ingredientes.editarForm')->middleware(['auth']);
Route::put('/stock/ingredientes/{ingrediente}/editar', [IngredienteController::class, 'editar'])->name('ingredientes.editar')->middleware(['auth']);

/* ============================ Categorias ========================================*/

Route::get('/categorias',[CategoriaController::class, 'index'])->name('categorias.index')->middleware(['auth']);
Route::get('/stock/ingredientes/categorias/nuevo',[CategoriaController::class, 'nuevo'])->name('categorias.nuevo')->middleware(['auth']);

Route::get('/categorias/nuevo',[CategoriaController::class, 'nuevo'])->name('categorias.nuevo')->middleware(['auth']);
Route::post('/categorias/crear',[CategoriaController::class, 'crear'])->name('categorias.crear')->middleware(['auth']);

Route::delete('/categorias/{categoria}/eliminar', [CategoriaController::class, 'eliminar'])->name('categorias.eliminar')->middleware(['auth']);

Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'editarForm'])->name('categorias.editarForm')->middleware(['auth']);
Route::put('/categorias/{categoria}/editar', [CategoriaController::class, 'editar'])->name('categorias.editar')->middleware(['auth']);


/* ============================ Unidades de Medida ========================================*/

Route::get('/unidades',[UnidadController::class, 'index'])->name('unidades.index')->middleware(['auth']);
Route::get('/stock/ingredientes/unidades/nuevo',[UnidadController::class, 'nuevo'])->name('unidades.nuevo')->middleware(['auth']);

Route::get('/unidades/nuevo',[UnidadController::class, 'nuevo'])->name('unidades.nuevo')->middleware(['auth']);
Route::post('/unidades/crear',[UnidadController::class, 'crear'])->name('unidades.crear')->middleware(['auth']);

Route::delete('/unidades/{unidad}/eliminar', [UnidadController::class, 'eliminar'])->name('unidades.eliminar')->middleware(['auth']);

Route::get('/unidades/{unidad}/editar', [UnidadController::class, 'editarForm'])->name('unidades.editarForm')->middleware(['auth']);
Route::put('/unidades/{unidad}/editar', [UnidadController::class, 'editar'])->name('unidades.editar')->middleware(['auth']);

/* ============================ Planificacion ========================================*/
Route::get('/planificacion',[PlanificacionController::class, 'index'])->name('planificacion')->middleware(['auth']);

/* ======================= Recetas ==================================*/

Route::get('/recetas',[RecetasController::class, 'index'])->name('recetas.index')->middleware(['auth']);
Route::get('/recetas/indexSinFormParams',[RecetasController::class, 'indexSinFormParams'])->name('recetas.indexSinFormParams')->middleware(['auth']);

Route::get('/recetas/{receta}/editar', [RecetasController::class, 'editarForm'])->name('recetas.editarForm')->middleware(['auth']);
Route::put('/recetas/{receta}/editar', [RecetasController::class, 'editar'])->name('recetas.editar')->middleware(['auth']);

Route::put('/recetas/{receta}/editarCabecera', [RecetasController::class, 'editarCabecera'])->name('recetas.editarCabecera')->middleware(['auth']);
Route::delete('/recetas/{receta}/eliminar', [RecetasController::class, 'eliminar'])->name('recetas.eliminar')->middleware(['auth']);

Route::get('/recetas/nuevo',[RecetasController::class, 'nuevo'])->name('recetas.nuevo')->middleware(['auth']);
Route::post('/recetas/crear',[RecetasController::class, 'crear'])->name('recetas.crear')->middleware(['auth']);


/* ============================ Tipos de Recetas ========================================*/

Route::get('/tipos',[TipoController::class, 'index'])->name('tipos.index')->middleware(['auth']);
Route::get('/planificacion/recetas/tipos/nuevo',[TipoController::class, 'nuevo'])->name('tipos.nuevo')->middleware(['auth']);

Route::get('/tipos/nuevo',[TipoController::class, 'nuevo'])->name('tipos.nuevo')->middleware(['auth']);
Route::post('/tipos/crear',[TipoController::class, 'crear'])->name('tipos.crear')->middleware(['auth']);

Route::delete('/tipos/{tipo}/eliminar', [TipoController::class, 'eliminar'])->name('tipos.eliminar')->middleware(['auth']);

Route::get('/tipos/{tipo}/editar', [TipoController::class, 'editarForm'])->name('tipos.editarForm')->middleware(['auth']);
Route::put('/tipos/{tipo}/editar', [TipoController::class, 'editar'])->name('tipos.editar')->middleware(['auth']);

/* ============================ RecetaItems ========================================*/
Route::get('/recetasItems/{receta_id}/index/', [RecetasItemsController::class, 'index'])->name('recetasItems.index')->middleware(['auth']);
Route::get('/recetasItems/{receta_id}/indexIngredientesSearch/', [RecetasItemsController::class, 'indexIngredientesSearch'])->name('recetasItems.indexIngredientesSearch')->middleware(['auth']);

Route::delete('/recetasItems/{ingrediente}/{receta}/eliminar', [RecetasItemsController::class, 'eliminar'])->name('recetasItems.eliminar')->middleware(['auth']);
Route::put('/recetasItems/{receta}/editar', [RecetasItemsController::class, 'editar'])->name('recetasItems.editar')->middleware(['auth']);

Route::get('/recetasItems/{receta_id}',[RecetasItemsController::class, 'index'])->name('recetasItems.index')->middleware(['auth']);
Route::get('/recetasItems/{receta}/nuevo',[RecetasItemsController::class, 'nuevo'])->name('recetasItems.nuevo')->middleware(['auth']);

Route::post('/recetasItems/agregar',[RecetasItemsController::class, 'agregar'])->name('recetasItems.agregar')->middleware(['auth']);

/* ======================= Etiquetas ==================================*/

Route::get('/etiquetas',[EtiquetaController::class, 'index'])->name('etiquetas.index')->middleware(['auth']);
Route::get('/planificacion/servicios/etiquetas/nuevo',[EtiquetaController::class, 'nuevo'])->name('etiquetas.nuevo')->middleware(['auth']);

Route::get('/etiquetas/nuevo',[EtiquetaController::class, 'nuevo'])->name('etiquetas.nuevo')->middleware(['auth']);
Route::post('/etiquetas/crear',[EtiquetaController::class, 'crear'])->name('etiquetas.crear')->middleware(['auth']);

Route::delete('/etiquetas/{etiqueta}/eliminar', [EtiquetaController::class, 'eliminar'])->name('etiquetas.eliminar')->middleware(['auth']);

Route::get('/etiquetas/{etiqueta}/editar', [EtiquetaController::class, 'editarForm'])->name('etiquetas.editarForm')->middleware(['auth']);
Route::put('/etiquetas/{etiqueta}/editar', [EtiquetaController::class, 'editar'])->name('etiquetas.editar')->middleware(['auth']);

/* ======================= Clientes ==================================*/

Route::get('/clientes',[ClienteController::class, 'index'])->name('clientes.index')->middleware(['auth']);

Route::get('clientes/nuevo',[ClienteController::class, 'nuevo'])->name('clientes.nuevo')->middleware(['auth']);

Route::get('/clientes/nuevo',[ClienteController::class, 'nuevo'])->name('clientes.nuevo')->middleware(['auth']);
Route::post('/clientes/crear',[ClienteController::class, 'crear'])->name('clientes.crear')->middleware(['auth']);

Route::delete('/clientes/{cliente}/eliminar', [ClienteController::class, 'eliminar'])->name('clientes.eliminar')->middleware(['auth']);

Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'editarForm'])->name('clientes.editarForm')->middleware(['auth']);
Route::put('/clientes/{cliente}/editar', [ClienteController::class, 'editar'])->name('clientes.editar')->middleware(['auth']);

/* ============================ ClientesServicios ========================================*/
Route::get('/clienteServicios/{cliente_id}/index/', [ClienteServiciosController::class, 'index'])->name('clienteServicios.index')->middleware(['auth']);
Route::get('/clienteServicios/{cliente_id}/indexEtiquetasSearch/', [ClienteServiciosController::class, 'indexEtiquetasSearch'])->name('clienteServicios.indexEtiquetasSearch')->middleware(['auth']);

Route::delete('/clienteServicios/{etiqueta}/{cliente}/eliminar', [ClienteServiciosController::class, 'eliminar'])->name('clienteServicios.eliminar')->middleware(['auth']);
Route::put('/clienteServicios/{cliente}/editar', [ClienteServiciosController::class, 'editar'])->name('clienteServicios.editar')->middleware(['auth']);

Route::get('/clienteServicios/{cliente_id}',[ClienteServiciosController::class, 'index'])->name('clienteServicios.index')->middleware(['auth']);
Route::get('/clienteServicios/{cliente}/nuevo',[ClienteServiciosController::class, 'nuevo'])->name('clienteServicios.nuevo')->middleware(['auth']);
Route::post('/clienteServicios/agregar',[ClienteServiciosController::class, 'agregar'])->name('clienteServicios.agregar')->middleware(['auth']);

/* ======================= Planificacion ==================================*/

Route::get('/indexCarga',[PlanificacionController::class, 'indexCarga'])->name('indexCarga')->middleware(['auth']);

Route::delete('/planificacion/{planificacion}/eliminarReceta', [PlanificacionController::class, 'eliminarReceta'])->name('planificacion.eliminarReceta')->middleware(['auth']);
Route::post('/planificacion/agregarCabecera', [PlanificacionController::class, 'agregarCabecera'])->name('planificacion.agregarCabecera')->middleware(['auth']);
Route::delete('/planificacion/eliminarItem/{planificacion}/eliminar', [PlanificacionItemController::class, 'eliminar'])->name('planificacion.eliminar')->middleware(['auth']);
Route::put('/planificacion/{planificacion}/editarCabecera', [PlanificacionController::class, 'editarCabecera'])->name('planificacion.editarCabecera')->middleware(['auth']);

/* ======================= PlanificacionItems ==================================*/

Route::get('/indexCargaItem',[PlanificacionItemController::class, 'indexCargaItem'])->name('indexCargaItem')->middleware(['auth']);
Route::post('/planificacionItem/agregar',[PlanificacionItemController::class, 'agregar'])->name('planificacionItem.agregar')->middleware(['auth']);
Route::delete('/planificacionItem/{planificacionItem}/eliminarItem', [PlanificacionItemController::class, 'eliminarItem'])->name('planificacionItem.eliminarItem')->middleware(['auth']);
Route::post('/planificacionItem/agregarItem', [PlanificacionItemController::class, 'agregarItem'])->name('planificacionItem.agregarItem')->middleware(['auth']);
Route::get('/planificacionItem/{planificacion}/{planificacionItem}/index',[PlanificacionItemController::class, 'index'])->name('planificacionItem.index')->middleware(['auth']);
Route::delete('/planificacionItem/{planificacionItem}/eliminarItem', [PlanificacionItemController::class, 'eliminarItem'])->name('planificacionItem.eliminarItem')->middleware(['auth']);
Route::put('/planificacionItem/{planificacion}/editarItem', [PlanificacionItemController::class, 'editarItem'])->name('planificacionItem.editarItem')->middleware(['auth']);
Route::get('/planificacionItem/{planificacion}/{recetas}/{clientes}/{tipos}/{planificacionItem}/indexCargaItem', [PlanificacionItemController::class, 'indexCargaItem'])->name('planificacionItem.indexCargaItem')->middleware(['auth']);


/* ======================= Servicios planificados ==================================*/
Route::get('/serviciosPlanificados',[ServiciosPlanificadosController::class, 'index'])->name('serviciosPlanificados')->middleware(['auth']);
Route::post('/serviciosPlanificados/cargaServicios', [ServiciosPlanificadosController::class, 'cargaServicios'])->name('serviciosPlanificados.cargaServicios')->middleware(['auth']);
Route::get('/serviciosPlanificados/{fecha}/{contexto}/{etiqueta}/{cliente}/verServicio', [ServiciosPlanificadosController::class, 'verServicio'])->name('serviciosPlanificados.verServicio')->middleware(['auth']);
Route::delete('/serviciosPlanificados/{planificacionItem_id}/eliminarItem', [ServiciosPlanificadosController::class, 'eliminarItem'])->name('serviciosPlanificados.eliminarItem')->middleware(['auth']);
Route::get('/serviciosPlanificados/{servicios}/calendario', [ServiciosPlanificadosController::class, 'calendario'])->name('serviciosPlanificados.calendario')->middleware(['auth']);
Route::get('/indexApertura', [ServiciosPlanificadosController::class, 'indexApertura'])->name('serviciosPlanificados.indexApertura')->middleware(['auth']);
Route::post('/listadoServiciosPlanificados', [ServiciosPlanificadosController::class, 'listadoServiciosPlanificados'])->name('serviciosPlanificados.listadoServiciosPlanificados')->middleware(['auth']);
Route::post('/aperturaSeleccion', [ServiciosPlanificadosController::class, 'aperturaSeleccion'])->name('serviciosPlanificados.aperturaSeleccion')->middleware(['auth']);

/* =======================  Presupuestos  ==================================*/
Route::get('/presupuestos/index',[PresupuestosController::class, 'index'])->name('presupuestos.index')->middleware(['auth']);
Route::get('/presupuestos/calcular',[PresupuestosController::class, 'calcular'])->name('presupuestos.calcular')->middleware(['auth']);
Route::get('/presupuestos/detalleGlobal',[PresupuestosController::class, 'detalleGlobal'])->name('presupuestos.detalleGlobal')->middleware(['auth']);
Route::get('/presupuestos/verDetalle',[PresupuestosController::class, 'verDetalle'])->name('presupuestos.verDetalle')->middleware(['auth']);
