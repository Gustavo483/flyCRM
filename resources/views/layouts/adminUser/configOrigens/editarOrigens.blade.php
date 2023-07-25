
<div class="d-flex justify-content-end">
    <button id="EditarOrigemBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarOrigem">
        Editar Origem
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="EditarOrigem" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar Origem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('editarOrigem')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_origemEdit" type="text" class="none" name="id_origem">
                        <input id="st_nomeOrigemEdit" type="text" class="form-control" placeholder="Origem:" name="st_nomeOrigem"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeOrigem') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeOrigem') ? $errors->first('st_nomeOrigem') : '' }}
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
