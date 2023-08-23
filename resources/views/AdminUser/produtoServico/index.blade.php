@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <!-- Modal Setores -->
            <div class="modal fade" id="AdicionarSetor" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h5 class="modal-title colorTitle" id="staticBackdropLabel">Adicionar produto/servico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body ">
                            <form method="post" action="{{route('registrarProdutoServico')}}">
                                @csrf
                                <div class="my-3">
                                    <input type="text" class="form-control" placeholder="Nome :" name="st_nomeProdutoServico"
                                           aria-describedby="basic-addon1" value="{{ old('st_nomeProdutoServico') }}" required>
                                    <div id="st_nomeProdutoServico" class="colorRed">
                                        {{ $errors->has('st_nomeProdutoServico') ? $errors->first('st_nomeProdutoServico') : '' }}
                                    </div>
                                </div>

                                <div class="my-3">
                                    <input type="text" class="form-control" placeholder="Descrição :" name="st_descricao"
                                           aria-describedby="basic-addon1" value="{{ old('st_descricao') }}" required>
                                    <div id="st_descricao" class="colorRed">
                                        {{ $errors->has('st_descricao') ? $errors->first('st_descricao') : '' }}
                                    </div>
                                </div>

                                <div class="my-3">
                                    <label>Selecione a cor :</label>
                                    <input type='color' class="inputColors" name="st_color" value="{{ old('st_color') }}" required>
                                    <div id="email" class="colorRed">
                                        {{ $errors->has('st_color') ? $errors->first('st_color') : '' }}
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="BtnBlue my-3">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="d-flex justify-content-end">
                <button id="EditarProdutoBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarProduto">
                    Editar produto Serviço
                </button>
            </div>

            <!-- Modal edit-->
            <div class="modal fade" id="EditarProduto" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar produto/serviço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('editarProdutoServico')}}">
                                @csrf
                                <div class="my-3">
                                    <input id="id_ProdutoServicoEdit" type="text" class="none" name="id_produtoServico">
                                    <input id="st_nomeProdutoServicoEdit" type="text" class="form-control" placeholder="Título :" name="st_nomeProdutoServico"
                                           aria-describedby="basic-addon1" value="{{ old('st_nomeProdutoServico') }}" required>
                                    <div class="colorRed">
                                        {{ $errors->has('st_nomeProdutoServico') ? $errors->first('st_nomeProdutoServico') : '' }}
                                    </div>
                                </div>
                                <div class="my-3">
                                    <input id="st_descricaoEdit" type="text" class="form-control" placeholder="Posição :" name="st_descricao"
                                           aria-describedby="basic-addon1" value="{{ old('st_descricao') }}" required>
                                    <div class="colorRed">
                                        {{ $errors->has('st_descricao') ? $errors->first('st_descricao') : '' }}
                                    </div>
                                </div>

                                <div class="my-3">
                                    <label>Selecione a cor :</label>
                                    <input id="st_colorProdutoServicoEdit" type='color' class="inputColors" name="st_color" value="{{ old('st_color') }}" required>
                                    <div id="email" class="colorRed">
                                        {{ $errors->has('st_color') ? $errors->first('st_color') : '' }}
                                    </div>
                                </div>


                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="BtnBlue my-3">Salvar edição</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <button id="DeletarProdutoBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#DeleteProduto">
                    Delete status
                </button>
            </div>

            <!-- Modal delete -->
            <div class="modal fade" id="DeleteProduto" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h5 class="modal-title colorRedDelete" id="staticBackdropLabel">deletar Produto/serviço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body ">
                            <form method="post" action="{{route('deletarProdutoServicos')}}">
                                @csrf
                                <div class="my-3">
                                    <input id="id_produtoServicoDelete" type="text" class="none" name="id_produtoServico">
                                </div>

                                <div class="colorRedDelete my-3">Deseja excluir mesmo este produto/serviço ? </div>
                                <div class="deleteText" id="st_nomeProdutoServicoDelete"></div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="BtnRed my-3">sim, quero remover</button>
                                </div>
                                <div class="deleteText p-0 m-0">A ação não pode ser desfeita .</div>
                                <div class="deleteText p-0 m-0">Todos dados atrelados serão removidos.</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="NavbarAdmimHoot">
                @include('layouts.navBarAdminUser')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div class="d-flex pt-3 justify-content-between align-items-center">
                    <div class=" colorgray">
                        Produtos/Serviços
                    </div>
                    <button type="button" class=" BtnConfig m-0" data-bs-toggle="modal"
                            data-bs-target="#AdicionarSetor">
                        Adicionar
                    </button>
                </div>

                <div class="mt-5">
                    <div class="d-flex justify-content-between mb-2">
                        <div id="" style="width: 60%" class="textIndices">Produtos</div>
                        <div style="width: 20%;text-align: center;" class="textIndices">
                            Leads atrelado
                        </div>
                        <div id="" style="width: 20%" class="textIndices text-end pe-3">Ações</div>
                    </div>
                    @foreach($produtos as  $produto)
                        <div class="divCabecalho mt-3">
                            <div class="d-flex justify-content-between w-100">
                                <div style="width: 60%" class="d-flex align-items-center">
                                    <div style="background:{{$produto->st_color}}" class="desenho2"></div>
                                    <div class="ps-2 textIndices">
                                        {{$produto->st_nomeProdutoServico}}
                                    </div>
                                </div>
                                <div style="width: 20%;text-align: center;" class="textIndices">
                                    {{$produto->leads->count()}}
                                </div>
                                <div style="width: 20%" class="textIndices2 text-end pe-3">
                                    <a onclick="EditarProduto({{$produto}})" class="linkEdit" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                    <a class="linkDelete ps-2" href="#" onclick="DeleteProduto({{$produto}})">
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
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection




