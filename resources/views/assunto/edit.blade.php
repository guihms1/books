@extends('app')

@section('content')
    <div class="row my-5">
        <div class="col">
            <h1>Editar assunto - {{ $assunto->Descricao  }}</h1>
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
            <form method="POST" action="{{ route('assuntos.update', $assunto->CodAs) }}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="Descricao" id="Descricao" value="{{ $assunto->Descricao }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        </div>
    </div>
@endsection
