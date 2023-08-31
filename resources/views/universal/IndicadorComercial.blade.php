@extends('components.basicComponent2')

@section('titulo', 'DashboarRoot')

@push('css')
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @if($permissao === 1)
                    @include('layouts.navBarAdminUser')
                @endif
                @if($permissao === 0)
                    @include('layouts.navBarUser')
                @endif
            </div>
            <div class="container">
                <div>
                    @include('layouts.sucessoErrorRequest')
                </div>
                <div class=" colorgray">
                    Leds com 30 dias sem movimentação
                </div>
                <div class="divEmpresas mb-5 mt-4">
                    @foreach($leads as $lead)
                        <div class="divEmpresas2 my-3 d-flex">
                            <div style="width: 40%" onclick="vizualizarLead({{$lead->id_lead}})"  class="d-flex justify-content-between">
                                <div class="textBlue d-flex align-items-center w-25">{{isset($lead->fase->st_nomeFase)?$lead->fase->st_nomeFase:''}}</div>
                                <div class="textGray d-flex align-items-center w-50">{{$lead->st_nome}}</div>
                                <div class="textGray d-flex align-items-center justify-content-start w-25">{{$lead->int_telefone}}</div>
                            </div>
                            <div class="d-flex justify-content-between tamanho60 align-items-center">
                                <div onclick="vizualizarLead({{$lead->id_lead}})"  class="textBlue w-25">{{isset($lead->produto) ? $lead->produto->st_nomeProdutoServico : ''}}</div>
                                @if($lead->int_temperatura == 0)
                                    <div onclick="vizualizarLead({{$lead->id_lead}})"  style="width: 120px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="blue" class="bi bi-zoom-out" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                            <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z"/>
                                            <path fill-rule="evenodd" d="M3 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($lead->int_temperatura != 0)
                                    <div onclick="vizualizarLead({{$lead->id_lead}})"  style="width: 120px; height:10px;">
                                        <div style="width:{{$lead->int_temperatura}}%;" class="divTemperatura"></div>
                                    </div>
                                @endif
                                <div onclick="vizualizarLead({{$lead->id_lead}})"  class="d-flex  align-items-center w-25">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#b9b9b9" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                                        <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    </svg>
                                    <div class="textGray3 d-flex align-items-center ps-3" >{{isset($lead->observacoes->last()->dt_contato)? DateTime::createFromFormat('Y-m-d', $lead->observacoes->last()->dt_contato)->format('d/m/Y') : '--'}}</div>
                                </div>
                                <div style="width:200px;" class="me-2">
                                    {{isset($lead->status) ? $lead->status->st_titulo :''}}
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


