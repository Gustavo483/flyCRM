@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

@section('content')
    <div class="text-center my-4">
        @include('layouts.navBar')
    </div>
    <div>teste de componente</div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Adicionar Empresa
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastro de empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form method="post" action="{{route('registerEmpresa')}}">
                        @csrf
                        <div class="my-3">
                            <input type="text" class="form-control" placeholder="Empresa:" name="st_nomeEmpresa" aria-describedby="basic-addon1" value="{{ old('st_nomeEmpresa') }}" required>
                            <div id="st_nomeEmpresa" class="colorRed">
                                {{ $errors->has('st_nomeEmpresa') ? $errors->first('st_nomeEmpresa') : '' }}
                            </div>
                        </div>
                        <div class="my-3">
                            <input type="text" class="form-control" placeholder="Documento:" name="st_DocResponsavel" aria-describedby="basic-addon1" value="{{ old('st_DocResponsavel') }}"  required>
                            <div id="st_DocResponsavel" class="colorRed">
                                {{ $errors->has('st_DocResponsavel') ? $errors->first('st_DocResponsavel') : '' }}
                            </div>
                        </div>
                        <div class="my-3">
                            <input type="text" class="form-control" placeholder="Responsável:" name="name" aria-describedby="basic-addon1" value="{{ old('name') }}"  required>
                            <div id="name" class="colorRed">
                                {{ $errors->has('name') ? $errors->first('name') : '' }}
                            </div>
                        </div>
                        <div class="my-3">
                            <input type="text" class="form-control" placeholder="Telefone:" name="st_telefone" aria-describedby="basic-addon1" value="{{ old('st_telefone') }}"  required>
                            <div id="st_telefone" class="colorRed">
                                {{ $errors->has('st_telefone') ? $errors->first('st_telefone') : '' }}
                            </div>
                        </div>
                        <div class="my-3">
                            <input type="text" class="form-control" placeholder="E-mail:" name="email" aria-describedby="basic-addon1" value="{{ old('email') }}"  required>
                            <div id="email" class="colorRed">
                                {{ $errors->has('email') ? $errors->first('email') : '' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between my-3">
                            <div>
                                <select class="form-select" name="id_plano" aria-label="Default select example" required>
                                    <option selected>plano</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div>
                                <select class="form-select" name="st_periodicidade" aria-label="Default select example" required>
                                    <option selected>Periodicidade</option>
                                    <option value="Periodicidade 1">1</option>
                                    <option value="Periodicidade 2">2</option>
                                    <option value="Periodicidade 3">3</option>
                                </select>
                            </div>
                            <div>
                                <select class="form-select" name="dt_validade" aria-label="Default select example" required>
                                    <option selected>Validade</option>
                                    <option value="1">1 ano</option>
                                    <option value="2">2 anos</option>
                                    <option value="3">3 anos</option>
                                </select>
                            </div>
                        </div>

                        <div class="my-4">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Deixe sua observação aqui" name="st_descricao" value="{{ old('st_descricao') }}"  id="" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Descrição/Observações</label>
                            </div>
                        </div>

                        <div class="my-2">
                            <input type="password" class="form-control" placeholder="password :" name="password" aria-describedby="basic-addon1" value="{{ old('password') }}"  required>
                            <div id="password" class="colorRed">
                                {{ $errors->has('password') ? $errors->first('password') : '' }}
                            </div>
                        </div>

                        <div class="my-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">Ativo:</div>
                                <select class="form-select" aria-label="Default select example" required name="bl_ativo">
                                    <option value="1">sim</option>
                                    <option value="0">não</option>
                                </select>
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
@endsection


