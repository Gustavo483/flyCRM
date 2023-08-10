@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

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
                <div class=" colorgray">
                    Configuração do sistema
                </div>

                <!-- Configurações para os usuarios -->
                <div>
                    @include('layouts.adminUser.configUsuario.editarUsuario')
                    @include('layouts.adminUser.configUsuario.deletarUsuario')
                    <div class="my-2">
                        @include('layouts.adminUser.configUsuario.adicionarUsuario')
                    </div>
                    <div id="divUsuariosEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaUsuarios','divUsuariosEmpresa')">
                        <div class="d-flex w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divUsuariosEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Usuario
                                </div>
                            </div>
                            <div id="" style="width: 40%" class="textIndices">Permissões</div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaUsuarios" class="p-3 none">
                        @foreach($dados['usuarios'] as $usuario)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 40%" class="d-flex align-items-center">
                                    <div class="iniciaisUsuario d-flex justify-content-center align-items-center">GS
                                    </div>
                                    <div class="ps-2 textIndices2">
                                        {{$usuario->name}}
                                    </div>
                                </div>
                                <div style="width: 40%" class="textIndices2">Leads, Oportunidades</div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarUsuario({{$usuario}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteUsuario({{$usuario}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarUsuario">
                                Adicionar usuario
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Configurações para os Status(Kanban) -->
                <div class="mt-3">
                    @include('layouts.adminUser.configStatus.editarStutus')
                    @include('layouts.adminUser.configStatus.deletarStutus')
                    @include('layouts.adminUser.configStatus.adicionarStutus')
                    <div id="divStatusEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaStatus','divStatusEmpresa')">
                        <div class="d-flex justify-content-between w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divStatusEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Status (Kanban)
                                </div>
                            </div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaStatus" class="p-3 none bgWhite">
                        @foreach($dados['status'] as $status)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 80%" class="d-flex align-items-center">
                                    <div style="background: {{$status->st_color}}" class="ColorKankan d-flex justify-content-center align-items-center"></div>
                                    <div class="ps-2 textIndices2">
                                        {{$status->st_titulo}}
                                    </div>
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarStatus({{$status}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteStatus({{$status}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarStatus">
                                Adicionar Status
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Configurações para midias da empresa -->
                <div class="mb-3">
                    @include('layouts.adminUser.configMidias.editarMidias')
                    @include('layouts.adminUser.configMidias.deletarMidias')
                    @include('layouts.adminUser.configMidias.adicionarMidias')
                    <div id="divMidiasEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaMidias','divMidiasEmpresa')">
                        <div class="d-flex justify-content-between w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divMidiasEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Mídias
                                </div>
                            </div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaMidias" class="p-3 none bgWhite">
                        @foreach($dados['midias'] as $midia)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 80%" class="d-flex align-items-center">
                                    <div class="ps-2 textIndices2">
                                        {{$midia->st_nomeMidia}}
                                    </div>
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarMidias({{$midia}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteMidia({{$midia}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarMidia">
                                Adicionar mídia
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Configurações para grupos da empresa -->
                <div class="mb-3">
                    @include('layouts.adminUser.configGrupos.editarGrupos')
                    @include('layouts.adminUser.configGrupos.deletarGrupos')
                    @include('layouts.adminUser.configGrupos.adicionarGrupos')
                    <div id="divGruposEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaGrupos','divGruposEmpresa')">
                        <div class="d-flex justify-content-between w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divGruposEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Grupos
                                </div>
                            </div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaGrupos" class="p-3 none bgWhite">
                        @foreach($dados['grupos'] as $grupo)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 80%" class="d-flex align-items-center">
                                    <div class="ps-2 textIndices2">
                                        {{$grupo->st_nomeGrupo}}
                                    </div>
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarGrupo({{$grupo}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteGrupo({{$grupo}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarGrupo">
                                Adicionar grupo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Configurações para Fases da empresa -->
                <div class="mb-3">
                    @include('layouts.adminUser.configFases.editarFases')
                    @include('layouts.adminUser.configFases.deletarFases')
                    @include('layouts.adminUser.configFases.adicionarFases')
                    <div id="divFasesEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaFases','divFasesEmpresa')">
                        <div class="d-flex justify-content-between w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divFasesEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Fases
                                </div>
                            </div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaFases" class="p-3 none bgWhite">
                        @foreach($dados['fases'] as $fase)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 80%" class="d-flex align-items-center">
                                    <div class="ps-2 textIndices2">
                                        {{$fase->st_nomeFase}}
                                    </div>
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarFase({{$fase}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteFase({{$fase}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarFase">
                                Adicionar fase
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Configurações para Origem da empresa -->
                <div class="mb-3">
                    @include('layouts.adminUser.configOrigens.editarOrigens')
                    @include('layouts.adminUser.configOrigens.deletarOrigens')
                    @include('layouts.adminUser.configOrigens.adicionarOrigens')
                    <div id="divOrigensEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaOrigens','divOrigensEmpresa')">
                        <div class="d-flex justify-content-between w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divOrigensEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Origens
                                </div>
                            </div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaOrigens" class="p-3 none bgWhite">
                        @foreach($dados['origens'] as $origem)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 80%" class="d-flex align-items-center">
                                    <div class="ps-2 textIndices2">
                                        {{$origem->st_nomeOrigem}}
                                    </div>
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarOrigem({{$origem}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteOrigem({{$origem}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarOrigem">
                                Adicionar Origem
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Configurações para Campanha da empresa -->
                <div class="mb-3">
                    @include('layouts.adminUser.configCampanhas.editarCampanhas')
                    @include('layouts.adminUser.configCampanhas.deletarCampanhas')
                    @include('layouts.adminUser.configCampanhas.adicionarCampanhas')
                    <div id="divCampanhasEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaCampanhas','divCampanhasEmpresa')">
                        <div class="d-flex justify-content-between w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divCampanhasEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Campanhas
                                </div>
                            </div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaCampanhas" class="p-3 none bgWhite">
                        @foreach($dados['campanhas'] as $campanha)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 80%" class="d-flex align-items-center">
                                    <div class="ps-2 textIndices2">
                                        {{$campanha->st_nomeCampanha}}
                                    </div>
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarCampanha({{$campanha}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteCampanha({{$campanha}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarCampanha">
                                Adicionar Campanha
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Configurações para Setor da empresa -->
                <div class="mb-3">
                    @include('layouts.adminUser.configSetores.editarSetores')
                    @include('layouts.adminUser.configSetores.deletarSetores')
                    @include('layouts.adminUser.configSetores.adicionarSetores')
                    <div id="divSetoresEmpresa" class="divCabecalho"
                         onclick="abrirDiv('listaSetores','divSetoresEmpresa')">
                        <div class="d-flex justify-content-between w-100">
                            <div style="width: 40%" class="d-flex align-items-center">
                                <div id="divSetoresEmpresaDesenho" class="desenho"></div>
                                <div class="ps-2 textIndices">
                                    Setores
                                </div>
                            </div>
                            <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                        </div>
                    </div>
                    <div id="listaSetores" class="p-3 none bgWhite">
                        @foreach($dados['setores'] as $setor)
                            <div class="d-flex w-100 align-items-center p-2 divGray mb-1">
                                <div style="width: 80%" class="d-flex align-items-center">
                                    <div class="ps-2 textIndices2">
                                        {{$setor->st_nomeSetor}}
                                    </div>
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarSetor({{$setor}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteSetor({{$setor}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-start mt-4">
                            <!-- Button trigger modal -->
                            <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                                    data-bs-target="#AdicionarSetor">
                                Adicionar Setor
                            </button>
                        </div>
                    </div>
                </div>

                <div class="py-5"></div>
            </div>
        </div>
    </div>
@endsection


