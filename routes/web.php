<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\campoPrecargadoController;
use App\Http\Controllers\encuestaController;
use App\Http\Controllers\campoVacioController;
use App\Http\Controllers\cuestionarioController;
use App\Http\Controllers\departamentoController;
use App\Http\Controllers\indicadorController;
use App\Http\Controllers\indicadoresLlenosController;
use App\Http\Controllers\informacionForaneaController;
use App\Http\Controllers\userController;
use App\Models\CampoPrecargado;
use App\Models\Indicador;
use Illuminate\Support\Facades\Route;




//Usuarios
Route::get('/', [userController::class, 'index'])->name('index');
Route::post('/login_user', [userController::class, 'login_user'])->name('login.user');
Route::get('/perfil_usuario', [userController::class, 'perfil_user'])->name('perfil.usuario');

//Rutas del llenado de los indicadores
Route::get('/perfil_usuario/indicador/{indicador}', [indicadorController::class, 'show_indicador_user'])->name('show.indicador.user');










//Administradores
Route::get('/admin_login', [adminController::class, 'login'])->name('admin.login.index');
Route::post('/admin_login/ingreso_perfil_admin', [adminController::class, 'ingreso_admin'])->name('admin.login.entrar');


Route::get('/perfil_admin', [adminController::class, 'perfil_admin'])->name('perfil.admin');

Route::post('/perfil_admin/agregar_cliente', [adminController::class, 'agregar_cliente'])->name('agregar.cliente');
Route::delete('/perfil_admin/eliminar_cliente/{cliente}', [adminController::class, 'eliminar_cliente'])->name('eliminar.cliente');
Route::patch('/perfil_admin/editar_cliente/{cliente}', [adminController::class, 'editar_cliente'])->name('editar.cliente');


Route::post('/perfil_admin/agregar_usuario', [adminController::class, 'agregar_usuario'])->name('agregar.usuario');
Route::post('/perfil_admin/agregar_departamento', [adminController::class, 'agregar_departamento'])->name('agregar.departamento');


//Rutas para ver el panel y agregar indicadores
Route::get('/perfil_admin/agregar_indicadores/{departamento}', [indicadorController::class, 'agregar_indicadores_index'])->name('agregar.indicadores.index');

Route::post('/perfil_admin/agregar_indicadores/agregar_indicador/{departamento}', [indicadorController::class, 'agregar_indicadores_store'])->name('agregar.indicadores.store');


Route::patch('/perfil_admin/agregar_indicadores/editar_usuario/{usuario}', [userController::class, 'editar_usuario'])->name('editar.usuario');




//RUTA QUE ELIMINA EL DEPARTAMENTO
Route::delete('/perfil_admin/eliminar_departamento/{departamento}', [departamentoController::class, 'eliminar_departamento'])->name('eliminar.departamento');

Route::patch('/perfil_admin/actualiza_departamento/{departamento}', [departamentoController::class, 'actuliza_departamento'])->name('actualizar.departamento');

Route::delete('/perfil_admin/elimina_usuario/{usuario}', [userController::class, 'eliminar_usuario'])->name('eliminar.usuario');



//Rutas de los indicadores
Route::get('/perfil_admin/agregar_indicadores/indicador/{indicador}', [indicadorController::class, 'indicador_index'])->name('indicador.index');
Route::delete('/perfil_admin/agregar_indicadores/{indicador}', [indicadorController::class, 'borrar_indicador'])->name('borrar.indicador');


//Rutas que agregan los campos de los indicadores
Route::post('/perfil_admin/agregar_indicadores/indicador/agregar_campo_vacio/{indicador}', [campoVacioController::class, 'agregar_campo_vacio'])->name('agregar.campo.vacio');

//Agregando campos precargados
Route::post('/perfil_admin/agregar_indicadores/indicador/agregar_campo_precargado/{indicador}', [campoPrecargadoController::class, 'agregar_campo_precargado'])->name('agregar.campo.precargado');


//Agregando la informacion foranea
Route::post('/perfil_admin/agregar_info_foranea', [informacionForaneaController::class, 'agregar_informacion_foranea'])->name('agregar.info.foranea');



//Eliminando campos la ctm
Route::delete('/perfil_admin/agregar_indicadores/indicador/campo_borrado/{campo}', [indicadorController::class, 'borrar_campo'])->name('eliminar.campo');



//Creando el campo promedio
Route::post("/perfil_admin/agregar_indicadores/indicador/crear_campo_promedio/{indicador}", [indicadorController::class, "input_promedio_guardar"])->name("input.promedio.guardar");






Route::post('/perfil_admin', [userController::class, 'cerrar_session'])->name('cerrar.session');







//Aui van las rutas de las encuestas para los clientes
Route::post('/perfil_admin/agregar_indicadores/agregar_encuesta/{departamento}', [encuestaController::class, 'encuesta_store'])->name('encuesta.store');
Route::delete('/perfil_admin/agregar_indicadores/eliminar_encuesta/{encuesta}', [encuestaController::class, 'encuesta_delete'])->name('encuesta.delete');
Route::patch('/perfil_admin/agregar_indicadores/editar_encuesta/{encuesta}', [encuestaController::class, 'encuesta_edit'])->name('encuesta.edit');

Route::get('/perfil_admin/agregar_indicadores/encuesta/{encuesta}', [encuestaController::class, 'encuesta_index'])->name('encuesta.index');
Route::post('/perfil_admin/agregar_indicadores/encuesta/agregar_pregunta/{encuesta}', [encuestaController::class, 'pregunta_store'])->name('pregunta.store');
Route::delete('/perfil_admin/agregar_indicadores/encuesta/eliminar_pregunta/{pregunta}', [encuestaController::class, 'pregunta_delete'])->name('pregunta.delete');


Route::get('/login_cliente',[encuestaController::class, 'login_cliente'])->name('login.cliente');




