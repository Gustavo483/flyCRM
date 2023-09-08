<?php

namespace App\Http\Controllers;

use App\Exports\Siope\SiopeExport;
use App\Exports\VariaveisExport;
use App\Models\Agenda;
use App\Models\Campanha;
use App\Models\ColumnsKhanban;
use App\Models\Empresa;
use App\Models\Fase;
use App\Models\Grupo;
use App\Models\Lead;
use App\Models\Midia;
use App\Models\ObservacaoLead;
use App\Models\Origem;
use App\Models\ProdutoServico;
use App\Models\Setor;
use App\Models\ToDoKhanban;
use App\Models\User;
use App\Constant\ConstantSystem;
use App\Models\Venda;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;


class AdminUserController extends Controller
{
    public function GerarPlanilhaVariaveis()
    {
        $empresa = auth()->user()->id_empresa;

        $empresaDados = Empresa::where('id_empresa',$empresa)->first();
        $informacoes = [];
        $camposVariaveis = [
            'Origem'=>[Origem::where('id_empresa', $empresa)->get(),'st_nomeOrigem', 'id_origem'],
            'Midia'=>[Midia::where('id_empresa', $empresa)->get(),'st_nomeMidia','id_midia'],
            'Campanha'=>[Campanha::where('id_empresa', $empresa)->get(),'st_nomeCampanha', 'id_campanha'],
            'Fase'=>[Fase::where('id_empresa', $empresa)->get(), 'st_nomeFase', 'id_fase'],
            'Grupo'=>[ Grupo::where('id_empresa', $empresa)->get(),'st_nomeGrupo', 'id_grupo'],
            'Status'=>[ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),'st_titulo','id_columnsKhanban'],
            'Usuario'=>[User::where('id_empresa', $empresa)->where('int_permisionAccess', 0)->get(), 'name', 'id'],
            'Produto'=>[ProdutoServico::where('id_empresa', $empresa)->get(),'st_nomeProdutoServico', 'id_produtoServico'],
        ];

        foreach ($camposVariaveis as $key => $dados){
            if (count($dados[0]) > 0) {
                foreach ($dados[0] as $dado) {
                    $nome = $dados[1];
                    $id = $dados[2];
                    array_push($informacoes,[
                        $key,
                        $dado->$nome,
                        $dado->$id,
                    ]);
                }
            }
        }
        array_push($informacoes,[
            'Empresa',
            $empresaDados->st_nomeEmpresa,
            $empresaDados->id_empresa,
        ]);
        return Excel::download(new VariaveisExport($informacoes), "variaveisFlyCrm.xlsx");

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
    public function relatorioEmpresa(Request $request)
    {
        $colunas = isset($request->colunas) ? $request->colunas : [
            'st_nome','st_email', 'int_telefone', 'id_fase', 'id_columnsKhanban',
            'id_produtoServico', 'id_campanha', 'id_origem', 'id_midia', 'id_grupo', 'int_temperatura'];

        $empresa = auth()->user()->id_empresa;

        $dadosForm = [
            "dt_inicio" => isset($request->todosCampos) ? null : $request->dt_inicio,
            "dt_final" => isset($request->todosCampos) ? null : $request->dt_final,
            "st_nome" => isset($request->todosCampos) ? null : $request->st_nome,
            "st_email" => isset($request->todosCampos) ? null : $request->st_email,
            "int_telefone" => isset($request->todosCampos) ? null : $request->int_telefone,
            "id_origem" => isset($request->todosCampos) ? null : $request->id_origem,
            "id_midia" => isset($request->todosCampos) ? null : $request->id_midia,
            "id_campanha" => isset($request->todosCampos) ? null : $request->id_campanha,
            "id_produtoServico" => isset($request->todosCampos) ? null : $request->id_produtoServico,
            "id_fase" => isset($request->todosCampos) ? null : $request->id_fase,
            "int_temperatura" => isset($request->todosCampos) ? null : $request->int_temperatura,
            "id_grupo" => isset($request->todosCampos) ? null : $request->id_grupo,
            "id_columnsKhanban" => isset($request->todosCampos) ? null : $request->id_columnsKhanban,
            "id_userResponsavel" => isset($request->todosCampos) ? null : $request->id_userResponsavel,
        ];

        $where = "";
        $atualizouData = 0;
        $primeiroWhere = 0;

        $usarLike = ['st_nome','st_email','int_telefone'];
        foreach ($dadosForm as $key => $filtro){
            if ($dadosForm['dt_inicio'] && $key === 'dt_inicio' && $dadosForm['dt_final']){
                $atualizouData !== 0 ? $where.=' and ' :'';
                $where.="created_at BETWEEN '$request->dt_inicio' AND '$request->dt_final'" ;
                $atualizouData ++;
                $primeiroWhere ++;
                continue;
            }
            if ($dadosForm['dt_inicio'] && $key === 'dt_inicio' && !$dadosForm['dt_final']){
                $atualizouData !== 0 ? $where.=' and ' :'';
                $where.="created_at >= '$request->dt_inicio'";
                $primeiroWhere ++;
                continue;
            }
            if ($dadosForm['dt_final'] && !$dadosForm['dt_inicio'] && $key === 'dt_final' && ! $atualizouData){
                $atualizouData !== 0 ? $where.=' and ' :'';
                $where.="created_at <= '$request->dt_final'";
                $primeiroWhere ++;
                continue;
            }
            if ($key !== 'dt_inicio' && $key !== 'dt_final' && $key !== 'id_userResponsavel' ){
                if ($dadosForm[$key] && in_array($key,$usarLike)){
                    $primeiroWhere ? $where.=" and " :'';
                    $like = '%'.$dadosForm[$key].'%';
                    $where.=" $key like '$like'";
                    $primeiroWhere ++;
                }
                if ($dadosForm[$key] && ! in_array($key,$usarLike)){
                    $primeiroWhere ? $where.=" and " :'';
                    $where.=" $key = '$dadosForm[$key]'";
                    $primeiroWhere ++;
                }
            }
        }

        $responsavel = $request->id_userResponsavel ? :'';
        if ($where){
            if ($responsavel){
                $sqlLeads= 'SELECT l.id_lead FROM tb_leads l
               left join tb_responsavel_lead rl on rl.id_lead =  l.id_lead
               WHERE '.$where.' and id_empresa = '.$empresa.' and rl.id_responsavel ='.$responsavel;
            }else{
                $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE '.$where.' and id_empresa = '.$empresa;
            }
        }else{
            if ($responsavel){
                $sqlLeads= 'SELECT l.id_lead FROM tb_leads l
                left join tb_responsavel_lead rl on rl.id_lead =  l.id_lead
                WHERE id_empresa = '.$empresa.' and rl.id_responsavel ='.$responsavel;
            }else{
                $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE id_empresa = '.$empresa;
            }
        }

        $leadsSql = DB::select($sqlLeads);

        $ids_leads = [];
        foreach ($leadsSql as $lead){
            array_push($ids_leads,$lead->id_lead);
        }

        $leads = Lead::wherein('id_lead',$ids_leads)->get();

        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');
        $hoje2 = date('Y-m-d');

        $id_leads = [];

        foreach ($leads as $lead){
            array_push($id_leads,$lead->id_lead);
        }


        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get(),
            'id_userResponsavel'=>User::where('id_empresa', auth()->user()->id_empresa)->where('int_permisionAccess',0)->get()
        ];

