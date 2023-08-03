@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarUser')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                    @include('components.userComponents.EditarLead')
                </div>

                <div>
                    <div class=" colorgray">
                        Leads > detalhamento lead
                    </div>
                    <div class="flexName mt-3">
                        <h1 class=" NameLead p-0 me-2">{{$lead->st_nome}}</h1>
                        <div class="mb-3" style="width: 180px; height:10px;">
                            <div style="width:{{$lead->int_temperatura}}%;" class="divTemperatura"></div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="divService px-2">Curso tecnico em logistica</span>
                    </div>

                    <div class="d-flex mt-5">
                        <a type="button" class="linksLeads me-3" data-bs-toggle="modal" data-bs-target="#AdicionarObservacao">
                            Adicionar observação
                        </a>
                        <a type="button" class="linksLeads me-3" data-bs-toggle="modal" data-bs-target="#AdicionarOportunidade">
                            Adicionar Oportunidade
                        </a>
                        <a class="linksLeads me-3">Converter em cliente</a>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="AdicionarOportunidade" data-bs-backdrop="static" data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastro de oportunidade</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body ">
                                    <form method="post" action="{{route('registrarOportunidade', ['id_lead'=>$lead->id_lead])}}">
                                        @csrf
                                        <div>
                                            <label>Data de contato:</label>
                                            <input class="form-control" type="date" name="dt_contato" required>
                                        </div>
                                        <div class="my-4">
                                            <div class="form-floating">
                                            <textarea class="form-control" placeholder="Deixe sua observação aqui"
                                                      name="st_descricao" id=""
                                                      style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">Observações</label>
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

                    <!-- Modal -->
                    <div class="modal fade" id="AdicionarObservacao" data-bs-backdrop="static" data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastro de observação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body ">
                                    <form method="post" action="{{route('registrarObservacao', ['id_lead'=>$lead->id_lead])}}">
                                        @csrf
                                        <div class="my-4">
                                            <div class="form-floating">
                                            <textarea class="form-control" placeholder="Deixe sua observação aqui"
                                                      name="st_descricao" id=""
                                                      style="height: 100px" required></textarea>
                                                <label for="floatingTextarea2">Observações</label>
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
                    <div style="width: 70%" class="mt-4 d-flex justify-content-end">
                        <!-- Button editar modal -->
                        <button type="button" class="BtnEditarLeads p-0 m-0" data-bs-toggle="modal"
                                data-bs-target="#EditarLead">
                            Editar lead
                        </button>
                    </div>
                    <div class=" border DivPrincipal">
                    </div>
                    <div class="d-flex justify-content-between mb-5">
                        <div class="DivPrincipal p-3">
                            <div class="">
                                @foreach($lead->observacoes->sortByDesc('created_at') as $observacao)
                                    @if($observacao->bl_oportunidade === 1)
                                        <div class="DivOportunidade d-flex justify-content-between align-items-center mt-4">
                                            <div>
                                                <p>{{$observacao->st_titulo}}</p>
                                                <p>{{$observacao->st_descricao}}</p>
                                            </div>
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" class="ms-3" fill="#3956ea" viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg>
                                            </div>
                                        </div>
                                    @endif
                                    @if($observacao->bl_oportunidade === 0)
                                        <div class="DivNormal d-flex justify-content-between align-items-center mt-4">
                                            <div>
                                                <p>{{$observacao->st_titulo}}</p>
                                                <p>{{$observacao->st_descricao}}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="DivInfo p-3">
                            <h4 class="colorgray2">Informações</h4>
                            <div class="mt-3">
                                <p class="colorgray2 m-0 bolder">{{$lead->st_nome}}</p>
                                <p class="colorgray3 m-0">{{$lead->int_telefone}}</p>
                                <p class="colorgray3 m-0">{{$lead->st_email}}</p>
                            </div>
                            <div class="mt-5">
                                <p class="colorgray3 m-0 ">Origem: {{isset($lead->origem->st_nomeOrigem) ?  $lead->origem->st_nomeOrigem : ''}}</p>
                                <p class="colorgray3 m-0">Mídia: {{isset($lead->midia->st_nomeMidia) ? $lead->midia->st_nomeMidia:''}}</p>
                                <p class="colorgray3 m-0">Campanha: {{isset($lead->campanha->st_nomeCampanha) ? $lead->campanha->st_nomeCampanha:''}}</p>
                                <p class="colorgray3 m-0">Responsável: {{isset($lead->responsavel->name) ? $lead->responsavel->name : ''}}</p>
                            </div>

                            <div class="my-5">
                                <p class="colorgray3 m-0">Status: {{isset($lead->status->st_titulo) ? $lead->status->st_titulo : ''}}</p>
                                <p class="colorgray3 m-0">Temperatura: {{$lead->int_temperatura}}%</p>
                                <p class="colorgray3 m-0">Fase: {{isset($lead->fase->st_nomeFase) ? $lead->fase->st_nomeFase : ''}}</p>
                                <p class="colorgray3 m-0">Grupo: {{isset($lead->grupo->st_nomeGrupo) ? $lead->grupo->st_nomeGrupo :''}}</p>
                                <p class="colorgray3 m-0">Produto/Serviço: {{isset($lead->servico->st_nomeProdutoServico) ?$lead->servico->st_nomeProdutoServico :''}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


