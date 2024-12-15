@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Assuntos</h1>
        </div>
    </div>

    <div class="row my-5">
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
            <a href="{{ route('assuntos.create') }}" class="btn btn-success">Cadastrar</a>
        </div>
    </div>
    <div class="row">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assuntos as $assunto)
                    <tr>
                        <th scope="row">{{ $assunto->CodAs }}</th>
                        <td>{{ $assunto->Descricao }}</td>
                        <td class="d-flex justify-content-start column-gap-2">
                            <a class="btn btn-sm btn-light" href="{{ route('assuntos.show', $assunto->CodAs) }}">+ Detalhes</a>
                            <a class="btn btn-sm btn-info ml-2" href="{{ route('assuntos.edit', $assunto->CodAs) }}">Editar</a>
                            <form action="{{ route('assuntos.destroy', $assunto->CodAs) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-sm btn-danger ml-2" type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if (!count($assuntos))
                    <tr><td colspan="3">Não existem assuntos cadastrados.</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
