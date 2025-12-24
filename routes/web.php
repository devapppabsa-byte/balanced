<?php


use App\Http\Controllers\apartadoNormaController;
use App\Http\Controllers\quejasController;
use App\Http\Controllers\normaController;
use App\Http\Controllers\proveedorController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\campoPrecargadoController;
use App\Http\Controllers\encuestaController;
use App\Http\Controllers\campoVacioController;
use App\Http\Controllers\cuestionarioController;
use App\Http\Controllers\departamentoController;
use App\Http\Controllers\indicadorController;
use App\Http\Controllers\indicadoresLlenosController;
use App\Http\Controllers\informacionForaneaController;
use App\Http\Controllers\evaluacionProveedorController;
use App\Http\Controllers\CamposForaneosImportController;
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
Route::get('/perfil_usuario/cumplimiento_normativo/', [normaController::class, 'cumplimiento_normativo_user'])->name('cumplimiento.normativo.user');
Route::get('/perfil_usuario/cumplimiento_normativo/registro_cumplimiento_normativo/{norma}', [apartadoNormaController::class, 'registro_cumplimiento_normativa_index'])->name('registro.cumplimiento.normativa.index');
Route::post('/perfil_usuario/cumplimiento_normativo/registro_cumplimiento_normativo/resgistro_actividad/{apartado}', [apartadoNormaController::class, 'registro_actividad_cumplimiento_norma'])->name('registro.actividad.cumplimiento.norma');
Route::get('/perfil_usuario/cumplimiento_normativo/registro_cumplimiento_normativo/registro_actividad/evidencias/{apartado}', [apartadoNormaController::class, 'ver_evidencia_cumplimiento_normativo'])->name('ver.evidencia.cumplimiento.normativo');


// esta es la ruta del las evaluaciondes de los clientes
Route::get('/perfil_usuario/encuestas_clientes/', [userController::class, 'encuesta_clientes_user'])->name('encuesta.clientes.user');
Route::get('/perfil_usuario/encuestas_clientes/encuesta/{encuesta}', [userController::class, 'encuesta_index_user'])->name('encuesta.index.user');

// Route::get('/perfil_usuario/cuencuestas_clientes/respuestas/{encuesta}', [userController::class, 'show_respuestas_usuario'])->name('show.respuestas.usuario');

Route::get('/perfil_usuario/encuestas/respuestas_clientes/{cliente}/{encuesta}', [userController::class, 'show_respuestas_usuario'])->name('show.respuestas.usuario');


// aqui van a estar las rutas para el fucking llenado de indicadores
Route::post('/perfil_usuario/indicador/llenado_de_informacion/{indicador}', [indicadorController::class, 'llenado_informacion_indicadores'])->name('llenado.informacion.indicadores');


// aqui van a estar las rutas para el fucking llenado de indicadores





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

Route::patch('/perfil_admin/agregar_indicadores/editando_indicador/{indicador}', [indicadorController::class, 'indicador_edit'])->name('indicador.edit');



//Rutas que agregan los campos de los indicadores
Route::post('/perfil_admin/agregar_indicadores/indicador/agregar_campo_vacio/{indicador}', [campoVacioController::class, 'agregar_campo_vacio'])->name('agregar.campo.vacio');

//Agregando campos precargados
Route::post('/perfil_admin/agregar_indicadores/indicador/agregar_campo_precargado/{indicador}', [campoPrecargadoController::class, 'agregar_campo_precargado'])->name('agregar.campo.precargado');


//Agregando la informacion foranea
Route::post('/perfil_admin/agregar_info_foranea', [informacionForaneaController::class, 'agregar_informacion_foranea'])->name('agregar.info.foranea');



//CREAR INPUT_PRECARGADO que sera llenado con la informacion mes a mes...
Route::post('/perfil_admin/informaion_foranea/agregar_campo_precargado', [campoPrecargadoController::class, 'crear_campo_precargado'])->name('crear_campo_precargado');


///PRUEBAS CON EL ARCHIVO DE EXCEL

Route::post('/perfil_admin/informacion_foranea/cargando_excel', [CamposForaneosImportController::class, 'importar'])->name('importar_excel');

//PRUEBAS CON EL ARCHIVO DE EXCEL




