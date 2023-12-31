<!-- Modal Mídias -->
<div class="modal fade" id="AdicionarMidia" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastrar Midias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('registrarMidia')}}">
                    @csrf
                    <div class="my-3">
                        <input type="text" class="form-control" placeholder="Mídia:" name="st_nomeMidia"
                               aria-describedby="basic-addon1" value="{{ old('st_nomeMidia') }}" required>
                        <div class="colorRed">
                            {{ $errors->has('st_nomeMidia') ? $errors->first('st_nomeMidia') : '' }}
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
