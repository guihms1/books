@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Cadastrar novo Livro</h1>
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
            <form method="POST" action="{{ route('livros.store') }}">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <label for="Titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" name="Titulo" id="Titulo" value="{{ old('Titulo') }}">
                </div>
                <div class="mb-3">
                    <label for="Editora" class="form-label">Editora</label>
                    <input type="text" class="form-control" name="Editora" id="Editora" value="{{ old('Editora') }}">
                </div>
                <div class="mb-3">
                    <label for="Edicao" class="form-label">Edição</label>
                    <input type="text" class="form-control" name="Edicao" id="Edicao" value="{{ old('Edicao') }}">
                </div>
                <div class="mb-3">
                    <label for="AnoPublicacao" class="form-label">Ano de Pulicação</label>
                    <input type="text" class="form-control" name="AnoPublicacao" id="AnoPublicacao" value="{{ old('AnoPublicacao') }}">
                </div>
                <div class="mb-3">
                    <label for="Valor" class="form-label">Valor</label>
                    <input type="text" class="form-control" name="Valor" id="Valor" value="{{ old('Valor') }}">
                </div>
                <div class="mb-3">
                    <label for="CodAu" class="form-label">Autores</label>
                    <select class="form-select" multiple aria-label="Selecione um ou mais autores" name="CodAu[]">
                        @foreach ($autores as $autor)
                            <option value="{{ $autor->CodAu }}">{{ $autor->Nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="CodAs" class="form-label">Assuntos</label>
                    <select class="form-select" multiple aria-label="Selecione um ou mais assuntos" name="CodAs[]">
                        @foreach ($assuntos as $assunto)
                            <option value="{{ $assunto->CodAs }}">{{ $assunto->Descricao }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>
    @vite('resources/js/mask.js')
@endsection