//Eliminando campos la ctm
Route::delete('/perfil_admin/agregar_indicadores/indicador/campo_borrado/{campo}', [indicadorController::class, 'borrar_campo'])->name('eliminar.campo');



//Creando el campo promedio
Route::post("/perfil_admin/agregar_indicadores/indicador/crear_campo_promedio/{indicador}", [indicadorController::class, "input_promedio_guardar"])->name("input.promedio.guardar");


//Creando el campo de multiplicacion
Route::post("/perfil_admin/agregar_indicadores/indicador/crear_campo_multiplicacion/{indicador}", [indicadorController::class, "input_multiplicacion_guardar"])->name('input.multiplicacion.guardar');

//Creando el campo de la suam
Route::post('/perfil_admin/agregar_indicadores/indicador/crear_campo_suma/{indicador}', [indicadorController::class, "input_suma_guardar"])->name('input.suma.guardar');

Route::post('/perfil_admin/agregar_indicadores/indicador/crear_campo_division/{indicador}', [indicadorController::class, 'input_division_guardar'])->name('input.division.guardar');


Route::post('/perfil_admin/agregar_indicadores/indicador/crear_campo_resta/{indicador}', [indicadorController::class, 'input_resta_guardar'])->name('input.resta.guardar');

Route::post('/perfil_admin/agregar_indicadores/indicador/crear_campo_porcentaje/{indicador}', [indicadorController::class, 'input_porcentaje_guardar'])->name('input.porcentaje.guardar');


Route::post('/perfil_admin', [userController::class, 'cerrar_session'])->name('cerrar.session');







//Aui van las rutas de las encuestas para los clientes
Route::post('/perfil_admin/agregar_indicadores/agregar_encuesta/{departamento}', [encuestaController::class, 'encuesta_store'])->name('encuesta.store');
Route::post('/perfil_admin/encuestas/', [encuestaController::class, 'encuesta_store_two'])->name('encuesta.store.two');
Route::delete('/perfil_admin/agregar_indicadores/eliminar_encuesta/{encuesta}', [encuestaController::class, 'encuesta_delete'])->name('encuesta.delete');
Route::patch('/perfil_admin/agregar_indicadores/editar_encuesta/{encuesta}', [encuestaController::class, 'encuesta_edit'])->name('encuesta.edit');

Route::post('/perfil_admin/agregar_indicadores/encuesta/agregar_pregunta/{encuesta}', [encuestaController::class, 'pregunta_store'])->name('pregunta.store');
Route::delete('/perfil_admin/agregar_indicadores/encuesta/eliminar_pregunta/{pregunta}', [encuestaController::class, 'pregunta_delete'])->name('pregunta.delete');



//Reacomodando los HTML
Route::get('/perfil_admin/departamentos', [departamentoController::class, "departamentos_show_admin"])->name('departamentos.show.admin');
Route::get('/perfil_admin/clientes', [clienteController::class, 'clientes_show_admin'])->name('clientes.show.admin');
Route::get('/perfil_admin/usuarios', [userController::class, 'usuarios_show_admin'])->name("usuarios.show.admin");
Route::get('/perfil_admin/encuestas', [encuestaController::class, 'encuestas_show_admin'])->name('encuestas.show.admin');
Route::get('/perfil_admin/encuestas/preguntas/{encuesta}', [encuestaController::class, 'encuesta_index'])->name('encuesta.index');
Route::get('/perfil_admin/reclamaciones', [quejasController::class, 'index_quejas'])->name('lista.quejas.cliente');


Route::get('/perfil_admin/proveedores', [proveedorController::class, 'proveedores_show_admin'])->name('proveedores.show.admin');
Route::delete('/perfil_admin/proveedores/eliminar/{proveedor}', [proveedorController::class, 'proveedor_delete']  )->name('proveedor.delete');


Route::get('/perfil_admin/proveedores/detalle_evaluacion/{proveedor}', [evaluacionProveedorController::class, 'detalle_evaluacion_proveedor'])->name('detalle.evaluacion.proveedor');


Route::get('/perfil_admin/informacion_foranea', [informacionForaneaController::class, 'informacion_foranea_show_admin'])->name('informacion.foranea.show.admin');



Route::get('/perfil_admin/encuestas/respuestas_clientes/{cliente}/{encuesta}', [clienteController::class, 'show_respuestas'])->name('show.respuestas');

