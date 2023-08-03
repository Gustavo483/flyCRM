@extends('components.basicComponent')

@section('titulo', 'DashboarRoot')

@section('content')
    <div class="">
        <div class="posicaoDiv w-100">
            <div class="NavbarAdmimHoot">
                @include('layouts.navBarUser')
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

                <div class="mb-5">
                    @foreach($oportunidades['oportunidadesHoje']->sortByDesc('dt_contato') as $observacao)
                        <div onclick="abrirLead({{$observacao->lead->id_lead}})" class="DivOportunidade d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p>{{$observacao->st_titulo}}</p>
                                <p>{{$observacao->st_descricao}}</p>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" class="ms-3" fill="#3956ea" viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg>
                            </div>
                            <a class="none" id="Lead{{$observacao->lead->id_lead}}" href="{{route('vizualizarLeadUser', ['id_lead'=>$observacao->lead->id_lead])}}"></a>
                        </div>
                    @endforeach
                    @foreach($oportunidades['oportunidadesOutroDia']->sortBy('dt_contato') as $observacao)
                        <div onclick="abrirLead({{$observacao->lead->id_lead}})" class="DivOportunidade d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p>{{$observacao->st_titulo}}</p>
                                <p>{{$observacao->st_descricao}}</p>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" class="ms-3" fill="#3956ea" viewBox="0 0 448 512"><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg>
                            </div>
                            <a class="none" id="Lead{{$observacao->lead->id_lead}}" href="{{route('vizualizarLeadUser', ['id_lead'=>$observacao->lead->id_lead])}}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


