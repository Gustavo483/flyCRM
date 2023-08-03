<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Lead;
use App\Models\User;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboardAdmin()
    {
        $usersEmpresas = User::where('int_permisionAccess',1)->get();
        $dadosInfo = [
            'empresas'=> count($usersEmpresas),
            'leads'=>count(Lead::all()),
            'suporte'=>0,
        ];
        return view('adminRoot.dashboard', ['dadosInfo'=>$dadosInfo,'usersEmpresas'=>$usersEmpresas, 'tela'=>'dashboard']);
    }
    public function registerEmpresa(Request $request)
    {
        try {
            $validacao = [
                'st_nomeEmpresa' => 'required',
                'name'=>'required',
                'email'=>'required|unique:users',
                'password'=>'required',
                'st_DocResponsavel' => 'required',
                'st_telefone' => 'required',
                'id_plano' => 'required',
                'st_periodicidade'=> 'required',
                'bl_ativo'=> 'required',
                'dt_validade'=> 'required'
            ];

            $feedback = [
                'required' => 'O campo é requirido',
                'unique'=> 'O email já está cadastrado no sistema'
            ];

            $request->validate($validacao, $feedback);
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'O email informado já está em uso, favor registrar um novo.');
        }
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'int_permisionAccess' => 1,
            ]);

            $dataAtual = new DateTime();

            $dataAtual->add(new DateInterval("P".$request->dt_validade."Y"));

            $empresa = Empresa::create([
                'st_nomeEmpresa' => $request->st_nomeEmpresa,
                'st_DocResponsavel' => $request->st_DocResponsavel,
                'st_telefone' => $request->st_telefone,
                'id_plano' => $request->id_plano,
                'st_periodicidade' => $request->st_periodicidade,
                'bl_ativo' => $request->bl_ativo,
                'st_descricao'=>$request->st_descricao ? : null,
                'dt_validade' => $dataAtual,
            ]);

            $user->update([
                'id_empresa'=>$empresa->id_empresa,
            ]);

            return redirect()->back()->with('success', 'Empresa Cadastrada com sucesso');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro na sua solicitação, favor contatar o suporte');
        }
    }

    public function vizualizarEmpresa(Empresa $id_empresa)
    {
        return view('adminRoot.empresas.vizualizarEmpresa',['id_empresa'=>$id_empresa]);
    }
    public function vizualizarTodasEmpresa()
    {
        $usersEmpresas = User::where('int_permisionAccess',1)->get();
        $dadosInfo = [
            'empresas'=> count($usersEmpresas),
            'leads'=>count(Lead::all()),
            'suporte'=>0,
        ];

        return view('adminRoot.empresas.vizualizarTodasEmpresa', ['dadosInfo'=>$dadosInfo,'usersEmpresas'=>$usersEmpresas, 'tela'=>'empresas']);
    }

    public function vizualizarPlanos()
    {
        $empresas = Empresa::all();

        $dadosInfo = [
            'empresas'=> count($empresas),
            'leads'=>count(Lead::all()),
            'suporte'=>0,
        ];
        return view('adminRoot.planos.vizualizarPlanos', ['dadosInfo'=>$dadosInfo,'tela'=>'planos']);
    }

    public function vizualizarChamados()
    {
        $empresas = Empresa::all();

        $dadosInfo = [
            'empresas'=> count($empresas),
            'leads'=>count(Lead::all()),
            'suporte'=>0,
        ];
        return view('adminRoot.chamados.vizualizarChamados', ['dadosInfo'=>$dadosInfo,'tela'=>'chamados']);
    }
}
