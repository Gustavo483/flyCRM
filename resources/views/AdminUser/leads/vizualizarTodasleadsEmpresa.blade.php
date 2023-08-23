@extends('components.basicComponent')

@section('titulo', 'Leads')

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
                    Todos os leads
                </div>
                @include('components.adminUserComponents.infos')
                <div>
                    @include('components.adminUserComponents.CadastrarLead')
                </div>
                <div>
                    @include('components.adminUserComponents.FiltrarLeads')
                </div>

                <div class="d-flex justify-content-between aling-items-center mt-5">
                    <div class="divFiltro">
                        <form method="post" action="{{route('filtrarLeadsAdmin')}}">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <div class=" d-flex tamanhoDivSearch">
                                    <input value="{{$dadosForm['dt_inicio'] ? : '' }}" class="form-select me-2" type="date" name="dt_inicio">
                                    <input value="{{$dadosForm['dt_final'] ? : '' }}" class="form-select me-2" type="date" name="dt_final">

                                    <select class="form-select me-2" name="id_fase" aria-label="Default select example">
                                        <option value="">fases:</option>
                                        @foreach($dadosCadastroLeads['fases'] as $fases)
                                            <option {{$dadosForm['id_fase'] == $fases->id_fase ? 'selected' : '' }} value="{{$fases->id_fase}}">{{$fases->st_nomeFase}}</option>
                                        @endforeach
                                    </select>

                                    <select class="form-select " name="id_columnsKhanban" aria-label="Default select example" >
                                        <option value="">status:</option>
                                        @foreach($dadosCadastroLeads['status'] as $status)
                                            <option {{$dadosForm['id_columnsKhanban'] == $status->id_columnsKhanban ? 'selected' : '' }} value="{{$status->id_columnsKhanban}}">{{$status->st_titulo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btnSearch border">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Button trigger modal -->
                    <button type="button" class="BtnCriarLeads" data-bs-toggle="modal"
                            data-bs-target="#CadastrarLead">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" viewBox="0 0 640 512">
                            <path
                                d="M72 88a56 56 0 1 1 112 0A56 56 0 1 1 72 88zM64 245.7C54 256.9 48 271.8 48 288s6 31.1 16 42.3V245.7zm144.4-49.3C178.7 222.7 160 261.2 160 304c0 34.3 12 65.8 32 90.5V416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V389.2C26.2 371.2 0 332.7 0 288c0-61.9 50.1-112 112-112h32c24 0 46.2 7.5 64.4 20.3zM448 416V394.5c20-24.7 32-56.2 32-90.5c0-42.8-18.7-81.3-48.4-107.7C449.8 183.5 472 176 496 176h32c61.9 0 112 50.1 112 112c0 44.7-26.2 83.2-64 101.2V416c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32zm8-328a56 56 0 1 1 112 0A56 56 0 1 1 456 88zM576 245.7v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM320 32a64 64 0 1 1 0 128 64 64 0 1 1 0-128zM240 304c0 16.2 6 31 16 42.3V261.7c-10 11.3-16 26.1-16 42.3zm144-42.3v84.7c10-11.3 16-26.1 16-42.3s-6-31.1-16-42.3zM448 304c0 44.7-26.2 83.2-64 101.2V448c0 17.7-14.3 32-32 32H288c-17.7 0-32-14.3-32-32V405.2c-37.8-18-64-56.5-64-101.2c0-61.9 50.1-112 112-112h32c61.9 0 112 50.1 112 112z"/>
                        </svg>
                    </button>
                </div>
                <div class="mt-2">
                    <button type="button" class="filtroavancancado" data-bs-toggle="modal" data-bs-target="#FiltrarLead">
                        Filtro avançado
                    </button>
                </div>

                <div class="divEmpresas mb-5 mt-4">
                    @foreach($leads as $lead)
                        <div onclick="vizualizarLead({{$lead->id_lead}})" class="divEmpresas2 my-3 d-flex">
                            <div class="d-flex justify-content-between tamanho60">
                                <div class="textBlue d-flex align-items-center w-25">{{isset($lead->fase->st_nomeFase)?$lead->fase->st_nomeFase:''}}</div>
                                <div class="textGray d-flex align-items-center w-50">{{$lead->st_nome}}</div>
                                <div class="textGray d-flex align-items-center justify-content-start w-25">{{$lead->int_telefone}}</div>
                            </div>
                            <div class="d-flex justify-content-between tamanho60 align-items-center">
                                <div class="textBlue w-25">{{isset($lead->produto) ? $lead->produto->st_nomeProdutoServico : ''}}</div>
                                @if($lead->int_temperatura == 0)
                                    <div style="width: 120px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="blue" class="bi bi-zoom-out" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                            <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z"/>
                                            <path fill-rule="evenodd" d="M3 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($lead->int_temperatura != 0)
                                        <div style="width: 120px; height:10px;">
                                            <div style="width:{{$lead->int_temperatura}}%;" class="divTemperatura"></div>
                                        </div>
                                @endif
                                <div class="d-flex  align-items-center w-25">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#b9b9b9" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                                        <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    </svg>
                                    <div class="textGray3 d-flex align-items-center ps-3" >{{isset($lead->observacoes->last()->dt_contato)? DateTime::createFromFormat('Y-m-d', $lead->observacoes->last()->dt_contato)->format('d/m/Y') : '--'}}</div>
                                </div>
                                <div>
                                    <a target=”_blank” href="https://web.whatsapp.com/send/?l=pt_BR&phone=55{{$lead->int_telefone}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7ba7d7" width="20px" height="20px" viewBox="0 0 320 512"><path d="M112 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm40 304V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V256.9L59.4 304.5c-9.1 15.1-28.8 20-43.9 10.9s-20-28.8-10.9-43.9l58.3-97c17.4-28.9 48.6-46.6 82.3-46.6h29.7c33.7 0 64.9 17.7 82.3 46.6l58.3 97c9.1 15.1 4.2 34.8-10.9 43.9s-34.8 4.2-43.9-10.9L232 256.9V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V352H152z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a id="Leads{{$lead->id_lead}}" class="none" href="{{route('vizualizarLeadAdminUser', ['id_lead'=>$lead->id_lead])}}"></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


