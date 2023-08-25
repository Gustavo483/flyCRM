@extends('components.basicComponent')

@section('titulo', 'DashboarAdmin')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarAdminUser')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div class="d-flex justify-content-between">
                    <div class=" colorgray">
                        Dashbord
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="divFiltro2 w-100 me-2 mt-3">
                        <form method="post" action="{{route('filtrarLeadsAdmin')}}">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <div class=" d-flex tamanhoDivSearch">
                                    <input class="form-select me-2" type="date" name="dt_inicio">
                                    <input class="form-select me-2" type="date" name="dt_final">
                                    <select class="form-select me-2" name="id_fase" aria-label="Default select example">
                                        <option value="">fases:</option>
                                        @foreach($dadosCadastroLeads['fases'] as $fases)
                                            <option value="{{$fases->id_fase}}">{{$fases->st_nomeFase}}</option>
                                        @endforeach
                                    </select>

                                    <select class="form-select " name="id_columnsKhanban" aria-label="Default select example">
                                        <option value="">status:</option>
                                        @foreach($dadosCadastroLeads['status'] as $status)
                                            <option value="{{$status->id_columnsKhanban}}">{{$status->st_titulo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btnSearch border">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Button trigger modal -->
                    <button type="button" class="BtnCriarLeads" data-bs-toggle="modal"
                            data-bs-target="#CadastrarLead">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" viewBox="0 0 640 512">
                            <path
                                d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/>
                        </svg>
                    </button>
                </div>

                <main class="mt-3">
                    <div id="projeto-id" style="display: none">{{$id_empresa}}</div>
                    @csrf
                    <section>
                        @foreach ($columnsStatus as $column)
                            <article class="sdfsdfs" data-column-id="{{ $column->id_columnsKhanban }}">
                                <div class="coluna-head">
                                    <label class="coluna-head3" style="background:{{$column->st_color}}">{{ $column->st_titulo }}</label>
                                </div>

                                <div class="coluna-body sdfsdfsdf">
                                    @foreach ($column->leadsKanbanStatus as $leads)
                                        <div ondblclick="vizualizarLeadKanban({{$leads->id_lead}})" class="tarefa bg" data-position="{{ $leads->int_posicao }}" data-id="status-{{ $leads->id_lead }}" draggable="true">
                                            <div class="nome">{{ $leads->st_nome }}</div>
                                        </div>
                                        <a id="LeadsKanban{{$leads->id_lead}}" class="none" href="{{route('vizualizarLeadAdminUser', ['id_lead'=>$leads->id_lead])}}"></a>
                                    @endforeach
                                    <div class="coluna-footer"></div>
                                </div>
                            </article>
                        @endforeach
                    </section>
                </main>
                @include('components.adminUserComponents.CadastrarLead')

                <div class="">
                    @include('components.adminUserComponents.infos')
                </div>

                <div class="d-flex mt-4">
                    <div class="w-75">
                        <div class="d-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#2563eb" viewBox="0 0 512 512">
                                <path
                                    d="M256 48C141.1 48 48 141.1 48 256v40c0 13.3-10.7 24-24 24s-24-10.7-24-24V256C0 114.6 114.6 0 256 0S512 114.6 512 256V400.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24H240c-26.5 0-48-21.5-48-48s21.5-48 48-48h32c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40V256c0-114.9-93.1-208-208-208zM144 208h16c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H144c-35.3 0-64-28.7-64-64V272c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64v48c0 35.3-28.7 64-64 64H352c-17.7 0-32-14.3-32-32V240c0-17.7 14.3-32 32-32h16z"/>
                            </svg>
                            <h5 class="proxOportunidade ps-2">Próximas oportunidades</h5>
                        </div>

                        @foreach($observacoes as $lead)
                            <div onclick="vizualizarLead({{$lead->lead->id_lead}})" class="divEmpresas2 my-3 d-flex">
                                <div class="d-flex justify-content-between tamanho60">
                                    <div class="textBlue d-flex align-items-center w-25">{{isset($lead->lead->fase->st_nomeFase)?$lead->lead->fase->st_nomeFase:''}}</div>
                                    <div class="textGray d-flex align-items-center w-50">
                                        <div class="w-75">
                                            {{isset($lead->lead) ? $lead->lead->st_nome : ''}}
                                        </div>
                                        <div class="w-25 me-5">
                                            <button class="infoResponsavel ps-1" data-toggle="tooltip" data-placement="bottom" title="{{$lead->lead->responsavel->name}}">
                                                {{isset($lead->lead->responsavel) ? $lead->lead->responsavel->st_iniciaisNome : ''}}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="textGray d-flex align-items-center justify-content-start w-25">{{isset($lead->lead) ? $lead->lead->int_telefone: ''}}</div>
                                </div>
                                <div class="d-flex justify-content-between tamanho40 align-items-center">
                                    <div class="textBlue w-50">{{isset($lead->lead->produto) ?$lead->lead->produto->st_nomeProdutoServico: ''}}</div>
                                    <div class="d-flex  align-items-center w-50 justify-content-between">
                                        <div class="d-flex  align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#b9b9b9" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                                                <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                            </svg>
                                            <div class="textGray3 d-flex align-items-center ps-3" >{{isset($lead->dt_contato)? DateTime::createFromFormat('Y-m-d', $lead->dt_contato)->format('d/m/Y') : '--'}}</div>
                                        </div>
                                        <div >
                                            <a target=”_blank” href="https://web.whatsapp.com/send/?l=pt_BR&phone=55{{$lead->int_telefone}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#7ba7d7" width="20px" height="20px" viewBox="0 0 320 512"><path d="M112 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm40 304V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9L59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352H152z"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a id="Leads{{$lead->lead->id_lead}}" class="none" href="{{route('vizualizarLeadAdminUser', ['id_lead'=>$lead->lead->id_lead])}}"></a>
                        @endforeach
                    </div>


                    <div class="w-25 p-3">
                        <div class="DivInfoGerais">
                            <p style="color: #a6b3f5; font-weight: bolder">último 15 dias</p>
                            <p style="color: #1d3ee7; font-weight: 900;font-size: 18px" class="mt-2 p-0 m-0">+{{$DivInfoGerais['leads']}}</p>
                            <p style="color: #95e1e1; font-weight: bolder" class="p-0 m-0">leads</p>
                            <p style="color: #1d3ee7; font-weight: 900;font-size: 18px" class="mt-2 p-0 m-0">+{{$DivInfoGerais['oportunidades']}}</p>
                            <p style="color: #95e1e1; font-weight: bolder" class="p-0 m-0">oportunidades</p>
                            <p style="color: #1d3ee7; font-weight: 900;font-size: 18px" class="mt-2 p-0 m-0">+{{$DivInfoGerais['conversoes']}}</p>
                            <p style="color: #95e1e1; font-weight: bolder" class="p-0 m-0">conversões</p>
                        </div>
                    </div>
                </div>



                <div class="d-flex justify-content-between align-items-center my-5">
                    <div class="DivInfoGerais">
                        <p style="color: #a6b3f5; font-weight: bolder" class="p-0 m-0">Status</p>
                        <canvas id="divGhafhcsStatus"></canvas>
                    </div>
                    <div class="DivInfoGerais">
                        <p style="color: #a6b3f5; font-weight: bolder" class="p-0 m-0">Fases</p>
                        <canvas id="divGhafhcsFases"></canvas>
                    </div>
                    <div class="DivInfoGerais2">
                        <p style="color: #a6b3f5; font-weight: bolder" class="p-0 m-0">Leads</p>
                        <canvas id="chartLeads15Dias"></canvas>
                    </div>
                </div>

                {{--                Cadastro de nova atividade --}}
                <div class="modal fade" id="CriarDadoKanban" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="CriarDadoKanban" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastrar Dado no Kanban</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body ">
                                <form method="post" action="{{route('registrarDadoKanbanAdmin')}}">
                                    @csrf
                                    <div class="my-3">
                                        <input type="text" class="form-control" placeholder="Descrição atividade:" name="st_descricao"
                                               aria-describedby="basic-addon1" value="{{ old('st_descricao') }}" required>
                                        <div class="colorRed">
                                            {{ $errors->has('st_descricao') ? $errors->first('st_descricao') : '' }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="BtnBlue my-3">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <button id="EditarTarefa"  type="button" class="none" data-bs-toggle="modal" data-bs-target="#EditarTarefaKanban">
                    Ações tarefa
                </button>
                <div class="modal fade" id="EditarTarefaKanban" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="CriarDadoKanban" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Ações tarefa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body ">
                                <div class="text-center colorTitle">
                                    Editar
                                </div>
                                <form method="post" action="{{route('editarDadoKanbanAdmin')}}">
                                    @csrf
                                    <div class="my-3">
                                        <input id="inputId" class="none" name="id_toDoKhanban">
                                        <input id="st_descricaoEditKanban" type="text" class="form-control" placeholder="Descrição:" name="st_descricao"
                                               aria-describedby="basic-addon1" value="{{ old('st_descricao') }}" required>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="BtnBlue my-3">Editar</button>
                                    </div>
                                </form>

                                <div class="text-center colorRed mt-5">
                                    Deletar
                                </div>
                                <div class="mt-2 colorRed text-center">
                                    deseja mesmo deletar a atividade ?
                                </div>

                                <form method="post" action="{{route('deletarDadoKanbanAdmin')}}">
                                    @csrf
                                    <div class="my-3">
                                        <input id="inputIdDelete" class="none" name="id_toDoKhanban">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="BtnRed my-3">Deletar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <main class="mb-5">
                    <div id="projeto-id" style="display: none">{{$id_empresa}}</div>
                    @csrf
                    <section>
                        @foreach ($columnsToDo as $column)
                            <article data-column-id="{{$column->id_columnsKhanban }}">
                                <div class="coluna-head">
                                    @if($column->st_titulo === 'a fazer')
                                        <label class="coluna-head3" style="background:{{$column->st_color}}">
                                            {{ $column->st_titulo }}
                                            <button style="background: {{$column->st_color}}" type="button" class="BtnAdicionarKanbanToDo" data-bs-toggle="modal" data-bs-target="#CriarDadoKanban">
                                                +
                                            </button>
                                        </label>
                                    @endif
                                    @if($column->st_titulo != 'a fazer')
                                        <label class="coluna-head3" style="background:{{$column->st_color}}">
                                            {{ $column->st_titulo }}
                                        </label>
                                    @endif
                                </div>

                                <div class="coluna-body">
                                    @if($column->st_titulo != 'concluído')
                                        @foreach ($column->ToDoUser as $ToDo)
                                            <div ondblclick="vizualizarTarefa({{$ToDo}})" class="tarefa bg" data-position="{{$ToDo->int_posicao}}" data-id="todo-{{ $ToDo->id_toDoKhanban}}" draggable="true">
                                                <div class="nome">{{$ToDo->st_descricao}}</div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if($column->st_titulo === 'concluído')
                                        @foreach ($column->ToDoUser as $ToDo)
                                            <div ondblclick="vizualizarTarefa({{$ToDo}})" class="tarefa bg" data-position="{{$ToDo->int_posicao}}" data-id="todo-{{ $ToDo->id_toDoKhanban}}" draggable="true">
                                                <div class="nome">{{$ToDo->st_descricao}}</div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="coluna-footer"></div>
                                </div>
                            </article>
                        @endforeach
                    </section>
                </main>
            </div>
        </div>
    </div>
    <script src="{{asset('js/board.js')}}"></script>
    <script>
        const leadsUltimosQuinzeDias = {!!  $graphics['leadsUltimosQuinzeDias'] !!};
        const chartLeads15Dias = document.getElementById('chartLeads15Dias');
        new Chart(chartLeads15Dias, {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Leads 15 dias',
                        data: JSON.parse(leadsUltimosQuinzeDias)
                    }]
            },
            options: {
                parsing: {
                    xAxisKey: 'day',
                    yAxisKey: 'qnt'
                }
            }
        });

        const divGhafhcsFases = document.getElementById('divGhafhcsFases');
        new Chart(divGhafhcsFases, {
            type: 'doughnut',
            data: {
                labels: [{!! $labelsFases!!}],
                datasets: [
                    {
                        label: 'Quantidade',
                        data: [{!! $dataFases!!}],
                    }]
            }
        });

        const divGhafhcsStatus = document.getElementById('divGhafhcsStatus');
        new Chart(divGhafhcsStatus, {
            type: 'doughnut',
            data: {
                labels: [{!! $labelsStatus!!}],
                datasets: [
                    {
                        label: 'Quantidade',
                        data: [{!! $dataStatus!!}],
                    }]
            }
        });
    </script>
@endsection


