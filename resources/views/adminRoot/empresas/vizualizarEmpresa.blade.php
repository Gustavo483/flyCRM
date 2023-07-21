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
                Vizualizar dados da empresa aqui
            </div>
        </div>
    </div>
@endsection


