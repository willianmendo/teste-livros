<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Minha Aplicação')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Sebo ADMIN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/" class="nav-link" title="Home">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('assuntos') }}">Assuntos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('autores') }}">Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('livros') }}">Livros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('relatorios') }}">Relatórios</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @include('layouts.callouts')
        @yield('content')
    </div>

    <footer class="bg-dark text-center py-3 mt-auto">
        &copy; {{ date('Y') }} Sebo ADMIN. Todos os direitos reservados.
    </footer>

</body>

</html>