Route::get('perfil_admin/lista_indicadores/encuesta/{encuesta}', [encuestaController::class, 'encuesta_llena_show_admin'] )->name('encuesta.llena.show.admin');




Route::get('/perfil_admin/normas/', [normaController::class, 'cumplimiento_norma_show_admin'])->name('cumplimiento.norma.show.admin');
Route::post('/perfil_admin/normas/agregar/{departamento}', [normaController::class, 'norma_store'])->name('norma.store');
Route::delete('/perfil_admin/normas/borrar/{norma}', [normaController::class, 'norma_delete'])->name('norma.delete');
Route::patch('/perfil_admin/normas/editar/{norma}', [normaController::class, 'norma_update'])->name('norma.update');

Route::get('/perfil_admin/normas/apartado/{norma}', [normaController::class, 'apartado_norma'])->name('apartado.norma');

Route::post('/perfil_admin/normas/apartado/agregar_apartado/{norma}', [apartadoNormaController::class, 'apartado_norma_store'])->name('apartado.norma.store');
Route::delete('/perfil_admin/normas/apartado/eliminar_apartado/{apartado}', [apartadoNormaController::class, 'delete_apartado_norma'])->name('delete.apartado.norma');
Route::patch('/perfil_admin/normas/apartado/editar_apartado/{apartado}', [apartadoNormaController::class, 'edit_apartado_norma'])->name('edit.apartado.norma');

Route::get('/perfil_admin/normas/apartado_admin/{apartado}', [apartadoNormaController::class, 'ver_evidencia_cumplimiento_normativo_admin'])->name('ver.evidencia.cumplimiento.normativo.admin');


//rutas que muestran los indicadores de cada departamento
Route::get('/perfil_admin/lista_indicadores/{departamento}', [indicadorController::class, 'lista_indicadores_admin'])->name('lista.indicadores.admin');

Route::get('/perfil_admin/lista_indicadores/detalle_indicador/{indicador}', [indicadorController::class, 'indicador_lleno_show_admin'])->name('indicador.lleno.show.admin');








//Rutas del seguimiento de las quejas desde el perifl del admin
Route::get('/perfil_admin/quejas/seguimiento_quejas/{queja}',[quejasController::class, 'seguimiento_quejas_admin'])->name('seguimiento_quejas.admin');









//rutas de las evaluaciones de los proveedores
Route::post('/perfil_admin/proveedores/', [proveedorController::class, 'proveedor_store'])->name('proveedor.store');
Route::post('/perfil_usuario/agregar_evauacion/{user}', [userController::class, 'evaluacion_servicio_store'])->name('evaluacion.servicio.store');
Route::get('/perfil_usuario/evaluaciones_proveedores', [evaluacionProveedorController::class, 'evaluaciones_show_user'])->name('evaluaciones.show.user');


Route::get('/login_cliente',[clienteController::class, 'login'])->name('login.cliente');
Route::post('/perfil_cliente', [clienteController::class, 'index_cliente'])->name('index.cliente');
Route::get('/login_cliente/ingreso_cliente', [clienteController::class, 'perfil_cliente'])->name('perfil.cliente');

//Para contestar los cuestionarios
Route::get('/perfil_cliente/cuestionario/{encuesta}', [clienteController::class, 'index_encuesta'])->name("index.encuesta");
Route::post('/perfil_cliente/cuestionario/contestando/{encuesta}', [clienteController::class, 'contestar_encuesta'])->name("contestar.encuesta");

Route::get('/perfil_cliente/cuestionario/contestado/{encuesta}', [clienteController::class, 'index_encuesta_contestada'])->name('index.encuesta.contestada');

Route::post('/perfil_cliente/queja', [clienteController::class, 'queja_cliente'])->name('queja.cliente');
Route::get('/perfil_cliente/lista_quejas', [clienteController::class, 'lista_quejas_clientes'])->name('lista.quejas.clientes.clientes');

Route::get('/perfil_cliente/seguimientos/{queja}', [clienteController::class, 'seguimiento_quejas_cliente'])->name('seguimiento.quejas.cliente');

Route::post('/perfil_cliente/seguimientos/comentando/{queja}', [clienteController::class, 'comentario_user_reclamo'])->name('comentario.user.reclamo');




