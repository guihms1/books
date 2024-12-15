@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>{{ $autor->Nome }}</h1>
        </div>
    </div>

    <div class="row mt-5 mb-3">
        <div class="col-1"><b>Nome:</b></div>
        <div class="col">{{ $autor->Nome }}</div>
    </div>
    <div class="row my-3">
        <div class="col-1"><b>Livros:</b></div>
        <div class="col">
            @foreach ($autor->livros as $livro)
                {{ $livro->Titulo }} {{ !$loop->last ? '/' : '' }}
            @endforeach
        </div>
    </div>

    <div class="row my-3">
        <div class="col"><a href="{{ route('autores.index') }}" class="btn btn-outline-dark">Voltar</a></div>
    </div>
@endsection
