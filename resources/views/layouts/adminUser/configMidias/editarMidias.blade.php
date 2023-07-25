
<div class="d-flex justify-content-end">
    <button id="EditarMidiaBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarMidia">
        Editar usuario
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="EditarMidia" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar midia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('editarMidia')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_midiaEdit" type="text" class="none" name="id_midia">
                        <input id="st_nomeMidiaEdit" type="text" class="form-control" placeholder="Mídia:" name="st_nomeMidia"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeMidia') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeMidia') ? $errors->first('st_nomeMidia') : '' }}
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
