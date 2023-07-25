<?php

namespace App\Http\Controllers;

use App\Models\ColumnsKhanban;
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
                'st_setor' => 'required',
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
                'st_setor'=> $request->st_setor,
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
                'st_setor' => 'required',
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
            'st_setor'=> $request->st_setor,
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
        dd($request->all());
    }

    public function deletarStatus(Request $request)
    {
        dd($request->all());
    }
}
