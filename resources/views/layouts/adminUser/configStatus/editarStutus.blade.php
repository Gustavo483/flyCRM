
<div class="d-flex justify-content-end">
    <button id="EditarStatusBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarStatus">
        Editar status (Kanban)
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="EditarStatus" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar status (Kanban)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('editarStatus')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_statusEdit" type="text" class="none" name="id_columnsKhanban">
                        <input id="st_nomeStatusEdit" type="text" class="form-control" placeholder="Título :" name="st_titulo"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeStatus') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeStatus') ? $errors->first('st_nomeStatus') : '' }}
                        </div>
                    </div>
                    <div class="my-3">
                        <input id="int_posicaoStatusEdit" type="text" class="form-control" placeholder="Posição :" name="int_posicao"
                               aria-describedby="basic-addon1" value="{{ old('int_posicao') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('int_posicao') ? $errors->first('int_posicao') : '' }}
                        </div>
                    </div>

                    <div class="my-3">
                        <label>Selecione a cor do card do Kanban:</label>
                        <input id="st_colorStatusEdit" type='color' class="inputColors" name="st_color" value="{{ old('st_color') }}" required>
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
