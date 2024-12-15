@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Editar livro - {{ $livro->Titulo  }}</h1>
        </div>
    </div>
    <div class="row my-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col">
            <form method="POST" action="{{ route('livros.update', $livro->CodL) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="Titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" name="Titulo" id="Titulo" value="{{ $livro->Titulo }}">
                </div>
                <div class="mb-3">
                    <label for="Editora" class="form-label">Editora</label>
                    <input type="text" class="form-control" name="Editora" id="Editora" value="{{ $livro->Editora }}">
                </div>
                <div class="mb-3">
                    <label for="Edicao" class="form-label">Edição</label>
                    <input type="text" class="form-control" name="Edicao" id="Edicao" value="{{ $livro->Edicao }}">
                </div>
                <div class="mb-3">
                    <label for="AnoPublicacao" class="form-label">Ano de Pulicação</label>
                    <input type="text" class="form-control" name="AnoPublicacao" id="AnoPublicacao" value="{{ $livro->AnoPublicacao }}">
                </div>
                <div class="mb-3">
                    <label for="Valor" class="form-label">Valor</label>
                    <input type="text" class="form-control" name="Valor" id="Valor" value="{{ $livro->Valor }}">
                </div>
                <div class="mb-3">
                    <label for="CodAu" class="form-label">Autores</label>
                    <select class="form-select" multiple aria-label="Selecione um ou mais autores" name="CodAu[]">
                        @foreach ($autores as $autor)
                            @php
                                $autorShouldBeSelected = $livro->autores->contains('CodAu', $autor->CodAu);
                            @endphp
                            <option value="{{ $autor->CodAu }}" {{ $autorShouldBeSelected ? 'selected' : '' }}>{{ $autor->Nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="CodAs" class="form-label">Assuntos</label>
                    <select class="form-select" multiple aria-label="Selecione um ou mais assuntos" name="CodAs[]">
                        @foreach ($assuntos as $assunto)
                            @php
                                $assuntoShouldBeSelected = $livro->assuntos->contains('CodAs', $assunto->CodAs);
                            @endphp
                            <option value="{{ $assunto->CodAs }}" {{ $assuntoShouldBeSelected ? 'selected' : '' }}>{{ $assunto->Descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        </div>
    </div>
    @vite('resources/js/mask.js')
@endsection
