@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Livros</h1>
        </div>
    </div>

    <div class="row my-4">
        @if (session()->has('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col d-flex justify-content-end">
            <a href="{{ route('livros.create') }}" class="btn btn-success">Cadastrar</a>
        </div>
    </div>
    <div class="row">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Título</th>
                    <th scope="col">Editora</th>
                    <th scope="col">Edição</th>
                    <th scope="col">Ano de publicação</th>
                    <th scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($livros as $livro)
                    <tr>
                        <th scope="row">{{ $livro->CodL }}</th>
                        <td>{{ $livro->Titulo }}</td>
                        <td>{{ $livro->Editora }}</td>
                        <td>{{ $livro->Edicao  }}</td>
                        <td>{{ $livro->AnoPublicacao }}</td>
                        <td class="d-flex justify-content-start column-gap-2">
                            <a class="btn btn-sm btn-light" href="{{ route('livros.show', $livro->CodL) }}">+ Detalhes</a>
                            <a class="btn btn-sm btn-info ml-2" href="{{ route('livros.edit', $livro->CodL) }}">Editar</a>
                            <form action="{{ route('livros.destroy', $livro->CodL) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-sm btn-danger ml-2" type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if (!count($livros))
                    <tr><td colspan="6">Não existem assuntos cadastrados.</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
