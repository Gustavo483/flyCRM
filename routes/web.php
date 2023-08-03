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
            Route::get('vizualizar-lead-admin-user/{id_lead}', 'vizualizarLeadAdminUser')->name('vizualizarLeadAdminUser');
            Route::post('Editar-Lead-admin/{id_lead}', 'EditarLeadAdmin')->name('EditarLeadAdmin');
            Route::post('registrar-leads-admin', 'registrarLeadsAdmin')->name('registrarLeadsAdmin');
            Route::post('filtrar-leads-admin', 'filtrarLeadsAdmin')->name('filtrarLeadsAdmin');

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

            //midias
            Route::post('registrar-midia', 'registrarMidia')->name('registrarMidia');
            Route::post('editar-midia', 'editarMidia')->name('editarMidia');
            Route::post('deletar-midia', 'deletarMidia')->name('deletarMidia');

            //Grupos
            Route::post('registrar-grupo', 'registrarGrupo')->name('registrarGrupo');
            Route::post('editar-grupo', 'editarGrupo')->name('editarGrupo');
            Route::post('deletar-grupo', 'deletarGrupo')->name('deletarGrupo');

            //Fases
            Route::post('registrar-fase', 'registrarFase')->name('registrarFase');
            Route::post('editar-fase', 'editarFase')->name('editarFase');
            Route::post('deletar-fase', 'deletarFase')->name('deletarFase');

            //origens
            Route::post('registrar-origem', 'registrarOrigem')->name('registrarOrigem');
            Route::post('editar-origem', 'editarOrigem')->name('editarOrigem');
            Route::post('deletar-origem', 'deletarOrigem')->name('deletarOrigem');

            //campanha
            Route::post('registrar-campanha', 'registrarCampanha')->name('registrarCampanha');
            Route::post('editar-campanha', 'editarCampanha')->name('editarCampanha');
            Route::post('deletar-campanha', 'deletarCampanha')->name('deletarCampanha');

            //setor
            Route::post('registrar-setor', 'registrarSetor')->name('registrarSetor');
            Route::post('editar-setor', 'editarSetor')->name('editarSetor');
            Route::post('deletar-setor', 'deletarSetor')->name('deletarSetor');

            //Produto servico
            Route::get('produto-servico', 'produtoServico')->name('produtoServico');
            Route::post('registrar-produto-servico', 'registrarProdutoServico')->name('registrarProdutoServico');
            Route::post('editar-produto-servico', 'editarProdutoServico')->name('editarProdutoServico');
            Route::post('deletar-produto-servicos', 'deletarProdutoServicos')->name('deletarProdutoServicos');

            // Kanban
            Route::post('registrar-kanban-admin', 'registrarDadoKanbanAdmin')->name('registrarDadoKanbanAdmin');

            //Oportunidade
            Route::post('registrar-oportunidade-admin', 'registrarOportunidadeAdmin')->name('registrarOportunidadeAdmin');
            Route::post('registrar-observacao-admin', 'registrarObservacaoAdmin')->name('registrarObservacaoAdmin');
            Route::get('vizualizar-oportunidades-user-admin', 'vizualizarOportunidadesUserAdmin')->name('vizualizarOportunidadesUserAdmin');


        });
    });

    Route::middleware('UserAccess')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('dashboard-user', 'dashboardUser')->name('dashboardUser');

            //agenda
            Route::get('vizualizar-agenda-user', 'vizualizarAgendaUser')->name('vizualizarAgendaUser');

            //leads
            Route::get('vizualizar-todas-leads-user', 'vizualizarTodasleadsUser')->name('vizualizarTodasleadsUser');
            Route::post('registrar-leads', 'registrarLeads')->name('registrarLeads');
            Route::post('filtrar-leads', 'filtrarLeads')->name('filtrarLeads');
            Route::get('vizualizar-lead-user/{id_lead}', 'vizualizarLeadUser')->name('vizualizarLeadUser');
            Route::post('Editar-Lead{id_lead}', 'EditarLead')->name('EditarLead');

            // Oportunidades
            Route::get('vizualizar-oportunidades-user', 'vizualizarOportunidadesUser')->name('vizualizarOportunidadesUser');
            Route::post('registrar-oportunidade', 'registrarOportunidade')->name('registrarOportunidade');
            Route::post('registrar-observacao', 'registrarObservacao')->name('registrarObservacao');

            //Produto servico
            Route::get('produto-servico-user', 'produtoServicoUser')->name('produtoServicoUser');
            Route::post('registrar-produto-servico-user', 'registrarProdutoServicoUser')->name('registrarProdutoServicoUser');
            Route::post('editar-produto-servico-user', 'editarProdutoServicoUser')->name('editarProdutoServicoUser');

            Route::get('teste-kanban', 'kanbanteste')->name('kanbanteste');

            Route::post('registrar-dado-kanban', 'registrarDadoKanban')->name('registrarDadoKanban');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/board/{id}/reorder', [UserController::class, 'saveTasksOrder'])->middleware(['auth', 'verified'])->name('saveTasksOrder');
});

require __DIR__.'/auth.php';