        return view('AdminUser.relatorio.vizualizarDados', ['tela' =>'relatorio','dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads, 'dadosForm'=>$dadosForm, 'colunas'=>$colunas]);

    }




    public function AtualizarStatusLeadAdmin(Lead $id_lead, $id_status)
    {
        try {
            $id_lead->update([
                'id_columnsKhanban'=>$id_status,
            ]);
            return 200;
        } catch (Exception $e) {
            return $e;
        }
    }
    public function editarStatusOportunidadeAdmin(Request $request)
    {
        try {
            ObservacaoLead::where('id_observacao',$request->id_observacao)->update([
                'bl_statusOportunidade'=>$request->bl_statusOportunidade,
            ]);
            return redirect()->back()->with('success', 'Status da oportunidade alterado com sucesso');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro ao alterar o status da oportunidade. Favor contatar o suporte.');
        }
    }
    public function filtrarLeadsAvancadoAdmin(Request $request)
    {
        $empresa = auth()->user()->id_empresa;

        $dadosForm = [
            "dt_inicio" => $request->dt_inicio,
            "dt_final" => $request->dt_final,
            "st_nome" => $request->st_nome,
            "st_email" => $request->st_email,
            "int_telefone" => $request->int_telefone,
            "id_origem" => $request->id_origem,
            "id_midia" => $request->id_midia,
            "id_campanha" => $request->id_campanha,
            "id_produtoServico" => $request->id_produtoServico,
            "id_fase" => $request->id_fase,
            "int_temperatura" => $request->int_temperatura,
            "id_grupo" => $request->id_grupo,
            "id_columnsKhanban" => $request->id_columnsKhanban,
            "id_userResponsavel" => $request->id_userResponsavel,
        ];

        $where = "";
        $atualizouData = 0;
        $primeiroWhere = 0;

        $usarLike = ['st_nome','st_email','int_telefone'];
        foreach ($dadosForm as $key => $filtro){
            if ($dadosForm['dt_inicio'] && $key === 'dt_inicio' && $dadosForm['dt_final']){
                $atualizouData !== 0 ? $where.=' and ' :'';
                $where.="created_at BETWEEN '$request->dt_inicio' AND '$request->dt_final'" ;
                $atualizouData ++;
                $primeiroWhere ++;
                continue;
            }
            if ($dadosForm['dt_inicio'] && $key === 'dt_inicio' && !$dadosForm['dt_final']){
                $atualizouData !== 0 ? $where.=' and ' :'';
                $where.="created_at >= '$request->dt_inicio'";
                $primeiroWhere ++;
                continue;
            }
            if ($dadosForm['dt_final'] && !$dadosForm['dt_inicio'] && $key === 'dt_final' && ! $atualizouData){
                $atualizouData !== 0 ? $where.=' and ' :'';
                $where.="created_at <= '$request->dt_final'";
                $primeiroWhere ++;
                continue;
            }
            if ($key !== 'dt_inicio' && $key !== 'dt_final' && $key !== 'id_userResponsavel'){
                if ($dadosForm[$key] && in_array($key,$usarLike)){
                    $primeiroWhere ? $where.=" and " :'';
                    $like = '%'.$dadosForm[$key].'%';
                    $where.=" $key like '$like'";
                    $primeiroWhere ++;
                }
                if ($dadosForm[$key] && ! in_array($key,$usarLike)){
                    $primeiroWhere ? $where.=" and " :'';
                    $where.=" $key = '$dadosForm[$key]'";
                    $primeiroWhere ++;
                }
            }
        }

        $responsavel = $request->id_userResponsavel ? :'';
        if ($where){
            if ($responsavel){
                $sqlLeads= 'SELECT l.id_lead FROM tb_leads l
               left join tb_responsavel_lead rl on rl.id_lead =  l.id_lead
               WHERE '.$where.' and id_empresa = '.$empresa.' and rl.id_responsavel ='.$responsavel;
            }else{
                $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE '.$where.' and id_empresa = '.$empresa;
            }
        }else{
            if ($responsavel){
                $sqlLeads= 'SELECT l.id_lead FROM tb_leads l
                left join tb_responsavel_lead rl on rl.id_lead =  l.id_lead
                WHERE id_empresa = '.$empresa.' and rl.id_responsavel ='.$responsavel;
            }else{
                $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE id_empresa = '.$empresa;
            }
        }

        $leadsSql = DB::select($sqlLeads);

        $ids_leads = [];
        foreach ($leadsSql as $lead){
            array_push($ids_leads,$lead->id_lead);
        }

        $leads = Lead::wherein('id_lead',$ids_leads)->get();

        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');
        $hoje2 = date('Y-m-d');

        $id_leads = [];

        foreach ($leads as $lead){
            array_push($id_leads,$lead->id_lead);
        }

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_empresa',$empresa)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get(),
            'id_userResponsavel'=>User::where('id_empresa', auth()->user()->id_empresa)->where('int_permisionAccess',0)->get()
        ];
        return view('AdminUser.leads.vizualizarTodasleadsEmpresa', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads, 'dadosForm'=>$dadosForm]);

    }
    public function registrarAtividadeAgenda(Request $request)
    {
        if (!$request->st_data && !$request->st_dataFinal && !$request->dt_contato){
            return redirect()->back()->with('error', 'Informe um período de data ou uma data para registro.');
        }
        $meses = ['Janeiro','February','March','April','May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        if ($request->periodo == 0 ){
            $data = explode("-", $request->st_data);
            try {
                Agenda::create([
                    'id_user'=>auth()->user()->id,
                    'st_color'=>$request->st_color,
                    'st_date'=>$meses[intval($data[1] -1)].'/'.$data[2].'/'.$data[0],
                    'st_titulo'=>$request->st_titulo,
                    'int_tipoData'=>1,
                    'st_descricao'=>$request->st_descricao,
                ]);
            }catch (Exception $e) {
                return redirect()->back()->with('error', 'Informe uma data correto para registro.');
            }

            return redirect()->back()->with('success', 'Atividade cadastrada na agenda com sucesso.');
        }
        if ($request->periodo == 1 ){
            try {
                $data = explode("-", $request->st_datainicio);
                $data2 = explode("-", $request->st_dataFinal);
                Agenda::create([
                    'id_user'=>auth()->user()->id,
                    'st_color'=>$request->st_color,
                    'st_date'=>$meses[intval($data[1] -1)].'/'.$data[2].'/'.$data[0],
                    'st_dateFinal'=>$meses[intval($data2[1] -1)].'/'.$data2[2].'/'.$data2[0],
                    'st_titulo'=>$request->st_titulo,
                    'st_descricao'=>$request->st_descricao,
                    'int_tipoData'=>2,
                ]);
            }catch (Exception $e) {
                return redirect()->back()->with('error', 'Informe um periodo de data correto correto para registro.');
            }
            return redirect()->back()->with('success', 'Atividade cadastrada na agenda com sucesso.');
        }
    }
    public function filtrarLeadsAdmin(Request $request)
    {
        $empresa = auth()->user()->id_empresa;

        $dadosForm = [
            "dt_inicio" => $request->dt_inicio,
            "dt_final" => $request->dt_final,
            "st_nome" => null,
            "st_email" => null,
            "int_telefone" => null,
            "id_origem" => null,
            "id_midia" => null,
            "id_campanha" => null,
            "id_produtoServico" => null,
            "id_fase" => $request->id_fase,
            "int_temperatura" => null,
            "id_grupo" => null,
            "id_columnsKhanban" => $request->id_columnsKhanban,
            "id_userResponsavel" => null,
        ];

        $where = "";
        if ($request->dt_inicio && $request->dt_final){
            $where.="created_at BETWEEN '$request->dt_inicio' AND '$request->dt_final'" ;
            $request->id_fase ? $where.= ' and id_fase = '.$request->id_fase :'';
            $request->id_columnsKhanban ? $where.= ' and id_columnsKhanban = '.$request->id_columnsKhanban :'';
        }
        if ($request->dt_inicio && !$request->dt_final){
            $where.="created_at >= '$request->dt_inicio'";
            $request->id_fase ? $where.= ' and id_fase = '.$request->id_fase :'';
            $request->id_columnsKhanban ? $where.= ' and id_columnsKhanban = '.$request->id_columnsKhanban :'';
        }
        if (!$request->dt_inicio && $request->dt_final){
            $where.="created_at <= '$request->dt_final'";
            $request->id_fase ? $where.= ' and id_fase = '.$request->id_fase :'';
            $request->id_columnsKhanban ? $where.= ' and id_columnsKhanban = '.$request->id_columnsKhanban :'';
        }
        if (!$request->dt_inicio && !$request->dt_final){
            if ($request->id_fase){
                $where.= 'id_fase = '.$request->id_fase;
                $request->id_columnsKhanban ? $where.= ' and id_columnsKhanban = '.$request->id_columnsKhanban :'';
            }
            if ($request->id_columnsKhanban && !$request->id_fase){
                $where.= ' id_columnsKhanban = '.$request->id_columnsKhanban;
            }
        }

        if ($where){
            $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE '.$where.' and id_empresa = '.$empresa;
        }else{
            $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE id_empresa = '.$empresa;
        }

        $leadsSql = DB::select($sqlLeads);

        $ids_leads = [];
        foreach ($leadsSql as $lead){
            array_push($ids_leads,$lead->id_lead);
        }

        $leads = Lead::wherein('id_lead',$ids_leads)->get();

        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');
        $hoje2 = date('Y-m-d');

        $id_leads = [];

        foreach ($leads as $lead){
            array_push($id_leads,$lead->id_lead);
        }

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_empresa',$empresa)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get(),
            'id_userResponsavel'=>User::where('id_empresa', auth()->user()->id_empresa)->where('int_permisionAccess',0)->get()
        ];

        return view('AdminUser.leads.vizualizarTodasleadsEmpresa', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads, 'dadosForm'=>$dadosForm]);

    }
    public function vizualizarOportunidadesUserAdmin()
    {
        $usuario = auth()->user()->id;
        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_empresa',$empresa)->get();
        $hoje = new DateTime();

        $oportunidadesHoje = new Collection();
        $oportunidadesOutroDia = new Collection();

        foreach ($leads as $lead){
            if (isset($lead->observacoes)){
                foreach ($lead->observacoes as $observacoes) {
                    if ($observacoes->dt_contato === $hoje->format('Y-m-d') && $observacoes->bl_oportunidade === 1){
                        $oportunidadesHoje->push($observacoes);
                    }
                    if ($observacoes->dt_contato != $hoje->format('Y-m-d') && $observacoes->bl_oportunidade === 1){
                        $oportunidadesOutroDia->push($observacoes);
                    }
                }
            }
        }

        $oportunidades = [
            'oportunidadesHoje'=>$oportunidadesHoje,
            'oportunidadesOutroDia'=>$oportunidadesOutroDia
        ];

        $dadosInfo = [
            'leads'=> count($leads),
            'leadsHoje'=>count($oportunidadesHoje),
            'totalOportunidades'=>count($oportunidadesOutroDia),
        ];


        return view('AdminUser.oportunidades.vizualizarOportunidadesAdminUser', ['tela' =>'oportunidade', 'oportunidades'=>$oportunidades,'dadosInfo'=>$dadosInfo ]);
    }
    public function registrarLeadsAdmin(Request $request)
    {
        $id_empresa = auth()->user()->id_empresa;

        $lead = Lead::create([
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
            'id_columnsKhanban'=>$request->id_columnsKhanban,
            'id_empresa'=>$id_empresa
        ]);
        $lead->responsavel()->attach($request->responsaveis);


        $agora = new DateTime();
        $dia = $agora->format('d/m/Y');
        $hora = $agora->format('H:i:s');
        $usuario = auth()->user();

        if ($request->st_observacoes) {
            $titulo = $dia . ' às ' . $hora . ' - ' . $usuario->name . ' - Lead Cadastrado no sistema com observação :';
            $this->adicionarHistoricoLead($lead, 0, $titulo, $usuario->id_empresa, $request->st_observacoes);
        } else {
            $titulo = $dia . ' às ' . $hora . ' - ' . $usuario->name . ' - Lead Cadastrado no sistema.';
            $this->adicionarHistoricoLead($lead, 0, $titulo, $usuario->id_empresa);
        }

        return redirect()->route('vizualizarLeadAdminUser',['id_lead'=>$lead->id_lead])->with('success', 'Lead cadastrado com sucesso.');
    }
    public function EditarLeadAdmin(Lead $id_lead, Request $request)
    {
        $agora = new DateTime();
        $dia = $agora->format('d/m/Y');
        $hora = $agora->format('H:i:s');

        $dados = [
            'id_origem'=>['tb_origens','st_nomeOrigem','Origem'],
            'id_midia'=>['tb_midias','st_nomeMidia', 'Midia'],
            'id_campanha'=>['tb_campanhas', 'st_nomeCampanha', 'Campanhas'],
            'id_produtoServico'=>['tb_produto_servicos','st_nomeProdutoServico', 'Produto'],
            'id_fase'=>['tb_fases','st_nomeFase', 'Fase'],
            'id_grupo'=>['tb_grupos','st_nomeGrupo', 'Grupo'],
            'id_columnsKhanban'=>['tb_columns_khanban','st_titulo','Status']
        ];

        if ($request->int_temperatura != $id_lead->int_temperatura){
            $mds = $dia.' às '.$hora.' - Temperatura do lead foi alterado para '.$request->int_temperatura.'%';
            $this->adicionarHistoricoLead($id_lead, 0, $mds);
        }

        foreach ($dados as $key => $dado ){
            if ($id_lead->$key != $request->$key){
                $sql = 'SELECT '. $dado[1].' FROM '.$dado[0].' WHERE '.$key.' = '.$request->$key;
                $resultSql = DB::select($sql);
                $campo = $dado[1];
                $mds = $dia.' às '.$hora.' - '.$dado[2].' do lead foi alterado para "'.$resultSql[0]->$campo.'"';
                $this->adicionarHistoricoLead($id_lead, 0, $mds);
            }
        }

        if ($request->responsaveis){
            $id_lead->responsavel()->detach();
            $id_lead->responsavel()->attach($request->responsaveis);
        }

        $id_lead->update($request->all());
        return redirect()->back()->with('success', 'Lead atualizado com sucesso.');
    }

    public function registrarOportunidadeAdmin(Request $request)
    {
        try {
            $validacao = [
                'dt_contato' => 'required',
                'st_descricao' => 'required'
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];

            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a oportunidade. Favor verificar os dados e tentar novamente.');
        }

        $agora = new DateTime();
        $dia = $agora->format('d/m/Y');
        $hora = $agora->format('H:i:s');

        $dataObjeto = DateTime::createFromFormat('Y-m-d', $request->dt_contato);

        $usuario = auth()->user();

        ObservacaoLead::create([
            'dt_contato'=>$request->dt_contato,
            'id_lead'=>$request->id_lead,
            'st_titulo'=>$dia.' às '.$hora.' - '.$usuario->name.' adicionou uma oportunidade para '. $dataObjeto->format('d/m/Y').' :',
            'st_descricao'=>$request->st_descricao,
            'bl_oportunidade'=>1,
            'id_empresa'=>$usuario->id_empresa
        ]);

        $lead = Lead::where('id_lead',$request->id_lead)->first();

        $lead->update([
            'updated_at'=>date('Y-m-d'),
            'int_interacoes'=>intval($lead->int_interacoes) + 1,
            'bl_atendimento' => 1
        ]);

        return redirect()->back()->with('success', 'Oportunidade cadastrado com sucesso.');
    }
    public function registrarObservacaoAdmin(Request $request)
    {
        try {
            $validacao = [
                'st_descricao' => 'required'
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];

            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a observação. Favor verificar os dados e tentar novamente.');
        }

        $agora = new DateTime();
        $dia = $agora->format('d/m/Y');
        $hora = $agora->format('H:i:s');


        $usuario = auth()->user();

        ObservacaoLead::create([
            'id_lead'=>$request->id_lead,
            'st_titulo'=>$dia.' às '.$hora.' - '.$usuario->name.' adicionou uma observação: ' ,
            'st_descricao'=>$request->st_descricao,
            'bl_oportunidade'=>0,
            'id_empresa'=>$usuario->id_empresa
        ]);

        $lead = Lead::where('id_lead',$request->id_lead)->first();

        $lead->update([
            'updated_at'=>date('Y-m-d'),
            'int_interacoes'=>intval($lead->int_interacoes) + 1,
            'bl_atendimento'=>1
        ]);

        return redirect()->back()->with('success', 'Oportunidade cadastrado com sucesso.');
    }

    public function indicadoresLeads($lead)
    {
        $totalObservacoes = ObservacaoLead::where('id_lead', $lead->id_lead)->get();
        $totalOportunidade = $totalObservacoes->where('bl_oportunidade', 1);
        $oportunidadeSucesso = $totalOportunidade->where('bl_statusOportunidade', 1);
        $diferencaEmDias = Carbon::parse($lead->updated_at->format('Y-m-d'))->diffInDays(Carbon::parse(date('Y-m-d')));
        $leedNutrido = $lead->int_interacoes > 20 ? 'lead bem nutrido' : 'lead pouco nutrido';

        return ["totalOportunidade"=>count($totalOportunidade), "oportunidadeSucesso"=>count($oportunidadeSucesso),'diferencaEmDias'=>$diferencaEmDias, 'leedNutrido'=>$leedNutrido];
    }

    public function vizualizarLeadAdminUser( Lead $id_lead)
    {
        $empresa = auth()->user()->id_empresa;

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get(),
            'id_userResponsavel'=>User::where('id_empresa', auth()->user()->id_empresa)->where('int_permisionAccess',0)->get()
        ];

        $Lead = $id_lead;

        $produtoServico = ProdutoServico::where('id_empresa',$empresa)->get();

        $vendas = Venda::where('id_lead',$id_lead->id_lead)->get();

        $responsaveis = $id_lead->responsavel;
        $id_responsaveis = [];

        foreach ($responsaveis as $respons){
            array_push($id_responsaveis, $respons->id);
        }

        $indicadoresLead = $this->indicadoresLeads($id_lead);

        return view('AdminUser.leads.vizualizarLeadAdminUser',['indicadoresLead'=>$indicadoresLead,'id_responsaveis'=>$id_responsaveis,'vendas'=>$vendas,'produtoServico'=>$produtoServico,'lead'=>$Lead,'dadosCadastroLeads'=>$dadosCadastroLeads]);
    }

    public function editarDadoKanbanAdmin(Request $request)
    {
        ToDoKhanban::where('id_toDoKhanban', $request->id_toDoKhanban)->update([
            'st_descricao' => $request->st_descricao
        ]);
        return redirect()->back()->with('success', 'Atividade atualizada com sucesso.');
    }

    public function deletarDadoKanbanAdmin(Request $request)
    {
        ToDoKhanban::where('id_toDoKhanban', $request->id_toDoKhanban)->delete();
        return redirect()->back()->with('success', 'Atividade deletada com sucesso.');
    }

    public function registrarDadoKanbanAdmin(Request $request)
    {
        try {
            $validacao = [
                'st_descricao' => 'required',
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];

            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a atividade. Favor verificar os dados e tentar novamente.');
        }
        $CollunsToDo = ColumnsKhanban::where('st_titulo','a fazer')->where('id_empresa', auth()->user()->id_empresa)->first();

        ToDoKhanban::create([
            'id_columnsKhanban'=>$CollunsToDo->id_columnsKhanban,
            'id_user'=>auth()->user()->id,
            'st_descricao'=>$request->st_descricao,
            'int_posicao'=>ToDoKhanban::where('id_columnsKhanban', $CollunsToDo->id_columnsKhanban)->count() + 1,
        ]);

        return redirect()->back()->with('success', 'Atividade cadastrada com sucesso.');
    }
    public function registrarProdutoServico(Request $request)
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

    public function editarProdutoServico(Request $request)
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

    public function deletarProdutoServicos(Request $request)
    {
        try {
            Lead::where('id_produtoServico', $request->id_produtoServico)->update([
                'id_produtoServico'=>null
            ]);
            ProdutoServico::where('id_produtoServico', $request->id_produtoServico)->delete();
            return redirect()->back()->with('success', 'Produto/Serviço excluído com sucesso.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir o Produto/Serviço, favor entrar em contato suporte,');
        }
    }


    public function produtoServico()
    {
        $id_empresa = auth()->user()->id_empresa;
        $produtos = ProdutoServico::where('id_empresa',$id_empresa)->get();
        return view('AdminUser.produtoServico.index',['tela'=>'produtoServico','produtos'=>$produtos]);
    }


    public function leadsUltimosQuinzeDias(): mixed
    {
        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalo2 = new DateInterval('P1D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');

        $TESTE =  new DateTime();
        $final = $TESTE->add($intervalo2)->format('Y-m-d');
        $Empresa = auth()->user()->id_empresa;
        $userCountByDay = Lead::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->whereRaw("created_at BETWEEN '$intervalodias' AND '$final'" )
            ->whereRaw("id_empresa = '$Empresa'" )
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();

        $results = [];

        foreach ($userCountByDay as $userCount) {
            $date = Carbon::createFromFormat('Y-m-d', $userCount->day);
            $formattedDate = $date->format('d/m');
            $results[] = [
                'day' => $formattedDate,
                'qnt' => $userCount->count,
            ];
        }

        return json_encode($results);
    }

    public function verificarAtividadesConcluidasToDo()
    {
        $colunaConcluidoEmpresa = ColumnsKhanban::where('st_titulo','concluído')->where('int_tipoKhanban',2)->where('id_empresa',auth()->user()->id_empresa)->first();
         ToDoKhanban::where('id_user',auth()->user()->id)->where('id_columnsKhanban',$colunaConcluidoEmpresa->id_columnsKhanban)->where('bl_ativo',1)->where('updated_at','<',date('Y-m-d'))->update([
            'bl_ativo'=> 0,
        ]);
    }
    public function dashboardAdminUser()
    {
        $empresa = auth()->user()->id_empresa;

        $leads15days = $this->leadsUltimosQuinzeDias();

        $sqlFases = 'SELECT f.st_nomeFase AS fase, COUNT(*) AS count FROM tb_leads as l
                    left JOIN tb_fases AS f ON l.id_fase = f.id_fase
                    WHERE l.id_empresa = '.$empresa.' GROUP BY fase';

        $fases = DB::select($sqlFases);

        $sqlStatus = 'SELECT s.st_titulo AS status, COUNT(*) AS count FROM tb_leads as l
                    left JOIN tb_columns_khanban AS s ON l.id_columnsKhanban = s.id_columnsKhanban
                    WHERE l.id_empresa = '.$empresa.' GROUP BY status';

        $status = DB::select($sqlStatus);

        $this->verificarAtividadesConcluidasToDo();

        $labelsFases= '';
        $dataFases = '';
        foreach ($fases as $fase){
            $nomeFase = $fase->fase ? : 'Sem fase';
            if ($labelsFases === ''){
                $labelsFases.= '"'.$nomeFase.'"';
                $dataFases.= '"'.$fase->count.'"';
            }else{
                $labelsFases.= ',"'.$nomeFase.'"';
                $dataFases.= ',"'.$fase->count.'"';
            }
        }

        $labelsStatus= '';
        $dataStatus = '';
        foreach ($status as $statu){
            $nomeStatus = $statu->status ? : 'Sem status';
            if ($labelsStatus === ''){
                $labelsStatus.= '"'.$nomeStatus.'"';
                $dataStatus.= '"'.$statu->count.'"';
            }else{
                $labelsStatus.= ',"'.$nomeStatus.'"';
                $dataStatus.= ',"'.$statu->count.'"';
            }
        }

        $graphics = [
            'leadsUltimosQuinzeDias' => json_encode($leads15days),
        ];

        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_empresa',$empresa)->get();

        $id_leads = $leads->pluck('id_lead')->toArray();

        $observacoes = ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato','>=',date('Y-m-d'))->where('bl_oportunidade',1)->orderby('dt_contato')->limit(5)->get();

        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');
        $hoje2 = new DateTime();

        $intervalo2 = new DateInterval('P1D');
        $final = $hoje2->add($intervalo2)->format('Y-m-d');
        $intervaloLeads15dias = Lead::where('id_empresa',$empresa)->whereRaw("created_at BETWEEN '$intervalodias' AND '$final'" )->get();

        $DivInfoGerais = [
            'leads'=> count($intervaloLeads15dias),
            'oportunidades'=> ObservacaoLead::wherein('id_lead',$id_leads)->where('bl_oportunidade',1)->whereRaw("dt_contato BETWEEN '$intervalodias' AND '$final'" )->count(),
            'conversoes'=> venda::wherein('id_lead',$id_leads)->whereRaw("dt_venda BETWEEN '$intervalodias' AND '$final'" )->count()
        ];

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_empresa',$empresa)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get(),
            'id_userResponsavel'=>User::where('id_empresa', auth()->user()->id_empresa)->where('int_permisionAccess',0)->get()
        ];

        $columnsStatus = ColumnsKhanban::where('id_empresa',$empresa)->where('int_tipoKhanban', 1)->orderBy('int_posicao')->get();

        $columnsToDo = ColumnsKhanban::where('id_empresa',$empresa)->where('int_tipoKhanban',2)->orderBy('int_posicao')->get();

        $campanhasAtiva = Campanha::where('id_empresa',$empresa)->where('bl_campanhaAtiva', 1)->first();

        $hoje = Carbon::today();
        $dataMenosTrintaDias = $hoje->subDays(30);
        $indicadorComercial = Lead::where('id_empresa',$empresa)->where('updated_at','<', $dataMenosTrintaDias)->orderBy('created_at', 'desc')->take(10)->count();

        return view('AdminUser.dashboard', [
            'tela' =>'dashboard',
            'dadosInfo'=>$dadosInfo,
            'dadosCadastroLeads'=>$dadosCadastroLeads,
            'graphics'=>$graphics,
            'labelsFases'=>$labelsFases,
            'dataFases'=>$dataFases,
            'labelsStatus'=>$labelsStatus,
            'dataStatus'=>$dataStatus,
            'columnsStatus'=>$columnsStatus,
            'columnsToDo'=>$columnsToDo,
            'id_empresa'=>$empresa,
            'observacoes'=>$observacoes,
            'DivInfoGerais'=>$DivInfoGerais,
            'campanhasAtiva'=>$campanhasAtiva,
            'indicadorComercial'=>$indicadorComercial
        ]);
    }

    public function vizualizarTodasleadsEmpresa()
    {
        $dadosForm = [
            "dt_inicio" => null,
            "dt_final" => null,
            "st_nome" => null,
            "st_email" => null,
            "int_telefone" => null,
            "id_origem" => null,
            "id_midia" => null,
            "id_campanha" => null,
            "id_produtoServico" => null,
            "id_fase" => null,
            "int_temperatura" => null,
            "id_grupo" => null,
            "id_columnsKhanban" => null,
            "id_userResponsavel" => null,
        ];

        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_empresa',$empresa)->get();
        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::where('id_empresa',auth()->user()->id_empresa)->where('dt_contato',date('Y-m-d'))->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_empresa',$empresa)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get(),
            'id_userResponsavel'=>User::where('id_empresa', auth()->user()->id_empresa)->where('int_permisionAccess',0)->get()
        ];

        return view('AdminUser.leads.vizualizarTodasleadsEmpresa', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads,'dadosForm'=>$dadosForm]);
    }

    public function vizualizarAgenda()
    {
        $results = [];

        $dadosAgenda = Agenda::where('id_user', auth()->user()->id)->get();
        foreach ($dadosAgenda as $agenda){
            if ($agenda->int_tipoData === 1){
                $results[] = [
                    'id' => $agenda->id_agenda,
                    'name' => $agenda->st_titulo,
                    'date' => $agenda->st_date,
                    'description'=> $agenda->st_descricao,
                    'type'=>"event",
                    'color'=> $agenda->st_color
                ];
            }else{
                $results[] = [
                    'id' => $agenda->id_agenda,
                    'name' => $agenda->st_titulo,
                    'date' => [$agenda->st_date,$agenda->st_dateFinal],
                    'description'=> $agenda->st_descricao,
                    'type'=>"event",
                    'color'=> $agenda->st_color
                ];
            }
        }
//        dd(json_decode($results));
        return view('AdminUser.agenda.vizualizarAgenda',['tela'=>'agenda', 'dadosAgenda'=>json_encode($results)]);
    }

    public function configuracaoEmpresa()
    {
        $id_empresa = auth()->user()->id_empresa;

        $dados = [
            'usuarios' => User::where('int_permisionAccess', ConstantSystem::User)->where('id_empresa',$id_empresa)->get(),
            'status' =>ColumnsKhanban::where('id_empresa', $id_empresa)->where('int_tipoKhanban',1)->orderBy('int_posicao')->get(),
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
        $nome = explode(" ", $request->name);
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

            $nome = explode(" ", $request->name);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_setor'=> $request->id_setor,
                'int_permisionAccess' => ConstantSystem::User,
                'id_empresa'=>auth()->user()->id_empresa,
                'st_iniciaisNome'=> count($nome)> 1 ? strtoupper($nome[0][0].$nome[1][0]) : strtoupper($nome[0][0]),
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
            Lead::where('id_columnsKhanban', $request->id_columnsKhanban)->update([
                'id_columnsKhanban'=>null,
            ]);
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
            Lead::where('id_midia',$request->id_midia)->update([
                'id_midia'=>null,
            ]);
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
            Lead::where('id_grupo',$request->id_grupo)->update([
                'id_grupo'=>null,
            ]);
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
            Lead::where('id_fase', $request->id_fase)->update([
                'id_fase'=>null
            ]);
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
            Lead::where('id_origem',$request->id_origem)->update([
                'id_origem'=>null,
            ]);
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
                'bl_campanhaAtiva'=>'required'
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];
            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar a campanha. Favor verificar os dados e tentar novamente.');
        }

        $id_empresa = auth()->user()->id_empresa;

        Campanha::create([
            'id_empresa'=>$id_empresa,
            'st_nomeCampanha'=>$request->st_nomeCampanha,
            'bl_campanhaAtiva'=>$request->bl_campanhaAtiva,
            'st_descricao'=>$request->st_descricao,
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
            'bl_campanhaAtiva' => $request->bl_campanhaAtiva,
            'st_descricao' => $request->st_descricao,
            'st_nomeCampanha' => $request->st_nomeCampanha
        ]);

        return redirect()->back()->with('success', 'Campanha editada com sucesso');
    }

    public function deletarCampanha(Request $request)
    {
        try {
            Lead::where('id_campanha',$request->id_campanha)->update([
                'id_campanha'=>null
            ]);
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
            User::where('id_setor',$request->id_setor)->update([
                'id_setor'=>null
            ]);
            Setor::where('id_setor',$request->id_setor)->delete();
            return redirect()->back()->with('success', 'Setor excluído com sucesso.');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possivel excluir o setor, favor entrar em contato com o suporte.');
        }
    }
}
