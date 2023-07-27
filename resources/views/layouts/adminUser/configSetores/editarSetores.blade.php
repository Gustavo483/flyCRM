
<div class="d-flex justify-content-end">
    <button id="EditarSetorBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarSetor">
        Editar Setor
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="EditarSetor" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar Setor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('editarSetor')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_setorEdit" type="text" class="none" name="id_setor">
                        <input id="st_nomeSetorEdit" type="text" class="form-control" placeholder="Setor:" name="st_nomeSetor"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeSetor') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeSetor') ? $errors->first('st_nomeSetor') : '' }}
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
