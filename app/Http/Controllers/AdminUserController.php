<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Campanha;
use App\Models\ColumnsKhanban;
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
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{

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

            return redirect()->back()->with('success', 'Atividade cadastrada com sucesso.');
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
            return redirect()->back()->with('success', 'Atividade cadastrada com sucesso.');
        }
    }
    public function filtrarLeadsAdmin(Request $request)
    {
        $usuario = auth()->user()->id;
        $empresa = auth()->user()->id_empresa;

        $dadosForm = [
            'dt_inicio'=>$request->dt_inicio,
            'dt_final'=>$request->dt_final,
            'id_fase'=>$request->id_fase,
            'id_columnsKhanban'=>$request->id_columnsKhanban,
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
            $where.="created_at =< '$request->dt_final'";
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
            'atendimento'=>0,
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

        return view('AdminUser.leads.vizualizarTodasLeadsEmpresa', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads, 'dadosForm'=>$dadosForm]);
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
                'id_columnsKhanban' => 'required'
            ];

            $feedback = [
                'required' => 'O campo é requirido',
            ];

            $request->validate($validacao, $feedback);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível adicionar o Lead. Favor verificar os dados e tentar novamente.');
        }

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
            'id_userResponsavel'=>$request->id_userResponsavel,
            'id_columnsKhanban'=>$request->id_columnsKhanban,
            'id_empresa'=>$id_empresa
        ]);

        $agora = new DateTime();
        $dia = $agora->format('d/m/Y');
        $hora = $agora->format('H:i:s');
        $usuario = auth()->user();

        ObservacaoLead::create([
            'id_lead'=>$lead->id_lead,
            'st_titulo'=>$dia.' ás '.$hora.' - '.$usuario->name.'- Lead Cadastrado no sistema.',
            'bl_oportunidade'=>0,
            'id_empresa'=>$usuario->id_empresa
        ]);

        return redirect()->route('vizualizarLeadAdminUser',['id_lead'=>$lead->id_lead])->with('success', 'Lead cadastrado com sucesso.');
    }
    public function EditarLeadAdmin(Lead $id_lead, Request $request)
    {
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
            'st_titulo'=>$dia.' ás '.$hora.' - '.$usuario->name.' adicionou uma oportunidade para '. $dataObjeto->format('d/m/Y').' :',
            'st_descricao'=>$request->st_descricao,
            'bl_oportunidade'=>1,
            'id_empresa'=>$usuario->id_empresa
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
            'st_titulo'=>$dia.' ás '.$hora.' - '.$usuario->name.' adicionou uma observação: ' ,
            'st_descricao'=>$request->st_descricao,
            'bl_oportunidade'=>0,
            'id_empresa'=>$usuario->id_empresa
        ]);

        return redirect()->back()->with('success', 'Oportunidade cadastrado com sucesso.');
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

        return view('AdminUser.leads.vizualizarLeadAdminUser',['lead'=>$Lead,'dadosCadastroLeads'=>$dadosCadastroLeads]);
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
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');

        $TESTE =  new DateTime();
        $final = $TESTE->format('Y-m-d');
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

        $id_leads = [];

        foreach ($leads as $lead){
            array_push($id_leads,$lead->id_lead);
        }

        $observacoes = ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato','>=',date('Y-m-d'))->where('bl_oportunidade',1)->orderby('dt_contato')->limit(5)->get();

        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');
        $hoje2 = date('Y-m-d');

        $DivInfoGerais = [
            'leads'=> Lead::where('id_empresa',$empresa)->whereRaw("created_at BETWEEN '$intervalodias' AND '$hoje2'" )->count(),
            'oportunidades'=> ObservacaoLead::wherein('id_lead',$id_leads)->where('bl_oportunidade',1)->whereRaw("dt_contato BETWEEN '$intervalodias' AND '$hoje2'" )->count(),
            'conversoes'=> 0
        ];

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>0,
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
            'DivInfoGerais'=>$DivInfoGerais
        ]);
    }

    public function vizualizarTodasleadsEmpresa()
    {
        $dadosForm = [
            'dt_inicio'=>null,
            'dt_final'=>null,
            'id_fase'=>null,
            'id_columnsKhanban'=>null,
        ];

        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_empresa',$empresa)->get();
        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::where('id_empresa',auth()->user()->id_empresa)->where('dt_contato',date('Y-m-d'))->where('bl_oportunidade',1)->count(),
            'atendimento'=>0,
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
                'st_iniciaisNome'=> count($nome)> 1 ? $nome[0][0].$nome[1][0] : $nome[0][0],
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
