<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
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
        return view('adminRoot.dashboard');
    }
    public function registerEmpresa(Request $request)
    {
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

        try {
            $request->validate($validacao, $feedback);

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
                'id_user' => $user->id,
                'dt_validade43222' => $dataAtual,
            ]);

            $user->update([
                'id_empresa'=>$empresa->id_empresa,
            ]);

            return redirect()->back()->with('success', 'Empresa Cadastrada com sucesso');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro na sua solicitação, favor contatar o suporte');

        }
    }
}
