
<div class="d-flex justify-content-end">
    <button id="EditarGrupoBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarGrupo">
        Editar usuario
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="EditarGrupo" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('editarGrupo')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_GrupoEdit" type="text" class="none" name="id_grupo">
                        <input id="st_nomeGrupoEdit" type="text" class="form-control" placeholder="Grupo:" name="st_nomeGrupo"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeGrupo') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeGrupo') ? $errors->first('st_nomeGrupo') : '' }}
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
