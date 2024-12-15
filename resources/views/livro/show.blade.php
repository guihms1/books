@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>{{ $livro->Titulo }}</h1>
        </div>
    </div>

    <div class="row mt-5 mb-3">
        <div class="col-1"><b>Título:</b></div>
        <div class="col">{{ $livro->Titulo }}</div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Editora:</b></div>
        <div class="col">{{ $livro->Editora }}</div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Edição:</b></div>
        <div class="col">{{ $livro->Edicao }}</div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Ano de publicação:</b></div>
        <div class="col">{{ $livro->AnoPublicacao }}</div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Valor:</b></div>
        <div class="col">R$ {{ number_format($livro->Valor, 2, '.', '') }}</div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Autores:</b></div>
        <div class="col">
            @foreach ($livro->autores as $autor)
                {{ $autor->Nome }} {{ !$loop->last ? '/' : '' }}
            @endforeach
        </div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Assuntos:</b></div>
        <div class="col">
            @foreach ($livro->assuntos as $assunto)
                {{ $assunto->Descricao }} {{ !$loop->last ? '/' : '' }}
            @endforeach
        </div>
    </div>

    <div class="row my-3">
        <div class="col"><a href="{{ route('livros.index') }}" class="btn btn-outline-dark">Voltar</a></div>
    </div>
@endsection
