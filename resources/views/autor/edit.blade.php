@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Editar assunto - {{ $autor->Nome  }}</h1>
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
            <form method="POST" action="{{ route('autores.update', $autor->CodAu) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="Nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="Nome" id="Nome" value="{{ $autor->Nome }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        </div>
    </div>
@endsection
