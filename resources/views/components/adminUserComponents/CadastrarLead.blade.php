<!-- Modal -->
<div class="modal fade treste123123" id="CadastrarLead" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="CadastrarLead" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastro leads</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('registrarLeadsAdmin')}}">
                    @csrf
                    <div class="my-3">
                        <input type="text" class="form-control" placeholder="Nome:"
                               name="st_nome" aria-describedby="basic-addon1"
                               value="{{ old('st_nome') }}">
                        <div id="st_nome" class="colorRed">
                            {{ $errors->has('st_nome') ? $errors->first('st_nome') : '' }}
                        </div>
                    </div>
                    <div class="d-flex">

                        <input type="email" class="form-control me-2" placeholder="E-mail:" name="st_email"
                               aria-describedby="basic-addon1" value="{{ old('st_email') }}">
                        <div id="st_email" class="colorRed">
                            {{ $errors->has('st_email') ? $errors->first('st_email') : '' }}
                        </div>


                        <input  type="text" class="form-control celular  w-75" placeholder="Telefone:"
                               name="int_telefone" aria-describedby="basic-addon1"
                               value="{{ old('int_telefone') }}">
                        <div id="int_telefone" class="colorRed">
                            {{ $errors->has('int_telefone') ? $errors->first('int_telefone') : '' }}
                        </div>

                    </div>

                    <div class="d-flex justify-content-between my-2">

                        <select class="form-select me-2" name="id_origem" aria-label="Default select example">
                            <option value="">Origem:</option>
                            @foreach($dadosCadastroLeads['origens'] as $origem)
                                <option value="{{$origem->id_origem}}">{{$origem->st_nomeOrigem}}</option>
                            @endforeach
                        </select>

                        <select class="form-select me-2" name="id_midia" aria-label="Default select example">
                            <option value="">Midia:</option>
                            @foreach($dadosCadastroLeads['midias'] as $midia)
                                <option value="{{$midia->id_midia}}">{{$midia->st_nomeMidia}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="id_campanha" aria-label="Default select example" >
                            <option value="">Campanha:</option>
                            @foreach($dadosCadastroLeads['campanhas'] as $campanha)
                                <option value="{{$campanha->id_campanha}}">{{$campanha->st_nomeCampanha}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="d-flex justify-content-between my-2">
                        <select class="form-select me-2" name="id_produtoServico" aria-label="Default select example">
                            <option value="">Produto:</option>
                            @foreach($dadosCadastroLeads['Produtos'] as $produtos)
                                <option value="{{$produtos->id_produtoServico}}">{{$produtos->st_nomeProdutoServico}}</option>
                            @endforeach
                        </select>
                        <select class="form-select me-2" name="id_fase" aria-label="Default select example">
                            <option value="">fases:</option>
                            @foreach($dadosCadastroLeads['fases'] as $fases)
                                <option value="{{$fases->id_fase}}">{{$fases->st_nomeFase}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="int_temperatura" aria-label="Default select example">
                            <option value="">Temperatura:</option>
                            <option value="0">0%</option>
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            <option value="100">100%</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between my-2">

                        <select class="form-select me-2" name="id_grupo" aria-label="Default select example" >
                            <option value="">Grupos:</option>
                            @foreach($dadosCadastroLeads['grupos'] as $grupo)
                                <option value="{{$grupo->id_grupo}}">{{$grupo->st_nomeGrupo}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="id_columnsKhanban" aria-label="Default select example">
                            <option value="">status:</option>
                            @foreach($dadosCadastroLeads['status'] as $status)
                                <option value="{{$status->id_columnsKhanban}}">{{$status->st_titulo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>Responsáveis:</label>
                    <div class="">
                        @foreach($dadosCadastroLeads['id_userResponsavel'] as $responsavel)
                            <label class="container">{{$responsavel->name}}
                                <input name="responsaveis[]" value="{{$responsavel->id}}" type="checkbox" checked>
                                <span class="checkmark"></span>
                            </label>
                        @endforeach
                    </div>

                    <div class="my-4">
                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Deixe sua observação aqui:"
                                                      name="st_observacoes" id=""
                                                      style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Descrição/Observações</label>
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
