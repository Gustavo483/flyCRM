<!-- Modal -->
<div class="modal fade" id="EditarLead" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="EditarLead" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('EditarLead', ['id_lead'=> $lead->id_lead])}}">
                    @csrf
                    <div class="my-3">
                        <input type="text" class="form-control" placeholder="Nome:"
                               name="st_nome" aria-describedby="basic-addon1"
                               value="{{ old('st_nome') ? : $lead->st_nome}}" required>
                        <div id="st_nome" class="colorRed">
                            {{ $errors->has('st_nome') ? $errors->first('st_nome') : '' }}
                        </div>
                    </div>
                    <div class="d-flex">

                        <input type="text" class="form-control me-2" placeholder="E-mail:" name="st_email"
                               aria-describedby="basic-addon1" value="{{ old('st_email')?:$lead->st_email}}" required>
                        <div id="st_email" class="colorRed">
                            {{ $errors->has('st_email') ? $errors->first('st_email') : '' }}
                        </div>


                        <input type="text" class="form-control  w-75" placeholder="telefone:"
                               name="int_telefone" aria-describedby="basic-addon1"
                               value="{{ old('int_telefone') ?:$lead->int_telefone }}" required>
                        <div id="int_telefone" class="colorRed">
                            {{ $errors->has('int_telefone') ? $errors->first('int_telefone') : '' }}
                        </div>

                    </div>

                    <div class="d-flex justify-content-between my-2">

                        <select class="form-select me-2" name="id_origem" aria-label="Default select example" required>
                            <option value="">Origem:</option>
                            @foreach($dadosCadastroLeads['origens'] as $origem)
                                <option {{isset($lead->origem->id_origem) && $lead->origem->id_origem === $origem->id_origem ? 'selected':''}} value="{{$origem->id_origem}}">{{$origem->st_nomeOrigem}}</option>
                            @endforeach
                        </select>

                        <select class="form-select me-2" name="id_midia" aria-label="Default select example" required>
                            <option value="">Midia:</option>
                            @foreach($dadosCadastroLeads['midias'] as $midia)
                                <option {{isset($lead->midia->id_midia) && $lead->midia->id_midia === $midia->id_midia ? 'selected':''}} value="{{$midia->id_midia}}">{{$midia->st_nomeMidia}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="id_campanha" aria-label="Default select example" required>
                            <option value="">Campanha:</option>
                            @foreach($dadosCadastroLeads['campanhas'] as $campanha)
                                <option {{isset($lead->campanha->id_campanha) && $lead->campanha->id_campanha === $campanha->id_campanha ? 'selected':''}} value="{{$campanha->id_campanha}}">{{$campanha->st_nomeCampanha}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="d-flex justify-content-between my-2">

                        <select class="form-select me-2" name="id_produtoServico" aria-label="Default select example" required>
                            <option value="">Produto:</option>
                            @foreach($dadosCadastroLeads['Produtos'] as $produtos)
                                <option {{isset($lead->servico->st_nomeProdutoServico) && $lead->servico->id_produtoServico ===$produtos->id_produtoServico ? 'selected':'' }} value="{{$produtos->id_produtoServico}}">{{$produtos->st_nomeProdutoServico}}</option>
                            @endforeach
                        </select>

                        <select class="form-select me-2" name="id_fase" aria-label="Default select example" required>
                            <option value="">fases:</option>
                            @foreach($dadosCadastroLeads['fases'] as $fases)
                                <option {{isset($lead->fase->id_fase) && $lead->fase->id_fase === $fases->id_fase ? 'selected':''}} value="{{$fases->id_fase}}">{{$fases->st_nomeFase}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="int_temperatura" aria-label="Default select example" required>
                            <option value="">Temperatura:</option>
                            <option {{$lead->int_temperatura === 25 ? 'selected':''}} value="25">25%</option>
                            <option {{$lead->int_temperatura === 50? 'selected':''}} value="50">50%</option>
                            <option {{$lead->int_temperatura === 75 ? 'selected':''}} value="75">75%</option>
                            <option {{$lead->int_temperatura === 100? 'selected':''}} value="100">100%</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between my-2">

                        <select class="form-select me-2" name="id_grupo" aria-label="Default select example" required>
                            <option value="">Grupos:</option>
                            @foreach($dadosCadastroLeads['grupos'] as $grupo)
                                <option {{isset($lead->grupo->id_grupo) && $lead->grupo->id_grupo === $grupo->id_grupo ? 'selected':''}}  value="{{$grupo->id_grupo}}">{{$grupo->st_nomeGrupo}}</option>
                            @endforeach
                        </select>

                        <select class="form-select " name="id_columnsKhanban" aria-label="Default select example" required>
                            <option value="">status:</option>
                            @foreach($dadosCadastroLeads['status'] as $status)
                                <option {{isset($lead->status->st_titulo) && $lead->status->id_columnsKhanban === $status->id_columnsKhanban ? 'selected':''}} value="{{$status->id_columnsKhanban}}">{{$status->st_titulo}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="my-4">
                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Deixe sua observação aqui"
                                                      name="st_observacoes" id=""
                                                      style="height: 100px">{{ $lead->st_observacoes }}</textarea>
                            <label for="floatingTextarea2">Descrição/Observações</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="BtnBlue my-3">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
