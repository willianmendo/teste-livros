@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
   <div class="container py-5">
    <div class="row g-4">
        <div class="col-md-6 align-items-center">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h4 class="card-title text-center">Relatório geral</h4>
                    <p class="text-center text-muted mt-2 mb-4">
                        Este relatório apresenta os livros agrupados por autor.
                    </p>
                    <form action="{{ route('relatorio') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Gerar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
