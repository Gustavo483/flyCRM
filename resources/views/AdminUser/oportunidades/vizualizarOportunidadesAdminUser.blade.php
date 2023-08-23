@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarAdminUser')
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div class=" colorgray">
                    Oportunidades
                </div>
                <div class="d-flex justify-content-between py-4">
                    <div class="AdminInfo1">
                        <div class="textInfo">
                            <h5> {{$dadosInfo['leads']}} leads</h5>
                        </div>
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#142ba1" viewBox="0 0 640 512">
                                <path
                                    d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="AdminInfo2">
                        <div class="textInfo">
                            <h5>{{$dadosInfo['leadsHoje']}} oportunidades para hoje</h5>
                        </div>
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#25a7a6" viewBox="0 0 512 512">
                                <path
                                    d="M256 48C141.1 48 48 141.1 48 256v40c0 13.3-10.7 24-24 24s-24-10.7-24-24V256C0 114.6 114.6 0 256 0S512 114.6 512 256V400.1c0 48.6-39.4 88-88.1 88L313.6 488c-8.3 14.3-23.8 24-41.6 24H240c-26.5 0-48-21.5-48-48s21.5-48 48-48h32c17.8 0 33.3 9.7 41.6 24l110.4 .1c22.1 0 40-17.9 40-40V256c0-114.9-93.1-208-208-208zM144 208h16c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H144c-35.3 0-64-28.7-64-64V272c0-35.3 28.7-64 64-64zm224 0c35.3 0 64 28.7 64 64v48c0 35.3-28.7 64-64 64H352c-17.7 0-32-14.3-32-32V240c0-17.7 14.3-32 32-32h16z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="AdminInfo3">
                        <div class="textInfo">
                            <h5>{{$dadosInfo['totalOportunidades'] + $dadosInfo['leadsHoje']}} Oportunidades ao total </h5>
                        </div>
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="#7ba9a8" viewBox="0 0 576 512"><path d="M148 76.6C148 34.3 182.3 0 224.6 0c20.3 0 39.8 8.1 54.1 22.4l9.3 9.3 9.3-9.3C311.6 8.1 331.1 0 351.4 0C393.7 0 428 34.3 428 76.6c0 20.3-8.1 39.8-22.4 54.1L302.1 234.1c-7.8 7.8-20.5 7.8-28.3 0L170.4 130.7C156.1 116.4 148 96.9 148 76.6zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Modal editar status oportunidade -->
                <div class="modal fade" id="editarStatusOportunidade" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="editarStatusOportunidade" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <h5 class="modal-title colorTitle" id="staticBackdropLabel">Alterar status oportunidade</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route('editarStatusOportunidadeAdmin')}}">
                                    @csrf
                                    <div class="d-flex justify-content-between my-2">
                                        <input id="idObservacaoStatusOportunidade" class="none" name="id_observacao">
                                        <select id="selectStatusOportunidade" class="form-select" name="bl_statusOportunidade" aria-label="Default select example" required>
                                            <option id="selectStatusOportunidade0" value="0">Agendado contato</option>
                                            <option id="selectStatusOportunidade1" value="1">sucesso no contato</option>
                                            <option id="selectStatusOportunidade2" value="2">Sem sucesso no contato</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="BtnBlue my-3">Salvar alterações</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    @foreach($oportunidades['oportunidadesHoje']->sortByDesc('dt_contato') as $observacao)
                        <div onclick="abrirLead({{$observacao->lead->id_lead}})" class="DivOportunidade d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p>{{$observacao->st_titulo}}</p>
                                <p class="colorBlack">{{$observacao->st_descricao}}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="pe-5 tamanha33">
                                    <div class="colorBlack">
                                        {{isset($observacao->lead) ? $observacao->lead->st_nome : ''}}
                                    </div>
                                    <div class="colorBlack">
                                        {{isset($observacao->lead->produto) ? $observacao->lead->produto->st_nomeProdutoServico : ''}}
                                    </div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" class="ms-3" fill="#3956ea" viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg>
                            </div>
                            <a class="none" id="Lead{{$observacao->lead->id_lead}}" href="{{route('vizualizarLeadAdminUser', ['id_lead'=>$observacao->lead->id_lead])}}"></a>
                        </div>
                    @endforeach
                    @foreach($oportunidades['oportunidadesOutroDia']->sortBy('dt_contato') as $observacao)
                        <div onclick="abrirLead({{$observacao->lead->id_lead}})" class="DivOportunidade d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p>{{$observacao->st_titulo}}</p>
                                <p class="colorBlack">{{$observacao->st_descricao}}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="pe-5 tamanha33">
                                    <div class="colorBlack">
                                        {{isset($observacao->lead) ? $observacao->lead->st_nome : ''}}
                                    </div>
                                    <div class="colorBlack">
                                        {{isset($observacao->lead->produto) ? $observacao->lead->produto->st_nomeProdutoServico : ''}}
                                    </div>
                                </div>
                                <button onclick="editarStatusOportunidade({{$observacao->bl_statusOportunidade}}, {{$observacao->id_observacao}})" type="button" class="BtnEditarLeads p-0 m-0" data-bs-toggle="modal" data-bs-target="#editarStatusOportunidade">
                                    @if($observacao->bl_statusOportunidade == 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" class="ms-3" fill="#3956ea" viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg>
                                    @endif
                                    @if($observacao->bl_statusOportunidade == 1)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                        </svg>
                                    @endif
                                    @if($observacao->bl_statusOportunidade == 2)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-hand-thumbs-down-fill" viewBox="0 0 16 16">
                                            <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                                        </svg>
                                    @endif
                                </button>
                            </div>
                            <a class="none" id="Lead{{$observacao->lead->id_lead}}" href="{{route('vizualizarLeadAdminUser', ['id_lead'=>$observacao->lead->id_lead])}}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


