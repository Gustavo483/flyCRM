<!-- Modal -->
<div class="modal fade" id="AdicionarUsuario" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastrar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{route('registrarUsuario')}}">
                    @csrf
                    <div class="my-3">
                        <input type="text" class="form-control" placeholder="nome:" name="name"
                               aria-describedby="basic-addon1" value="{{ old('name') }}" required>
                        <div id="name" class="colorRed">
                            {{ $errors->has('name') ? $errors->first('name') : '' }}
                        </div>
                    </div>

                    <div class="my-3">
                        <input type="text" class="form-control" placeholder="E-mail:" name="email"
                               aria-describedby="basic-addon1" value="{{ old('email') }}" required>
                        <div id="email" class="colorRed">
                            {{ $errors->has('email') ? $errors->first('email') : '' }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="my-2">
                            <input type="password" class="form-control" placeholder="password :"
                                   name="password" aria-describedby="basic-addon1"
                                   value="{{ old('password') }}" required>
                            <div id="password" class="colorRed">
                                {{ $errors->has('password') ? $errors->first('password') : '' }}
                            </div>
                        </div>

                        <div class="my-2">
                            <input type="text" class="form-control" placeholder="setor:"
                                   name="st_setor" aria-describedby="basic-addon1"
                                   value="{{ old('st_setor') }}" required>
                            <div id="password" class="colorRed">
                                {{ $errors->has('st_setor') ? $errors->first('st_setor') : '' }}
                            </div>
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
