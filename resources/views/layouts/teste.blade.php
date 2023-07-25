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
        @foreach($dados['Origens'] as $origem)
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
