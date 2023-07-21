@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarAdminRoot')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div class="d-flex justify-content-between py-3">
                    <div class="AdminInfo1">
                        <div class="textInfo">
                            <h5> {{$dadosInfo['empresas']}} empresas ativas</h5>
                        </div>
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#142ba1"
                                 class="bi bi-building" viewBox="0 0 16 16">
                                <path
                                    d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
                                <path
                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="AdminInfo2">
                        <div class="textInfo">
                            <h5>{{$dadosInfo['leads']}} leads totais</h5>
                        </div>
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#25a7a6"
                                 class="bi bi-person-heart" viewBox="0 0 16 16">
                                <path
                                    d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="AdminInfo3">
                        <div class="textInfo">
                            <h5>{{$dadosInfo['suporte']}} chamada de suporte </h5>
                        </div>
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#7ba9a8"
                                 class="bi bi-headset" viewBox="0 0 16 16">
                                <path
                                    d="M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="BtnCriarEmpresa" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#7ba9a8"
                             class="bi bi-buildings" viewBox="0 0 16 16">
                            <path
                                d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022ZM6 8.694 1 10.36V15h5V8.694ZM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15Z"/>
                            <path
                                d="M2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-2 2h1v1H2v-1Zm2 0h1v1H4v-1Zm4-4h1v1H8V9Zm2 0h1v1h-1V9Zm-2 2h1v1H8v-1Zm2 0h1v1h-1v-1Zm2-2h1v1h-1V9Zm0 2h1v1h-1v-1ZM8 7h1v1H8V7Zm2 0h1v1h-1V7Zm2 0h1v1h-1V7ZM8 5h1v1H8V5Zm2 0h1v1h-1V5Zm2 0h1v1h-1V5Zm0-2h1v1h-1V3Z"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Cadastro de empresa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body ">
                                <form method="post" action="{{route('registerEmpresa')}}">
                                    @csrf
                                    <div class="my-3">
                                        <input type="text" class="form-control" placeholder="Empresa:"
                                               name="st_nomeEmpresa" aria-describedby="basic-addon1"
                                               value="{{ old('st_nomeEmpresa') }}" required>
                                        <div id="st_nomeEmpresa" class="colorRed">
                                            {{ $errors->has('st_nomeEmpresa') ? $errors->first('st_nomeEmpresa') : '' }}
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <input type="text" class="form-control" placeholder="Documento:"
                                               name="st_DocResponsavel" aria-describedby="basic-addon1"
                                               value="{{ old('st_DocResponsavel') }}" required>
                                        <div id="st_DocResponsavel" class="colorRed">
                                            {{ $errors->has('st_DocResponsavel') ? $errors->first('st_DocResponsavel') : '' }}
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <input type="text" class="form-control" placeholder="Responsável:" name="name"
                                               aria-describedby="basic-addon1" value="{{ old('name') }}" required>
                                        <div id="name" class="colorRed">
                                            {{ $errors->has('name') ? $errors->first('name') : '' }}
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <input type="text" class="form-control" placeholder="Telefone:"
                                               name="st_telefone" aria-describedby="basic-addon1"
                                               value="{{ old('st_telefone') }}" required>
                                        <div id="st_telefone" class="colorRed">
                                            {{ $errors->has('st_telefone') ? $errors->first('st_telefone') : '' }}
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <input type="text" class="form-control" placeholder="E-mail:" name="email"
                                               aria-describedby="basic-addon1" value="{{ old('email') }}" required>
                                        <div id="email" class="colorRed">
                                            {{ $errors->has('email') ? $errors->first('email') : '' }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between my-3">
                                        <div>
                                            <select class="form-select" name="id_plano"
                                                    aria-label="Default select example" required>
                                                <option selected>plano</option>
                                                <option value="1">plano 1</option>
                                                <option value="2">plano 2</option>
                                                <option value="3">plano 3</option>
                                            </select>
                                        </div>
                                        <div>
                                            <select class="form-select" name="st_periodicidade"
                                                    aria-label="Default select example" required>
                                                <option selected>Periodicidade</option>
                                                <option value="mensal">mensal</option>
                                                <option value="bimestral">bimestral</option>
                                                <option value="trimestral">trimestral</option>
                                                <option value="semestral">semestral</option>
                                                <option value="anual">anual</option>
                                            </select>
                                        </div>
                                        <div>
                                            <select class="form-select" name="dt_validade"
                                                    aria-label="Default select example" required>
                                                <option selected>Validade</option>
                                                <option value="1">1 ano</option>
                                                <option value="2">2 anos</option>
                                                <option value="3">3 anos</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="my-4">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Deixe sua observação aqui"
                                                      name="st_descricao" id=""
                                                      style="height: 100px"></textarea>
                                            <label for="floatingTextarea2">Descrição/Observações</label>
                                        </div>
                                    </div>

                                    <div class="my-2">
                                        <input type="password" class="form-control" placeholder="password :"
                                               name="password" aria-describedby="basic-addon1"
                                               value="{{ old('password') }}" required>
                                        <div id="password" class="colorRed">
                                            {{ $errors->has('password') ? $errors->first('password') : '' }}
                                        </div>
                                    </div>

                                    <div class="my-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">Ativo:</div>
                                            <select class="form-select" aria-label="Default select example" required
                                                    name="bl_ativo">
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
                <div>
                    <h1 class="text-center py-3">Fazer o filtro</h1>
                </div>
                <div class="divEmpresas">
                    @foreach($usersEmpresas as $usersEmpresa)
                        <div onclick="vizualizarEmpresa({{$usersEmpresa->empresa->id_empresa}})" class="divEmpresas2 my-2 d-flex">
                            <div class="d-flex justify-content-between tamanho60">
                                <div class="textBlue d-flex align-items-center w-25">{{$usersEmpresa->name}}</div>
                                <div class="textGray d-flex align-items-center w-50">{{$usersEmpresa->empresa->st_nomeEmpresa}}</div>
                                <div class="textGray d-flex align-items-center justify-content-start w-25">{{$usersEmpresa->empresa->st_telefone}}</div>
                            </div>
                            <div class="d-flex justify-content-between tamanho60">
                                <div class="textBlue d-flex align-items-center w-25">Plano Pro</div>
                                <div class="d-flex  align-items-center w-25">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#b9b9b9" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                                        <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    </svg>
                                    <div class="textGray3 d-flex align-items-center ps-3" >{{$usersEmpresa->empresa->st_periodicidade}}</div>
                                </div>
                                <div class="textBlue  d-flex align-items-center justify-content-center w-25">{{$usersEmpresa->empresa->bl_ativo ? 'Ativo' : 'Inativo'}}</div>
                                <div class="textGray3  d-flex align-items-center justify-content-end w-25">{{$usersEmpresa->dt_ultimoLogin}}</div>
                            </div>
                        </div>
                        <a id="{{$usersEmpresa->empresa->id_empresa}}" class="none" href="{{route('vizualizarEmpresa',['id_empresa'=>$usersEmpresa->empresa->id_empresa])}}"></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection




