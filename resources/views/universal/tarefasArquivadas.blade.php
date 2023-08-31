@extends('components.basicComponent2')

@section('titulo', 'DashboarAdmin')

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
                <div class="d-flex justify-content-between">
                    <div class=" colorgray">
                        Tarefas arquivadas
                    </div>
                </div>

                <div class="mt-5 FlexTarefas">
                    @foreach($tarefasArquivadas as $tarefas)
                        <div class="divTarefas">
                            <div>
                                Data Arquivamento : {{$tarefas->updated_at->format('d/m/Y')}}
                            </div>
                            <div class=" mt-3">
                                Texto tarefa :
                            </div>
                            <div class="text-center">
                                {{$tarefas->st_descricao}}
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


