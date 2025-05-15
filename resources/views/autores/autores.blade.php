@extends('layouts.app')

@section('title', 'Listagem de autores')

@section('content')
    <h2 class="mb-4">Lista de Autores</h2>
    <a href="{{ route('novoautor', ['codAu' => null]) }}" class="btn btn-primary btn-novo">
        Novo Autor
    </a>
    <form method="GET" action="{{ route('autores') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="busca" value="{{ $busca }}" class="form-control"
                placeholder="Buscar por descrição...">
            <button style="margin-left: 10px" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%" scope="col">Código</th>
                    <th scope="col">Nome</th>
                    <th style="width: 7%" scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($autores as $autor)
                    <tr>
                        <td class="text-center align-middle">{{ $autor->codAu }}</td>
                        <td>{{ $autor->nome }}</td>
                        <td class="text-center">
                            <a href="{{ route('novoautor') }}?codAu={{ $autor->codAu }}"
                                class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('deletarautor') }}?codAu={{ $autor->codAu }}" method="POST"
                                style="display: inline-block;"
                                onsubmit="return confirm('Tem certeza que deseja excluir esse autor?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Nenhum autor encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    <div class="mt-1">
        {{ $autores->links() }}
    </div>
@endsection
