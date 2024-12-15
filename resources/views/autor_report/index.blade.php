@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Relatório de autores</h1>
        </div>
    </div>

    <div class="row my-4">
        <div class="col table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#Código Autor</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Livros</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <th scope="row">{{ $item->Cod_Autor }}</th>
                        <td>{{ $item->Nome_Autor }}</td>
                        <td>{{ $item->Livros  }}</td>
                    </tr>
                @endforeach
                @if (!count($data))
                    <tr><td colspan="3">Não existem autores cadastrados.</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
