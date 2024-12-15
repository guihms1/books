@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Autores</h1>
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
            <a href="{{ route('autores.create') }}" class="btn btn-success">Cadastrar</a>
        </div>
    </div>
    <div class="row">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($autores as $autor)
                    <tr>
                        <th scope="row">{{ $autor->CodAu }}</th>
                        <td>{{ $autor->Nome }}</td>
                        <td class="d-flex justify-content-start column-gap-2">
                            <a class="btn btn-sm btn-light" href="{{ route('autores.show', $autor->CodAu) }}">+ Detalhes</a>
                            <a class="btn btn-sm btn-info ml-2" href="{{ route('autores.edit', $autor->CodAu) }}">Editar</a>
                            <form action="{{ route('autores.destroy', $autor->CodAu) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-sm btn-danger ml-2" type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if (!count($autores))
                    <tr><td colspan="3">Não existem autores cadastrados.</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
