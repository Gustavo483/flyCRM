<!-- Modal Campanhas -->
<div class="modal fade" id="AdicionarCampanha" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastrar Campanhas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('registrarCampanha')}}">
                    @csrf
                    <div class="my-3">
                        <input type="text" class="form-control" placeholder="Campanha:" name="st_nomeCampanha"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeCampanha') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeCampanha') ? $errors->first('st_nomeCampanha') : '' }}
                        </div>

                        <div class="my-4">
                            <div class="form-floating">
                                            <textarea class="form-control" placeholder="Descrição da campanha:"
                                                      name="st_descricao" id=""
                                                      style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Descrição/Observações</label>
                            </div>
                        </div>

                        <select class="form-select" name="bl_campanhaAtiva" aria-label="Default select example" required>
                            <option value="">Status campanha:</option>
                            <option value="1">Ativa</option>
                            <option  value="0">Inativa</option>
                        </select>

                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="BtnBlue my-3">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
