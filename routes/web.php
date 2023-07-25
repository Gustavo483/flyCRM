<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
});

Route::get('/dashboard', [AuthenticatedSessionController::class, 'validatePermission'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('AdminAccess')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('dashboard-admin', 'dashboardAdmin')->name('dashboardAdmin');

            // Rotas Empresas
            Route::post('registerEmpresa', 'registerEmpresa')->name('registerEmpresa');
            Route::get('vizualizar-empresa/{id_empresa}', 'vizualizarEmpresa')->name('vizualizarEmpresa');
            Route::get('vizualizar-todas-empresa', 'vizualizarTodasEmpresa')->name('vizualizarTodasEmpresa');

            // Rotas Planos
            Route::get('vizualizar-planos', 'vizualizarPlanos')->name('vizualizarPlanos');

            // Rotas Chamados
            Route::get('vizualizar-chamados', 'vizualizarChamados')->name('vizualizarChamados');
        });
    });

    Route::middleware('AdminUserAccess')->group(function () {
        Route::controller(AdminUserController::class)->group(function () {
            Route::get('dashboard-admin-user', 'dashboardAdminUser')->name('dashboardAdminUser');

            //Leads
            Route::get('vizualizar-todas-leads-empresa', 'vizualizarTodasleadsEmpresa')->name('vizualizarTodasleadsEmpresa');

            //agenda
            Route::get('vizualizar-agenda', 'vizualizarAgenda')->name('vizualizarAgenda');

            //configuracoes
            Route::get('configuracao-empresa', 'configuracaoEmpresa')->name('configuracaoEmpresa');

            //Usuarios
            Route::post('registrar-usuario', 'registrarUsuario')->name('registrarUsuario');
            Route::post('editar-usuario', 'editarUsuario')->name('editarUsuario');
            Route::post('deletar-usuaio', 'deletarUsuaio')->name('deletarUsuaio');

            //Status
            Route::post('registrar-status', 'registrarStatus')->name('registrarStatus');
            Route::post('editar-status', 'editarStatus')->name('editarStatus');
            Route::post('deletar-status', 'deletarStatus')->name('deletarStatus');

        });
    });

    Route::middleware('UserAccess')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('dashboard-user', 'dashboardUser')->name('dashboardUser');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
