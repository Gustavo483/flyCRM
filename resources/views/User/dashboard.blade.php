@extends('components.basicComponent')

@section('titulo', 'DashboarUser')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarUser')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div class="d-flex align-items-center p-2 campanhaVigente">
                    <div class=" colorgray me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#818181" height="1em" viewBox="0 0 640 512"><path d="M533.6 32.5C598.5 85.3 640 165.8 640 256s-41.5 170.8-106.4 223.5c-10.3 8.4-25.4 6.8-33.8-3.5s-6.8-25.4 3.5-33.8C557.5 398.2 592 331.2 592 256s-34.5-142.2-88.7-186.3c-10.3-8.4-11.8-23.5-3.5-33.8s23.5-11.8 33.8-3.5zM473.1 107c43.2 35.2 70.9 88.9 70.9 149s-27.7 113.8-70.9 149c-10.3 8.4-25.4 6.8-33.8-3.5s-6.8-25.4 3.5-33.8C475.3 341.3 496 301.1 496 256s-20.7-85.3-53.2-111.8c-10.3-8.4-11.8-23.5-3.5-33.8s23.5-11.8 33.8-3.5zm-60.5 74.5C434.1 199.1 448 225.9 448 256s-13.9 56.9-35.4 74.5c-10.3 8.4-25.4 6.8-33.8-3.5s-6.8-25.4 3.5-33.8C393.1 284.4 400 271 400 256s-6.9-28.4-17.7-37.3c-10.3-8.4-11.8-23.5-3.5-33.8s23.5-11.8 33.8-3.5zM301.1 34.8C312.6 40 320 51.4 320 64V448c0 12.6-7.4 24-18.9 29.2s-25 3.1-34.4-5.3L131.8 352H64c-35.3 0-64-28.7-64-64V224c0-35.3 28.7-64 64-64h67.8L266.7 40.1c9.4-8.4 22.9-10.4 34.4-5.3z"/></svg>
                    </div>
                    <div>
                        <p style="color:#818181; font-weight: bolder" class="p-0 m-0">{{$campanhasAtiva->st_nomeCampanha}} - ({{$campanhasAtiva->st_descricao}})</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="divFiltro2 w-100 me-2">
                        <form method="post" action="{{route('filtrarLeads')}}">
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
                    <button type="button" class="BtnCriarLeads" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" viewBox="0 0 640 512">
                            <path
                                d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/>
                        </svg>
                    </button>
                </div>

                <main class="mt-2">
                    <div id="projeto-id" style="display: none">{{$id_empresa}}</div>
                    @csrf
                    <section>
                        @foreach ($columnsStatus as $column)
                            <article data-column-id="{{ $column->id_columnsKhanban }}">
                                <div class="coluna-head">
                                    <label class="coluna-head3" style="background:{{$column->st_color}}">{{ $column->st_titulo }}</label>
                                </div>
                                <div class="coluna-body">
                                    @foreach ($column->leadsKanbanStatus as $leads)
                                        <div ondblclick="vizualizarLeadKanban({{$leads->id_lead}})" class="tarefa bg" data-position="{{ $leads->int_posicao }}" data-id="status-{{ $leads->id_lead }}" draggable="true">
                                            <div class="nome">{{ $leads->st_nome }}</div>
                                        </div>
                                        <a id="LeadsKanban{{$leads->id_lead}}" class="none" href="{{route('vizualizarLeadUser', ['id_lead'=>$leads->id_lead])}}"></a>
                                    @endforeach
                                    <div class="coluna-footer"></div>
                                </div>
                            </article>
                        @endforeach
                    </section>
                </main>

                @include('components.userComponents.CadastrarLead')

                <div class="">
                    @include('components.userComponents.infos')
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
                                    <div class="textGray d-flex align-items-center w-50">{{isset($lead->lead) ? $lead->lead->st_nome :''}}</div>
                                    <div class="textGray d-flex align-items-center justify-content-start w-25">{{ isset($lead->lead)? $lead->lead->int_telefone:''}}</div>
                                </div>
                                <div class="d-flex justify-content-between tamanho40 align-items-center">
                                    <div class="textBlue w-50">{{isset($lead->lead->produto) ?$lead->lead->produto->st_nomeProdutoServico :''}}</div>
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
                            <a id="Leads{{$lead->id_lead}}" class="none" href="{{route('vizualizarLeadUser', ['id_lead'=>$lead->lead->id_lead])}}"></a>
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
                                <form method="post" action="{{route('registrarDadoKanban')}}">
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
                                <form method="post" action="{{route('editarDadoKanban')}}">
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

                                <form method="post" action="{{route('deletarDadoKanban')}}">
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
                <div class="d-flex justify-content-end">
                    <a href="{{route('tarefasArquivadas', ['permissao'=>0])}}">
                        Tarefas Arquivadas
                    </a>
                </div>
            </div>
        </div>
        @if($indicadorComercial > 0 && auth()->user()->dt_fechouIndicador != date('Y-m-d'))
            <div id="DivIndicadorComercial" class="positionAbsolut flesdsd p-2">
                <div onclick="fecharIndicador()" class="d-flex justify-content-end fechar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </div>
                <div onclick="DirecionarLeadParaFiltro()" class="pointer d-flex align-items-center">
                    <div class="DivComercial">
                        Você tem {{$indicadorComercial}} leads sem movimentação a 1 mês. <br>Que tal movimenta-los ?
                    </div>
                    <div class="ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="70" height="70" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                    </div>
                </div>
            </div>
        @endif
        <a id="IndicadorComercialLink" href="{{route('IndicadorComercial')}}" class="none"></a>
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


