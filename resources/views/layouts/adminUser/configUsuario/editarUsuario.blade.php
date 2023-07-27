
<div class="d-flex justify-content-end my-3">
    <button id="EditarUsuarioBtn" type="button" class=" BtnConfig none" data-bs-toggle="modal" data-bs-target="#EditarUsuario">
        Editar usuario
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="EditarUsuario" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('editarUsuario')}}">
                    @csrf
                    <div class="my-3">
                        <input id="id_user" type="text" class="none" name="id" >
                        <input id="nameEdit" type="text" class="form-control" placeholder="nome:" name="name"
                               aria-describedby="basic-addon1" required>
                        <div id="name" class="colorRed">
                            {{ $errors->has('name') ? $errors->first('name') : '' }}
                        </div>
                    </div>

                    <div class="my-3">
                        <input id="emailEdit" type="text" class="form-control" placeholder="E-mail:" name="email"
                               aria-describedby="basic-addon1" value="{{ old('email') }}" required>
                        <div id="email" class="colorRed">
                            {{ $errors->has('email') ? $errors->first('email') : '' }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="my-2">
                            <input type="password" class="form-control" placeholder="password :"
                                   name="password" aria-describedby="basic-addon1"
                                   value="{{ old('password') }}">
                            <div id="password" class="colorRed">
                                {{ $errors->has('password') ? $errors->first('password') : '' }}
                            </div>
                        </div>

                        <div class="my-2">
                            <select class="form-control"  name="id_setor">
                                @foreach($dados['setores'] as $setor)
                                    <option id="SetoreUsuario{{$setor->id_setor}}" value="{{$setor->id_setor}}">{{$setor->st_nomeSetor}}</option>
                                @endforeach
                            </select>
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
