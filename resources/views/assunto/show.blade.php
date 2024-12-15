@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>{{ $assunto->Descricao }}</h1>
        </div>
    </div>

    <div class="row mt-5 mb-3">
        <div class="col-1"><b>Nome:</b></div>
        <div class="col">{{ $assunto->Descricao }}</div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Livros:</b></div>
        <div class="col">
            @foreach ($assunto->livros as $livro)
                {{ $livro->Titulo }} {{ !$loop->last ? '/' : '' }}
            @endforeach
        </div>
    </div>

    <div class="row my-3">
        <div class="col"><a href="{{ route('assuntos.index') }}" class="btn btn-outline-dark">Voltar</a></div>
    </div>
@endsection