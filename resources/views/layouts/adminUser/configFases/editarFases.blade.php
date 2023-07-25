
<div class="d-flex justify-content-end">
    <button id="EditarFaseBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarFase">
        Editar fase
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="EditarFase" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar Fase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('editarFase')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_faseEdit" type="text" class="none" name="id_fase">
                        <input id="st_nomeFaseEdit" type="text" class="form-control" placeholder="Fase:" name="st_nomeFase"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeFase') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeFase') ? $errors->first('st_nomeFase') : '' }}
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
