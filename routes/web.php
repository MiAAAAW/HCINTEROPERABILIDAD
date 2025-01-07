<?php


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\PrdCursosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\InscribirController;
use App\Http\Controllers\EstudianteNotasController;
use App\Http\Controllers\MencionController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReniecController;
use App\Models\Noticia;

/*
 *
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('login' , [AuthController::class , 'login'] );
Route::post('login' , [AuthController::class , 'AuthLogin'] );
Route::get('logout' , [AuthController::class , 'logout'] );
Route::get('forgot-password' , [AuthController::class , 'forgotpassword'] );
Route::post('forgot-password' , [AuthController::class , 'PostForgotPassword'] );
Route::get('reset/{token}' , [AuthController::class , 'reset'] );
Route::post('reset/{token}' , [AuthController::class , 'PostReset'] );




Route::get('/', function () {
    // Si el usuario está autenticado, cerramos la sesión y redirigimos a la misma página
    if (Auth::check()) {
        Auth::logout();
        return redirect('/');
    }

    // Cargamos las imágenes desde 'public/images'
    $images = Storage::files('public/images');

    // Llamamos al controlador MencionController para cargar las menciones
    $response = app()->call('App\Http\Controllers\MencionController@index');


    // Obtenemos las noticias desde la base de datos
    $noticias = Noticia::orderBy('fecha_publicacion', 'desc')->get();

    // Pasamos las imágenes, noticias y menciones a la vista
    return view('welcome', array_merge($response->getData(), ['images' => $images, 'noticias' => $noticias]));
})->name('/');


Route::get('/mencion/{slug}', [MencionController::class, 'mostrarCursos'])->name('mencion.cursos');

Route::get('historia', function () {
   return view('layouts.frontend.history');
})->name('historia');

Route::get('mision', function () {
   return view('layouts.frontend.misionvision');
})->name('mision');

Route::get('sendemail', function () {
    return view('layouts.frontend.sendemail');
})->name('sendemail');


Route::group(['middleware' => 'admin'], function (){

    Route::get('admin/dashboard' , [DashboardController::class , 'dashboard'] );
    Route::get('admin/admin/list' , [AdminController::class , 'list'] );
    Route::post('admin/admin/list' , [AdminController::class , 'list'] );
    Route::get('admin/admin/add' , [AdminController::class , 'add'] );
    Route::post('admin/admin/add' , [AdminController::class , 'insert'] );
    Route::get('admin/admin/edit/{id}' , [AdminController::class , 'edit']);
    Route::post('admin/admin/edit/{id}' , [AdminController::class , 'update']);
    Route::get('admin/admin/delete/{id}' , [AdminController::class , 'delete']);

    //estudiante - student
    Route::get('admin/estudiante/list' , [EstudianteController::class , 'list'] );
    Route::post('admin/estudiante/list' , [EstudianteController::class , 'list'] );
    Route::get('admin/estudiante/add' , [EstudianteController::class , 'add'] );
    Route::post('admin/estudiante/add' , [EstudianteController::class , 'insert'] );
    Route::get('admin/estudiante/edit/{id}' , [EstudianteController::class , 'edit']);
    Route::post('admin/estudiante/edit/{id}' , [EstudianteController::class , 'update']);
    Route::get('admin/estudiante/delete/{id}' , [EstudianteController::class , 'delete']);

    //periodo - class
    Route::get('admin/periodo/list' , [PeriodoController::class , 'list'] );
    Route::post('admin/periodo/list' , [PeriodoController::class , 'list'] );
    Route::get('admin/periodo/add' , [PeriodoController::class , 'add'] );
    Route::post('admin/periodo/add' , [PeriodoController::class , 'insert'] );
    Route::get('admin/periodo/edit/{id}' , [PeriodoController::class , 'edit'] );
    Route::post('admin/periodo/edit/{id}' , [PeriodoController::class , 'update'] );
    Route::get('admin/periodo/delete/{id}' , [PeriodoController::class , 'delete'] );

    //cursos - subject
    Route::get('admin/cursos/list' , [CursosController::class , 'list'] );
    Route::post('admin/cursos/list' , [CursosController::class , 'list'] );
    Route::get('admin/cursos/add' , [CursosController::class , 'add'] );
    Route::post('admin/cursos/add' , [CursosController::class , 'insert'] );
    Route::get('admin/cursos/edit/{id}' , [CursosController::class , 'edit'] );
    Route::post('admin/cursos/edit/{id}' , [CursosController::class , 'update'] );
    Route::get('admin/cursos/delete/{id}' , [CursosController::class , 'delete'] );

    //periodos_cursos - assign_subject
    Route::get('admin/periodo_cursos/list' , [PrdCursosController::class , 'list'] );
    Route::post('admin/periodo_cursos/list' , [PrdCursosController::class , 'list'] );
    Route::get('admin/periodo_cursos/add' , [PrdCursosController::class , 'add'] );
    Route::post('admin/periodo_cursos/add' , [PrdCursosController::class , 'insert'] );
    Route::get('admin/periodo_cursos/edit/{id}' , [PrdCursosController::class , 'edit'] );
    Route::post('admin/periodo_cursos/edit/{id}' , [PrdCursosController::class , 'update'] );
    Route::get('admin/periodo_cursos/delete/{id}' , [PrdCursosController::class , 'delete'] );
    Route::get('admin/periodo_cursos/edit_single/{id}' , [PrdCursosController::class , 'edit_single'] );
    Route::post('admin/periodo_cursos/edit_single/{id}' , [PrdCursosController::class , 'update_single'] );


    //images
    Route::post('/admin/flayer', [ImageController::class, 'uploadImage'])->name('admin.flayer.upload');
    Route::get('/admin/flayer', [ImageController::class, 'showGallery'])->name('admin.flayer');

    // inscripción - enroll
    Route::get('admin/inscribir/list', [InscribirController::class, 'list']);
    Route::post('admin/inscribir/list' , [InscribirController::class , 'list'] );
    Route::get('admin/inscribir/add', [InscribirController::class, 'add']);
    Route::post('admin/inscribir/add', [InscribirController::class, 'insert']);
    Route::get('admin/inscribir/edit/{id}', [InscribirController::class, 'edit']);
    Route::post('admin/inscribir/edit/{id}', [InscribirController::class, 'update']);
    Route::get('admin/inscribir/delete/{id}', [InscribirController::class, 'delete']);

    //cambiar contraseña - change_password
    Route::get('admin/change_password' , [UserController::class , 'change_password'] );
    Route::post('admin/change_password', [UserController::class , 'update_change_password'] );


    // Rutas para el CRUD de noticias en el dashboard del administrador
    Route::get('/admin/noticias', [NoticiaController::class, 'index'])->name('admin.noticias.index');
    Route::get('/admin/noticias/create', [NoticiaController::class, 'create'])->name('admin.noticias.create');
    Route::post('/admin/noticias', [NoticiaController::class, 'store'])->name('admin.noticias.store');
    Route::get('/admin/noticias/{id}/edit', [NoticiaController::class, 'edit'])->name('admin.noticias.edit');
    Route::put('/admin/noticias/{id}', [NoticiaController::class, 'update'])->name('admin.noticias.update');
    Route::delete('/admin/noticias/{id}', [NoticiaController::class, 'destroy'])->name('admin.noticias.destroy');


});

Route::group(['middleware' =>'docente'], function (){

    Route::get('docente/dashboard' , [DashboardController::class , 'dashboard'] );

    Route::get('docente/change_password' , [UserController::class , 'change_password'] );
    Route::post('docente/change_password', [UserController::class , 'update_change_password'] );


});


Route::group(['middleware' =>'estudiante'], function (){

    Route::get('estudiante/dashboard' , [DashboardController::class , 'dashboard'] );
    //Route::get('estudiante/notas', [EstudianteNotasController::class, 'notas']);

    Route::get('estudiante/change_password' , [UserController::class , 'change_password'] );
    Route::post('estudiante/change_password', [UserController::class , 'update_change_password'] );

    
    // --- RUTAS PARA EL CONSUMO DE RENIEC A TRAVÉS DE PIDE ---
    // Actualizar credencial (cambiar clave en RENIEC/PIDE)
    Route::post('estudiante/reniec/actualizar', [ReniecController::class, 'actualizarCredencial'])
         ->name('reniec.actualizar');

    // Consultar datos de una persona por DNI
    Route::post('estudiante/reniec/consultar', [ReniecController::class, 'consultarDatos'])
         ->name('reniec.consultar');

});
