<?php

namespace App\Http\Controllers;

use App\Models\Campanha;
use App\Models\ColumnsKhanban;
use App\Models\Fase;
use App\Models\Grupo;
use App\Models\Midia;
use App\Models\Origem;
use App\Models\Setor;
use App\Models\User;
use App\Constant\ConstantSystem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function dashboardAdminUser()
    {
        return view('AdminUser.dashboard',['tela'=>'dashboard']);
    }

    public function vizualizarTodasleadsEmpresa()
    {
        return view('AdminUser.leads.vizualizarTodasleadsEmpresa',['tela'=>'leads']);
    }

    public function vizualizarAgenda()
    {
        return view('AdminUser.agenda.vizualizarAgenda',['tela'=>'agenda']);
    }

    public function configuracaoEmpresa()
    {
        $id_empresa = auth()->user()->id_empresa;

        $dados = [
            'usuarios' => User::where('int_permisionAccess', ConstantSystem::User)->where('id_empresa',$id_empresa)->get(),
            'status' =>ColumnsKhanban::where('id_empresa', $id_empresa)->orderBy('int_posicao')->get(),
            'midias'=>Midia::where('id_empresa', $id_empresa)->get(),
            'grupos'=>Grupo::where('id_empresa', $id_empresa)->get(),
            'fases'=>Fase::where('id_empresa', $id_empresa)->get(),
            'origens'=>Origem::where('id_empresa', $id_empresa)->get(),
            'campanhas'=>Campanha::where('id_empresa', $id_empresa)->get(),
            'setores'=>Setor::where('id_empresa', $id_empresa)->get(),
        ];
        return view('AdminUser.configuracao.configuracaoEmpresa',['tela'=>'configuracao','dados'=>$dados]);
    }

    public function registrarUsuario(Request $request)
    {
        try {
            $validacao = [
                'name' => 'required',
                'email'=>'required|unique:users',
                'password'=>'required',
                'id_setor' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
                'unique'=> 'O email já está cadastrado no sistema'
            ];
            $request->validate($validacao, $feedback);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_setor'=> $request->id_setor,
                'int_permisionAccess' => ConstantSystem::User,
                'id_empresa'=>auth()->user()->id_empresa,
            ]);
            return  redirect()->back()->with('success', 'Usuario cadastrado com sucesso');

        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível salvar o usuario, favor verificar os dados e tentar novamente.');
        }
    }

    public function editarUsuario(Request $request)
    {
        try {
            $validacao = [
                'name' => 'required',
                'id_setor' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível editar o usuario, favor verificar os dados e tentar novamente.');
        }

        $user = User::where('id', $request->id)->first();

        if ($request->email){
            if($user->email != $request->email){
                $verificarEmail = User::where('email', $request->email)->count();
                if($verificarEmail){
                    return redirect()->back()->with('error', 'O email editado para o usuario já está em uso.');
                }
            }
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email ? $request->email :$user->email,
            'password' => $request->password ? Hash::make($request->password) :$user->password,
            'id_setor'=> $request->id_setor,
        ]);

        return redirect()->back()->with('success', 'Usuario Cadastro com sucesso');
    }

    public function deletarUsuaio(Request $request){
        try {
            User::where('id',$request->id)->delete();
            return redirect()->back()->with('success', 'Usuario excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir o usuário, favor entrar em contato suporte,');
        }
    }


    public function registrarStatus(Request $request)
    {
        try {
            $validacao = [
                'st_titulo' => 'required',
                'int_posicao' => 'required',
                'st_color' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar o status do Kankan. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        ColumnsKhanban::create([
            'id_empresa'=>$id_empresa,
            'st_titulo'=>$request->st_titulo,
            'int_posicao'=>$request->int_posicao,
            'int_tipoKhanban'=>ConstantSystem::KanbanStatus,
            'st_color'=>$request->st_color,
        ]);

        return  redirect()->back()->with('success', 'Status cadastrado com sucesso');

    }

    public function editarStatus(Request $request)
    {

        try {
            $validacao = [
                'st_titulo' => 'required',
                'int_posicao' => 'required',
                'st_color' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível editar o status do Kankan. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;
        $kanban = ColumnsKhanban::where('id_columnsKhanban',$request->id_columnsKhanban)->first();
        $kanban->update([
            'st_titulo'=>$request->st_titulo,
            'int_posicao'=>$request->int_posicao,
            'st_color'=>$request->st_color,
        ]);
        return  redirect()->back()->with('success', 'Status atualizado com sucesso');

    }

    public function deletarStatus(Request $request)
    {
        try {
            ColumnsKhanban::where('id_columnsKhanban', $request->id_columnsKhanban)->delete();
            return redirect()->back()->with('success', 'Status excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir o Status, favor entrar em contato suporte,');
        }
    }


    public function registrarMidia(Request $request)
    {
        try {
            $validacao = [
                'st_nomeMidia' => 'required',
            ];

            $feedback = [
                'st_nomeMidia' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a mídia. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        Midia::create([
            'id_empresa'=>$id_empresa,
            'st_nomeMidia'=>$request->st_nomeMidia,
        ]);

        return  redirect()->back()->with('success', 'Mídia cadastrada com sucesso');
    }

    public function editarMidia(Request $request)
    {
        try {
            $validacao = [
                'st_nomeMidia' => 'required',
            ];

            $feedback = [
                'st_nomeMidia' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível editar a mídia. Favor verificar os dados e tentar novamente.');
        }

        $midia = Midia::where('id_midia', $request->id_midia)->first();

        $midia->update([
            'st_nomeMidia' => $request->st_nomeMidia
        ]);

        return redirect()->back()->with('success', 'Midia editada com sucesso');
    }

    public function deletarMidia(Request $request)
    {
        try {
            Midia::where('id_midia',$request->id_midia)->delete();
            return redirect()->back()->with('success', 'Mídia excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir a Mídia, favor entrar em contato suporte.');
        }
    }

    public function registrarGrupo(Request $request)
    {
        try {
            $validacao = [
                'st_nomeGrupo' => 'required',
            ];

            $feedback = [
                'st_nomeGrupo' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar o grupo. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        Grupo::create([
            'id_empresa'=>$id_empresa,
            'st_nomeGrupo'=>$request->st_nomeGrupo,
        ]);

        return  redirect()->back()->with('success', 'Grupo cadastrado com sucesso');
    }

    public function editarGrupo(Request $request)
    {
        try {
            $validacao = [
                'st_nomeGrupo' => 'required',
            ];

            $feedback = [
                'st_nomeGrupo' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível editar o grupo. Favor verificar os dados e tentar novamente.');
        }

        $grupo = Grupo::where('id_grupo', $request->id_grupo)->first();

        $grupo->update([
            'st_nomeGrupo' => $request->st_nomeGrupo
        ]);

        return redirect()->back()->with('success', 'Grupo editado com sucesso');
    }

    public function deletarGrupo(Request $request)
    {
        try {
            Grupo::where('id_grupo',$request->id_grupo)->delete();
            return redirect()->back()->with('success', 'Grupo excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir o grupo, favor entrar em contato com o suporte');
        }
    }

    public function registrarFase(Request $request)
    {
        try {
            $validacao = [
                'st_nomeFase' => 'required',
            ];

            $feedback = [
                'st_nomeFase' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a fase. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        Fase::create([
            'id_empresa'=>$id_empresa,
            'st_nomeFase'=>$request->st_nomeFase,
        ]);

        return  redirect()->back()->with('success', 'Fase cadastrada com sucesso');
    }

    public function editarFase(Request $request)
    {
        try {
            $validacao = [
                'st_nomeFase' => 'required',
            ];

            $feedback = [
                'st_nomeFase' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível editar a fase. Favor verificar os dados e tentar novamente.');
        }

        $fase = Fase::where('id_fase', $request->id_fase)->first();

        $fase->update([
            'st_nomeFase' => $request->st_nomeFase
        ]);

        return redirect()->back()->with('success', 'Fase editada com sucesso.');
    }

    public function deletarFase(Request $request)
    {
        try {
            Fase::where('id_fase', $request->id_fase)->delete();
            return redirect()->back()->with('success', 'Fase excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir a Fase, favor entrar em contato com o suporte.');
        }
    }
    public function registrarOrigem(Request $request)
    {
        try {
            $validacao = [
                'st_nomeOrigem' => 'required',
            ];

            $feedback = [
                'st_nomeOrigem' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a origem. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        Origem::create([
            'id_empresa'=>$id_empresa,
            'st_nomeOrigem'=>$request->st_nomeOrigem,
        ]);

        return  redirect()->back()->with('success', 'Origem cadastrada com sucesso.');
    }

    public function editarOrigem(Request $request)
    {
        try {
            $validacao = [
                'st_nomeOrigem' => 'required',
            ];

            $feedback = [
                'st_nomeOrigem' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível editar a origem. Favor verificar os dados e tentar novamente.');
        }

        $origem = Origem::where('id_origem', $request->id_origem)->first();

        $origem->update([
            'st_nomeOrigem' => $request->st_nomeOrigem
        ]);

        return redirect()->back()->with('success', 'Origem editada com sucesso.');
    }

    public function deletarOrigem(Request $request)
    {
        try {
            Origem::where('id_origem',$request->id_origem)->delete();
            return redirect()->back()->with('success', 'Origem excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir a origem, favor entrar em contato com o suporte');
        }
    }

    public function registrarCampanha(Request $request)
    {
        try {
            $validacao = [
                'st_nomeCampanha' => 'required',
            ];

            $feedback = [
                'st_nomeCampanha' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a campanha. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        Campanha::create([
            'id_empresa'=>$id_empresa,
            'st_nomeCampanha'=>$request->st_nomeCampanha,
        ]);

        return  redirect()->back()->with('success', 'Campanha cadastrada com sucesso.');
    }

    public function editarCampanha(Request $request)
    {
        try {
            $validacao = [
                'st_nomeCampanha' => 'required',
            ];

            $feedback = [
                'st_nomeCampanha' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a campanha. Favor verificar os dados e tentar novamente.');
        }

        $campanha = Campanha::where('id_campanha', $request->id_campanha)->first();

        $campanha->update([
            'st_nomeCampanha' => $request->st_nomeCampanha
        ]);

        return redirect()->back()->with('success', 'Campanha editada com sucesso');
    }

    public function deletarCampanha(Request $request)
    {
        try {
            Campanha::where('id_campanha',$request->id_campanha)->delete();
            return redirect()->back()->with('success', 'Campanha excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir a campanha, favor entrar em contato com o suporte.');
        }
    }


    public function registrarSetor(Request $request)
    {
        try {
            $validacao = [
                'st_nomeSetor' => 'required',
            ];

            $feedback = [
                'st_nomeSetor' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar o setor. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        Setor::create([
            'id_empresa'=>$id_empresa,
            'st_nomeSetor'=>$request->st_nomeSetor,
        ]);

        return  redirect()->back()->with('success', 'Setor cadastrada com sucesso.');
    }

    public function editarSetor(Request $request)
    {
        try {
            $validacao = [
                'st_nomeSetor' => 'required',
            ];

            $feedback = [
                'st_nomeSetor' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar o setor. Favor verificar os dados e tentar novamente.');
        }

        $setor = Setor::where('id_setor', $request->id_setor)->first();

        $setor->update([
            'st_nomeSetor' => $request->st_nomeSetor
        ]);

        return redirect()->back()->with('success', 'Setor editada com sucesso.');
    }

    public function deletarSetor(Request $request)
    {
        try {
            Setor::where('id_setor',$request->id_setor)->delete();
            return redirect()->back()->with('success', 'Setor excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir o setor, favor entrar em contato com o suporte.');
        }
    }
}
