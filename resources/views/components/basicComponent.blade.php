<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title class="">@yield('titulo')</title>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/board.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body id="body">
    <div class="tamanhoDivConteudo">
        @yield('content')
    </div>
    <div class="my-5 d-flex justify-content-center">
        <img class="imgLogo" src="{{asset('imgs/logo_temporaria.png')}}">
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('js/script.js')}}"></script>
<script>
    @if ($message = Session::get('success'))
        @if($message === 'Atividade cadastrada com sucesso.' or $message === 'Atividade atualizada com sucesso.' or $message === 'Atividade deletada com sucesso.')
            window.scrollTo(0, document.body.scrollHeight);
        @endif
    @endif
</script>
</html>

