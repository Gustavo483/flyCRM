
<div class="d-flex justify-content-end my-3">
    <button id="DeletarStatusBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#DeleteStatus">
        Delete status
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="DeleteStatus" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorRedDelete" id="staticBackdropLabel">Delete status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('deletarStatus')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_statusDelete" type="text" class="none" name="id_columnsKhanban">
                    </div>

                    <div class="colorRedDelete my-3">Deseja excluir mesmo este status do Kanban ? </div>
                    <div class="deleteText" id="StTituloDelete"></div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="BtnRed my-3">sim, quero remover</button>
                    </div>
                    <div class="deleteText p-0 m-0">A ação não pode ser desfeita .</div>
                    <div class="deleteText p-0 m-0">Todos dados atrelados serão removidos.</div>
                </form>
            </div>
        </div>
    </div>
</div>
