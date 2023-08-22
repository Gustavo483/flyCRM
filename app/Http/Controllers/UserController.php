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
use App\Models\ToDoKhanban;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    public function filtrarLeadsAvancadoUser(Request $request)
    {
        $usuario = auth()->user()->id;
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
            if ($key !== 'dt_inicio' && $key !== 'dt_final'){
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

        if ($where){
            $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE '.$where.' and id_userResponsavel = '.$usuario;
        }else{
            $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE id_userResponsavel = '.$usuario;
        }

        $leadsSql = DB::select($sqlLeads);

        $ids_leads = [];
        foreach ($leadsSql as $lead){
            array_push($ids_leads,$lead->id_lead);
        }

        $leads = Lead::wherein('id_lead',$ids_leads)->get();

        $hoje2 = new DateTime();

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$ids_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_userResponsavel',$usuario)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get()
        ];

        return view('User.leads.vizualizarTodasLeadsUser', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads, 'dadosForm'=>$dadosForm]);
    }
    public function registrarAtividadeAgendaUser(Request $request)
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

    public function editarDadoKanban(Request $request)
    {
        ToDoKhanban::where('id_toDoKhanban', $request->id_toDoKhanban)->update([
            'st_descricao' => $request->st_descricao
        ]);
        return redirect()->back()->with('success', 'Atividade atualizada com sucesso.');
    }

    public function deletarDadoKanban(Request $request)
    {
        ToDoKhanban::where('id_toDoKhanban', $request->id_toDoKhanban)->delete();
        return redirect()->back()->with('success', 'Atividade deletada com sucesso.');
    }

    public function registrarDadoKanban(Request $request)
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

    public function registrarOportunidade(Request $request)
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

        return redirect()->back()->with('success', 'Oportunidade cadastrado com sucesso.');
    }

    public function registrarObservacao(Request $request)
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

        return redirect()->back()->with('success', 'Oportunidade cadastrado com sucesso.');
    }
    public function vizualizarLeadUser( Lead $id_lead)
    {
        $empresa = auth()->user()->id_empresa;
        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get()
        ];
        $Lead = $id_lead;
        return view('User.leads.vizualizarLeadUser',['lead'=>$Lead,'dadosCadastroLeads'=>$dadosCadastroLeads]);
    }
    public function EditarLead(Lead $id_lead, Request $request)
    {
        $id_lead->update($request->all());
        return redirect()->back()->with('success', 'Lead atualizado com sucesso.');
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
        $usuario = auth()->user()->id;


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
            'id_userResponsavel'=>$usuario,
            'id_columnsKhanban'=>$request->id_columnsKhanban,
            'id_empresa'=>$id_empresa
        ]);

        $agora = new DateTime();
        $dia = $agora->format('d/m/Y');
        $hora = $agora->format('H:i:s');
        $usuario = auth()->user();

        ObservacaoLead::create([
            'id_lead'=>$lead->id_lead,
            'st_titulo'=>$dia.' às '.$hora.' - '.$usuario->name.' - Lead Cadastrado no sistema.',
            'bl_oportunidade'=>0,
            'id_empresa'=>$usuario->id_empresa
        ]);

        return redirect()->route('vizualizarLeadUser', ['id_lead'=>$lead->id_lead])->with('success', 'Lead cadastrado com sucesso.');
    }

    public function leadsUltimosQuinzeDias(): mixed
    {
        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalo2 = new DateInterval('P1D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');

        $TESTE =  new DateTime();
        $final = $TESTE->add($intervalo2)->format('Y-m-d');
        $userResponsavel = auth()->user()->id;
        $userCountByDay = Lead::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->whereRaw("created_at BETWEEN '$intervalodias' AND '$final'" )
            ->whereRaw("id_userResponsavel = '$userResponsavel'" )
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
    public function dashboardUser()
    {

        $this->verificarAtividadesConcluidasToDo();

        $userResponsavel = auth()->user()->id;

        $leads15days = $this->leadsUltimosQuinzeDias();

        $sqlFases = 'SELECT f.st_nomeFase AS fase, COUNT(*) AS count FROM tb_leads as l
                    left JOIN tb_fases AS f ON l.id_fase = f.id_fase
                    WHERE id_userResponsavel = '.$userResponsavel.' GROUP BY fase';

        $fases = DB::select($sqlFases);

        $sqlStatus = 'SELECT s.st_titulo AS status, COUNT(*) AS count FROM tb_leads as l
                    left JOIN tb_columns_khanban AS s ON l.id_columnsKhanban = s.id_columnsKhanban
                    WHERE id_userResponsavel = '.$userResponsavel.' GROUP BY status';

        $status = DB::select($sqlStatus);

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

        $usuario = auth()->user()->id;
        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_userResponsavel',$usuario)->get();

        $id_leads = [];

        foreach ($leads as $lead){
            array_push($id_leads,$lead->id_lead);
        }

        $observacoes = ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato','>=',date('Y-m-d'))->where('bl_oportunidade',1)->orderby('dt_contato')->limit(5)->get();

        $hoje = new DateTime();
        $intervalo = new DateInterval('P15D');
        $intervalodias = $hoje->sub($intervalo)->format('Y-m-d');
        $hoje2 = new DateTime();
        $intervalo2 = new DateInterval('P1D');
        $final = $hoje2->add($intervalo2)->format('Y-m-d');


        $DivInfoGerais = [
            'leads'=> Lead::where('id_userResponsavel',$usuario)->whereRaw("created_at BETWEEN '$intervalodias' AND '$final'" )->count(),
            'oportunidades'=> ObservacaoLead::wherein('id_lead',$id_leads)->where('bl_oportunidade',1)->whereRaw("created_at BETWEEN '$intervalodias' AND '$final'" )->count(),
            'conversoes'=> 1
        ];

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_userResponsavel',$usuario)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get()
        ];
        $columnsStatus = ColumnsKhanban::where('id_empresa',$empresa)->where('int_tipoKhanban', 1)->orderBy('int_posicao')->get();

        $columnsToDo = ColumnsKhanban::where('id_empresa',$empresa)->where('int_tipoKhanban',2)->orderBy('int_posicao')->get();
        return view('User.dashboard', [
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
    public function kanbanteste()
    {
        $empresa = auth()->user()->id_empresa;
        $columns = ColumnsKhanban::where('id_empresa',$empresa)->where('int_tipoKhanban', 1)->orderBy('int_posicao')->get();
        return view('User.teste', [
            'columns'=>$columns
        ]);
    }
    public function saveTasksOrder(Request $request)
    {
        try {
            $dados = json_decode($request->json, true);
            foreach ($dados as $id_tarefa => $tarefa) {

                $tarf = explode("-", $id_tarefa);
                if ($tarf[0] ==='todo'){
                    $toDo = ToDoKhanban::where('id_toDoKhanban',$tarf[1])->first();
                    $toDo->update([
                        'id_columnsKhanban'=>$tarefa['coluna'],
                        'int_posicao'=>$tarefa['posicao']
                    ]);
                }
                if ($tarf[0] ==='status'){
                    $lead = Lead::where('id_lead',$tarf[1])->first();
                    if ($lead->id_columnsKhanban != $tarefa['coluna']){
                        $lead->update([
                            'id_columnsKhanban'=>$tarefa['coluna'],
                            'int_posicao'=>$tarefa['posicao'],
                            'bl_atendimento'=>1
                        ]);
                    }
                }
            }
        }
        catch (Throwable $erro) {
            DB::rollBack();
            echo "Erro ao salvar ordem das tarefas: {$erro}";
            die;
        }
        echo 'Ordem atualizada com sucesso!';
    }

    public function vizualizarAgendaUser()
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
        return view('User.agenda.vizualizarAgenda',['tela'=>'agenda', 'dadosAgenda'=>json_encode($results)]);
    }
    public function vizualizarTodasleadsUser()
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
            "id_columnsKhanban" => null
        ];


        $usuario = auth()->user()->id;
        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_userResponsavel',$usuario)->get();
        $id_leads = [];

        foreach ($leads as $lead){
            array_push($id_leads,$lead->id_lead);
        }

        $hoje2 = new DateTime();

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$id_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_userResponsavel',$usuario)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get()
        ];

        return view('User.leads.vizualizarTodasLeadsUser', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads,'dadosForm'=>$dadosForm]);
    }

    public function filtrarLeads(Request $request)
    {
        $usuario = auth()->user()->id;
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
            $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE '.$where.' and id_userResponsavel = '.$usuario;
        }else{
            $sqlLeads= 'SELECT id_lead FROM tb_leads WHERE id_userResponsavel = '.$usuario;
        }

        $leadsSql = DB::select($sqlLeads);

        $ids_leads = [];
        foreach ($leadsSql as $lead){
            array_push($ids_leads,$lead->id_lead);
        }

        $leads = Lead::wherein('id_lead',$ids_leads)->get();

        $hoje2 = new DateTime();

        $dadosInfo = [
            'leads'=> count($leads),
            'Oportunidades'=>ObservacaoLead::wherein('id_lead',$ids_leads)->where('dt_contato',$hoje2)->where('bl_oportunidade',1)->count(),
            'atendimento'=>Lead::where('id_userResponsavel',$usuario)->where('bl_atendimento', 1)->count(),
        ];

        $dadosCadastroLeads = [
            'origens' => Origem::where('id_empresa', $empresa)->get(),
            'campanhas' => Campanha::where('id_empresa', $empresa)->get(),
            'Produtos' => ProdutoServico::where('id_empresa', $empresa)->get(),
            'fases' => Fase::where('id_empresa', $empresa)->get(),
            'grupos' => Grupo::where('id_empresa', $empresa)->get(),
            'status' => ColumnsKhanban::where('id_empresa', $empresa)->where('int_tipoKhanban',1)->get(),
            'midias' => Midia::where('id_empresa', $empresa)->get()
        ];

        return view('User.leads.vizualizarTodasLeadsUser', ['tela' =>'leads','dadosInfo'=>$dadosInfo,'dadosCadastroLeads'=>$dadosCadastroLeads,'leads'=>$leads, 'dadosForm'=>$dadosForm]);
    }



    public function vizualizarOportunidadesUser()
    {
        $usuario = auth()->user()->id;
        $empresa = auth()->user()->id_empresa;
        $leads = Lead::where('id_userResponsavel',$usuario)->get();
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

        return view('User.oportunidades.vizualizarOportunidadesUser', ['tela' =>'oportunidade', 'oportunidades'=>$oportunidades,'dadosInfo'=>$dadosInfo ]);
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
