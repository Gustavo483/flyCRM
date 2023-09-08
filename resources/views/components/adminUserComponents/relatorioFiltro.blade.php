<!-- Modal -->
<div class="modal fade treste123123" id="relatorioFiltro" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="relatorioFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Filtro avançado para busca de lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('relatorioEmpresa')}}">
                    @csrf
                    <label style="color: black">Pesquisar por periodio:</label>
                    <div class="d-flex">
                        <input value="{{$dadosForm['dt_inicio'] ? : '' }}" class="form-select me-2" type="date" name="dt_inicio">
                        <input value="{{$dadosForm['dt_final'] ? : '' }}" class="form-select me-2" type="date" name="dt_final">
                    </div>
                    <div class="my-3">
                        <input type="text" class="form-control" placeholder="Nome:"
                               name="st_nome" aria-describedby="basic-addon1"
                               value="{{$dadosForm['st_nome'] ? : '' }}">
                    </div>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" placeholder="E-mail:" name="st_email"
                               aria-describedby="basic-addon1" value="{{$dadosForm['st_email'] ? : '' }}">
                        <input type="text" class="form-control celular  w-75" placeholder="Telefone:"
                               name="int_telefone" aria-describedby="basic-addon1"
                               value="{{$dadosForm['int_telefone'] ? : '' }}">
                    </div>

                    <div class="d-flex justify-content-between my-2">
                        <select class="form-select me-2" name="id_origem" aria-label="Default select example"  >
                            <option value="">Origem:</option>
                            @foreach($dadosCadastroLeads['origens'] as $origem)
                                <option {{$dadosForm['id_origem'] == $origem->id_origem ? 'selected' : '' }} value="{{$origem->id_origem}}">{{$origem->st_nomeOrigem}}</option>
                            @endforeach
                        </select>

                        <select class="form-select me-2" name="id_midia" aria-label="Default select example"  >
                            <option value="">Midia:</option>
                            @foreach($dadosCadastroLeads['midias'] as $midia)
                                <option {{$dadosForm['id_midia'] == $midia->id_midia ? 'selected' : '' }} value="{{$midia->id_midia}}">{{$midia->st_nomeMidia}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="id_campanha" aria-label="Default select example"  >
                            <option value="">Campanha:</option>
                            @foreach($dadosCadastroLeads['campanhas'] as $campanha)
                                <option {{$dadosForm['id_campanha'] == $campanha->id_campanha ? 'selected' : '' }} value="{{$campanha->id_campanha}}">{{$campanha->st_nomeCampanha}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="d-flex justify-content-between my-2">
                        <select class="form-select me-2" name="id_produtoServico" aria-label="Default select example"  >
                            <option value="">Produto:</option>
                            @foreach($dadosCadastroLeads['Produtos'] as $produtos)
                                <option {{$dadosForm['id_produtoServico'] == $produtos->id_produtoServico ? 'selected' : '' }} value="{{$produtos->id_produtoServico}}">{{$produtos->st_nomeProdutoServico}}</option>
                            @endforeach
                        </select>

                        <select class="form-select me-2" name="id_fase" aria-label="Default select example">
                            <option value="">fases:</option>
                            @foreach($dadosCadastroLeads['fases'] as $fases)
                                <option {{$dadosForm['id_fase'] == $fases->id_fase ? 'selected' : '' }} value="{{$fases->id_fase}}">{{$fases->st_nomeFase}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="int_temperatura" aria-label="Default select example"  >
                            <option value="">Temperatura:</option>
                            <option {{$dadosForm['int_temperatura'] == '0' ? 'selected' : '' }} value="0">0%</option>
                            <option {{$dadosForm['int_temperatura'] == '25' ? 'selected' : '' }} value="25">25%</option>
                            <option {{$dadosForm['int_temperatura'] == '50' ? 'selected' : '' }} value="50">50%</option>
                            <option {{$dadosForm['int_temperatura'] == '75' ? 'selected' : '' }} value="75">75%</option>
                            <option {{$dadosForm['int_temperatura'] == '100' ? 'selected' : '' }} value="100">100%</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between my-2">

                        <select class="form-select me-2" name="id_grupo" aria-label="Default select example"  >
                            <option value="">Grupos:</option>
                            @foreach($dadosCadastroLeads['grupos'] as $grupo)
                                <option {{$dadosForm['id_grupo'] == $grupo->id_grupo ? 'selected' : '' }} value="{{$grupo->id_grupo}}">{{$grupo->st_nomeGrupo}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="id_columnsKhanban" aria-label="Default select example" >
                            <option value="">status:</option>
                            @foreach($dadosCadastroLeads['status'] as $status)
                                <option {{$dadosForm['id_columnsKhanban'] == $status->id_columnsKhanban ? 'selected' : '' }} value="{{$status->id_columnsKhanban}}">{{$status->st_titulo}}</option>
                            @endforeach
                        </select>
                        <select class="form-select " name="id_userResponsavel" aria-label="Default select example"  >
                            <option value="">Responsável:</option>
                            @foreach($dadosCadastroLeads['id_userResponsavel'] as $responsavel)
                                <option {{$dadosForm['id_userResponsavel'] == $responsavel->id ? 'selected' : '' }} value="{{$responsavel->id}}">{{$responsavel->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <p>Campos relatório :</p>
                    <div class="d-flex">
                        <label class="container">Nome lead
                            <input name="colunas[]"  value="st_nome" type="checkbox" {{in_array('st_nome', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">E-mail
                            <input name="colunas[]"  value="st_email" type="checkbox" {{in_array('st_email', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">Telefone
                            <input name="colunas[]"  value="int_telefone" type="checkbox" {{in_array('int_telefone', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">Fase
                            <input name="colunas[]" value="id_fase" type="checkbox" {{in_array('id_fase', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">Status
                            <input name="colunas[]" value="id_columnsKhanban" type="checkbox" {{in_array('id_columnsKhanban', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">Prod/Serv
                            <input name="colunas[]" value="id_produtoServico" type="checkbox" {{in_array('id_produtoServico', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="d-flex">
                        <label class="container">Campanha
                            <input name="colunas[]" value="id_campanha" type="checkbox" {{in_array('id_campanha', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">Origem
                            <input name="colunas[]" value="id_origem" type="checkbox" {{in_array('id_origem', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">Midia
                            <input name="colunas[]" value="id_midia" type="checkbox" {{in_array('id_midia', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">grupo
                            <input name="colunas[]" value="id_grupo" type="checkbox" {{in_array('id_grupo', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                        <label class="container">Temperatura
                            <input name="colunas[]" value="int_temperatura" type="checkbox" {{in_array('int_temperatura', $colunas) ? 'checked' :''}}>
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="BtnBlue my-3">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
