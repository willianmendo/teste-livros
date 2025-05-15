@extends('layouts.app')

@section('title', 'Listagem de assuntos')

@section('content')
    <h2 class="mb-4">Lista de Assuntos</h2>
    <a href="{{ route('novoassunto', ['codAs' => null]) }}" class="btn btn-primary btn-novo">
        Novo Assunto
    </a>
    <form method="GET" action="{{ route('assuntos') }}" class="mb-4">
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
                    <th scope="col">Descrição</th>
                    <th style="width: 7%" scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assuntos as $assunto)
                    <tr>
                        <td class="text-center align-middle">{{ $assunto->codAs }}</td>
                        <td>{{ $assunto->descricao }}</td>
                        <td class="text-center">
                            <a href="{{ route('novoassunto') }}?codAs={{ $assunto->codAs }}"
                                class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('deletarassunto') }}?codAs={{ $assunto->codAs }}" method="POST"
                                style="display: inline-block;"
                                onsubmit="return confirm('Tem certeza que deseja excluir esse assunto?')">
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
                        <td colspan="3" class="text-center">Nenhum assunto encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    <div class="mt-1">
        {{ $assuntos->links() }}
    </div>
@endsection
