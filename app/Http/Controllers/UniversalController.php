<?php

namespace App\Http\Controllers;

use App\Models\Campanha;
use App\Models\ColumnsKhanban;
use App\Models\Fase;
use App\Models\Grupo;
use App\Models\Lead;
use App\Models\Midia;
use App\Models\ObservacaoLead;
use App\Models\Origem;
use App\Models\ProdutoServico;
use App\Models\ToDoKhanban;
use App\Models\User;
use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UniversalController extends Controller
{
    public function fecharIndicador()
    {
        $us = auth()->user()->id;
        $usuario =  User::where('id',$us)->first();
        $usuario->update([
            'dt_fechouIndicador'=>date("Y-m-d")
        ]);
        return $usuario;
    }
    public function IndicadorComercial()
    {
        $empresa = auth()->user()->id_empresa;
        $usuario = auth()->user()->id;
        $permissao = auth()->user()->int_permisionAccess === 1 ? 1: 0 ;
        $hoje = Carbon::today();

        // Subtrai 30 dias da data de hoje
        $dataMenosTrintaDias = $hoje->subDays(30);
        if(auth()->user()->int_permisionAccess == 0){
            $leads = Lead::where('updated_at','<', $dataMenosTrintaDias)->where('id_userResponsavel',$usuario)->orderBy('created_at', 'desc')->take(10)->get();
        }else{
            $leads = Lead::where('updated_at','<', $dataMenosTrintaDias)->where('id_empresa',$empresa)->orderBy('created_at', 'desc')->take(10)->get();
        }
        return view('universal.indicadorComercial',['leads'=>$leads,'permissao'=>$permissao]);
    }
    public function tarefasArquivadas($permissao)
    {
        $user = auth()->user()->id;
        $tarefasArquivadas = ToDoKhanban::where('id_user', $user)->where('bl_ativo',0)->get();
        return view('universal.tarefasArquivadas', [
            'tarefasArquivadas' => $tarefasArquivadas,
            'permissao'=>intval($permissao)
        ]);
    }

    public function ConverterCliente(Lead $id_lead)
    {
        try {
            $id_lead->update([
                'bl_cliente' => 1
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro ao salvar o lead como cliente. Favor contatar o suporte.');
        }

        $agora = new DateTime();
        $dia = $agora->format('d/m/Y');
        $hora = $agora->format('H:i:s');
        $usuario = auth()->user();

        $titulo = $dia.' às '.$hora.' - '.$usuario->name.' - Lead convertido em cliente.';

        ObservacaoLead::create([
            'id_lead'=>$id_lead->id_lead,
            'st_titulo'=>$titulo,
            'bl_oportunidade'=>0,
            'id_empresa'=>isset($id_empresa) ?$id_empresa : auth()->user()->id_empresa
        ]);

        return redirect()->back()->with('success', 'Lead cadastrado como cliente com suceso.');
    }

    public function registrarVenda(Request $request, Lead $id_lead, $bl_admin)
    {
        try {
            $venda = Venda::create([
                'int_preco'=>$request->int_preco,
                'st_descricao'=>$request->st_descricao,
                'dt_venda'=>$request->dt_venda,
                'id_lead'=>$id_lead->id_lead
            ]);

            if (!$id_lead->int_interacoesAteFechamento){
                $id_lead->update([
                    'int_interacoesAteFechamento'=>$id_lead->int_interacoes,
                ]);
            }

            $venda->produtos()->attach($request->produtos);

            $agora = new DateTime();
            $dia = $agora->format('d/m/Y');
            $hora = $agora->format('H:i:s');

            $usuario = auth()->user();

            $produtossd = '';
            foreach ($request->produtos as $produto){
                $produtossd = $produtossd.'<li>'.$produto.'</li>';
            }
            $dataObjeto = DateTime::createFromFormat('Y-m-d', $request->dt_venda);

            $titulo = $dia.' às '.$hora.' - '.$usuario->name.' adicionou uma venda.';
            $st_descricao = '<div class="d-flex justify-content-between"><div>Data da venda : '.$dataObjeto->format('d/m/Y').'</div>
            <div>valor : R$ '.$request->int_preco.'</div></div><div>Produtos vendidos:<div>'.$produtossd.'</div></div>';

            $this->adicionarHistoricoLead($id_lead,2,$titulo, null,$st_descricao);

            if ($bl_admin == 1){
                return redirect()->route('vizualizarLeadAdminUser',['id_lead'=>$id_lead->id_lead])->with('success', 'Venda cadastrada com sucesso.');
            }else{
                return redirect()->route('vizualizarLeadUser',['id_lead'=>$id_lead->id_lead])->with('success', 'Venda cadastrada com sucesso.');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro ao salvar o venda, favor entrar em contato com suporte');
        }
    }

    public function adicionarHistoricoLead(Lead $id_lead,$tipoMensagem, $st_titulo,$id_empresa = null, $st_descricao = null ,$dt_contato = null)
    {
        ObservacaoLead::create([
            'dt_contato'=>$dt_contato,
            'id_lead'=>$id_lead->id_lead,
            'st_titulo'=>$st_titulo,
            'st_descricao'=>$st_descricao,
            'bl_oportunidade'=>$tipoMensagem,
            'id_empresa'=>isset($id_empresa) ?$id_empresa : auth()->user()->id_empresa
        ]);

        $id_lead->update([
            'updated_at'=>date('Y-m-d'),
            'int_interacoes'=>intval($id_lead->int_interacoes) + 1,
        ]);

    }
    public function ImportLeadExcel(Request $request)
    {
        $archivo = $request->file('arquiloLeads');
        $hoja = IOFactory::load($archivo)->getActiveSheet();

        $contador = 0;
        $linhasComErro = [];
        $user = auth()->user();
        foreach ($hoja->getRowIterator() as $fila) {
            $celdas = $fila->getCellIterator();
            $filaData = [];

            foreach ($celdas as $celda) {
                $valor = $celda->getValue();
                $filaData[] = $valor;
            }

            $erro = 0;
            if ($contador === 0){
                $filaData[0] !== "Nome" ? $erro++ : '';
                $filaData[1] !== "E-mail" ? $erro++ : '';
                $filaData[2] !== "Telefone" ? $erro++ : '';
                $filaData[3] !== "Origem" ? $erro++ : '';
                $filaData[4] !== "Midia" ? $erro++ : '';
                $filaData[5] !== "Campanha" ? $erro++ : '';
                $filaData[6] !== "Produto" ? $erro++ : '';
                $filaData[7] !== "Fases" ? $erro++ : '';
                $filaData[8] !== "Temperatura" ? $erro++ : '';
                $filaData[9] !== "Grupo" ? $erro++ : '';
                $filaData[10] !== "Status" ? $erro++ : '';
                $filaData[11] !== "Responsável" ? $erro++ : '';
                $filaData[12] !== "Observação" ? $erro++ : '';

                if ($erro){
                    return redirect()->back()->with('error', 'O arquivo não esta nos moldes solicitados pelo sistema. Favor olhar a documentação !');
                }
            }else{
                $subset = array_slice($filaData, 0, 13);
                $erroValidacao = $this->validarXlsx($subset, $user);

                if ($erroValidacao[0] !== 3){
                    array_push($linhasComErro, $contador);
                }
            }
            $contador ++;
        }
        if ($linhasComErro){
            return redirect()->back()->with('error', 'As linhas '. implode(", ", $linhasComErro).' não foram salvos no sistema, favor verifique os dados e tente novamente.');
        }
        return redirect()->back()->with('success', 'Arquivos salvos com sucesso');
    }
    public function validarXlsx($dados, $user)
    {
        $id_empresa = $user->id_empresa;

        if (!$dados[0] || !$dados[2] || !$dados[1] || !$dados[11]) {
            return [1, 'Os campos Nome,E-mail,Telefone,Responsável devem ser preenchidos.'];
        }

        $list = [];
        $dados[3] && Origem::where('id_empresa', $id_empresa)->where('id_origem', $dados[3])->count() < 1 ? array_push($list,'Origem') : '';
        $dados[4] && Midia::where('id_empresa', $id_empresa)->where('id_midia', $dados[4])->count() < 1 ? array_push($list,'Midia') : '';
        $dados[5] && Campanha::where('id_empresa', $id_empresa)->where('id_campanha', $dados[5])->count() < 1 ? array_push($list,'Campanha') : '';
        $dados[6] && ProdutoServico::where('id_empresa', $id_empresa)->where('id_produtoServico', $dados[6])->count() < 1 ? array_push($list,'Produto') : '';
        $dados[7] && Fase::where('id_empresa', $id_empresa)->where('id_fase', $dados[7])->count() < 1 ? array_push($list,'Fase') : '';
        $dados[9] && Grupo::where('id_empresa', $id_empresa)->where('id_grupo', $dados[9])->count() < 1 ? array_push($list,'Grupo') : '';
        $dados[10] && ColumnsKhanban::where('id_empresa', $id_empresa)->where('id_columnsKhanban', $dados[10])->count() < 1 ? array_push($list,'Status') : '';
        User::where('id_empresa', $id_empresa)->where('id', $dados[11])->count() < 1 ? array_push($list,'Responsável') : '';

        if (count($list) > 0) {
            return [2, 'verifique os ids de referencias da sua empresa para o registro correto do Lead'];
        }

        try {
            $lead = Lead::create([
                'st_nome' => $dados[0],
                'int_telefone' => $dados[2],
                'int_posicao' => $dados[10] ? Lead::where('id_columnsKhanban', $dados[10])->count() + 1 : null,
                'st_email' => $dados[1],
                'id_origem' => $dados[3],
                'id_midia' => $dados[4],
                'id_campanha' => $dados[5],
                'id_produtoServico' => $dados[6],
                'id_fase' => $dados[7],
                'int_temperatura' => $dados[8] ?: 0,
                'id_grupo' => $dados[9],
                'st_observacoes' => $dados[12],
                'id_columnsKhanban' => $dados[10],
                'id_empresa' => $id_empresa
            ]);
            if ($dados[12]){
                $agora = new DateTime();
                $dia = $agora->format('d/m/Y');
                $hora = $agora->format('H:i:s');

                $usuario = auth()->user();
                ObservacaoLead::create([
                    'id_lead'=>$lead->id_lead,
                    'st_titulo'=>$dia.' às '.$hora.' - '.$usuario->name.' adicionou uma observação: ' ,
                    'st_descricao'=>$dados[12],
                    'bl_oportunidade'=>0,
                    'id_empresa'=>$usuario->id_empresa
                ]);
            }

            $lead->responsavel()->attach($dados[11]);

            $agora = new DateTime();
            $dia = $agora->format('d/m/Y');
            $hora = $agora->format('H:i:s');
            $mds = $dia.' às '.$hora.' - '.$user->name.' - Lead Cadastrado no sistema.';

            $this->adicionarHistoricoLead($lead,0,$mds);

            return [3, 'Sucesso ao salvar o lead'];
        } catch (Exception $e) {
            return [4, 'Erro ao salvar o lead'];
        }
    }
}
