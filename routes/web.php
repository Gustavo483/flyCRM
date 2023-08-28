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


Route::get('/registrar-lead-externo', [AdminUserController::class, 'registrarLeadExterno'])->name('registrarLeadExterno');


Route::middleware('auth')->group(function () {

    Route::middleware('AdminAccess')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('dashboard-admin', 'dashboardAdmin')->name('dashboardAdmin');

            // Rotas Empresas
            Route::post('registrar-empresa', 'registerEmpresa')->name('registerEmpresa');
            Route::get('visualizar-empresa/{id_empresa}', 'vizualizarEmpresa')->name('vizualizarEmpresa');
            Route::get('visualizar-todas-empresa', 'vizualizarTodasEmpresa')->name('vizualizarTodasEmpresa');

            // Rotas Planos
            Route::get('visualizar-planos', 'vizualizarPlanos')->name('vizualizarPlanos');

            // Rotas Chamados
            Route::get('visualizar-chamados', 'vizualizarChamados')->name('vizualizarChamados');

        });
    });

    Route::middleware('AdminUserAccess')->group(function () {
        Route::controller(AdminUserController::class)->group(function () {
            Route::get('dashboard-admin-user', 'dashboardAdminUser')->name('dashboardAdminUser');

            Route::get('gerar-planilha-veriaveis', 'GerarPlanilhaVeriaveis')->name('GerarPlanilhaVeriaveis');

            //Leads
            Route::get('visualizar-todas-leads-empresa', 'vizualizarTodasleadsEmpresa')->name('vizualizarTodasleadsEmpresa');
            Route::get('visualizar-lead-admin-user/{id_lead}', 'vizualizarLeadAdminUser')->name('vizualizarLeadAdminUser');
            Route::post('Editar-Lead-admin/{id_lead}', 'EditarLeadAdmin')->name('EditarLeadAdmin');
            Route::post('registrar-leads-admin', 'registrarLeadsAdmin')->name('registrarLeadsAdmin');
            Route::post('filtrar-leads-admin', 'filtrarLeadsAdmin')->name('filtrarLeadsAdmin');
            Route::post('filtrar-leads-avancado-admin', 'filtrarLeadsAvancadoAdmin')->name('filtrarLeadsAvancadoAdmin');
            Route::get('atualizar-status-lead-admin/{id_lead}/{id_status}', 'AtualizarStatusLeadAdmin')->name('AtualizarStatusLeadAdmin');
            Route::post('Import-lead-excel', 'ImportLeadExcel')->name('ImportLeadExcel');


            //agenda
            Route::get('visualizar-agenda', 'vizualizarAgenda')->name('vizualizarAgenda');
            Route::post('registrar-atividade-agenda', 'registrarAtividadeAgenda')->name('registrarAtividadeAgenda');

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
            Route::post('editar-kanban-admin', 'editarDadoKanbanAdmin')->name('editarDadoKanbanAdmin');
            Route::post('deletar-kanban-admin', 'deletarDadoKanbanAdmin')->name('deletarDadoKanbanAdmin');

            //Oportunidade
            Route::post('registrar-oportunidade-admin', 'registrarOportunidadeAdmin')->name('registrarOportunidadeAdmin');
            Route::post('registrar-observacao-admin', 'registrarObservacaoAdmin')->name('registrarObservacaoAdmin');
            Route::get('visualizar-oportunidades-user-admin', 'vizualizarOportunidadesUserAdmin')->name('vizualizarOportunidadesUserAdmin');
            Route::post('editar-status-oportunidade-admin', 'editarStatusOportunidadeAdmin')->name('editarStatusOportunidadeAdmin');

            // Converter em cliente
            Route::get('converter-cliente-admin/{id_lead}', 'ConverterClienteAdmin')->name('ConverterClienteAdmin');

            // Relatorio
            Route::post('relatorio-empresa', 'relatorioEmpresa')->name('relatorioEmpresa');

            //Venda
            Route::post('registrar-venda-admin/{id_lead}', 'registrarVendaAdmin')->name('registrarVendaAdmin');


        });
    });

    Route::middleware('UserAccess')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('dashboard-user', 'dashboardUser')->name('dashboardUser');

            //agenda
            Route::get('visualizar-agenda-user', 'vizualizarAgendaUser')->name('vizualizarAgendaUser');
            Route::post('registrar-atividade-agenda-user', 'registrarAtividadeAgendaUser')->name('registrarAtividadeAgendaUser');

            //leads
            Route::get('visualizar-todas-leads-user', 'vizualizarTodasleadsUser')->name('vizualizarTodasleadsUser');
            Route::post('registrar-leads', 'registrarLeads')->name('registrarLeads');
            Route::post('filtrar-leads', 'filtrarLeads')->name('filtrarLeads');
            Route::post('filtrar-leads-avancado-user', 'filtrarLeadsAvancadoUser')->name('filtrarLeadsAvancadoUser');
            Route::get('visualizar-lead-user/{id_lead}', 'vizualizarLeadUser')->name('vizualizarLeadUser');
            Route::post('Editar-Lead{id_lead}', 'EditarLead')->name('EditarLead');
            Route::get('atualizar-status-lead-user/{id_lead}/{id_status}', 'AtualizarStatusLeadUser')->name('AtualizarStatusLeadUser');

            // Oportunidades
            Route::get('visualizar-oportunidades-user', 'vizualizarOportunidadesUser')->name('vizualizarOportunidadesUser');
            Route::post('registrar-oportunidade', 'registrarOportunidade')->name('registrarOportunidade');
            Route::post('registrar-observacao', 'registrarObservacao')->name('registrarObservacao');
            Route::post('editar-status-oportunidade-user', 'editarStatusOportunidadeUser')->name('editarStatusOportunidadeUser');

            //Produto servico
            Route::get('produto-servico-user', 'produtoServicoUser')->name('produtoServicoUser');
            Route::post('registrar-produto-servico-user', 'registrarProdutoServicoUser')->name('registrarProdutoServicoUser');
            Route::post('editar-produto-servico-user', 'editarProdutoServicoUser')->name('editarProdutoServicoUser');

            // Kanban
            Route::post('registrar-dado-kanban', 'registrarDadoKanban')->name('registrarDadoKanban');
            Route::post('editar-kanban', 'editarDadoKanban')->name('editarDadoKanban');
            Route::post('deletar-kanban', 'deletarDadoKanban')->name('deletarDadoKanban');

            // Converter em cliente
            Route::get('converter-cliente-user/{id_lead}', 'ConverterClienteUser')->name('ConverterClienteUser');

        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/board/{id}/reorder', [UserController::class, 'saveTasksOrder'])->middleware(['auth', 'verified'])->name('saveTasksOrder');
});

require __DIR__.'/auth.php';
