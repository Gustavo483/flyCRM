<?php

namespace App\Http\Controllers;

use App\Models\Campanha;
use App\Models\ColumnsKhanban;
use App\Models\Fase;
use App\Models\Grupo;
use App\Models\Lead;
use App\Models\Midia;
use App\Models\Origem;
use App\Models\ProdutoServico;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function vizualizarLeadUser( Lead $id_lead)
    {
        dd($id_lead);
    }
    public function registrarLeads(Request $request)
    {
        try {
            $validacao = [
                'st_nome' => 'required',
                'st_email' => 'required',
                'int_telefone' => 'required',
                'id_origem' => 'required',
                'id_midia' => 'required',
                'id_campanha' => 'required',
                'id_produtoServico' => 'required',
                'id_fase' => 'required',
                'id_grupo' => 'required',
                'id_columnsKhanban' => 'required',
                'st_descricao' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];

            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar o Lead. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;
        $usuario = auth()->user()->id;

        Lead::create([
            'st_nome'=>$request->st_nome,
            'int_telefone'=>$request->int_telefone,
            'int_posicao'=>Lead::where('id_columnsKhanban', $request->id_columnsKhanban)->count() + 1,
            'st_email'=>$request->st_email,
            'id_origem'=>$request->id_origem,
            'id_midia'=>$request->id_midia,
            'id_campanha'=>$request->id_campanha,
            'id_produtoServico'=>$request->id_produtoServico,
            'id_fase'=>$request->id_fase,
            'int_temperatura'=>$request->int_temperatura,
            'id_grupo'=>$request->id_grupo,
            'st_observacoes'=>$request->st_observacoes ? $request->st_observacoes : null ,
            'id_userResponsavel'=>$usuario,
            'id_columnsKhanban'=>$request->id_columnsKhanban,
            'id_empresa'=>$id_empresa
        ]);

        return redirect()->back()->with('success', 'Lead cadastrado com sucesso.');
    }
    public function dashboardUser()
    {
        $usuario = auth()->user()->id;
        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_userResponsavel',$usuario)->get();
        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>0,
            'atendimento'=>0,
        ];
        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get()
        ];
        return view('User.dashboard', ['tela' =>'dashboard','dadosInfo'=>$dadosInfo, 'dadosCadastroLeads'=>$dadosCadastroLeads ]);
    }

    public function vizualizarAgendaUser()
    {
        return view('User.agenda.vizualizarAgenda', ['tela' =>'agenda']);
    }

    public function vizualizarTodasleadsUser()
    {
        $usuario = auth()->user()->id;
        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_userResponsavel',$usuario)->get();
        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>0,
            'atendimento'=>0,
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get()
        ];

        return view('User.leads.vizualizarTodasLeadsUser', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads]);
    }

    public function vizualizarOportunidadesUser()
    {
        return view('User.oportunidades.vizualizarOportunidadesUser', ['tela' =>'oportunidade']);
    }

    public function produtoServicoUser()
    {
        $id_empresa = auth()->user()->id_empresa;
        $produtos = ProdutoServico::where('id_empresa',$id_empresa)->get();
        return view('User.produtoServico.index', ['tela' =>'produtoServico', 'produtos'=>$produtos]);
    }

    public function registrarProdutoServicoUser(Request $request)
    {
        try {
            $validacao = [
                'st_nomeProdutoServico' => 'required',
                'st_color' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];

            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar o Produto/Serviço. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        ProdutoServico::create([
            'id_empresa'=>$id_empresa,
            'st_nomeProdutoServico'=>$request->st_nomeProdutoServico,
            'st_descricao'=>$request->st_descricao ? $request->st_descricao : null,
            'st_color'=>$request->st_color
        ]);

        return  redirect()->back()->with('success', 'Status cadastrado com sucesso');
    }

    public function editarProdutoServicoUser(Request $request)
    {

        try {
            $validacao = [
                'st_nomeProdutoServico' => 'required',
                'st_color' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];

            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível editar o Produto/Serviço. Favor verificar os dados e tentar novamente.');
        }

        $produtoServico = ProdutoServico::where('id_produtoServico',$request->id_produtoServico)->first();
        $produtoServico->update([
            'st_nomeProdutoServico'=>$request->st_nomeProdutoServico,
            'st_descricao'=>$request->st_descricao ? $request->st_descricao : null,
            'st_color'=>$request->st_color,
        ]);

        return  redirect()->back()->with('success', 'Produto/Serviço atualizado com sucesso');
    }
}
